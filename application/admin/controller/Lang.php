<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use app\common\model\Config as ConfigModel;
use GuzzleHttp\Client;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\exception\PDOException;
use think\exception\ValidateException;
use think\response\Json;
use Exception;

/**
 * 语言包
 *
 * @icon fa fa-circle-o
 *
 * composer require guzzlehttp/psr7 1.9.1
 * composer require alibabacloud/alimt-20181012 1.2.0
 */
class Lang extends Backend
{

    /**
     * Lang模型对象
     * @var \app\admin\model\Lang
     */
    protected $model = null;
    protected $noNeedRight = ['get_lang_list'];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Lang;

    }


    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 查看
     *
     * @return string|Json
     * @throws \think\Exception
     * @throws DbException
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags', 'trim']);
        if (false === $this->request->isAjax()) {
            return $this->view->fetch();
        }
        //如果发送的来源是 Selectpage，则转发到 Selectpage
        if ($this->request->request('keyField')) {
            return $this->selectpage();
        }
        [$where, $sort, $order, $offset, $limit] = $this->buildparams();
        $list = $this->model
            ->where($where)
            ->select();
        $this->success('', null, $list);
    }

    /**
     * 添加自定义分类
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post();
            if ($params) {
                $params = json_decode($params['data'], true);
                $params['lang'] = strtolower($params['lang']);
                $params['nation_code'] = preg_replace("/[^0-9]/", '', $params['nation_code']);
                $params['currency'] = strtoupper($params['currency']);
                if(!preg_match('/^[a-zA-Z-]+$/', $params['lang'])){
                    $this->error(__('Lang can only [a-zA-Z-]'));
                }
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                if($this->model->where('lang', $params['lang'])->find()){
                    $this->error(__('Record already exists'));
                }
                $result = false;
                Db::startTrans();
                try {
                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    if($this->model->lang != 'zh-cn'){
                        $this->copyLang($this->model->lang);
                        $zh_cn_file = dirname(__DIR__) . DS . 'lang' . DS . 'zh-cn.php';
                        $data = include $zh_cn_file;
                        $data[$this->model->lang] = $this->model->lang_cn;
                        $this->writeToFile($zh_cn_file, $data);
                        $zh_cn_addon_file = ADDON_PATH . 'dramas' . DS . 'lang' . DS . 'zh-cn.php';
                        $data_addon = include $zh_cn_addon_file;
                        $data_addon[$this->model->lang] = $this->model->lang_cn;
                        $this->writeToFile($zh_cn_addon_file, $data_addon);
                        $this->copyAddonLang($this->model->lang);
                        $this->updateLangConfig($this->model->lang);
                    }
                    $this->success('', null, $this->model->id);
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }

        if ($this->request->isPost()) {
            $params = $this->request->post();
            if ($params) {
                $params = json_decode($params['data'], true);
                $params['lang'] = strtolower($params['lang']);
                $params['nation_code'] = preg_replace("/[^0-9]/", '', $params['nation_code']);
                $params['currency'] = strtoupper($params['currency']);
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $old = $row['lang'];
                $new = $params['lang'];
                $result = false;
                Db::startTrans();
                try {
                    $result = $row->allowField(true)->save($params);
                    $result = true;
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    if($row->lang != 'zh-cn'){
                        // 更新后台zh-cn
                        $zh_cn_file = dirname(__DIR__) . DS . 'lang' . DS . 'zh-cn.php';
                        $data = include $zh_cn_file;
                        $data[$row->lang] = $row->lang_cn;
                        $this->writeToFile($zh_cn_file, $data);
                        // 更新插件zh-cn
                        $zh_cn_addon_file = ADDON_PATH . 'dramas' . DS . 'lang' . DS . 'zh-cn.php';
                        $data_addon = include $zh_cn_addon_file;
                        $data_addon[$row->lang] = $row->lang_cn;
                        $this->writeToFile($zh_cn_addon_file, $data_addon);
//                        // 复制目录
//                        $this->copyLang($row->lang);
//                        $this->copyAddonLang($row->lang);
//                        $this->updateLangConfig($new, $old);
                    }
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->assignconfig("row", $row);
        return $this->view->fetch();
    }

    /**
     * 删除
     *
     * @param $ids
     * @return void
     * @throws DbException
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     */
    public function del($ids = null)
    {
        if (false === $this->request->isPost()) {
            $this->error(__("Invalid parameters"));
        }
        $ids = $ids ?: $this->request->post("ids");
        if (empty($ids)) {
            $this->error(__('Parameter %s can not be empty', 'ids'));
        }
        $pk = $this->model->getPk();
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            $this->model->where($this->dataLimitField, 'in', $adminIds);
        }
        $list = $this->model->where($pk, 'in', $ids)->select();

        $count = 0;
        Db::startTrans();
        try {
            foreach ($list as $item) {
                $count += $item->delete();
            }
            Db::commit();
        } catch (PDOException|Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        if ($count) {
            foreach ($list as $item){
                $name = $item['lang'];
                // 更新后台语言
                $lang_file = dirname(__DIR__) . DS . 'lang' . DS . $name .'.php';
                if(is_file($lang_file)){
                    unlink($lang_file);
                }
                $lang_folder = dirname(__DIR__) . DS . 'lang' . DS . $name . DS;
                $this->deleteDir($lang_folder);
                // 更新插件语言
                $lang_file = ADDON_PATH  . 'dramas' . DS . 'lang' . DS . $name .'.php';
                if(is_file($lang_file)){
                    unlink($lang_file);
                }
                // 更新中文语言
                $zh_cn_file = dirname(__DIR__) . DS . 'lang' . DS . 'zh-cn.php';
                $data = include $zh_cn_file;
                unset($data[$name]);
                $this->writeToFile($zh_cn_file, $data);
                $zh_cn_addon_file = ADDON_PATH . 'dramas' . DS . 'lang' . DS . 'zh-cn.php';
                $data_addon = include $zh_cn_addon_file;
                unset($data_addon[$name]);
                $this->writeToFile($zh_cn_addon_file, $data_addon);
                // 删除语言
                $this->updateLangConfig('', $name);
            }
            $this->success();
        }
        $this->error(__('No rows were deleted'));
    }

    /**
     * 获取语言文件列表
     * @internal
     */
    public function get_lang_list()
    {
        $lang = $this->request->param('name');
        $adminLangDir = dirname(__DIR__) . DS . 'lang' . DS;
        $addonsLangDir = ADDON_PATH . 'dramas' . DS . 'lang' . DS;
        $data_admin = $this->getDirContents($adminLangDir);
        $data_admin_lang = [];
        foreach ($data_admin as $item){
            if($lang == $item['name'] || $lang == str_replace('.php', '', $item['name'])){
                $data_admin_lang[] = $item;
            }
        }
        $data_dramas = $this->getDirContents($addonsLangDir);
        $data_dramas_lang = [];
        foreach ($data_dramas as $key=>$item){
            if($lang == $item['name'] || $lang == str_replace('.php', '', $item['name'])){
                $data_dramas_lang[] = $item;
            }
        }
        $data = [
            ['type'=>'folder', 'name'=>__('Admin lang'), 'children'=>$data_admin_lang],
            ['type'=>'folder', 'name'=>__('Dramas lang'), 'children'=>$data_dramas_lang]
        ];
        $this->success('', null, $data);
    }

    /**
     * 获取语言包内容
     */
    public function get_lang_data(){
        $lang = $this->request->post('lang');
        $lang_file = $this->request->post('lang_path');
        $zh_cn_file = str_replace($lang, 'zh-cn', $lang_file);
        $data = [];
        if($lang != 'zh-cn'){
            if(is_file($zh_cn_file)){
                $data['zh-cn'] = include $zh_cn_file;
            }
        }
        if(is_file($lang_file)){
            $data[$lang] = include $lang_file;
        }
        $list = [];
        foreach ($data['zh-cn'] as $key=>$value){
            $list[$key] = ['key'=>$key,'zh-cn'=>$value];
            if($lang != 'zh-cn'){
                $list[$key][$lang] = '';
            }
        }
        if($lang != 'zh-cn'){
            foreach ($data[$lang] as $key=>$value){
                if(isset($list[$key])){
                    $item = $list[$key];
                    $item[$lang] = $value;
                    $list[$key] = $item;
                }
            }
        }
        $list = count($list)>0 ? array_values($list) : [];
        $this->success('', null, $list);
    }

    /**
     * 更新语言包
     */
    public function set_lang_data(){
        $lang = $this->request->post('lang');
        $lang_file = $this->request->post('lang_path');
        $lang_data = $this->request->post('lang_data');
        $lang_data = json_decode($lang_data, true);
        $data = [];
        foreach ($lang_data as $item){
            $data[$item['key']] = $item[$lang];
        }
        $this->writeToFile($lang_file, $data);
        $this->success('');
    }

    /**
     * 百度翻译
     */
    public function multi_translate(){
        $lang = $this->request->post('lang');
        $to = $this->request->post('to');
        $lang_data = $this->request->post('lang_data', '', 'strip_tags');
        $lang_data = json_decode($lang_data, true);
        $app_id = config('site.app_id');
        $sec_key = config('site.sec_key');
        $error_msg = [
            '52001'=>'Request timeout',
            '52002'=>'System error',
            '52003'=>'Unauthorized user: Check if your app ID is correct or if the service is enabled',
            '54000'=>'Required parameter is empty',
            '54001'=>'Signature error',
            '54003'=>'Access frequency restricted',
            '54004'=>'Insufficient account balance',
            '54005'=>'Frequent long query requests',
            '58000'=>'Illegal client IP',
            '58001'=>'Translation language direction not supported: check if the translation language is in the language list',
            '58002'=>'The service is currently closed: please go to the management console to start the service',
            '90107'=>'Certification not passed or not effective',
        ];
        $i = 0;
        foreach ($lang_data as &$item){
            if(isset($item[$lang])){
                if($item[$lang] != '' || !isset($item['zh-cn']) || $item['zh-cn'] == ''){
                    continue;
                }
                ++$i;
                if($i > 100){
                    break;
                }
                $data = [];
                do{
                    if($data){
                        // 暂停0.2秒
                        usleep(200000);
                    }
                    $data = $this->translate($item['zh-cn'], $to, $app_id, $sec_key);
                }while (isset($data['error_code']) && $data['error_code']=='54003');

                if(isset($data['error_code']) && isset($data['error_msg'])){
                    $msg = isset($error_msg[$data['error_code']]) ? __($error_msg[$data['error_code']]) : $data['error_code'].':'.$data['error_msg'];
                    $this->error($msg, null, $lang_data);
                }
                if(isset($data['trans_result'][0]['dst'])){
                    $val = $data['trans_result'][0]['dst'];
                    if(strpos($data['trans_result'][0]['src'], '%s') !== false){
                        $val = str_replace('% s', ' %s ', $val);
                        $val = str_replace('%S', ' %s ', $val);
                    }
                    if(strpos($data['trans_result'][0]['src'], '%d') !== false){
                        $val = str_replace('% d', ' %d ', $val);
                        $val = str_replace('%D', ' %d ', $val);
                    }
                    $item[$lang] = $val;
                }
            }

        }
        $this->success('', null, $lang_data);
    }

    /**
     * 百度翻译配置
     * @return string
     * @throws \think\Exception
     */
    public function config(){
        $model = new ConfigModel();
        if ($this->request->isPost()) {
            $params = $this->request->post();
            $configList = [];
            $list = $model->where('name', 'in', ['app_id', 'sec_key'])->select();
            foreach ($list as $v) {
                if (isset($params[$v['name']])) {
                    $value = $params[$v['name']];
                    if (is_array($value) && isset($value['field'])) {
                        $value = json_encode(ConfigModel::getArrayData($value), JSON_UNESCAPED_UNICODE);
                    } else {
                        $value = is_array($value) ? implode(',', $value) : $value;
                    }
                    $v['value'] = $value;
                    $configList[] = $v->toArray();
                }
            }
            try {
                $model->allowField(true)->saveAll($configList);
            } catch (\think\Exception $e) {
                $this->error($e->getMessage());
            }
            try {
                ConfigModel::refreshFile();
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success();
        }
        $row = $model->where('name', 'in', ['app_id', 'sec_key'])->column('value', 'name');
        $this->assignconfig("row", $row);
        return $this->view->fetch();
    }

    private function translate($query, $to, $app_id, $sec_key){
        $url = "http://api.fanyi.baidu.com/api/trans/vip/translate";
        $args = array(
            'q' => $query,
            'appid' => $app_id,
            'salt' => rand(10000,99999),
            'from' => 'zh',
            'to' => $to,

        );
        $args['sign'] = $this->buildSign($query, $app_id, $args['salt'], $sec_key);
        $client = new Client();
        $header = ["Content-Type:application/x-www-form-urlencoded"];
        $res = $client->request('POST', $url, [
            'headers' => $header,
            'form_params' => $args,
            'timeout' => 60,
            'verify' => false,
            'allow_redirects' => ['strict' => true]
        ]);
        $ret = @json_decode($res->getBody()->getContents(), true);
        return $ret;
    }

    //加密
    private function buildSign($query, $appID, $salt, $secKey)
    {
        $str = $appID . $query . $salt . $secKey;
        $ret = md5($str);
        return $ret;
    }

    private function updateLangConfig($add_name='', $del_name=''){
        $coreConfigFile = CONF_PATH . 'config.php';
        $coreConfigText = @file_get_contents($coreConfigFile);
        $allow_lang_list = $allow_lang_list_new = config('allow_lang_list');

        if($del_name !== ''){
            // 找到"banana"元素的索引
            $index = array_search($del_name, $allow_lang_list_new);
            // 如果找到了索引，则使用unset()函数删除该元素
            if ($index !== false) {
                unset($allow_lang_list_new[$index]);
            }
        }

        $old = '\[';
        $new = '[';
        foreach ($allow_lang_list as $value){
            $old .= "'";
            $old .= $value;
            $old .= "', ";
        }
        foreach ($allow_lang_list_new as $value){
            $new .= "'";
            $new .= $value;
            $new .= "', ";
        }
        $old = trim($old, ', ');
        $old .= '\]';
        if($add_name !== ''){
            $new .= "'";
            $new .= $add_name;
            $new .= "'";
        }
        $new = trim($new, ', ');
        $new .= ']';
        $coreConfigText = @preg_replace("/'allow_lang_list'(\s+)=>(\s+){$old}/", "'allow_lang_list'\$1=>\$2{$new}", $coreConfigText);
        $result = @file_put_contents($coreConfigFile, $coreConfigText);
        if (!$result) {
            $this->error(__('Operation failed'));
        }
    }

    private function getDirContents($dir, &$results = array()){
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                $results[] = ['type'=>'file', 'name'=>$value, 'path'=>$path, 'children'=>[]];
            } else if($value != "." && $value != "..") {
                $folderName = basename($path);
                $data = ['type'=>'folder', 'name'=>$folderName, 'path'=>$path, 'children'=>[]];
                $this->getDirContents($path, $data['children']);
                $results[] = $data;
            }
        }
        return $results;
    }

    private function copyLang($name)
    {
        $zh_cn_file = dirname(__DIR__) . DS . 'lang' . DS . 'zh-cn.php';
        $lang_file = dirname(__DIR__) . DS . 'lang' . DS . $name .'.php';
        if(!is_file($lang_file)){
            copy($zh_cn_file, $lang_file);
            chmod($lang_file, 0755);
            $data = include $lang_file;
//            foreach ($data as $key=>&$value){
//                $value = '';
//            }
            $this->writeToFile($lang_file, $data);
        }
        $zh_cn_folder = dirname(__DIR__) . DS . 'lang' . DS . 'zh-cn' . DS;
        $lang_folder = dirname(__DIR__) . DS . 'lang' . DS . $name . DS;
        $this->copyDir($zh_cn_folder, $lang_folder);
    }

    private function copyAddonLang($name)
    {
        $zh_cn_file = ADDON_PATH . 'dramas' . DS . 'lang' . DS . 'zh-cn.php';
        $lang_file = ADDON_PATH . 'dramas' . DS . 'lang' . DS . $name .'.php';
        if(!is_file($lang_file)){
            copy($zh_cn_file, $lang_file);
            chmod($lang_file, 0755);
            $data = include $lang_file;
            foreach ($data as $key=>&$value){
                $value = '';
            }
            $this->writeToFile($lang_file, $data);
        }
    }

    private function copyDir($source, $dest){
        //检查目标目录是否存在，不存在则创建
        if(!is_dir($dest)){
            mkdir($dest,0755,true);
        }
        //打开目录
        $dir=opendir($source);
        while(($file=readdir($dir)) !== false){
            if(($file!='.') && ($file!='..')){
                //复制文件
                if(is_file($source.DS.$file) && !is_file($dest.DS.$file)){
                    copy($source.DS.$file,$dest.DS.$file);
                    chmod($dest.DS.$file, 0755);
                    $data = include $dest.DS.$file;
//                    foreach ($data as $key=>&$value){
//                        $value = '';
//                    }
                    $this->writeToFile($dest.DS.$file, $data);
                }
                //如果是子目录，则进行递归操作
                if(is_dir($source.DS.$file)){
                    $this->copyDir($source.DS.$file,$dest.DS.$file);
                }
            }
        }
        //关闭目录
        closedir($dir);
    }

    private function deleteDir($dir) {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!$this->deleteDir($dir . DS . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }

    private function writeToFile($zh_cn_file, $lang_data){
        // 返回 array 格式字符串
        $lang_var = $this->get_export_short($lang_data, 4);
        // lang 模板
        $lang_tlp = <<<EOT
<?php
                    
return {$lang_var};

EOT;
        // 写入lang文件
        $put_res = file_put_contents($zh_cn_file, $lang_tlp);
        if (!$put_res) {
            throw new Exception('文件写入失败 请确定lang目录有写入权限');
        }
    }

    private function get_export_short($var, $indent = "")
    {
        if (gettype($var) != 'array') {
            $this->error('语言变量不为array类');
        }
        $indexed = array_keys($var) === range(0, count($var) - 1);
        $r = [];
        foreach ($var as $key => $value) {
            $r[] = "    "
                . ($indexed ? "" : var_export_short($key) . " => ")
                . var_export_short($value, "    ");
        }
        return "[\n" . implode(",\n", $r) . "\n" . "]";
    }
}
