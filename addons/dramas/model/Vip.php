<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use think\Model;


class Vip extends Model
{

    // 表名
    protected $name = 'dramas_vip';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'type_text'
    ];

    
    public function getTypeList()
    {
        return ['d' => __('Day'), 'm' => __('Month'), 'q' => __('Quarter'), 'y' => __('Year')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getContentAttr($value, $data){
        $value = $value ? json_decode($value, true) : (isset($data['content']) && $data['content'] ?
            json_decode($data['content'], true) : null);
        return $value;
    }
}
