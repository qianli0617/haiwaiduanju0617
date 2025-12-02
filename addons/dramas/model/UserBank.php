<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use think\Model;
use addons\dramas\exception\Exception;
use think\Db;
use traits\model\SoftDelete;

/**
 * 钱包
 */
class UserBank extends Model
{
    use SoftDelete;

    // 表名,不含前缀
    protected $name = 'dramas_user_bank';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';


    // 追加属性
    protected $append = [];


    // 提现账户详情
    public static function info($type, $encryptCardNo = false)
    {
        $user = User::info();
        $bank = self::where(['user_id' => $user->id, 'type' => $type])->find();
        if(!$bank) {
            throw new \Exception(__('Please complete your account information'));
        }
        $bank['image_url'] = $bank['image'] ? cdnurl($bank['image'], true) : '';
        if ($encryptCardNo) {
            $bank = self::encryptCardNo($bank, $type);
        }
        return $bank;
    }

    private static function encryptCardNo($bank, $platform)
    {
        switch ($platform) {
            case 'wechat':
                //加密openid
                $bank['card_no'] = substr_replace($bank['card_no'], '****', 3, 20);
                break;
            case 'bank':
                // 加密银行卡号
                $bank['card_no'] = substr_replace($bank['card_no'], '****', 3, 12);
                break;
            case 'alipay':
                // 加密支付宝账号
                $bank['card_no'] = substr_replace($bank['card_no'], '****', 3, 10);
                break;
        }
        return $bank;
    }

    // 编辑提现账户
    public static function edit($params)
    {
        $user = User::info();

        extract($params);

        $bank = self::where(['user_id' => $user->id, 'type' => $type])->find();

        if ($bank) {
            $bank->real_name = $real_name;
            $bank->bank_name = $bank_name;
            $bank->card_no = $card_no;
            $bank->image = $image;
            $bank['type'] = $type;
            $bank->save();
        } else {
            $bank = new self();
            $bank->site_id = Config::getSiteId();
            $bank->user_id = $user->id;
            $bank['type'] = $type;
            $bank->real_name = $real_name;
            $bank->bank_name = $bank_name;
            $bank->card_no = $card_no;
            $bank->image = $image;
            $bank->save();
        }
        $bank['image'] = $bank['image'] ? cdnurl($bank['image'], true) : '';
        return $bank;
    }
}
