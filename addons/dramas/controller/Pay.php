<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

use addons\dramas\model\ResellerOrder;
use addons\dramas\model\UsableOrder;
use addons\dramas\model\User;
use addons\dramas\model\VipOrder;
use app\common\model\Lang;
use Omnipay\Omnipay;
use think\Log;
use Yansongda\Pay\Exceptions\GatewayException;

/**
 * 支付
 * Class Pay
 * composer require league/omnipay omnipay/paypal
 * composer require stripe/stripe-php
 * composer require league/omnipay omnipay/stripe
 * @package addons\dramas\controller
 */
class Pay extends Base
{

    protected $noNeedLogin = ['notifyx', 'notify_paypal', 'notifyr', 'confirm'];
    protected $noNeedRight = ['*'];


    /**
     * 支付宝网页支付
     * @ApiInternal
     */
    public function alipay()
    {
        $order_sn = $this->request->get('order_sn');
        $platform = $this->request->get('platform');

        list($order, $prepay_type) = $this->getOrderInstance($order_sn);
        $order = $order->where('order_sn', $order_sn)->where('site_id', $this->site_id)->find();

        try {
            if (!$order) {
                throw new \Exception(__('Order does not exist'));
            }
            if ($order->status > 0) {
                throw new \Exception(__('Order has payment'));
            }
            if ($order->status < 0) {
                throw new \Exception(__('Order has expired'));
            }

            $order_data = [
                'order_id' => $order->id,
                'out_trade_no' => $order->order_sn,
                'total_fee' => $order->total_fee,
                'subject' => __('Order payment'),
            ];

            $notify_url = $this->request->root(true) . '/addons/dramas/pay/notifyx/payment/alipay/platform/H5/sign/'.$this->sign;
            $pay = new \addons\dramas\library\PayService($this->site_id, 'alipay', 'url', $notify_url);
            $result = $pay->create($order_data);

            $result = $result->getContent();

	        echo $result;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        // $this->assign('result', $result);

        // return $this->view->fetch();
    }

    /**
     * PayPal支付
     * @ApiMethod   (POST)
     * @ApiParams   (name="order_sn", type="string", required=true, description="订单号")
     * @ApiParams   (name="payment", type="string", required=true, description="支付平台默认:paypal")
     * @ApiParams   (name="platform", type="string", required=true, description="平台:H5/App")
     * @ApiParams   (name="cancel_url", type="string", required=true, description="跳转地址")
     * @ApiParams   (name="return_url", type="string", required=true, description="跳转地址")
     */
    public function paypal(){
        $user = User::info();
        $order_sn = $this->request->post('order_sn', '');
        $payment = $this->request->post('payment', 'paypal');
        $platform = $this->request->post('platform', 'H5');
        $cancel_url = $this->request->post('cancel_url', '');
        $return_url = $this->request->post('return_url', '');

        list($order, $prepay_type) = $this->getOrderInstance($order_sn);
        $order = $order->where('user_id', $user->id)->where('order_sn', $order_sn)->where('site_id', $this->site_id)->find();

        if (!$order) {
            $this->error(__('Order does not exist'));
        }

        if ($order->status != 0) {
            $this->error(__('Order has expired'));
        }

        if (!$payment || !in_array($payment, ['wechat', 'alipay', 'paypal', 'stripe', 'wallet'])) {
            $this->error(__('Payment type error'));
        }

        $paymentConfig = @json_decode(\addons\dramas\model\Config::get(['name' => $payment, 'site_id'=>$this->site_id])->value, true);
        if(empty($paymentConfig)){
            $this->error(__('Please configure %s payment first', $payment));
        }
        if(!in_array($platform, $paymentConfig['platform'])){
            $this->error(__('Currently not supported for payment on the current platform'));
        }

        $currency = $order['currency'];
        $description = 'Buy Things';
        $name = 'Goods';
        if($prepay_type == 'reseller'){
            $reseller = \addons\dramas\model\Reseller::get($order['reseller_id']);
            $name = $reseller['name'];
            $description = __("Buy:%s", $reseller['name']);
        }elseif($prepay_type == 'vip'){
            $vip = \addons\dramas\model\Vip::get($order['vip_id']);
            $name = $vip['title'];
            $description = __("Buy:%s", $vip['title']);
        }elseif($prepay_type == 'usable'){
            $usable = \addons\dramas\model\Usable::get($order['usable_id']);
            $name = $usable['title'];
            $description = __("Buy:%s", $usable['title']);
        }
        if($payment == 'paypal'){
            $postData = [
                'amount' => $order->total_fee,
                'currency' => $currency,
                'description' => $description,
            ];
            $gateway = Omnipay::create('PayPal_Rest');
            $gateway->setClientId($paymentConfig['clent_id']);
            $gateway->setSecret($paymentConfig['client_secret']);
            $mode = $paymentConfig['environment'] == 'sandbox' ? true : false;
            $gateway->setTestMode($mode); //设置为测试环境，如果是生产环境，请设置为false
            $notify_url = $this->request->root(true) . '/addons/dramas/pay/notify_paypal/sign/' . $this->sign;
            $postData['returnUrl'] = $this->request->root(true) . '/h5?' . $this->sign . '#' . $return_url . '?';
            $postData['cancelUrl'] = $this->request->root(true) . '/h5?' . $this->sign . '#' . $cancel_url . '?';
            $postData['notifyUrl'] = $notify_url;
            $response = $gateway->purchase($postData)->setTransactionId($order->order_sn)->send();
            if ($response->isSuccessful()) {
                $result = $response->getData(); // 这将包含您需要的付款信息
                if($platform == 'App'){
                    $pay_data['amount'] = $order->total_fee;
                    $pay_data['currency'] = $currency;
                    $pay_data['clientId'] = $paymentConfig['clent_id'];
                    $pay_data['orderId'] = $result['id'];
                    $pay_data['environment'] = $paymentConfig['environment']; // 运行环境 sandbox / live
                    $pay_data["userAction"] = "continue"; // 按钮 paynow(立即付款) / continue(继续)
                    return $this->success(__('Successfully obtained advance payment'), ['pay_data' => $pay_data]);
                }

                return $this->success(__('Successfully obtained advance payment'), ['pay_data' => $result]);
            } else {
                // 显示错误信息
                $this->error(__('Payment error:%s', [$response->getMessage()]));
            }
        }elseif($payment == 'stripe'){
            if($platform == 'App'){
                $stripe = new \Stripe\StripeClient($paymentConfig['private_key']);
                try {
                    $customer = $stripe->customers->create();
                    $ephemeralKey = $stripe->ephemeralKeys->create([
                        'customer' => $customer->id,
                    ], [
                        'stripe_version' => '2022-08-01',
                    ]);
                    $paymentIntent = $stripe->paymentIntents->create([
                        'amount' => bcmul($order->total_fee, 100, 0),
                        'currency' => $currency,
                        'customer' => $customer->id,
                        'automatic_payment_methods' => [
                            'enabled' => 'true',
                        ],
                        'metadata' => ['order_sn' => $order->order_sn],
                    ]);
                }catch (\Exception $e){
                    $this->error(__('Payment error:%s', [$e->getMessage()]));
                }
                $data = [
                    'paymentIntent' => $paymentIntent->client_secret,
                    'ephemeralKey' => $ephemeralKey->secret,
                    'customer' => $customer->id,
                    'publishKey' => $paymentConfig['public_key']
                ];
                $this->success(__('Successfully obtained advance payment'),
                    ['pay_data' => $data]);
            }else{
                \Stripe\Stripe::setApiKey($paymentConfig['private_key']);
                try {
                    $session = \Stripe\Checkout\Session::create([
                        'line_items' => [
                            [
                                'price_data' => [
                                    'currency' => $currency,
                                    'unit_amount' => bcmul($order->total_fee, 100, 0),
                                    'product_data' => [
                                        'name' => $name,
                                        'description' => $description,
                                    ],
                                ],
                                'quantity' => 1,
                            ]
                        ],
                        'metadata' => ['order_sn' => $order->order_sn],
                        'mode' => 'payment',
                        'success_url' => $this->request->root(true) . '/h5?' . $this->sign . '#' . $return_url . '?session_id={CHECKOUT_SESSION_ID}',
                        'cancel_url' => $this->request->root(true) . '/h5?' . $this->sign . '#' . $return_url . '?',
                    ]);
                }catch (\Exception $e){
                    $this->error(__('Payment error:%s', [$e->getMessage()]));
                }
                return $this->success(__('Successfully obtained advance payment'), ['pay_data' => $session]);
            }
        }
    }

    /**
     * 拉起支付
     * @ApiMethod   (POST)
     * @ApiParams   (name="order_sn", type="string", required=true, description="订单号")
     * @ApiParams   (name="payment", type="string", required=true, description="支付平台默认wechat")
     * @ApiParams   (name="openid", type="string", required=true, description="微信openid")
     * @ApiParams   (name="platform", type="string", required=true, description="平台:wxMiniProgram=微信小程序")
     */
    public function prepay()
    {
        if (!class_exists(\Yansongda\Pay\Pay::class)) {
            new \addons\dramas\exception\Exception(__('Please configure the payment plugin first'));
        }

        $user = User::info();
        $order_sn = $this->request->post('order_sn');
        $payment = $this->request->post('payment', 'wallet');
        $openid = $this->request->post('openid', '');
        $platform = $this->request->post('platform');

        list($order, $prepay_type) = $this->getOrderInstance($order_sn);
        $order = $order->where('user_id', $user->id)->where('order_sn', $order_sn)->where('site_id', $this->site_id)->find();
        
        if (!$order) {
            $this->error(__('Order does not exist'));
        }

        if ($order->status != 0) {
            $this->error(__('Order has expired'));
        }

        if (!$payment || !in_array($payment, ['wechat', 'alipay', 'wallet'])) {
            $this->error(__('Payment type cannot be empty'));
        }

        if ($payment == 'wallet' && $prepay_type == 'order') {
            // 余额支付
            $this->walletPay($order, $payment, $platform);
        }

        $order_data = [
            'order_id' => $order->id,
            'out_trade_no' => $order->order_sn,
            'total_fee' => $order->total_fee,
        ];

        // 微信公众号，小程序支付，必须有 openid
        if ($payment == 'wechat') {
            if (in_array($platform, ['wxOfficialAccount', 'wxMiniProgram'])) {
                if (isset($openid) && $openid) {
                    // 如果传的有 openid
                    $order_data['openid'] = $openid;
                } else {
                    // 没有 openid 默认拿下单人的 openid
                    $oauth = \addons\dramas\model\UserOauth::where([
                        'user_id' => $order->user_id,
                        'provider' => 'Wechat',
                        'platform' => $platform
                    ])->find();

                    $order_data['openid'] = $oauth ? $oauth->openid : '';
                }
    
                if (empty($order_data['openid'])) {
                    // 缺少 openid
                    return $this->success(__('Missing openid'), 'no_openid');
                }
            }

            $order_data['body'] = __('Order payment');
        } else {
            $order_data['subject'] = __('Order payment');
        }

        try {
            $notify_url = $this->request->root(true) . '/addons/dramas/pay/notifyx/payment/' . $payment . '/platform/' . $platform . '/sign/' . $this->sign;
            $pay = new \addons\dramas\library\PayService($this->site_id, $payment, $platform, $notify_url);
            $result = $pay->create($order_data);
        } catch (\Exception $e) {
            $this->error(__("Payment configuration error:%s", $e->getMessage()));
        }
        
        if ($platform == 'Web') {
            $result = $result->code_url;
        }
        if ($platform == 'H5' && $payment == 'wechat') {
            $result = $result->getContent();
        }

        return $this->success(__('Successfully obtained advance payment'), [
            'pay_data' => $result,
        ]);
    }

    /**
     * 查询支付结果
     * @ApiMethod   (POST)
     * @ApiParams   (name="payment", type="string", required=true, description="支付平台默认wechat")
     * @ApiParams   (name="orderid", type="string", required=true, description="订单编号")
     */
    public function checkPay(){
        $payment = $this->request->post('payment', 'wechat');
        $orderid = $this->request->post("orderid", '');
        if (!$payment || !in_array($payment, ['wechat', 'alipay'])) {
            $this->error(__('Payment type cannot be empty'));
        }
        //发起PC支付(Scan支付)(PC扫码模式)
        $pay = new \addons\dramas\library\PayService($this->site_id, $payment, 'Web');
        try {
            $result = $pay->checkPay($orderid, 'scan');
            if ($result) {
                $this->success("", $result);
            } else {
                $this->error(__('Operation failed'));
            }
        } catch (GatewayException $e) {
            $this->error(__('Operation failed'));
        }
    }

    /**
     * 余额支付
     * @ApiInternal
     * @param $order
     * @param $type
     * @param $method
     */
    public function walletPay ($order, $type, $method) {
        // $order = Db::transaction(function () use ($order, $type, $method) {
        //     // 重新加锁读，防止连点问题
        //     $order = Order::nopay()->where('order_sn', $order->order_sn)->lock(true)->find();
        //     if (!$order) {
        //         $this->error("订单已支付");
        //     }
        //     $total_fee = $order->total_fee;
        //
        //     // 扣除余额
        //     $user = User::info();
        //
        //     if (is_null($user)) {
        //         // 没有登录，请登录
        //         $this->error(__('Please login first'), null, 401);
        //     }
        //
        //     User::money(-$total_fee, $user->id, 'wallet_pay', $order->id, '',[
        //         'order_id' => $order->id,
        //         'order_sn' => $order->order_sn,
        //     ]);
        //
        //     // 支付后流程
        //     $notify = [
        //         'order_sn' => $order['order_sn'],
        //         'transaction_id' => '',
        //         'notify_time' => date('Y-m-d H:i:s'),
        //         'buyer_email' => $user->id,
        //         'pay_fee' => $order->total_fee,
        //         'pay_type' => 'wallet'             // 支付方式
        //     ];
        //     $notify['payment_json'] = json_encode($notify);
        //     $order->paymentProcess($order, $notify);
        //
        //     return $order;
        // });

        $this->success(__('Operation completed'), $order);
    }

    /**
     * 支付成功回调
     * @ApiInternal
     */
    public function notifyx()
    {
        Log::write('notifyx-comein:');

        $payment = $this->request->param('payment', 'wechat');
        $platform = $this->request->param('platform', 'wxMiniProgram');

        $pay = new \addons\dramas\library\PayService($this->site_id, $payment, $platform);

        $result = $pay->notify(function ($data, $pay = null) use ($payment) {
            Log::write('notifyx-result:'. json_encode($data));
            try {
                $out_trade_no = $data['out_trade_no'];
                $out_refund_no = $data['out_biz_no'] ?? '';

                list($order, $prepay_type) = $this->getOrderInstance($out_trade_no);
                // 判断是否是支付宝退款（支付宝退款成功会通知该接口）
                if ($payment == 'alipay'    // 支付宝支付
                    && $data['notify_type'] == 'trade_status_sync'      // 同步交易状态
                    && $data['trade_status'] == 'TRADE_CLOSED'          // 交易关闭
                    && $out_refund_no                                   // 退款单号
                ) {
                    // 退款回调
                    if ($prepay_type == 'order') {
                        // 退款逻辑
                    } else {
                        // 其他订单如果支持退款，逻辑这里补充
                    }

                    return $this->payResponse($pay, $payment);
                }

                // 判断支付宝微信是否是支付成功状态，如果不是，直接返回响应
                if ($payment == 'alipay' && $data['trade_status'] != 'TRADE_SUCCESS') {
                    // 不是交易成功的通知，直接返回成功
                    return $this->payResponse($pay, $payment);
                }

                if ($payment == 'wechat' && ($data['result_code'] != 'SUCCESS' || $data['return_code'] != 'SUCCESS')) {
                    // 微信交易未成功，返回 false，让微信再次通知
                    return false;
                }

                // 支付成功流程
                $pay_fee = $payment == 'alipay' ? $data['total_amount'] : $data['total_fee'] / 100;


                //你可以在此编写订单逻辑
                $order = $order->where('order_sn', $out_trade_no)->find();

                if (!$order || $order->status > 0) {
                    // 订单不存在，或者订单已支付
                    return $this->payResponse($pay, $payment);
                }

                $notify = [
                    'order_sn' => $data['out_trade_no'],
                    'transaction_id' => $payment == 'alipay' ? $data['trade_no'] : $data['transaction_id'],
                    'notify_time' => date('Y-m-d H:i:s', strtotime($data['time_end'] ?? $data['notify_time'])),
                    'buyer_email' => $payment == 'alipay' ? $data['buyer_logon_id'] : $data['openid'],
                    'payment_json' => json_encode($data),
                    'pay_fee' => $pay_fee,
                    'pay_type' => $payment              // 支付方式
                ];
                $order->paymentProcess($order, $notify);

                return $this->payResponse($pay, $payment);
            } catch (\Exception $e) {
                Log::write('notifyx-error:' . json_encode($e->getMessage()));
            }
        });

        return $result;
    }

    /**
     * 支付成功回调
     * @ApiInternal
     */
    public function notify_paypal()
    {
        $payment = $this->request->param('payment', 'paypal');
        if($payment == 'paypal'){
            $data = $this->request->param();
            Log::write('notify-paypal-result:'. json_encode($data));
            $data = $this->request->param();
            if(!isset($data['resource']['transactions'][0]['invoice_number'])){
                return 'fail';
            }
            $out_trade_no = $data['resource']['transactions'][0]['invoice_number'];
            list($order, $prepay_type) = $this->getOrderInstance($out_trade_no);
            $order = $order->where('order_sn', $out_trade_no)->find();
            if (!$order || $order->status > 0) {
                // 订单不存在，或者订单已支付
                return 'success';
            }
            $paymentConfig = @json_decode(\addons\dramas\model\Config::get(['name' => 'paypal', 'site_id'=>$order['site_id']])->value, true);
            // 配置PayPal参数
            $gateway = Omnipay::create('PayPal_Rest');
            $gateway->setClientId($paymentConfig['clent_id']);
            $gateway->setSecret($paymentConfig['client_secret']);
            $mode = $paymentConfig['environment'] == 'sandbox' ? true : false;
            $gateway->setTestMode($mode); // 设置为沙箱模式，如果使用生产环境，请设置为false

            $response = $gateway->completePurchase([
                'transactionReference' => $data['resource']['id'],
                'payerId' => $data['resource']['payer']['payer_info']['payer_id'],
            ])->send();
            $isSuccessful = $response->isSuccessful();
            if (!$isSuccessful) {
                Log::write('notify-paypal-error:' . json_encode($response->getMessage()));
                return 'fail';
            }
            $amount = $data['resource']['transactions'][0]['amount']['total'];
            // $currency = $data['resource']['transactions'][0]['amount']['currency'];
            $transaction_id = $data['resource']['id'];
        }else{
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            $payload = @file_get_contents('php://input');
            Log::write('notify-stripe-result:'. $sig_header);
            Log::write('notify-stripe-result:'. $payload);
            $paymentConfig = @json_decode(\addons\dramas\model\Config::get(['name' => 'stripe', 'site_id'=>$this->site_id])->value, true);
            \Stripe\Stripe::setApiKey($paymentConfig['private_key']);
            $endpoint_secret = $paymentConfig['webhook_key'];
            $event = null;
            try {
                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $endpoint_secret
                );
            } catch(\UnexpectedValueException $e) {
                // Invalid payload
                Log::write('notify-stripe-result:'. json_encode(['Error parsing payload: ' => $e->getMessage()]));
                return 'fail';
            } catch(\Stripe\Exception\SignatureVerificationException $e) {
                // Invalid signature
                Log::write('notify-stripe-result:'. json_encode(['Error verifying webhook signature: ' => $e->getMessage()]));
                return 'fail';
            }
            switch ($event->type) {
                case 'checkout.session.completed':
                case 'payment_intent.succeeded':
                    $data = $event->data->object; // contains a \Stripe\PaymentIntent
                    if(!isset($data['metadata']['order_sn'])){
                        return 'fail';
                    }
                    $out_trade_no = $data['metadata']['order_sn'];
                    list($order, $prepay_type) = $this->getOrderInstance($out_trade_no);
                    $order = $order->where('order_sn', $out_trade_no)->find();
                    if (!$order || $order->status > 0) {
                        // 订单不存在，或者订单已支付
                        return 'success';
                    }
                    if($event->type == 'checkout.session.completed'){
                        if($data['payment_status'] !== 'paid'){
                            return 'fail';
                        }
                        $amount = bcdiv($data['amount_total'], 100, 2);
                    }else{
                        $amount = bcdiv($data['amount'], 100, 2);
                    }
                    // $currency = $data['currency'];
                    $transaction_id = $data['id'];
                    break;
                default:
                    Log::write('notify-stripe-result:'. 'Received unknown event type ' . $event->type);
                    return 'fail';
            }
        }


        // 验证支付回调
        try {
            // 处理支付成功逻辑
            $notify = [
                'order_sn' => $out_trade_no,
                'transaction_id' => $transaction_id,
                'notify_time' => date('Y-m-d H:i:s'),
                'buyer_email' => '',
                'payment_json' => json_encode($data),
                'pay_fee' => $amount,
                'pay_type' => $payment              // 支付方式
            ];
            $order->paymentProcess($order, $notify);
            return 'success';
        } catch (\Exception $e) {
            Log::write('notify-error:' . json_encode($e->getMessage()));
            return 'fail';
        }
    }

    /**
     * 退款成功回调
     * @ApiInternal
     */
    public function notifyr()
    {
        Log::write('notifyreturn-comein:');

        $payment = $this->request->param('payment');
        $platform = $this->request->param('platform');

        $pay = new \addons\dramas\library\PayService($this->site_id, $payment, $platform);

        $result = $pay->notifyRefund(function ($data, $pay = null) use ($payment, $platform) {
            try {
                $out_refund_no = $data['out_refund_no'];
                $out_trade_no = $data['out_trade_no'];

                // 退款逻辑


                return $this->payResponse($pay, $payment);
            } catch (\Exception $e) {
                Log::write('notifyreturn-error:' . json_encode($e->getMessage()));
                return false;
            }
        });

        return $result;
    }

    /**
     * @ApiInternal
     */
    public function confirm(){
    }

    /**
     * 响应
     * @ApiInternal
     */
    private function payResponse($pay = null, $payment = null) 
    {
        return $pay->success()->send();
    }


    /**
     * 根据订单号获取订单实例
     * @ApiInternal
     * @param [type] $order_sn
     * @return void
     */
    private function getOrderInstance($order_sn) 
    {
        if (strpos($order_sn, 'TO') === 0) {
            // VIP订单
            $prepay_type = 'vip';
            $order = new VipOrder();
        } else if (strpos($order_sn, 'AO') === 0) {
            // 剧场积分充值订单
            $prepay_type = 'usable';
            $order = new UsableOrder();
        } else {
            // 分销商订单
            $prepay_type = 'reseller';
            $order = new ResellerOrder();
        }

        return [$order, $prepay_type];
    }
}
