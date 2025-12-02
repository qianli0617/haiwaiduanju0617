<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

/**
 * 提现账户
 * Class UserBank
 * @package addons\dramas\controller
 */
class UserBank extends Base
{

    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];


    /**
     * 提现账户
     * @ApiParams   (name="type", type="string", required=true, description="提现账户类型：wechat微信，alipay支付宝，bank银行")
     */
    public function info()
    {
        $type = $this->request->get('type');
        try {
            $bankInfo = \addons\dramas\model\UserBank::info($type);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('', $bankInfo);
    }

    /**
     * 编辑提现
     * @ApiMethod   (POST)
     * @ApiParams   (name="type", type="string", required=true, description="提现账户类型：wechat微信，alipay支付宝，bank银行")
     * @ApiParams   (name="real_name", type="string", required=true, description="真实姓名")
     * @ApiParams   (name="card_no", type="string", required=false, description="账号")
     * @ApiParams   (name="bank_name", type="string", required=false, description="开户行")
     * @ApiParams   (name="image", type="string", required=false, description="收款码")
     */
    public function edit()
    {
        $params = $this->request->post();
        if ($params['type'] === 'alipay') {
            $params['bank_name'] = __('Alipay account');
            if(!$params['card_no'] && !$params['image']){
                $this->error(__('Withdrawal account and payment code must be selected and added!'));
            }
        }elseif ($params['type'] === 'wechat') {
            $params['bank_name'] = __('WeChat account');
            $params['card_no'] = '';
            if(!$params['image']){
                $this->error(__('WeChat withdrawal requires uploading the payment code!'));
            }
        }else{
            if(!$params['card_no'] || !$params['bank_name']){
                $this->error(__('Bank card withdrawal requires submission of card number and opening bank!'));
            }
        }
        $params['image'] = $params['image'] ?? '';

        // 表单验证
        $this->dramasValidate($params, get_class(), 'edit');

        $this->success(__('Operation completed'), \addons\dramas\model\UserBank::edit($params));
    }
}
