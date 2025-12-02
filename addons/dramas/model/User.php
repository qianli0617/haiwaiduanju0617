<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use addons\dramas\exception\Exception;
use think\Model;
use app\common\library\Auth;
use think\Db;

/**
 * 会员模型
 */
class User extends Model
{
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    // 追加属性
    protected $append = [
        'nickname_hide'
    ];

    public static function info()
    {
        if (Auth::instance()->isLogin()) {
            return Auth::instance();
        }
        return null;
    }

    /**
     * 获取头像
     * @param   string $value
     * @param   array  $data
     * @return string
     */
    public function getAvatarAttr($value, $data)
    {
        if (!$value) {
            //如果不需要启用首字母头像，请使用
            //$value = '/assets/img/avatar.png';
            $config = json_decode(\addons\dramas\model\Config::get(['name' => 'user'])->value, true);
            $value = $config['avatar'];
        }

        return cdnurl($value, true);
    }

    /**
     * 获取会员的组别
     */
    public function getGroupAttr($value, $data)
    {
        return UserGroup::get($data['group_id']);
    }

    /**
     * 获取验证字段数组值
     * @param   string $value
     * @param   array  $data
     * @return  object
     */
    public function getVerificationAttr($value, $data)
    {
        $value = array_filter((array)json_decode($value, true));
        $value = array_merge(['email' => 0, 'mobile' => 0], $value);
        return (object)$value;
    }

    /**
     * 设置验证字段
     * @param mixed $value
     * @return string
     */
    public function setVerificationAttr($value)
    {
        $value = is_object($value) || is_array($value) ? json_encode($value) : $value;
        return $value;
    }

    public function getNicknameHideAttr($value, $data)
    {
        if (isset($data['nickname'])) {
            if (mb_strlen($data['nickname']) > 2) {
                $nickname = mb_substr($data['nickname'], 0, 2) . '***';
            } else {
                $nickname = $data['nickname'];
            }

            return $nickname;
        }
        return null;
    }

    /**
     * @name 变更会员余额
     * @param  float        $money      变更金额
     * @param  int|object   $user       会员对象或会员ID
     * @param  string       $type       变更类型
     * @param  int          $item_id    变更ID
     * @param  string       $memo       备注
     * @param  array        $ext        扩展字段
     * @return boolean
     */
    public static function money($money, $user, $type = '', $type_id = 0, $memo = '', $ext = [])
    {
        // 判断用户
        if (is_numeric($user)) {
            $user = self::get($user);
        }
        if (!$user) {
            new Exception(__('No results were found'));
        }
        // 判断金额
        if ($money == 0) {
            new Exception(__('Please enter the correct amount'));
        }

        $before = $user->money;
        $after = $user->money + $money;
        // 只有后台扣除用户余额和佣金退回，余额才可以是负值
        if ($after < 0 && !in_array($type, ['admin_deduct', 'commission_back', 'admin_recharge'])) {
            new Exception(__('Insufficient available balance'));
        }
        try {
            // 更新会员余额信息
            $user->money = Db::raw('money + ' . $money);
            $user->save();
            UserWalletLog::write($user, $money, $before, $after, $type, $type_id, "money", $memo, $ext);
        } catch (\Exception $e) {
            new Exception(__('The data you submitted is incorrect'));
        }

        // 写入dramas日志
        return true;
    }

    /**
     * @name 变更会员剧场积分
     * @param  int          $score      变更剧场积分
     * @param  int|object   $user       会员对象或会员ID
     * @param  string       $type       变更类型
     * @param  int          $item_id    变更ID
     * @param  string       $memo       备注
     * @param  array        $ext        扩展字段
     * @return boolean
     */
    public static function usable($usable, $user, $type = '', $type_id = 0, $memo = '', $ext = [])
    {
        $usable = intval($usable);
        // 判断用户
        if (is_numeric($user)) {
            $user = self::get($user);
        }
        if (!$user) {
            new Exception(__('No results were found'));
        }
        // 判断积分
        if ($usable === 0) {
            new Exception(__('Please enter the correct theater points'));
        }
        $before = $user->usable;
        $after = $user->usable + $usable;
        if ($after < 0) {
            new Exception(__('Insufficient available theater points'));
        }
        try {
            // 更新会员余额信息
            $user->usable = Db::raw('usable + ' . $usable);
            $user->save();
            UserWalletLog::write($user, $usable, $before, $after, $type, $type_id, "usable", $memo, $ext);
        } catch (\Exception $e) {
            new Exception(__('The data you submitted is incorrect'));
        }
        // 写入dramas日志
        return true;
    }

    /**
     * 下级
     */
    public function children()
    {
        return $this->hasMany(\addons\dramas\model\User::class, 'parent_user_id')->field('id,nickname,avatar,parent_user_id');
    }

}
