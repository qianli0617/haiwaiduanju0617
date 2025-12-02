<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

use addons\dramas\model\ResellerBind;
use addons\dramas\model\ResellerLog;
use addons\dramas\model\Richtext;
use app\common\library\Ems;
use app\common\library\Sms;
use fast\Random;
use think\Log;
use think\Validate;
use addons\dramas\model\UserOauth;
use addons\dramas\model\Config;

/**
 * 会员管理
 */
class User extends Base
{
    protected $noNeedLogin = ['accountLogin', 'captchaLogin', 'resetpwd'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        return parent::_initialize();
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $auth = \app\common\library\Auth::instance();
        $auth->setAllowFields(['id', 'parent_user_id', 'username', 'nickname', 'mobile', 'email', 'avatar', 'score', 'birthday', 'money',
            'group_id', 'verification', 'usable', 'vip_expiretime', 'reseller', 'is_vip']);
        $data = $auth->getUserinfo();
        $data['avatar'] = $data['avatar'] ? cdnurl($data['avatar'], true) : '';
        $data['vip_expiretime_text'] = $data['vip_expiretime'] ? date('Y-m-d', $data['vip_expiretime']) : '';
        $data['is_vip'] = $data['vip_expiretime'] > time() ? 1 : 0;

        $verification = $data['verification'];
        $verification->email = $verification->email ?? 0;
        $verification->mobile = $verification->mobile ?? 0;
        $data['verification'] = $verification;

        $user_oauth = UserOauth::where('user_id', $data['id'])->column('id', 'platform');
        $data['user_bind'] = $user_oauth;

        $data['reseller'] = ResellerBind::info();
        $data['parent_id'] = $data['parent_user_id'];
        $this->success('', $data);
    }

    /**
     * 分销商数据
     *
     * @return void
     */
    public function userData()
    {
        $auth = \app\common\library\Auth::instance();
        $auth->setAllowFields(['id', 'nickname', 'avatar', 'money', 'total_money', 'reseller']);
        $data = $auth->getUserinfo();
        $data['avatar'] = $data['avatar'] ? cdnurl($data['avatar'], true) : '';
        $data['reseller'] = ResellerBind::info();
        $data['reseller_money'] = ResellerLog::where('reseller_user_id', $data['id'])->sum('total_money');
        $data['today_reseller_money'] = ResellerLog::where('reseller_user_id', $data['id'])
            ->where('createtime', '>', strtotime(date('Y-m-d')))->sum('total_money');
        $config = Config::where('name', 'dramas')->where('site_id', $this->site_id)->value('value');
        $config = json_decode($config, true);
        $data['reseller_desc'] = [];
        if(isset($config['reseller_desc']) && $config['reseller_desc']){
            $data['reseller_desc'] = Richtext::get($config['reseller_desc'][$this->lang]);
        }
        $this->success('', $data);
    }

    /**
     * 密码登录
     * @ApiMethod   (POST)
     * @param string $account 账号
     * @param string $password 密码
     */
    public function accountLogin()
    {
        $account = $this->request->post('account');
        $password = $this->request->post('password');
        if (!$account || !$password) {
            $this->error(__('Invalid parameters'));
        }
        $ret = $this->auth->login($account, $password, $this->site_id);
        if ($ret) {
            $data = ['token' => $this->auth->getToken(), 'verification' => $this->auth->verification];
            $this->success(__('Logged in successful'), $data);
        } else {
            $this->error(__($this->auth->getError()));
        }
    }

    /**
     * 验证码登录/注册
     * @ApiMethod (POST)
     * @ApiParams   (name="account", type="string", required=true, description="手机号/邮箱")
     * @ApiParams   (name="captcha", type="string", required=true, description="验证码")
     * @ApiParams   (name="password", type="string", required=false, description="密码")
     * @ApiParams   (name="spm", type="string", required=false, description="分享标识")
     * @ApiParams   (name="platform", type="string", required=false, description="平台")
     */
    public function captchaLogin()
    {
        $account = $this->request->post('account');
        $captcha = $this->request->post('captcha');
        $password = $this->request->post('password');
        $spm = $this->request->post('spm');
        $platform = $this->request->header('platform', 'H5');
        if (!$account || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (Validate::is($account, "email")) {
            if (!Ems::check($account, $captcha, 'mobilelogin')) {
                $this->error(__('Captcha is incorrect'));
            }
            $user = \app\common\model\User::getByEmail($account);
        }elseif (Validate::regex($account, '/^\d+$/')) {
            if (!Sms::check($account, $captcha, 'mobilelogin')) {
                $this->error(__('Captcha is incorrect'));
            }
            $user = \app\common\model\User::getByMobile($account);
        }else{
            $this->error(__('Please enter the correct email account or phone number!'));
        }
        if ($user) {
            if ($user->status != 'normal') {
                $this->error(__('Account is locked'));
            }
            //如果已经有账号则直接登录
            $ret = $this->auth->direct($user->id);
        } else {
            if (Validate::is($account, "email")){
                $registerData['email'] = $account;
            }
            if (Validate::regex($account, '/^\d+$/')){
                $registerData['mobile'] = $account;
            }
            $registerData['password'] = $password;
            $registerData['spm'] = $spm;
            $registerData['platform'] = $platform;
            $ret = $this->register_user($registerData);
        }
        if ($ret) {
            if (Validate::is($account, "email")){
                Ems::flush($account, 'mobilelogin');
            }elseif (Validate::regex($account, "/^\d+$/")){
                Sms::flush($account, 'mobilelogin');
            }
            $data = ['token' => $this->auth->getToken(), 'verification' => $this->auth->verification];
            $this->success(__('Logged in successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 注册
     * 使用spm方法拼接 shareUserId(分享者用户ID).page(页面类型:1=首页(默认),2=AI创作,3=图片设计,4=知识库).pageId(页面模板ID).platform(平台渠道: 1=H5,2=微信公众号网页,3=微信小程序,4=Web,5=Admin,6=App).from(分享方式: 1=直接转发,2=海报,3=链接,4=补录)
     * 例 spm=258.2.0.4.2 即为ID为258用户通过电脑网页平台生成了AI创作模板ID为0的分享海报
     * @param $registerData
     * @return bool
     */
    private function register_user($registerData){
        $username = $registerData['username'] ?? Random::alnum(20);
        $password = $registerData['password'] ?? Random::alnum();
        $mobile = $registerData['mobile'] ?? '';
        $email = $registerData['email'] ?? '';
        $nickname = $registerData['nickname'] ?? '';
        $avatar = $registerData['avatar'] ?? '';
        $spm = $registerData['spm'] ?? '';
        $platform = $registerData['platform'] ?? '';
        $extend = $this->getUserDefaultFields();
        $extend['user_head'] = $this->match;
        $extend['nickname'] = $nickname ? $nickname : $extend['nickname'];
        $extend['avatar'] = $avatar ? $avatar : $extend['avatar'];
        $extend['site_id'] = $this->site_id;
        $this->{$extend['user_head']}();
        $registerResult = $this->auth->register($username, $password, $email, $mobile, $extend);
        if(!$registerResult) {
            $this->error(__($this->auth->getError()));
        }

        $user = $this->auth->getUser();
        if (empty($nickname)) {
            $user->nickname = $extend['nickname'] . $this->auth->getUser()->id;
            $user->save();
        }
        if(!empty($user->mobile)) {
            $verification = $user->verification;
            $verification->mobile = 1;
            $user->verification = $verification;
            $user->save();
        }
        if(!empty($user->email)) {
            $verification = $user->verification;
            $verification->email = 1;
            $user->verification = $verification;
            $user->save();
        }
        if($registerData['password']) {
            $verification = $user->verification;
            $verification->password = 1;
            $user->verification = $verification;
            $user->save();
        }

        $data = ['user_id'=>$user['id'], 'site_id'=>$this->site_id, 'lang_id'=>$this->lang_id];
        \think\Hook::listen('user_register_after', $data);
        // 保存推荐记录和关系
        if($spm){
            try {
                $share = ['spm'=>$spm, 'platform'=>$platform, 'site_id'=>$this->site_id, 'lang_id'=>$this->lang_id];
                \think\Hook::listen('register_after', $share);
            }catch (\Exception $e){
                Log::error('User-Reseller'.$e->getMessage());
            }
        }

        return true;
    }

    /**
     * 修改邮箱
     * @ApiMethod (POST)
     * @ApiParams   (name="email", type="string", required=false, description="邮箱")
     * @ApiParams   (name="captcha", type="string", required=true, description="验证码")
     */
    public function changeemail()
    {
        $user = $this->auth->getUser();
        $email = $this->request->post('email');
        $captcha = $this->request->post('captcha');
        if (!$email || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::is($email, "email")) {
            $this->error(__('Email is incorrect'));
        }
        if (\app\common\model\User::where('email', $email)->where('id', '<>', $user->id)->find()) {
            $this->error(__('Email already exists'));
        }
        $result = Ems::check($email, $captcha, 'changemobile');
        if (!$result) {
            $this->error(__('Captcha is incorrect'));
        }
        $verification = $user->verification;
        $verification->email = 1;
        $user->verification = $verification;
        $user->email = $email;
        $user->save();

        Ems::flush($email, 'changemobile');
        $this->success(__('Operation completed'));
    }

    /**
     * 修改手机号
     * @ApiMethod (POST)
     * @ApiParams   (name="mobile", type="string", required=false, description="手机号")
     * @ApiParams   (name="captcha", type="string", required=true, description="验证码")
     */
    public function changemobile()
    {
        $user = $this->auth->getUser();
        $mobile = $this->request->post('mobile');
        $captcha = $this->request->post('captcha');
        if (!$mobile || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "/^\d+$/")) {
            $this->error(__('Mobile is incorrect'));
        }
        if (\app\common\model\User::where('mobile', $mobile)->where('id', '<>', $user->id)->find()) {
            $this->error(__('Mobile already exists'));
        }
        $result = Sms::check($mobile, $captcha, 'changemobile');
        if (!$result) {
            $this->error(__('Captcha is incorrect'));
        }
        $verification = $user->verification;
        $verification->mobile = 1;
        $user->verification = $verification;
        $user->mobile = $mobile;
        $user->save();

        Sms::flush($mobile, 'changemobile');
        $this->success(__('Operation completed'));
    }

    /**
     * 重置密码
     * @ApiMethod (POST)
     * @ApiParams   (name="account", type="string", required=false, description="手机号/邮箱")
     * @ApiParams   (name="captcha", type="string", required=true, description="验证码")
     * @ApiParams   (name="password", type="string", required=false, description="密码")
     */
    public function resetpwd()
    {
        $account = $this->request->post('account');
        $newpassword = $this->request->post("password");
        $captcha = $this->request->post("captcha");
        if (Validate::is($account, "email")) {
            $type = 'email';
            $email = $account;
        }elseif (Validate::regex($account, "/^\d+$/")) {
            $type = 'mobile';
            $mobile = $account;
        }else{
            $this->error(__('Please enter the correct email account or phone number!'));
        }
        if (!$newpassword || !$captcha) {
            $this->error(__('Invalid parameters'));
        }
        //验证Token
        if (!Validate::make()->check(['newpassword' => $newpassword], ['newpassword' => 'require|regex:\S{6,30}'])) {
            $this->error(__('Password must be 6 to 30 characters'));
        }
        if ($type == 'mobile') {
            $user = \app\common\model\User::getByMobile($mobile);
            if (!$user) {
                $this->error(__('User not found'));
            }
            $ret = Sms::check($mobile, $captcha, 'resetpwd');
            if (!$ret) {
                $this->error(__('Captcha is incorrect'));
            }
            Sms::flush($mobile, 'resetpwd');
        } else {
            $user = \app\common\model\User::getByEmail($email);
            if (!$user) {
                $this->error(__('User not found'));
            }
            $ret = Ems::check($email, $captcha, 'resetpwd');
            if (!$ret) {
                $this->error(__('Captcha is incorrect'));
            }
            Ems::flush($email, 'resetpwd');
        }
        //模拟一次登录
        $this->auth->direct($user->id);
        $ret = $this->auth->changepwd($newpassword, '', true);
        if ($ret) {
            $this->success(__('Reset password successful'));
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 修改密码
     * @ApiMethod (POST)
     * @ApiParams   (name="oldpassword", type="string", required=false, description="旧密码")
     * @ApiParams   (name="newpassword", type="string", required=false, description="新密码")
     */
    public function changePwd()
    {
        $user = $this->auth->getUser();

        $oldpassword = $this->request->post("oldpassword");
        $newpassword = $this->request->post("newpassword");

        if (!$newpassword || !$oldpassword) {
            $this->error(__('Invalid parameters'));
        }
        if (strlen($newpassword) < 6 || strlen($newpassword) > 16) {
            $this->error(__('密码长度 6-16 位')); //TODO:密码规则校验
        }

        $ret = $this->auth->changepwd($newpassword, $oldpassword);

        if ($ret) {
            $this->auth->direct($user->id);
            $data = ['token' => $this->auth->getToken(), 'verification' => $this->auth->verification];
            $this->success(__('Change password successful'), $data);
        } else {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 解除绑定
     * @ApiMethod   (POST)
     * @ApiParams   (name="platform", type="string", required=true, description="平台")
     * @ApiParams   (name="provider", type="string", required=true, description="厂商：Wechat微信")
     */
    public function unbindThirdOauth()
    {
        $user = $this->auth->getUser();
        $platform = $this->request->post('platform');
        $provider = $this->request->post('provider');

        $verification = $user->verification;
        if (!$verification->mobile) {
            $this->error(__('Please bind your phone number first before unbinding'));
        }

        $verifyField = $platform;
        if ($platform === 'App' && $provider === 'Wechat') {
            $verifyField = 'wxOpenPlatform';
        }

        $verification->$verifyField = 0;
        $user->verification = $verification;
        $user->save();
        $userOauth = UserOauth::where([
            'platform' => $platform,
            'provider'  => $provider,
            'user_id' => $user->id
        ])->delete();
        if ($userOauth) {
            $this->success(__('Unbind successful'));
        }
        $this->error(__('Unbind failed'));
    }

    /**
     * 注销登录
     */
    public function logout()
    {
        if ($this->auth->isLogin()) {
            $this->auth->logout();
        }
        $this->success(__('Logout successful'));
    }

    /**
     * 修改会员个人信息
     * @ApiMethod (POST)
     * @param string $avatar 头像地址
     * @param string $username 用户名
     * @param string $nickname 昵称
     * @param string $birthday 生日
     * @param string $bio 个人简介
     */
    public function profile()
    {
        $user = $this->auth->getUser();
        $user_id = $user['id'];
        $username = $this->request->post('username');
        $nickname = $this->request->post('nickname');
        $bio = $this->request->post('bio', '');
        $birthday = $this->request->post('birthday', '');
        $avatar = $this->request->post('avatar', '', 'trim,strip_tags,htmlspecialchars');
        if ($username) {
            $exists = \app\common\model\User::where('username', $username)->where('site_id', $this->site_id)
                ->where('id', '<>', $this->auth->id)->find();
            if ($exists) {
                $this->error(__('Username already exists'));
            }
            $user->username = $username;
        }
        if(!empty($nickname)){
            $user->nickname = $nickname;
            try {
                $data = ['user_id'=>$user_id, 'site_id'=>$this->site_id, 'lang_id'=>$this->lang_id];
                \think\Hook::listen('user_bind_name_after', $data);
            }catch (\Exception $e){}
        }
        if(!empty($bio)){
            $user->bio = $bio;
        }
        if(!empty($birthday)){
            $user->birthday = $birthday;
        }
        if (!empty($avatar)) {
            $user->avatar = $avatar;
            try {
                $data = ['user_id'=>$user_id, 'site_id'=>$this->site_id, 'lang_id'=>$this->lang_id];
                \think\Hook::listen('user_bind_avatar_after', $data);
            }catch (\Exception $e){}
        }
        $user->save();
        $this->success(__('Operation completed'));
    }

    /**
     * 用户注销
     *
     * @return void
     */
    public function delete()
    {
        $user = $this->auth->getUser();
        $this->auth->delete($user->id);

        UserOauth::where('user_id', $user->id)->delete();

        $this->success(__('Logout successful'));
    }

    private function getUserDefaultFields()
    {   $userConfig = Config::get(['name' => 'user', 'site_id'=>$this->site_id]);
        $userConfig = isset($userConfig->value) ? json_decode($userConfig->value, true) : ['nickname'=>'Mett -', 'avatar'=>'/assets/img/logo.png'];
        return $userConfig;
    }

    private function setUserVerification($user, $provider, $platform)
    {
        $verification = $user->verification;
        if ($platform === 'App') {
            $platform = '';
            if ($provider === 'Wechat') {
                $platform = 'wxOpenPlatform';
            } elseif ($provider === 'Alipay') {
                $platform = 'aliOpenPlatform';
            }
        }
        if ($platform !== '') {
            $verification->$platform = 1;
            $user->verification = $verification;
            $user->save();
        }
    }

}
