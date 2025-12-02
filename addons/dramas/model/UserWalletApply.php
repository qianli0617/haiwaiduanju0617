<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use app\common\model\Lang;
use think\Model;
use traits\model\SoftDelete;
use addons\dramas\exception\Exception;

/**
 * 钱包
 */
class UserWalletApply extends Model
{
    use SoftDelete;

    // 表名,不含前缀
    protected $name = 'dramas_user_wallet_apply';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    protected $hidden = ['actual_money', 'log', 'payment_json', 'updatetime'];

    // 追加属性
    protected $append = [
        'status_text',
        'apply_type_text',
    ];


    /**
     * 获取提现单号
     *
     * @param int $user_id
     * @return string
     */
    public static function getSn($user_id)
    {
        $rand = $user_id < 9999 ? mt_rand(100000, 99999999) : mt_rand(100, 99999);
        $order_sn = date('Yhis') . $rand;

        $id = str_pad($user_id, (24 - strlen($order_sn)), '0', STR_PAD_BOTH);

        return 'W' . $order_sn . $id;
    }

    // 提现记录
    public static function getList()
    {
        $user = User::info();

        $walletApplys = self::where(['user_id' => $user->id, 'site_id'=>$user->site_id])->order('id desc')->paginate(10);

        return $walletApplys;
    }

    public static function exchange($currency, $money, $pay_money){
        $type = $money == 0 ? 'money' : 'point';
        $user = User::info();
        $lang = Lang::get(['currency'=>$currency]);
        if(empty($lang) || $lang['exchange_rate'] <= 0){
            throw new \Exception(__('Please setting currency or exchange rate'));
        }
        $exchange_rate = $lang['exchange_rate'];
        $config = self::getWithdrawConfig();
        if(!$config){
            throw new \Exception(__('Please setting withdrawal rules'));
        }

        $min = intval($config['min']);
        $max = intval($config['max']);
        $service_fee = round(floatval($config['service_fee']), 3);      // 三位小数

        if($type == 'money'){
            $real_money = bcmul($pay_money, $exchange_rate, 0);
            $money = bcdiv($real_money, bcsub(1, $service_fee, 3), 0);
            $charge = bcmul($money, $service_fee, 0);
        }else{
            $charge = bcmul($money, $service_fee, 0);
            $pay_money = bcdiv(bcsub($money, $charge, 0), $exchange_rate, 2);
            $real_money = bcsub($money, $charge, 0);
        }
        if (bccomp($user->money, $money) === -1) {
            throw new \Exception(__('Insufficient withdrawable balance'));
        }

        // 检查最小提现金额
        if (bccomp($money, $min) === -1 && $type == 'money') {
            throw new \Exception(__('The withdrawal amount cannot be less than %d', $min));
        }

        // 检查最大提现金额
        if ($max && bccomp($money, $max) === 1 && $type == 'money') {
            throw new \Exception(__('The withdrawal amount cannot be greater than %d', $max));
        }

        $data = [
            'money'=>$money,
            'real_money'=>$real_money,
            'currency'=>$currency,
            'exchange_rate'=>$exchange_rate,
            'pay_money'=>$pay_money,
            'charge_money'=>$charge,
            'service_fee'=>$service_fee,
        ];
        return $data;
    }

    /**
     * 申请提现
     *
     * @param int $type 提现方式 wechat|alipay|bank
     * @param int $money 提现金额
     */
    public static function apply($type, $money, $currency, $platform)
    {
        $user = User::info();
        $lang = Lang::get(['currency'=>$currency]);
        if(empty($lang) || $lang['exchange_rate'] <= 0){
            throw new \Exception(__('Please setting currency or exchange rate'));
        }
        $exchange_rate = $lang['exchange_rate'];
        $config = self::getWithdrawConfig();
        if(!$config){
            throw new \Exception(__('Please setting withdrawal rules'));
        }
        if (!in_array($type, $config['methods'])) {
            throw new \Exception(__('The withdrawal method is currently not supported'));
        }

        $min = intval($config['min']);
        $max = intval($config['max']);
        $service_fee = round(floatval($config['service_fee']), 3);      // 三位小数

        // 检查最小提现金额
        if (bccomp($money, $min) === -1 || $money <= 0) {
            throw new \Exception(__('The withdrawal amount cannot be less than %d', $min));
        }

        // 检查最大提现金额
        if ($max && bccomp($money, $max) === 1 ) {
            throw new \Exception(__('The withdrawal amount cannot be greater than %d', $max));
        }

        // 计算手续费
        $charge = bcmul($money, $service_fee, 0);
        if (bccomp($user->money, $money) === -1) {
            throw new \Exception(__('Insufficient withdrawable balance'));
        }

        // 检查每日最大提现次数
        if (isset($config['perday_num']) && $config['perday_num'] > 0) {
            $num = self::where(['user_id' => $user->id, 'createtime' => ['egt', strtotime(date("Y-m-d", time()))]])->count();
            if ($num >= $config['perday_num']) {
                throw new \Exception(__('The daily withdrawal frequency cannot exceed %d times', $config['perday_num']));
            }
        }

        // 检查每日最大提现金额
        if (isset($config['perday_amount']) && $config['perday_num'] > 0) {
            $amount = self::where(['user_id' => $user->id, 'createtime' => ['egt', strtotime(date("Y-m-d", time()))]])->sum('money');
            if ($amount >= $config['perday_amount']) {
                throw new \Exception(__('The daily withdrawal amount cannot be greater than %d', $config['perday_amount']));
            }
        }

        // 检查提现账户信息
        $bank = \addons\dramas\model\UserBank::info($type, false);

        $apply = new self();
        $apply->apply_sn = self::getSn($user->id);
        $apply->site_id = $user->site_id;
        $apply->user_id = $user->id;
        $apply->money = bcsub($money, $charge, 0);
        $apply->currency = $currency;
        $apply->exchange_rate = $exchange_rate;
        $apply->pay_money = bcdiv(bcsub($money, $charge, 0), $exchange_rate, 2);
        $apply->charge_money = $charge;
        $apply->service_fee = $service_fee;
        $apply->apply_type = $type;
        $apply->platform = $platform;
        switch ($type) {
            case 'wechat':
                $applyInfo = [
                    'Real name' => $bank['real_name'],
                    'WeChat account'  => $bank['card_no'],
                    'Payment code'  => $bank['image'] ? cdnurl($bank['image'], true) : '',
                ];
                break;
            case 'alipay':
                $applyInfo = [
                    'Real name' => $bank['real_name'],
                    'Alipay account' => $bank['card_no'],
                    'Payment code'  => $bank['image'] ? cdnurl($bank['image'], true) : '',
                ];
                break;
            case 'bank':
                $applyInfo = [
                    'Real name' => $bank['real_name'],
                    'Bank name' => $bank['bank_name'],
                    'Bank card' => $bank['card_no']
                ];
                break;
        }
        if (!isset($applyInfo)) {
            throw new \Exception(__('Incorrect withdrawal information'));
        }
        $apply->apply_info = $applyInfo;

        $apply->status = 0;
        $apply->save();
        self::handleLog($apply, __('User initiates withdrawal request'));
        // 扣除用户余额
        User::money(-$money, $user->id, 'cash', $apply->id);

        // 检查是否执行自动打款
        $autoCheck = false;
        if ($type !== 'bank' && $config['wechat_alipay_auto']) {
            $autoCheck = true;
        }

        if ($autoCheck) {
            $apply = self::handleAgree($apply);
            $apply = self::handleWithdraw($apply);
        }

        return $apply;
    }

    public static function handleLog($apply, $oper_info)
    {
        $log = $apply->log;
        $oper = \addons\dramas\library\Oper::set();
        $log[] = [
            'oper_type' => $oper['oper_type'],
            'oper_id' => $oper['oper_id'],
            'oper_info' => $oper_info,
            'oper_time' => time()
        ];
        $apply->log = $log;
        $apply->save();
        return $apply;
    }

    // 同意
    public static function handleAgree($apply)
    {
        if ($apply->status != 0) {
            throw new \Exception(__('Do not repeat the operation'));
        }
        $apply->status = 1;
        $apply->save();
        return self::handleLog($apply, __('Agree to withdrawal application'));
    }

    // 处理打款
    public static function handleWithdraw($apply)
    {
        $withDrawStatus = true;
        if ($apply->status != 1) {
            throw new \Exception(__('Do not repeat the operation'));
        }

        if ($withDrawStatus) {
            $apply->status = 2;
            $apply->actual_money = $apply->pay_money;
            $apply->save();
            return self::handleLog($apply, __('Paid'));
        }
        return $apply;
    }

    // 拒绝
    public static function handleReject($apply, $rejectInfo)
    {
        if ($apply->status != 0 && $apply->status != 1) {
            throw new \Exception(__('Do not repeat the operation'));
        }
        $apply->status = -1;
        $apply->save();
        User::money($apply->money + $apply->charge_money, $apply->user_id, 'cash_error', $apply->id);
        return self::handleLog($apply, __('Rejected').':' . $rejectInfo);
    }

    /**
     * 提现类型列表
     */
    public function getApplyTypeList()
    {
        return [
            'bank' => __('Apply_type bank'),
            'wechat' => __('Apply_type wechat'),
            'alipay' => __('Apply_type alipay')
        ];
    }


    /**
     * 提现类型中文
     */
    public function getApplyTypeTextAttr($value, $data)
    {
        $value = isset($data['apply_type']) ? $data['apply_type'] : '';
        $list = $this->getApplyTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    /**
     * 提现信息
     */
    public function getApplyInfoAttr($value, $data)
    {
        $value = isset($data['apply_info']) ? $data['apply_info'] : $value;
        return json_decode($value, true);
    }

    /**
     * 提现信息 格式转换
     */
    public function setApplyInfoAttr($value, $data)
    {
        $value = isset($data['apply_info']) ? $data['apply_info'] : $value;
        $applyInfo = json_encode($value, JSON_UNESCAPED_UNICODE);
        return $applyInfo;
    }

    public function getStatusTextAttr($value, $data)
    {
        switch ($data['status']) {
            case 0:
                $status_name = __('Under review');
                break;
            case 1:
                $status_name = __('Processing');
                break;
            case 2:
                $status_name = __('Processed');
                break;
            case -1:
                $status_name = __('Rejected');
                break;
            default:
                $status_name = '';
        }

        return $status_name;
    }


    public static function getWithdrawConfig()
    {
        $site_id = Config::getSiteId();
        $config = \addons\dramas\model\Config::where('name', 'withdraw')
            ->where('site_id', $site_id)->find();
        $data = [];
        if(!empty($config)){
            $data = json_decode($config['value'], true);
        }
        return $data;
    }

    /**
     * 获取日志字段数组
     */
    public function getLogAttr($value, $data)
    {
        $value = array_filter((array)json_decode($value, true));
        return (array)$value;
    }

    /**
     * 设置日志字段
     * @param mixed $value
     * @return string
     */
    public function setLogAttr($value)
    {
        $value = is_object($value) || is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
        return $value;
    }
}
