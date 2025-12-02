<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use think\Model;
use traits\model\SoftDelete;

class Task extends Model
{
    use SoftDelete;

    // 表名
    protected $name = 'dramas_task';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'type_text',
    ];

    public static $hooks = [
        'user_register_after' => 'User register after',
        'share_success'     => 'Share success',
    ];

    
    public function getTypeList()
    {
        return ['first' => __('Type first'), 'day' => __('Type day')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }



}
