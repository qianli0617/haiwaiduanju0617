<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use think\Model;

class Usable extends Model
{
    // 表名
    protected $name = 'dramas_usable';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';

    protected $hidden = ['createtime', 'updatetime', 'status', 'weigh'];

    // 追加属性
    protected $append = [
    ];

    public function getContentAttr($value, $data){
        $value = $value ? json_decode($value, true) : (isset($data['content']) && $data['content'] ?
            json_decode($data['content'], true) : null);
        return $value;
    }

}
