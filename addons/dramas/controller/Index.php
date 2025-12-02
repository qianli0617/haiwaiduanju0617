<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

use addons\dramas\model\Richtext;
use app\admin\model\AuthRule;
use app\common\library\Menu;
use fast\Random;
use fast\Tree;
use think\Config as FaConfig;
use think\Db;
use think\exception\HttpResponseException;

/**
 * 首页相关
 * Class Index
 * @package addons\dramas\controller
 * php think addon -a dramas -c package
 * php think api -a dramas -o api.html --force=true
 * sudo -u www php think dramas:chat start d
 */
class Index extends Base
{
    protected $noNeedLogin = ['init', 'about_us', 'lang_list', 'lang_data', 'index', 'richtext', 'check_host', 'version'];
    protected $noNeedRight = '*';

    /**
     * @ApiInternal
     */
    public function index()
    {
        $menu = self::getMenu();
        Menu::upgrade('dramas', $menu['new']);

        // TODO 更新dramas分站点权限
        $ai_rule_id = Db::name('auth_rule')->where('name', 'dramas')->value('id');
        $yx_rule_id = Db::name('auth_rule')->where('name', 'dramas/yingxiao')->value('id');
        $children_auth_rules = Db::name('auth_rule')->select();
        $ruleTree = new Tree();
        $ruleTree->init($children_auth_rules);
        $ruleIdList1 = $ruleTree->getChildrenIds($ai_rule_id, true);
        $ruleIdList2 = $ruleTree->getChildrenIds($yx_rule_id, true);
        $rules1 = implode(',', $ruleIdList1);
        $rules2 = implode(',', $ruleIdList2);
        $rules = trim('29,30,32,23,24,25,26,27,28,8,2,7,'.$rules1.','.$rules2, ',');
        Db::name('auth_group')->where('id', 2)->update(['rules'=>$rules]);

        header('Location: /');
        exit();
    }

    /**
     * @ApiInternal
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private static function getMenu()
    {
        $newMenu = [];
        $config_file = ADDON_PATH . "dramas" . DS . 'config' . DS . "menu.php";
        if (is_file($config_file)) {
            $newMenu = include $config_file;
        }
        $oldMenu = AuthRule::where('name','like',"dramas%")->select();
        $oldMenu = array_column($oldMenu, null, 'name');
        return ['new' => $newMenu, 'old' => $oldMenu];
    }

    /**
     * 初始化
     * @ApiParams   (name="platform", type="string", required=true, description="平台标识")
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function init()
    {
        $platform = $this->request->param('platform', 'H5'); // 获取平台标识
        $data = [];     // 设置信息
        if (!in_array($platform, ['App', 'H5'])) {
            $this->error(__('Please use the correct  platform'));
        }
        $configFields = ['dramas', 'share', 'user', $platform];    // 定义设置字段
        $configModel = new \addons\dramas\model\Config;
        $config = $configModel->where('site_id', $this->site_id)->where('name', 'in', $configFields)->column('value', 'name');

        // 基本设置
        $dramasConfig = isset($config['dramas']) ? @json_decode($config['dramas'], true) : [];
        if(isset($dramasConfig['lang_id']) && $dramasConfig['lang_id']){
            $dramasConfig['lang'] = \app\common\model\Lang::where('id', $dramasConfig['lang_id'])->value('lang');
        }else{
            $dramasConfig['lang'] = 'zh-cn';
        }
        $dramasConfig['name'] = $dramasConfig['name'][$this->lang] ?? '';
        $dramasConfig['user_protocol'] = $dramasConfig['user_protocol'][$this->lang] ?? null;
        $dramasConfig['privacy_protocol'] = $dramasConfig['privacy_protocol'][$this->lang] ?? null;
        $dramasConfig['about_us'] = $dramasConfig['about_us'][$this->lang] ?? null;
        $dramasConfig['contact_us'] = $dramasConfig['contact_us'][$this->lang] ?? null;
        $dramasConfig['legal_notice'] = $dramasConfig['legal_notice'][$this->lang] ?? null;
        $dramasConfig['usable_desc'] = $dramasConfig['usable_desc'][$this->lang] ?? null;
        $dramasConfig['vip_desc'] = $dramasConfig['vip_desc'][$this->lang] ?? null;
        $dramasConfig['reseller_desc'] = $dramasConfig['reseller_desc'][$this->lang] ?? null;
        unset($dramasConfig['user_protocol_title'],$dramasConfig['privacy_protocol_title'],$dramasConfig['about_us_title'],
            $dramasConfig['contact_us_title'],$dramasConfig['legal_notice_title'],$dramasConfig['usable_desc_title']
            ,$dramasConfig['vip_desc_title'],$dramasConfig['reseller_desc_title']);
        $dramasConfig['h5_theme'] = $this->h5_theme;
        $dramasConfig['logo'] = isset($dramasConfig['logo']) && $dramasConfig['logo']? cdnurl($dramasConfig['logo'], true) : '';
        $dramasConfig['company'] = isset($dramasConfig['company']) && $dramasConfig['company'] ? cdnurl($dramasConfig['company'], true) : '';
        $dramasConfig['mobile_switch'] = isset($dramasConfig['mobile_switch']) ? $dramasConfig['mobile_switch'] : '0';
        $dramasConfig['android_autoplay'] = isset($dramasConfig['android_autoplay']) ? $dramasConfig['android_autoplay'] : '1';
        $copyrights = $dramasConfig['copyright']['list'] ?? [];
        foreach ($copyrights as &$item){
            $item['image'] = isset($item['image']) && $item['image'] ? cdnurl($item['image'], true) : '';
        }
        $dramasConfig['copyright'] = $copyrights;
        $data['system'] = $dramasConfig;

        // 分享设置
        $shareConfig = isset($config['share']) ? json_decode($config['share'], true) : [];
        $shareConfig['user_poster_bg'] = isset($shareConfig['user_poster_bg']) && $shareConfig['user_poster_bg'] ? cdnurl($shareConfig['user_poster_bg'], true) : '';
        $shareConfig['user_poster_bg_color'] = $shareConfig['user_poster_bg_color'] ?? '#6A62D1';
        $data['share'] = $shareConfig;

        // 支付设置
        $payment = $configModel->where('site_id', $this->site_id)->where('group', 'payment')->select();
        $paymentConfig = [];
        foreach ($payment as $key => $v) {
            $val = json_decode($v->value, true);
            if ($val && in_array($platform, $val['platform'])) {
                if($v->name == 'paypal'){
                    $paymentConfig[] = ['name'=>__('Paypal'), 'type'=>$v->name, 'logo'=>cdnurl('/assets/addons/dramas/img/user_wallet_apply/paypal.png', true)];
                }elseif ($v->name == 'stripe'){
                    $paymentConfig[] = ['name'=>__('Stripe'), 'type'=>$v->name, 'logo'=>cdnurl('/assets/addons/dramas/img/user_wallet_apply/stripe.png', true)];
                }elseif ($v->name == 'wechat'){
                    $paymentConfig[] = ['name'=>__('Wechat'), 'type'=>$v->name, 'logo'=>cdnurl('/assets/addons/dramas/img/user_wallet_apply/wechat.png', true)];
                }elseif ($v->name == 'alipay'){
                    $paymentConfig[] = ['name'=>__('Alipay'), 'type'=>$v->name, 'logo'=>cdnurl('/assets/addons/dramas/img/user_wallet_apply/alipay.png', true)];
                }
            }
        }

        $data['payment'] = $paymentConfig;        // 平台支持的支付方式

        // 会员设置
        $data['user'] =  isset($config['user']) ? json_decode($config['user'], true) : [];

        $this->success('', $data);
    }

    /**
     * 站点相关信息
     * @throws \think\exception\DbException
     */
    public function about_us(){
        $configFields = ['dramas', 'wxMiniProgram', 'wxOfficialAccount'];    // 定义设置字段
        $configModel = new \addons\dramas\model\Config;
        $config = $configModel->where('site_id', $this->site_id)->where('name', 'in', $configFields)->column('value', 'name');

        // 基本信息
        $dramasConfig = [];
        if(isset($config['dramas'])){
            $dramasConfig = @json_decode($config['dramas'], true);
            if(isset($dramasConfig['lang_id']) && $dramasConfig['lang_id']){
                $dramasConfig['lang'] = \app\common\model\Lang::where('id', $dramasConfig['lang_id'])->value('lang');
            }else{
                $dramasConfig['lang'] = 'zh-cn';
            }
            $dramasConfig['name'] = $dramasConfig['name'][$this->lang] ?? '';
            $dramasConfig['logo'] = isset($dramasConfig['logo']) && $dramasConfig['logo'] ? cdnurl($dramasConfig['logo'], true) : '';
            $dramasConfig['company'] = isset($dramasConfig['company']) && $dramasConfig['company'] ? cdnurl($dramasConfig['company'], true) : '';
            $copyrights = $dramasConfig['copyright']['list'] ?? [];
            foreach ($copyrights as &$item){
                $item['image'] = isset($item['image']) && $item['image'] ? cdnurl($item['image'], true) : '';
            }
            $dramasConfig['copyright'] = $copyrights;
            $info = get_addon_info('dramas');
            $dramasConfig['version'] = $info['version'];

            $dramasConfig['user_protocol'] = isset($dramasConfig['user_protocol'][$this->lang]) ? Richtext::get($dramasConfig['user_protocol'][$this->lang]) : null;
            $dramasConfig['privacy_protocol'] = isset($dramasConfig['privacy_protocol'][$this->lang]) ? Richtext::get($dramasConfig['privacy_protocol'][$this->lang]) : null;
            $dramasConfig['about_us'] = isset($dramasConfig['about_us'][$this->lang]) ? Richtext::get($dramasConfig['about_us'][$this->lang]) : null;
            $dramasConfig['contact_us'] = isset($dramasConfig['contact_us'][$this->lang]) ? Richtext::get($dramasConfig['contact_us'][$this->lang]) : null;
            $dramasConfig['legal_notice'] = isset($dramasConfig['legal_notice'][$this->lang]) ? Richtext::get($dramasConfig['legal_notice'][$this->lang]) : null;
            $dramasConfig['usable_desc'] = isset($dramasConfig['usable_desc'][$this->lang]) ? Richtext::get($dramasConfig['usable_desc'][$this->lang]) : null;
            $dramasConfig['vip_desc'] = isset($dramasConfig['vip_desc'][$this->lang]) ? Richtext::get($dramasConfig['vip_desc'][$this->lang]) : null;
            $dramasConfig['reseller_desc'] = isset($dramasConfig['reseller_desc'][$this->lang]) ? Richtext::get($dramasConfig['reseller_desc'][$this->lang]) : null;
            unset($dramasConfig['user_protocol_title'],$dramasConfig['privacy_protocol_title'],$dramasConfig['about_us_title'],
                $dramasConfig['contact_us_title'],$dramasConfig['legal_notice_title'],$dramasConfig['usable_desc_title']
                ,$dramasConfig['vip_desc_title'],$dramasConfig['reseller_desc_title']);
        }
        $data['system'] = $dramasConfig;

        $this->success('', $data);
    }

    /**
     * 语言列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lang_list(){
        $list = \app\common\model\Lang::select();
        $lang_list = [];
        foreach ($list as $item){
            $lang_file = ADDON_PATH . 'dramas' . DS . 'lang' . DS . $item['lang'] .'.php';
            if(is_file($lang_file)){
                $data = include $lang_file;
                $filtered_array = array_filter($data, function($value) {
                    return empty($value);
                });
                if (count($filtered_array) > 10){
                    continue;
                }
            }else{
                continue;
            }
            $item['lang_text'] = __($item['lang']);
            $lang_list[] = $item;
        }
        $this->success('', $lang_list);
    }

    /**
     * 语言包
     * @ApiParams   (name="lang", type="string", required=true, description="语言")
     */
    public function lang_data(){
        $lang = $this->request->param('lang', 'zh-cn');
        if(!in_array($lang, config('allow_lang_list'))){
            $this->error(__('Error lang'));
        }
        $lang_file = ADDON_PATH . 'dramas' . DS . 'lang' . DS . $lang .'.php';
        $data = [];
        if(is_file($lang_file)){
            $data = include $lang_file;
        }
        $this->success('', $data);
    }

    /**
     * 反馈类型
     */
    public function feedback_type()
    {
        $this->success('', array_values(\addons\dramas\model\Feedback::$typeAll));
    }

    /**
     * 意见反馈
     * @ApiMethod   (POST)
     * @ApiParams   (name="type", type="string", required=true, description="反馈类型")
     * @ApiParams   (name="phone", type="string", required=true, description="联系电话")
     * @ApiParams   (name="content", type="string", required=true, description="反馈内容")
     * @ApiParams   (name="images", type="string", required=true, description="反馈图片，多个英文下逗号（,）分隔")
     */
    public function feedback() {
        $params = $this->request->post();

        // 表单验证
        $this->dramasValidate($params, get_class(), 'add');

        $this->success('', \addons\dramas\model\Feedback::add($params));
    }

    /**
     * 富文本详情
     * @ApiParams   (name="id", type="string", required=true, description="富文本ID")
     * @throws \think\exception\DbException
     */
    public function richtext()
    {
        $id = $this->request->get('id');
        $data = \addons\dramas\model\Richtext::get(['id' => $id, 'site_id'=>$this->site_id]);
        $this->success($data->title, $data);
    }

    /**
     * 版本更新信息
     */
    public function version(){
        // $oldversion = $this->request->get('oldversion', '');
        // $data = null;
        // if($oldversion != ''){
        //    $data = Db::name('dramas_version')->where('oldversion', $oldversion)->find();
        // }
        $data = Db::name('dramas_version')
            ->where('site_id', $this->site_id)
            ->where('status', 'normal')
            ->order('id', 'desc')
            ->find();
        $data['downloadurl'] = isset($data['downloadurl']) && $data['downloadurl'] ? cdnurl($data['downloadurl'], true) : '';
        $this->success('ok',$data);
    }

    /**
     * 上传文件
     * @ApiMethod (POST)
     * @ApiParams   (name="file", type="file", required=true, description="文件流")
     */
    public function upload()
    {
        $file = $this->request->file('file');
        if (empty($file)) {
            $this->error(__('No file upload or server upload limit exceeded'));
        }

        //判断是否已经存在附件
        $sha1 = $file->hash();

        $upload = FaConfig::get('upload');

        preg_match('/(\d+)(\w+)/', $upload['maxsize'], $matches);
        $type = strtolower($matches[2]);
        $typeDict = ['b' => 0, 'k' => 1, 'kb' => 1, 'm' => 2, 'mb' => 2, 'gb' => 3, 'g' => 3];
        $size = (int)$upload['maxsize'] * pow(1024, isset($typeDict[$type]) ? $typeDict[$type] : 0);
        $fileInfo = $file->getInfo();
        $suffix = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
        $suffix = $suffix && preg_match("/^[a-zA-Z0-9]+$/", $suffix) ? $suffix : 'file';

        $mimetypeArr = explode(',', strtolower($upload['mimetype']));
        $typeArr = explode('/', $fileInfo['type']);

        //禁止上传PHP和HTML文件
        if (in_array($fileInfo['type'], ['text/x-php', 'text/html']) || in_array($suffix, ['php', 'html', 'htm'])) {
            $this->error(__('Uploaded file format is limited'));
        }
        //验证文件后缀
        if (
            $upload['mimetype'] !== '*' &&
            (!in_array($suffix, $mimetypeArr)
                || (stripos($typeArr[0] . '/', $upload['mimetype']) !== false && (!in_array($fileInfo['type'], $mimetypeArr) && !in_array($typeArr[0] . '/*', $mimetypeArr))))
        ) {
            $this->error(__('Uploaded file format is limited'));
        }
        //验证是否为图片文件
        $imagewidth = $imageheight = 0;
        if (in_array($fileInfo['type'], ['image/gif', 'image/jpg', 'image/jpeg', 'image/bmp', 'image/png', 'image/webp']) || in_array($suffix, ['gif', 'jpg', 'jpeg', 'bmp', 'png', 'webp'])) {
            $imgInfo = getimagesize($fileInfo['tmp_name']);
            if (!$imgInfo || !isset($imgInfo[0]) || !isset($imgInfo[1])) {
                $this->error(__('Uploaded file is not a valid image'));
            }
            $imagewidth = isset($imgInfo[0]) ? $imgInfo[0] : $imagewidth;
            $imageheight = isset($imgInfo[1]) ? $imgInfo[1] : $imageheight;
        }

        // 文件 md5
        $fileMd5 = md5_file($fileInfo['tmp_name']);

        $replaceArr = [
            '{year}' => date("Y"),
            '{mon}' => date("m"),
            '{day}' => date("d"),
            '{hour}' => date("H"),
            '{min}' => date("i"),
            '{sec}' => date("s"),
            '{random}' => Random::alnum(16),
            '{random32}' => Random::alnum(32),
            '{filename}' => $suffix ? substr($fileInfo['name'], 0, strripos($fileInfo['name'], '.')) : $fileInfo['name'],
            '{suffix}' => $suffix,
            '{.suffix}' => $suffix ? '.' . $suffix : '',
            '{filemd5}' => $fileMd5,
        ];
        $savekey = $upload['savekey'];
        $savekey = str_replace(array_keys($replaceArr), array_values($replaceArr), $savekey);

        $uploadDir = substr($savekey, 0, strripos($savekey, '/') + 1);
        $fileName = substr($savekey, strripos($savekey, '/') + 1);

        if (in_array($upload['storage'], ['cos', 'alioss', 'qiniu'])) {     // upyun:又拍云 ，bos:百度BOS，ucloud: Ucloud， 如果要使用这三种，请自行安装插件配置，并将标示填入前面数组，进行测试
            $token_name = $upload['storage'] . 'token';     // costoken, aliosstoken, qiniutoken
            $uploads_addon = get_addon_info('uploads');
            if($upload['storage'] == 'alioss' && isset($uploads_addon['state']) && $uploads_addon['state'] == 1){
                $controller_name = '\\addons\\uploads\\controller\\Alioss';
            }elseif($upload['storage'] == 'cos' && isset($uploads_addon['state']) && $uploads_addon['state'] == 1){
                $controller_name = '\\addons\\uploads\\controller\\Cos';
            }elseif(method_exists('\\addons\\' . $upload['storage'] . '\\controller\\Index', 'index')){
                $controller_name = '\\addons\\' . $upload['storage'] . '\\controller\\Index';
            }else{
                $this->error(__('Please configure the cloud storage plugin first!'));
            }

            $storageToken[$token_name] = $upload['multipart'] && $upload['multipart'][$token_name] ? $upload['multipart'][$token_name] : '';
            $domain = request()->domain();
            try {
                $uploadCreate = \think\Request::create('foo', 'POST', array_merge([
                    'key' => $savekey,
                    'name' => $fileInfo['name'],
                    'md5' => $fileMd5,
                    'chunk' => 0,
                    'site_id' => $this->site_id,
                ], $storageToken));

                // 重新设置跨域允许域名
                $cors = config('fastadmin.cors_request_domain');
                config('fastadmin.cors_request_domain', $cors . ',' . $domain);

                $uploadController = new $controller_name($uploadCreate);
                $uploadController->upload();
            } catch (HttpResponseException $e) {
                $result = $e->getResponse()->getData();
                if (isset($result['code']) && $result['code'] == 0) {
                    $this->error($result['msg']);
                }

                $resultData = $result['data'];
            }
        } else {
            $splInfo = $file->validate(['size' => $size])->move(ROOT_PATH . '/public' . $uploadDir, $fileName);

            if ($splInfo) {
                $resultData = [
                    'url' => $uploadDir . $splInfo->getSaveName(),
                    'fullurl' => request()->domain() . $uploadDir . $splInfo->getSaveName()
                ];
            } else {
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }

        $params = array(
            'admin_id' => 0,
            'user_id' => (int)$this->auth->id,
            'site_id' => (int)$this->auth->site_id,
            'filename'    => substr(htmlspecialchars(strip_tags($fileInfo['name'])), 0, 100),
            'filesize' => $fileInfo['size'],
            'imagewidth' => $imagewidth,
            'imageheight' => $imageheight,
            'imagetype' => $suffix,
            'imageframes' => 0,
            'mimetype' => $fileInfo['type'] == 'application/octet-stream' && in_array($suffix, ['gif', 'jpg', 'jpeg', 'bmp', 'png', 'webp']) ? 'image/' . $suffix : $fileInfo['type'],
            'url' => $resultData['url'],
            'uploadtime' => time(),
            'storage' => $upload['storage'],
            'sha1' => $sha1,
        );
        $attachment = new \app\common\model\Attachment;
        $attachment->data(array_filter($params));
        $attachment->save();
        \think\Hook::listen("upload_after", $attachment);

        $this->success(__('Upload successful'), $resultData);
    }

}
