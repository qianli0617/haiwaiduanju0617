<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace app\admin\model\dramas;

use think\Model;


class Block extends Model
{

    // 表名
    protected $name = 'dramas_block';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'parsetpl_text',
        'status_text'
    ];

    public function getParsetplList()
    {
        return ['0' => __('Parsetpl 0'), '1' => __('Parsetpl 1')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Status normal'), 'hidden' => __('Status hidden')];
    }

    public function getParsetplTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['parsetpl']) ? $data['parsetpl'] : '');
        $list = $this->getParsetplList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getLangList()
    {
        $list = (new \app\admin\model\Lang())->column('lang', 'id');
        foreach ($list as &$value){
            $value = __($value);
        }
        return $list;
    }

    public function video()
    {
        return $this->belongsTo('Video', 'video_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }

}
