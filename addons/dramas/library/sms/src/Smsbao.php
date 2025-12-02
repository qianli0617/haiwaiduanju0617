<?php

namespace addons\dramas\library\sms\src;

class Smsbao
{
    private $_params = [];
    private $nationCode = '86';
    protected $error = '';
    protected $config = [];
    protected static $instance = null;
    protected $statusStr = array(
        "0"  => "Successfully sent",
        "-1" => "Error parameters",
        "-2" => "Server space not supported",
        "30" => "Password error",
        "40" => "Account does not exist",
        "41" => "Insufficient balance",
        "42" => "Account has expired",
        "43" => "IP address restrictions",
        "50" => "Content contains sensitive words",
        "51" => "Mobile is incorrect"
    );

    public function __construct($options = [])
    {
        $this->config = $options;
    }

    /**
     * 单例
     * @param array $options 参数
     * @return Smsbao
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }
        return self::$instance;
    }

    /**
     * 立即发送短信
     *
     * @return boolean
     */
    public function send()
    {
        $this->error = '';
        $params = $this->_params();
        if($this->nationCode == '86') {
            $url = 'http://api.smsbao.com/sms';
            $mobile = $params['mobile'];
        }else{
            $url = 'http://api.smsbao.com/wsms';
            $mobile = '+'.$this->nationCode.$params['mobile'];
        }

        $postArr = array(
            'u' => $params['u'],
            'p' => $params['p'],
            'm' => $mobile,
            'c' => $params['msg']
        );
        $options = [
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json; charset=utf-8'
            )
        ];
        $result = \fast\Http::sendRequest($url, $postArr, 'GET', $options);
        if ($result['ret']) {
            if (isset($result['msg']) && $result['msg'] == '0')
                return TRUE;
            $this->error = isset($this->statusStr[$result['msg']]) ? __($this->statusStr[$result['msg']]) : 'InvalidResult';
        } else {
            $this->error = $result['msg'];
        }
        return FALSE;
    }

    private function _params()
    {
        return array_merge([
            'u' => $this->config['username'],
            'p' => md5($this->config['password']),
        ], $this->_params);
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 接收手机
     * @param   string $mobile 手机号码
     * @return Smsbao
     */
    public function mobile($mobile = '')
    {
        $this->_params['mobile'] = $mobile;
        return $this;
    }

    public function nation_code($nationCode = '86'){
        $this->nationCode = $nationCode;
        return $this;
    }

    /**
     * 短信内容
     * @param   string $msg 短信内容
     * @return Smsbao
     */
    public function msg($msg = '')
    {
        $this->_params['msg'] = "【".$this->config['sign']."】" . $msg;
        return $this;
    }
}