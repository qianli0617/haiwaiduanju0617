<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use think\Db;
use think\Model;

/**
 * 区块模型
 */
class Block extends Model
{
    protected $name = "dramas_block";
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    protected $hidden = ['createtime', 'updatetime', 'status', 'weigh'];
    // 追加属性
    protected $append = [
    ];


    public function getImageAttr($value, $data)
    {
        $value = $value ? $value : '';
        return cdnurl($value, true);
    }

    /**
     * 获取区块列表
     * @param $params
     * @return false|\PDOStatement|string|\think\Collection
     */
    public static function getBlockList($params)
    {
        $where['site_id'] = $params['site_id'];
        $where['lang_id'] = $params['lang_id'];
        $where['status'] = 'normal';
        $order = 'weigh DESC, id ASC';

        $list = self::where($where)
            ->orderRaw($order)
            ->select();

        return $list;
    }

}
