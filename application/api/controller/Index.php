<?php

namespace app\api\controller;

use app\common\controller\Api;
use Omnipay\Omnipay;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     *
     */
    public function index()
    {
        $data1 = $this->getDirContents(ROOT_PATH . 'application' . DS . 'admin' . DS . 'lang' . DS);
        $data2 = $this->getDirContents(ADDON_PATH . 'dramas' . DS . 'lang' . DS);
        $data['admin'] = $data1;
        $data['dramas'] = $data2;
        $this->success('请求成功', $data);
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

}
