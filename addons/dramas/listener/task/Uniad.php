<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\listener\task;

use addons\dramas\model\Task;
use addons\dramas\model\User as UserModel;
use addons\dramas\model\UserWalletLog;
use think\Db;

/**
 * 广告
 */
class Uniad
{
    // 观看广告成功后
    public function uniadSuccess($data){
        // 增加剧场积分
        $task = Task::where('site_id', $data['site_id'])
            ->where('lang_id', $data['lang_id'])
            ->where('hook', 'uniad_success')
            ->where('status', 'normal')
            ->find();
        if($task){
            $task_ids = Db::name('dramas_task')
                ->where('site_id', $data['site_id'])
                ->whereIn('hook', $task['hook'])
                ->column('id');
            $where['item_id'] = ['in', $task_ids];
            $where['site_id'] = $data['site_id'];
            $where['user_id'] = $data['user_id'];
            $where['wallet_type'] = 'usable';
            $where['type'] = 'task';
            if($task['type'] == 'day'){
                $count = UserWalletLog::where($where)
                    ->whereTime('createtime', 'd')
                    ->count();
            }else{
                $count = UserWalletLog::where($where)->count();
            }
            if($count < $task['limit']){
                UserModel::usable($task['usable'], $data['user_id'], 'task', $task['id'], $task['title']);
            }
        }
    }

}
