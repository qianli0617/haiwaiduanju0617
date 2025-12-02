<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace addons\dramas\library\sms;

use addons\dramas\library\sms\src\Alisms;
use addons\dramas\library\sms\src\Hwsms;
use addons\dramas\library\sms\src\SmsSingleSender;
use addons\dramas\library\sms\src\Smsbao;

class Sms
{
    public $channel = 'alisms'; //渠道
    public $config = array(); //配置
    private $sendError = '';

    /**
     * dramas constructor.
     */
    public function __construct($channel, $config=array())
    {
        $this->channel = $channel;
        if(isset($config['template'])){
            $template = [];
            foreach ($config['template'] as $value){
                $template[$value['key']] = $value['value'];
            }
            $config['template'] = $template;
        }
        $this->config = $config;
    }

    /**
     * 短信发送行为
     * @param array $params 必须包含mobile,event,code
     * @return bool|mixed
     */
    public function send($params){
        if($this->channel == 'alisms'){
            $response = $this->aliSend($params);
        }elseif($this->channel == 'hwsms'){
            $response = $this->hwSend($params);
        }elseif($this->channel == 'qcloudsms'){
            $response = $this->qcloudSend($params);
        }elseif($this->channel == 'baosms'){
            $response = $this->baoSend($params);
        }else{
            $this->setError(__('Error parameters'));
            $response = false;
        }
        return $response;
    }

    /**
     * 短信发送通知
     * @param array $params 必须包含 mobile,event,msg
     * @return bool|mixed
     */
    public function notice($params){
        if($this->channel == 'alisms'){
            $response = $this->aliSend($params);
        }elseif($this->channel == 'hwsms'){
            $response = $this->hwSend($params);
        }elseif($this->channel == 'qcloudsms'){
            $response = $this->qcloudSend($params);
        }elseif($this->channel == 'baosms'){
            $response = $this->baoSend($params);
        }else{
            $this->setError(__('Error parameters'));
            $response = false;
        }
        return $response;
    }

    /**
     * 短信发送行为
     * 国际/港澳台消息：国际区号+号码，例如852000012****。
     * @param array $params 必须包含mobile,event,code
     * @return  boolean
     */
    private function aliSend($params)
    {
        $lang_ = $params['lang'] == 'zh-cn' ? 'zh-cn' : 'en';
        if (!isset($this->config['template'][$lang_]) || !$this->config['template'][$lang_]) {
            $this->setError(__('Please configure the SMS template first'));
            return false;
        }
        $alisms = new Alisms($this->config);
        $result = $alisms->mobile($params['nation_code'].$params['mobile'])
            ->template($this->config['template'][$lang_])
            ->param(['code' => $params['code']])
            ->send();
        if(!$result){
            $this->setError($alisms->getError());
        }
        return $result;
    }

    /**
     * 短信发送通知
     * @param array $params 必须包含 mobile,event,msg
     * @return  boolean
     */
    private function aliNotice($params)
    {
        $alisms = Alisms::instance();
        if (isset($params['msg'])) {
            if (is_array($params['msg'])) {
                $param = $params['msg'];
            } else {
                parse_str($params['msg'], $param);
            }
        } else {
            $param = [];
        }
        $param = $param ? $param : [];
        $params['template'] = isset($params['template']) ? $params['template'] : (isset($params['lang']) && isset($this->config['template'][$params['lang']]) && $this->config['template'][$params['lang']] ? $this->config['template'][$params['lang']] : '');
        $result = $alisms->mobile($params['nation_code'].$params['mobile'])
            ->template($params['template'])
            ->param($param)
            ->send();
        return $result;
    }

    /**
     * 短信发送行为
     * @param array $params 必须包含mobile,event,code
     * @return  boolean
     */
    private function hwSend($params)
    {
        $lang_ = $params['lang'] == 'zh-cn' ? 'zh-cn' : 'en';
        if (!isset($this->config['template'][$lang_]) || !$this->config['template'][$lang_]) {
            $this->setError(__('Please configure the SMS template first'));
            return false;
        }
        $hwsms = new Hwsms($this->config);
        $result = $hwsms->mobile('+'.$params['nation_code'].$params['mobile'])
            ->template($this->config['template'][$lang_])
            ->param(['code' => $params['code']])
            ->send();
        if(!$result){
            $this->setError($hwsms->getError());
        }
        return $result;
    }

    /**
     * 短信发送通知
     * @param array $params 必须包含 mobile,event,msg
     * @return  boolean
     */
    private function hwNotice($params)
    {
        $hwsms = Hwsms::instance();
        if (isset($params['msg'])) {
            if (is_array($params['msg'])) {
                $param = $params['msg'];
            } else {
                parse_str($params['msg'], $param);
            }
        } else {
            $param = [];
        }
        $param = $param ? $param : [];
        $params['template'] = isset($params['template']) ? $params['template'] : (isset($params['lang']) && isset($this->config['template'][$params['lang']]) && $this->config['template'][$params['lang']] ? $this->config['template'][$params['lang']] : '');
        $result = $hwsms->mobile('+'.$params['nation_code'].$params['mobile'])
            ->template($params['template'])
            ->param($param)
            ->send();

        return $result;
    }

    /**
     * 短信发送行为
     * @param Sms $params
     * @return  boolean
     */
    private function qcloudSend($params)
    {
        try {
            if ($this->config['isTemplateSender'] == 1) {
                $lang_ = $params['lang'] == 'zh-cn' ? 'zh-cn' : 'en';
                if (!isset($this->config['template'][$lang_]) || !$this->config['template'][$lang_]) {
                    $this->setError(__('Please configure the SMS template first'));
                    return false;
                }
                $templateID = $this->config['template'][$lang_];
                //普通短信发送
                $sender = new SmsSingleSender($this->config['appid'], $this->config['appkey']);
                $result = $sender->sendWithParam($params['nation_code'], $params['mobile'], $templateID, ["{$params->code}"], $this->config['sign'], "", "");
            } else {
                $sender = new SmsSingleSender($this->config['appid'], $this->config['appkey']);
                //参数：短信类型{1营销短信，0普通短信 }、国家码、手机号、短信内容、扩展码（可留空）、服务的原样返回的参数
                $result = $sender->send($params['type'], $params['nation_code'], $params['mobile'], $params['msg'], "", "");
            }
            $rsp = json_decode($result, true);
            if ($rsp['result'] == 0 && $rsp['errmsg'] == 'OK') {
                return true;
            } else {
                //记录错误信息
                $this->setError($rsp);
                return false;
            }
        } catch (\Exception $e) {
            $this->setError($e->getMessage());
        }
        return false;
    }

    /**
     * 短信发送通知
     * @param array $params
     * @return  boolean
     */
    private function qcloudNotice($params)
    {
        try {
            if ($this->config['isTemplateSender'] == 1) {
                $templateID = $this->config['template'][$params['lang']];
                //普通短信发送
                $sender = new SmsSingleSender($this->config['appid'], $this->config['appkey']);
                $result = $sender->sendWithParam($params['nation_code'], $params['mobile'], $templateID, ["{$params['msg']}"], $this->config['sign'], "", "");
            } else {
                $sender = new SmsSingleSender($this->config['appid'], $this->config['appkey']);
                //参数：短信类型{1营销短信，0普通短信 }、国家码、手机号、短信内容、扩展码（可留空）、服务的原样返回的参数
                $result = $sender->send($params['type'], $params['nation_code'], $params['mobile'], $params['msg'], "", "");
            }
            $rsp = (array)json_decode($result, true);
            if ($rsp['result'] == 0 && $rsp['errmsg'] == 'OK') {
                return true;
            } else {
                //记录错误信息
                $this->setError($rsp);
                return false;
            }
        } catch (\Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }
    }

    /**
     * 短信发送
     * 注：国际号码需包含国际地区前缀号码 格式必须是"+"号开头("+"号需要urlencode处理 如：urlencode("+60901234567")否则会出现格式错误)
     * @param Sms $params
     * @return mixed
     */
    private function baoSend($params)
    {
        $lang_ = $params['lang'] == 'zh-cn' ? 'zh-cn' : 'en';
        if (!isset($this->config['template'][$lang_]) || !$this->config['template'][$lang_]) {
            $this->setError(__('Please configure the SMS template first'));
            return false;
        }
        $smsbao = new Smsbao($this->config);
        $msg = str_replace('{code}', $params['code'], $this->config['template'][$lang_]);
        $result = $smsbao->mobile($params['mobile'])
            ->nation_code($params['nation_code'])
            ->msg($msg)
            ->send();
        if(!$result){
            $this->setError($smsbao->getError());
        }
        return $result;
    }

    /**
     * 短信发送通知（msg参数直接构建实际短信内容即可）
     * @param   array $params
     * @return  boolean
     */
    private function baoNotice($params)
    {
        $smsbao = new Smsbao($this->config);
        $result = $smsbao->nation_code($params['nation_code'])->mobile($params['mobile'])->msg($params['msg'])->send();
        return $result;
    }


    /**
     * 记录失败信息
     * @param [type] $err [description]
     */
    private function setError($err)
    {
        $this->sendError = $err;
    }

    /**
     * 获取失败信息
     * @return [type] [description]
     */
    public function getError()
    {
        return $this->sendError;
    }

}
