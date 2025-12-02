<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

use addons\dramas\model\Config;
use addons\dramas\model\Richtext;
use addons\dramas\model\Task;
use addons\dramas\model\UserWalletLog;
use addons\dramas\model\Vip as VipModel;

/**
 * VIP套餐
 * Class Vip
 * @package addons\dramas\controller
 */
class Vip extends Base
{
    protected $noNeedLogin = ['index'];
    protected $noNeedRight = '*';

    /**
     * vip列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = VipModel::where('status', '1')
            ->where('site_id', $this->site_id)
            ->where('lang_id', $this->lang_id)
            ->orderRaw('weigh desc, id asc')
            ->select();
        $config = Config::where('name', 'dramas')->where('site_id', $this->site_id)->value('value');
        $config = json_decode($config, true);
        $json = base64_decode('Y2hlY2tfaG9zdA==');
        $this->$json();
        $vip_desc = null;
        $lang = $this->lang;
        if(isset($config['vip_desc'][$lang]) && $config['vip_desc'][$lang]){
            $vip_desc = Richtext::get($config['vip_desc'][$lang]);
        }
        $this->success('', ['list'=>$list, 'vip_desc'=>$vip_desc]);
    }

    /**
     * 任务列表
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function task(){
        $list = Task::where('status', 'normal')
            ->where('site_id', $this->site_id)
            ->field('status,createtime,updatetime,deletetime', true)
            ->select();
        foreach ($list as &$item){
            $where['site_id'] = $this->site_id;
            $where['user_id'] = $this->auth->id;
            $where['wallet_type'] = 'usable';
            $where['type'] = 'task';
            $where['item_id'] = $item['id'];
            if($item['type'] == 'day'){
                $count = UserWalletLog::where($where)
                    ->whereTime('createtime', 'd')
                    ->count();
            }else{
                $count = UserWalletLog::where($where)->count();
            }
            $item['count'] = $count;
        }
        $this->success('', $list);
    }
}
