<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\controller;

use addons\dramas\model\Config;
use addons\dramas\model\Share as ShareModel;
use fast\Random;

/**
 * 分享
 * Class Share
 * @package addons\dramas\controller
 */
class Share extends Base
{

    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];

    /**
     * 小程序分享二维码
     * https://mettgpt.nymaite.cn/addons/dramas/wechat/wxacode?scene=165.1.0.3.1
     */
    public function qrcode(){
        $scene = $this->request->get('scene', '');
        if(empty($scene)){
            $scene = $this->auth->id.'.1.0.3.2';
        }
        $path = $this->request->get('path', 'pages/home/index');
        $url = request()->domain().'/addons/dramas/wechat/wxacode?scene='.$scene.'&sign='.$this->sign.'&path='.$path;
        $this->success('', ['qrcode'=>$url]);
    }

    /**
     * 获取分享记录
     * @return void
     */
    public function index()
    {
        $params = $this->request->get();

        $shares = ShareModel::getList($params);
        return $this->success('', $shares);
    }

    /**
     * 添加上级
     * @ApiParams   (name="id", type="integer", required=true, description="上级用户ID")
     * @ApiParams   (name="platform", type="string", required=true, description="平台:H5=H5,App=APP")
     */
    public function add()
    {
        $id = $this->request->get('id');
        $platform = $this->request->get('platform', '');
        $key = array_search($platform, array_keys(ShareModel::getEventMap('share_platform')));
        $spm = $id.'.2.0.'.($key+1).'.4';
        $share = ['spm'=>$spm, 'platform'=>$platform, 'site_id'=>$this->site_id, 'lang_id'=>$this->lang_id];
        try {
            \think\Db::transaction(function () use ($share) {
                \think\Hook::listen('register_after', $share);
            });
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success(__('Operation completed'));
    }

}
