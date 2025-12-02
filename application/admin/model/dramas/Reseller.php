<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace app\admin\model\dramas;

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

    // 追加属性
    protected $append = [
        'status_text',
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getStatusList()
    {
        return ['normal' => __('Status normal'), 'hidden' => __('Status hidden')];
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

}
