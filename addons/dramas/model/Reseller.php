<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use addons\dramas\model\Share as ShareModel;
use think\Db;
use think\Model;
use traits\model\SoftDelete;

class Reseller extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'dramas_reseller';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    protected $hidden = ['createtime', 'deletetime', 'updatetime', 'status', 'weigh'];

    // 追加属性
    protected $append = [
    ];

    public function getContentAttr($value, $data){
        $value = $value ? json_decode($value, true) : (isset($data['content']) && $data['content'] ?
            json_decode($data['content'], true) : null);
        return $value;
    }

    public static function share_user_reseller($share, $user){
        $share_user_1 = User::where('id', $share['share_id'])->find();
        if($share_user_1){
            Db::name('dramas_reseller_user')->insert([
                'site_id' => $user->site_id,
                'user_id' => $user->id,
                'parent_id' => $share_user_1['id'],
                'reseller_user_id' => $share_user_1['id'],
                'type' => '1',
                'createtime' => time()
            ]);
        }
        $share_parent = ShareModel::where('user_id', $share['share_id'])->find();
        if($share_parent){
            $share_user_2 = User::where('id', $share_parent['share_id'])->find();
            if($share_user_2){
                Db::name('dramas_reseller_user')->insert([
                    'site_id' => $user->site_id,
                    'user_id' => $user->id,
                    'parent_id' => $share['share_id'],
                    'reseller_user_id' => $share_user_2['id'],
                    'type' => '2',
                    'createtime' => time()
                ]);
            }
        }
    }

}
