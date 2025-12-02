<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

use addons\dramas\model\Config;
use addons\dramas\model\Reseller as ResellerModel;
use addons\dramas\model\ResellerLog;
use addons\dramas\model\Richtext;
use think\Db;

/**
 * 分销管理
 * Class VipOrder
 * @package addons\dramas\controller
 */
class Reseller extends Base
{
    protected $noNeedLogin = ['index', 'detail'];
    protected $noNeedRight = '*';

    /**
     * 分销商等级
     */
    public function index(){
        $list = ResellerModel::where('status', 'normal')
            ->where('site_id', $this->site_id)
            ->where('lang_id', $this->lang_id)
            ->orderRaw('weigh desc, id asc')
            ->select();
        foreach ($list as $key=>$item){
            $list[$key]['image'] = $item['image'] ? cdnurl($item['image'], true) : '';
            $list[$key]['expire_text'] = $item['expire'] == 0 ? __('Forever') : intval($item['expire']/86400).__('Day');
        }
        $config = Config::where('name', 'dramas')->where('site_id', $this->site_id)->value('value');
        $config = json_decode($config, true);
        $reseller_desc = null;
        $lang = $this->lang;
        if(isset($config['reseller_desc'][$lang]) && $config['reseller_desc'][$lang]){
            $reseller_desc = Richtext::get($config['reseller_desc'][$lang]);
        }
        $this->success('', ['list'=>$list, 'reseller_desc'=>$reseller_desc]);
    }

    /**
     * 分销等级详情
     * @ApiParams   (name="id", type="integer", required=true, description="分销等级ID")
     * @ApiParams   (name="level", type="integer", required=true, description="分销等级")
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail(){
        $id = $this->request->get('id', 0);
        $level = $this->request->get('level', 0);
        if($id){
            $where['id'] = $id;
        }
        if($level){
            $where['level'] = $level;
        }
        $where['status'] = 'normal';
        $data = ResellerModel::where($where)->where('site_id', $this->site_id)->find();
        if(empty($data)){
            $this->error(__('No results were found'));
        }
        $data['image'] = $data['image'] ? cdnurl($data['image'], true) : '';
        $data['expire_text'] = $data['expire'] == 0 ? __('Forever') : intval($data['expire']/86400).__('Day');
        $this->success('', $data);
    }

    /**
     * 团队用户
     * @ApiParams   (name="page", type="integer", required=false, description="页数")
     * @ApiParams   (name="pagesize", type="integer", required=false, description="每页数量")
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function user(){
        $page = $this->request->get('page', 1);
        $pagesize = $this->request->get('pagesize', 10);
        $count = Db::name('dramas_reseller_user')
            ->where('site_id', $this->site_id)
            ->where('reseller_user_id', $this->auth->id)
            ->count();
        $count_direct = Db::name('dramas_reseller_user')
            ->where('site_id', $this->site_id)
            ->where('reseller_user_id', $this->auth->id)
            ->where('type', '1')
            ->count();
        $count_indirect = Db::name('dramas_reseller_user')
            ->where('site_id', $this->site_id)
            ->where('reseller_user_id', $this->auth->id)
            ->where('type', '2')
            ->count();
        $reseller_user = Db::name('dramas_reseller_user')
            ->alias('r')
            ->join('user u', 'r.user_id=u.id', 'left')
            ->field('r.*,u.nickname,u.avatar')
            ->where('r.site_id', $this->site_id)
            ->where('r.reseller_user_id', $this->auth->id)
            ->order('r.id', 'desc')
            ->page($page, $pagesize)
            ->select();
        foreach ($reseller_user as &$item){
            if($item['nickname'] == null && $item['avatar'] == null){
                $userConfig = json_decode(Config::get(['name' => 'user', 'site_id'=>$this->site_id])->value, true);
                $item['nickname'] = isset($userConfig['nickname']) ? $userConfig['nickname'].'**' : __('Anonymous user');
                $item['avatar'] = isset($userConfig['avatar']) ? cdnurl($userConfig['avatar'], true) : '';
            }
            $item['createtime'] = date('Y-m-d H:i:s', $item['createtime']);
        }
        $this->success('', [
            'count' => $count,
            'count_direct' => $count_direct,
            'count_indirect' => $count_indirect,
            'reseller_user' => $reseller_user,
        ]);
    }

    /**
     * 分销记录
     * @ApiParams   (name="page", type="integer", required=false, description="页数")
     * @ApiParams   (name="pagesize", type="integer", required=false, description="每页数量")
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function log(){
        $page = $this->request->get('page', 1);
        $pagesize = $this->request->get('pagesize', 10);
        $sum = ResellerLog::where('reseller_user_id', $this->auth->id)->where('site_id', $this->site_id)->sum('total_money');
        $count = ResellerLog::where('reseller_user_id', $this->auth->id)->where('site_id', $this->site_id)->count();
        $list = ResellerLog::alias('rl')
            ->join('user u', 'rl.user_id=u.id', 'left')
            ->field('rl.*,u.nickname,u.avatar')
            ->where('rl.reseller_user_id', $this->auth->id)
            ->where('rl.site_id', $this->site_id)
            ->order('rl.id', 'desc')
            ->page($page, $pagesize)
            ->select();
        foreach ($list as &$item){
            $item['avatar'] = cdnurl($item['avatar'], true);
            $item['createtime'] = date('Y-m-d H:i:s', $item['createtime']);
        }
        $this->success('', ['sum'=>$sum, 'count'=>$count, 'list'=>$list]);
    }

    /**
     * 分销商订单记录
     */
    public function order_list()
    {
        $params = $this->request->get();

        $this->success('', \addons\dramas\model\ResellerOrder::getList($params));
    }

    /**
     * 分销商订单详情
     * @ApiParams   (name="id", type="integer", required=true, description="订单ID")
     * @ApiParams   (name="order_sn", type="string", required=true, description="订单号")
     */
    public function order_detail()
    {
        $params = $this->request->get();
        $this->success('', \addons\dramas\model\ResellerOrder::detail($params));
    }

    /**
     * 分销商创建订单
     * @ApiMethod   (POST)
     * @ApiParams   (name="reseller_id", type="integer", required=true, description="分销商ID")
     * @ApiParams   (name="total_fee", type="string", required=true, description="金额")
     * @ApiParams   (name="platform", type="string", required=false, description="平台:H5=H5,wxOfficialAccount=微信公众号,wxMiniProgram=微信小程序,Web=Web")
     */
    public function recharge()
    {
        $params = $this->request->post();

        // 表单验证
        $this->dramasValidate($params, get_class(), 'recharge');

        $order = \addons\dramas\model\ResellerOrder::recharge($params);

        $this->success('', $order);
    }


}
