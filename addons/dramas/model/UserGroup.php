<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use think\Model;

/**
 * 会员组模型
 */
class UserGroup extends Model
{

    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $hidden = ['createtime', 'updatetime', 'id', 'rules', 'status'];

    // 追加属性
    protected $append = [
    ];

}
