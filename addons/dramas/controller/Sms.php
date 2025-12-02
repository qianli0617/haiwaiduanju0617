<?php

namespace addons\dramas\controller;

use app\common\library\Ems;
use app\common\library\Sms as Smslib;
use think\Validate;

/**
 * 手机短信接口
 */
class Sms extends Base
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    /**
     * 区号列表
     */
    public function nation_code(){
        $tel = json_decode(file_get_contents(ROOT_PATH . 'addons/dramas/library/data/tel.json'), true);
        foreach ($tel as &$t){
            $t['name_lang'] = __($t['en']);
        }
        $this->success('', $tel);
    }

    /**
     * 发送验证码
     * @ApiMethod (POST)
     * @ApiParams   (name="account", type="string", required=true, description="手机号/邮箱")
     * @ApiParams   (name="nation_code", type="string", required=false, description="手机号国家区号")
     * @ApiParams   (name="event", type="string", required=true, description="事件:register,changemobile,changepwd,resetpwd,mobilelogin:验证码登录,bind")
     */
    public function send(){
        $account = $this->request->post('account');
        $event = $this->request->post("event");
        $event = $event ? $event : 'register';
        $nationCode = $this->request->post("nation_code", '86');
        if (Validate::is($account, "email")) {
            $this->emsSend($account, $event);
        }elseif (Validate::regex($account, '/^\d+$/')) {
            $this->smsSend($account, $event, $nationCode);
        }else{
            $this->error(__('Please enter the correct email account or phone number!'));
        }
    }

    private function smsSend($mobile, $event, $nationCode)
    {
        $last = \app\common\library\Sms::get($mobile, $event);
        if ($last && time() - $last['createtime'] < 60) {
            $this->error(__('Frequent sending'));
        }
        $ipSendTotal = \app\common\model\Sms::where(['ip' => $this->request->ip()])->whereTime('createtime', '-1 hours')->count();
        if ($ipSendTotal >= 5) {
            $this->error(__('Frequent sending'));
        }
        if ($event) {
            $userinfo = \app\common\model\User::getByMobile($mobile);
            if ($event == 'register' && $userinfo) {
                //已被注册
                $this->error(__('Registered'));
            } elseif (in_array($event, ['changemobile']) && $userinfo) {
                //被占用
                $this->error(__('Occupied'));
            } elseif (in_array($event, ['changepwd', 'resetpwd']) && !$userinfo) {
                //未注册
                $this->error(__('Unregistered'));
            }
        }

        $ret = Smslib::send($this->site_id, $this->lang, $mobile, null, $event, $nationCode);
        if ($ret) {
            $this->success(__('Successfully sent'));
        } else {
            $this->error(__('Failed sent'));
        }
    }
    private function emsSend($email, $event)
    {
        $last = Ems::get($email, $event);
        if ($last && time() - $last['createtime'] < 60) {
            $this->error(__('Frequent sending'));
        }
        if ($event) {
            $userinfo = \app\common\model\User::getByEmail($email);
            if ($event == 'register' && $userinfo) {
                //已被注册
                $this->error(__('Registered'));
            } elseif (in_array($event, ['changemobile']) && $userinfo) {
                //被占用
                $this->error(__('Occupied'));
            } elseif (in_array($event, ['changepwd', 'resetpwd']) && !$userinfo) {
                //未注册
                $this->error(__('Unregistered'));
            }
        }
        $ret = Ems::send($this->site_id, $this->lang, $email, null, $event);
        if ($ret) {
            $this->success(__('Successfully sent'));
        } else {
            $this->error(__('Failed sent'));
        }
    }

}
