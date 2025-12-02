<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

use addons\dramas\model\Config;
use addons\dramas\model\Usable as UsableModel;
use addons\dramas\model\Richtext;
use think\Db;

/**
 * 剧场积分充值管理
 * Class VipOrder
 * @package addons\dramas\controller
 */
class Usable extends Base
{
    protected $noNeedLogin = ['index', 'detail'];
    protected $noNeedRight = '*';

    /**
     * 剧场积分充值套餐
     */
    public function index(){
        $list = UsableModel::where('status', '1')
            ->where('site_id', $this->site_id)
            ->where('lang_id', $this->lang_id)
            ->orderRaw('weigh desc, id asc')
            ->select();
        foreach ($list as $key=>$item){
            $list[$key]['image'] = $item['image'] ? cdnurl($item['image'], true) : '';
        }
        $config = Config::where('name', 'dramas')->where('site_id', $this->site_id)->value('value');
        $config = json_decode($config, true);
        $json = base64_decode('Y2hlY2tfaG9zdA==');
        $this->$json();
        $usable_desc = null;
        $lang = $this->lang;
        if(isset($config['usable_desc'][$lang]) && $config['usable_desc'][$lang]){
            $usable_desc = Richtext::get($config['usable_desc'][$lang]);
        }
        $this->success('', ['list'=>$list, 'usable_desc'=>$usable_desc]);
    }

    /**
     * 剧场积分充值套餐详情
     * @ApiParams   (name="id", type="integer", required=true, description="剧场积分充值套餐ID")
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail(){
        $id = $this->request->get('id', 0);
        $where['id'] = $id;
        $where['status'] = '1';
        $data = UsableModel::where($where)->where('site_id', $this->site_id)->find();
        if(empty($data)){
            $this->error(__('No results were found'));
        }
        $data['image'] = $data['image'] ? cdnurl($data['image'], true) : '';
        $this->success('', $data);
    }

    /**
     * 剧场积分充值订单记录
     */
    public function order_list()
    {
        $params = $this->request->get();

        $this->success('', \addons\dramas\model\UsableOrder::getList($params));
    }

    /**
     * 剧场积分充值订单详情
     * @ApiParams   (name="id", type="integer", required=true, description="订单ID")
     * @ApiParams   (name="order_sn", type="string", required=true, description="订单号")
     */
    public function order_detail()
    {
        $params = $this->request->get();
        $this->success('', \addons\dramas\model\UsableOrder::detail($params));
    }

    /**
     * 剧场积分充值创建订单
     * @ApiMethod   (POST)
     * @ApiParams   (name="usable_id", type="integer", required=true, description="剧场积分充值套餐ID")
     * @ApiParams   (name="total_fee", type="string", required=true, description="金额")
     * @ApiParams   (name="platform", type="string", required=false, description="平台:H5=H5,wxOfficialAccount=微信公众号,wxMiniProgram=微信小程序,Web=Web")
     */
    public function recharge()
    {
        $params = $this->request->post();

        // 表单验证
        $this->dramasValidate($params, get_class(), 'recharge');

        $order = \addons\dramas\model\UsableOrder::recharge($params);

        $this->success('', $order);
    }


}
