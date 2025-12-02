<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use think\Model;
use app\common\model\MoneyLog;
use app\common\model\ScoreLog;

/**
 * 钱包
 */
class UserWalletLog extends Model
{

    // 表名,不含前缀
    protected $name = 'dramas_user_wallet_log';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    protected $hidden = ['deletetime'];


    // 追加属性
    protected $append = [
        'type_name',
        'wallet_type_name'
    ];

    public static $typeAll = [
        // money
        'wallet_pay' => ['code' => 'wallet_pay', 'name' => 'Balance payment'],
        'recharge' => ['code' => 'recharge', 'name' => 'User recharge'],
        'cash' => ['code' => 'cash', 'name' => 'User withdrawal'],
        'cash_error' => ['code' => 'cash_error', 'name' => 'Withdrawal rejection'],
        'wallet_refund' => ['code' => 'wallet_refund', 'name' => 'Balance refund'],
        'commission_income' => ['code' => 'commission_income', 'name' => 'Commission revenues'],
        'commission_back' => ['code' => 'commission_back', 'name' => 'Commission deduction'],

        // usable
        'task' => ['code' => 'task', 'name' => 'Task acquisition'],
        'used_video' => ['code' => 'used_video', 'name' => 'dramas tracking expenses'],
        'recharge_usable' => ['code' => 'recharge_usable', 'name' => 'Theater point recharge'],
        'cryptocard' => ['code' => 'cryptocard', 'name' => 'Card exchange'],


        // admin
        'admin_recharge' => ['code' => 'admin_recharge', 'name' => 'Backend recharge'],
        'admin_deduct' => ['code' => 'admin_deduct', 'name' => 'Backend deduction'],
    ];


    public static $walletTypeAll = [
        'money' => 'Wallet_type money',
        'score' => 'Wallet_type score',
        'usable' => 'Wallet_type usable'
    ];

    public function scopeMoney($query)
    {
        return $query->where('wallet_type', 'money');
    }

    public function scopeScore($query)
    {
        return $query->where('wallet_type', 'score');
    }

    public function scopeUsable($query)
    {
        return $query->where('wallet_type', 'usable');
    }

    public function scopeAdd($query)
    {
        return $query->where('wallet', '>', 0);
    }

    public function scopeReduce($query)
    {
        return $query->where('wallet', '<', 0);
    }

    public static function write($user, $amount, $before, $after, $type, $type_id, $wallet_type, $memo, $ext = [])
    {
        if ($memo === '' && $type !== '') {
            $memo = self::getTypeName($type);
        }

        // 写入fastadmin日志
        if($wallet_type === 'money') {
            MoneyLog::create(['user_id' => $user->id, 'money' => $amount, 'before' => $before, 'after' => $after, 'memo' => $memo]);
        } else if($wallet_type === 'score') {
            ScoreLog::create(['user_id' => $user->id, 'score' => $amount, 'before' => $before, 'after' => $after, 'memo' => $memo]);
        }

        if(User::info()){
            $this_user = User::info();
            $oper = \addons\dramas\library\Oper::set('user', $this_user->id);
        }else{
            $oper = \addons\dramas\library\Oper::set();
        }
        $self = self::create([
            'site_id' => $user->site_id,
            "user_id" => $user->id,
            "wallet" => $amount,       // 符号直接存到记录里面
            "before" => $before,
            "after" => $after,
            "type" => $type,
            "memo" => $memo,
            "item_id" => $type_id,
            "wallet_type" => $wallet_type,
            "ext" => json_encode($ext),
            "oper_type" => $oper['oper_type'],
            "oper_id" => $oper['oper_id']
        ]);

        return $self;
    }



    public static function getList($params)
    {
        $user_id = User::info()->id;
        $user = User::get($user_id);

        // 分页列表
        $walletLogs = self::buildSearch($params)->order('id', 'DESC')->paginate(10);
        // 收入
        $income = self::buildSearch($params)->where('wallet', '>=', 0)->sum('wallet');
        // 支出
        $expend = self::buildSearch($params)->where('wallet', '<', 0)->sum('wallet');

        foreach ($walletLogs as $w) {
            $w->avatar = $user->avatar;
            switch ($w['type']) {
                case 'cash':
                case 'cash_error':
                    $w->avatar = $user->avatar;
                    break;
            }
        }
        return [
            'wallet_logs' => $walletLogs,
            'income' => $income,
            'expend' => $expend,
        ];
    }


    private static function buildSearch($params)
    {
        $user = User::info();
        $status = $params['status'] ?? 'all';
        $wallet_type = $params['wallet_type'] ?? 'usable';

        $walletLogs = self::{$wallet_type}();

        if ($status != 'all') {
            $walletLogs = $walletLogs->{$status}();
        }

        $walletLogs = $walletLogs->where(['user_id' => $user->id, 'site_id' => $user->site_id]);
        if(isset($params['date'])){
            $date = isset($params['date']) ? explode('-', $params['date']) : [];
            $start = isset($date[0]) && $date[0] ? strtotime($date[0]) : strtotime(date('Y-m') . '-01');
            $end = isset($date[1]) && $date[1] ? (strtotime($date[1]) + 86399) : strtotime(date('Y-m-d')) + 86399;
            $walletLogs = $walletLogs->whereBetween('createtime', [$start, $end]);
        }

        return $walletLogs;
    }



    public static function getTypeName($type)
    {
        return isset(self::$typeAll[$type]) ? __(self::$typeAll[$type]['name']) : '';
    }


    public function getTypeNameAttr($value, $data)
    {
        return self::getTypeName($data['type']);
    }


    public function getWalletTypeNameAttr($value, $data)
    {
        return self::$walletTypeAll[$data['wallet_type']] ? __(self::$walletTypeAll[$data['wallet_type']]) : '';
    }


    public function getWalletAttr($value, $data)
    {
        return $data['wallet_type'] == 'score' || $data['wallet_type'] == 'usable' ? intval($value) : $value;
    }
}
