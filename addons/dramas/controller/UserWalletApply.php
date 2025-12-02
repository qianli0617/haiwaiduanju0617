<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;


use app\common\model\Lang;

/**
 * 提现管理
 * Class UserWalletApply
 * @package addons\dramas\controller
 */
class UserWalletApply extends Base
{
    protected $noNeedLogin = ['rule'];
    protected $noNeedRight = ['*'];

    /**
     * 提现记录
     */
    public function index()
    {
        $this->success(__('Withdrawal records'), \addons\dramas\model\UserWalletApply::getList());
    }


    /**
     * 申请提现
     * @ApiMethod   (POST)
     * @ApiParams   (name="type", type="string", required=true, description="提现类型：wechat微信，alipay支付宝，bank银行")
     * @ApiParams   (name="money", type="string", required=true, description="提现积分")
     * @ApiParams   (name="currency", type="string", required=true, description="提现货币标准符号")
     * @ApiParams   (name="platform", type="string", required=true, description="平台:H5=H5,App=APP")
     * @throws \addons\dramas\exception\Exception
     */
    public function apply()
    {
        $this->repeat_filter();        // 防抖
        $type = $this->request->post('type');
        $money = $this->request->post('money');
        $currency = $this->request->post('currency');
        $platform = $this->request->post('platform', '');
        $apply = \think\Db::transaction(function () use ($type, $money, $currency, $platform) {
            try {
                return \addons\dramas\model\UserWalletApply::apply($type, $money, $currency, $platform);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        });
        if($apply) {
            $this->success(__('Apply successful'));
        }
        $this->error(__('Apply unsuccessful'));
    }

    /**
     * 积分货币兑换
     * @ApiMethod   (POST)
     * @ApiParams   (name="currency", type="string", required=true, description="提现货币标准符号")
     * @ApiParams   (name="money", type="string", required=false, description="提现积分")
     * @ApiParams   (name="pay_money", type="string", required=false, description="提现金额")
     * @throws \addons\dramas\exception\Exception
     */
    public function exchange()
    {
        $currency = $this->request->post('currency');
        $money = $this->request->post('money', 0);
        $pay_money = $this->request->post('pay_money', 0);

        try {
            $data = \addons\dramas\model\UserWalletApply::exchange($currency, $money, $pay_money);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success(__('Operation completed'), $data);
    }

    /**
     * 提现规则
     */
    public function rule()
    {
        $langs = Lang::field('currency, exchange_rate')->select();
        $config = \addons\dramas\model\UserWalletApply::getWithdrawConfig();
        if(!$config){
            $this->error(__('Please setting withdrawal rules'));
        }
        $min = round(floatval($config['min']), 2);
        $max = round(floatval($config['max']), 2);
        $service_fee = floatval($config['service_fee']) * 100;
        $service_fee = round($service_fee, 1);      // 1 位小数
        $perday_amount = isset($config['perday_amount']) ? round(floatval($config['perday_amount']), 2) : 0;
        $perday_num = isset($config['perday_num']) ? round(floatval($config['perday_num']), 2) : 0;

        $methods = $config['methods'] ?? [];
        $methods_data = [];
        foreach ($methods as $method){
            if($method == 'wechat'){
                $methods_data[] = ['name'=>__('Apply_type wechat'), 'type'=>$method];
            }elseif($method == 'alipay'){
                $methods_data[] = ['name'=>__('Apply_type alipay'), 'type'=>$method];
            }elseif($method == 'bank'){
                $methods_data[] = ['name'=>__('Apply_type bank'), 'type'=>$method];
            }
        }

        $rule = [
            'min' => $min,
            'max' => $max,
            'service_fee' => $service_fee,
            'perday_amount' => $perday_amount,
            'perday_num' => $perday_num,
            'currency_exchange_rate' => $langs,
            'methods' => $methods_data
        ];

        $this->success(__('Withdrawal rules'), $rule);
    }
}
