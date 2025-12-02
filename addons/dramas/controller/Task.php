<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

use addons\dramas\model\User;
use addons\dramas\model\UserWalletLog;
use think\Db;
use think\Exception;

/**
 * 任务
 * Class Task
 * @package addons\dramas\controller
 */
class Task extends Base
{
    protected $noNeedLogin = ['index'];
    protected $noNeedRight = ['*'];

    /**
     * 任务列表
     * @ApiParams   (name="platform", type="string", required=true, description="平台:H5=H5,wxOfficialAccount=微信公众号,wxMiniProgram=微信小程序,Web=Web")
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(){
        $platform = $this->request->get('platform', '');
        $hooks = array_keys(\addons\dramas\model\Task::$hooks);
        $task_list = Db::name('dramas_task')
            ->where('site_id', $this->site_id)
            ->where('lang_id', $this->lang_id)
            ->whereIn('hook', $hooks)
            ->where('status', 'normal')
            ->whereNull('deletetime')
            ->field('id,title,desc,limit,usable,type,hook')
            ->select();
        $user = User::info();
        foreach ($task_list as &$task){
            $task['user_count'] = 0;
            if($user){
                $task_ids = Db::name('dramas_task')
                    ->where('site_id', $this->site_id)
                    ->whereIn('hook', $task['hook'])
                    ->column('id');
                $where['site_id'] = $this->site_id;
                $where['user_id'] = $user->id;
                $where['wallet_type'] = 'usable';
                $where['type'] = 'task';
                $where['item_id'] = ['in', $task_ids];
                if($task['type'] == 'day'){
                    $count = UserWalletLog::where($where)
                        ->whereTime('createtime', 'd')
                        ->count();
                }else{
                    $count = UserWalletLog::where($where)->count();
                }
                $task['user_count'] = $count ?? 0;
            }
        }

        $this->success('剧场积分任务', $task_list);
    }

    /**
     * 广告任务详情
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function uniad(){
        $task = Db::name('dramas_task')
            ->where('site_id', $this->site_id)
            ->whereIn('hook', 'uniad_success')
            ->where('status', 'normal')
            ->whereNull('deletetime')
            ->field('id,title,desc,limit,usable,type,hook')
            ->find();
        $user = User::info();
        $task['user_count'] = 0;
        if($user){
            $where['site_id'] = $this->site_id;
            $where['user_id'] = $user->id;
            $where['wallet_type'] = 'usable';
            $where['type'] = 'task';
            $where['item_id'] = $task['id'];
            if($task['type'] == 'day'){
                $count = UserWalletLog::where($where)
                    ->whereTime('createtime', 'd')
                    ->count();
            }else{
                $count = UserWalletLog::where($where)->count();
            }
            $task['user_count'] = $count ?? 0;
        }

        $this->success('广告任务', $task);
    }

    /**
     * 任务成功
     * @ApiMethod   (POST)
     * @ApiParams   (name="type", type="string", required=true, description="share_wx_after分享微信，share_wxf_after分享朋友圈，uniad_success观看广告成功后")
     */
    public function add(){
        $this->repeat_filter();        // 防抖
        $type = $this->request->post('type');
        if(!in_array($type, ['share_wx_after', 'share_wxf_after', 'uniad_success'])){
            $this->error(__('Error parameters'));
        }

        $data = ['user_id'=>$this->auth->id, 'site_id'=>$this->site_id, 'lang_id'=>$this->lang_id];
        try {
            \think\Hook::listen($type, $data);
        }catch (Exception $e){
            $this->error('失败：'.$e->getMessage());
        }
        $this->success('成功');
    }
}