<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace app\admin\model\dramas;

use think\Model;
use traits\model\SoftDelete;

class Richtext extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'dramas_richtext';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [

    ];


    public function getLangList()
    {
        $list = (new \app\admin\model\Lang())->column('lang', 'id');
        foreach ($list as &$value){
            $value = __($value);
        }
        return $list;
    }


}
