<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\listener;

use addons\dramas\model\ResellerBind;
use addons\dramas\model\ResellerLog;
use addons\dramas\model\Share as ShareModel;
use addons\dramas\model\User;
use think\Db;

/**
 * 分销
 */
class Reseller
{
    /**
     * 注册后推广关系保存
     * 注意user要求必须是登录用户，必须放到事务中执行
     * 使用spm方法拼接 shareUserId(分享者用户ID).page(页面类型:1=首页(默认),2=添加(手动)).pageId(页面ID).platform(平台渠道: 1=H5,2=微信公众号网页,3=微信小程序,4=Web,5=Admin,6=App).from(分享方式: 1=直接转发,2=海报,3=链接,4=补录)
     * 例 spm=258.1.0.3.2 即为ID为258用户通过微信小程序平台生成了首页分享海报
     */
    public function registerAfter($params){
        extract($params);
        $share = ShareModel::add($spm, $platform);
        if($share){
            $share_id = $share['share_id'];
            $data = ['user_id'=>$share_id, 'site_id'=>$site_id, 'lang_id'=>$lang_id];
            \think\Hook::listen('share_success', $data);
            $user = User::info();
            User::where('id', $user->id)->update(['parent_user_id'=>$share['share_id']]);
            \addons\dramas\model\Reseller::share_user_reseller($share, $user);
        }
    }

    /**
     * 订单完成后
     * [order, order_type]
     */
    public function finishAfter($param){
        extract($param);
        if(in_array($order['status'], [1,2])){
            $reseller_user = Db::name('dramas_reseller_user')
                ->where('user_id', $order['user_id'])
                ->select();
            if(empty($reseller_user)){
                return;
            }
            $lang_id = 0;
            if(isset($order['vip_id']) && $order['vip_id']){
                $lang_id = Db::name('dramas_vip')->where('id', $order['vip_id'])->value('lang_id');
            }elseif(isset($order['usable_id']) && $order['usable_id']){
                $lang_id = Db::name('dramas_usable')->where('id', $order['usable_id'])->value('lang_id');
            }elseif(isset($order['reseller_id']) && $order['reseller_id']){
                $lang_id = Db::name('dramas_reseller')->where('id', $order['reseller_id'])->value('lang_id');
            }
            $lang = Db::name('lang')->where('id', $lang_id)->find();
            if(empty($lang) || !$lang['currency'] || $lang['exchange_rate'] <= 0){
                return;
            }
            $currency = $lang['currency'];
            $exchange_rate = $lang['exchange_rate'];
            foreach ($reseller_user as $item){
                $reseller_bind = ResellerBind::where('user_id', $item['reseller_user_id'])->find();
                if(empty($reseller_bind)){
                    return false;
                }
                if($reseller_bind['expiretime'] != 0 && $reseller_bind['expiretime'] < time()){
                    return false;
                }
                $reseller = json_decode($reseller_bind['reseller_json'], true);
                $params = [
                    'reseller_user_id' => $item['reseller_user_id'],
                    'site_id' => $order['site_id'],
                    'user_id' => $order['user_id'],
                    'pay_money' => $order['pay_fee'],
                    'order_type' => $order_type,
                    'order_id' => $order['id']
                ];
                $msg = '';
                if($item['type'] == '1'){
                    $params['type'] = 'direct';
                    $params['ratio'] = $reseller['direct'];
                    // 佣金收益
                    $reseller_money = bcmul($order['pay_fee'], $reseller['direct']/100, 2);
                    $msg = __('Direct distribution commission');
                }elseif($item['type'] == '2'){
                    $params['type'] = 'indirect';
                    $params['ratio'] = $reseller['indirect'];
                    // 佣金收益
                    $reseller_money = bcmul($order['pay_fee'], $reseller['indirect']/100, 2);
                    $msg = __('Indirect distribution commission');
                }
                $total_money = bcmul($reseller_money, $exchange_rate, 0);
                $params['money'] = $reseller_money;
                $params['currency'] = $currency;
                $params['exchange_rate'] = $exchange_rate;
                $params['total_money'] = $total_money;
                $reseller_log = ResellerLog::create($params);
                if($total_money > 0){
                    \addons\dramas\model\User::money($total_money, $item['reseller_user_id'], 'commission_income',
                        $reseller_log->id, $msg, [
                            'reseller_log_id' => $reseller_log->id,
                            'user_id' => $reseller_log->user_id,
                            'parent_id' => $item['parent_id'],
                            'reseller_user_id' => $reseller_log->reseller_user_id
                        ]);
                }
            }
        }
    }

}
