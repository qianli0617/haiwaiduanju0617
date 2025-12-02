<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\library;

use app\admin\library\Auth as AdminAuth;
use addons\dramas\model\User;

class Oper
{
    public static function set($operType = '', $operId = 0)
    {
        if ($operType === '') {
            // 自动获取操作人
            if (strpos(request()->url(), 'addons/dramas') !== false) {
                // 用户
                $user = User::info();
                if ($user) {
                    $operType = 'user';
                    $operId = $user->id;
                }
            }else{
                $admin = AdminAuth::instance();     // 没有登录返回的还是这个类实例
                if ($admin->isLogin()) {
                    // 后台管理员
                    $operType = 'admin';
                    $operId = $admin->id;
                }
            }
        }
        if ($operType === '') {
            $operType = 'system';
        }
        return [
            'oper_type' => $operType,
            'oper_id' => $operId
        ];
    }

    public static function get($operType, $operId)
    {
        $operator = null;
        if ($operType === 'admin') {
            $operator = \app\admin\model\Admin::where('id', $operId)->field('nickname as name, avatar')->find();
            $operator['type'] = __('Admin');
        } elseif ($operType === 'user') {
            $operator = \addons\dramas\model\User::where('id', $operId)->field('nickname as name, avatar')->find();
            $operator['type'] = __('User');
        } else {
            $operator = [
                'name' => __('System'),
                'avatar' => '',
                'type' => __('System')
            ];
        }
        if(!isset($operator['name'])) {
            $operator['name'] = __('Deleted');
            $operator['avatar'] = '';
        }
        return $operator;
    }
}
