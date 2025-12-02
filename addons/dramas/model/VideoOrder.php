<?php

namespace addons\dramas\model;

use think\Db;
use think\Model;
use traits\model\SoftDelete;
use addons\dramas\exception\Exception;

class VideoOrder extends Model
{
    use SoftDelete;

    // 表名
    protected $name = 'dramas_video_order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'integer';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';
    protected $hidden = ['site_id', 'updatetime', 'deletetime'];

    // 追加属性
    protected $append = [
    ];


    public static function addVideoEpisodes($platform, $episodes){
        $price = $episodes['price'];
        if($price == 0){
            return true;
        }
        $user = User::info();
        $vid = $episodes['vid'];
        $episode_id = $episodes['id'];
        $video_order = self::where('user_id', $user->id)->where('vid', $vid)
            ->where(function ($query) use ($episode_id){
                $query->whereOr('episode_id', 0)->whereOr('episode_id', $episode_id);
            })->find();
        if($video_order){
            return true;
        }
        if($user->vip_expiretime > time()){
            $price = $episodes['vprice'];
            if($price == 0){
                return true;
            }
        }
        // 不能跨集购买
        $episodes_list = VideoEpisodes::where('vid', $vid)
            ->where('weigh', '>=', $episodes['weigh'])
            ->where('id', '<', $episode_id)
            ->where(function ($query) use ($user){
                if($user->vip_expiretime > time()){
                    return $query->where('vprice', '>', 0);
                }else{
                    return $query->where('price', '>', 0);
                }
            })
            ->select();
        foreach ($episodes_list as $item){
            $video_order = self::where('user_id', $user->id)->where('vid', $vid)
                ->where(function ($query) use ($item){
                    $query->whereOr('episode_id', 0)->whereOr('episode_id', $item['id']);
                })->find();
            if(empty($video_order)){
                new Exception(__('Please purchase in order of playback'));
            }
        }
        $order_sn = self::getSn($user->id);
        Db::transaction(function () use ($user, $vid, $episode_id, $price, $order_sn, $platform){
            $user = User::where('id', $user->id)->lock(true)->find();
            $data = [
                'site_id' => $user->site_id,
                'vid' => $vid,
                'episode_id' => $episode_id,
                'order_sn' => $order_sn,
                'user_id' => $user->id,
                'total_fee' => $price,
                'platform' => $platform,
            ];
            $video_order = self::create($data);
            VideoEpisodes::where('id', $episode_id)->setInc('sales');
            User::usable(-$price, $user, 'used_video', $video_order->id, __('Pay for watching dramass'), [
                'request_id'=>$video_order->id
            ]);
        });
        return true;
    }

    public static function addVideos($platform, $video){
        $price = $video['price'];
        if($price == 0){
            return true;
        }
        $user = User::info();
        $id = $video['id'];
        $video_order = self::where('user_id', $user->id)->where('id', $id)
            ->where('episode_id', 0)->find();
        if($video_order){
            return true;
        }
        if($user->vip_expiretime > time()){
            $price = $video['vprice'];
            if($price == 0){
                return true;
            }
        }
        $order_sn = self::getSn($user->id);
        Db::transaction(function () use ($user, $id, $price, $order_sn, $platform){
            $user = User::where('id', $user->id)->lock(true)->find();
            $data = [
                'site_id' => $user->site_id,
                'vid' => $id,
                'episode_id' => 0,
                'order_sn' => $order_sn,
                'user_id' => $user->id,
                'total_fee' => $price,
                'platform' => $platform,
            ];
            $video_order = self::create($data);
            Video::where('id', $id)->setInc('sales');
            User::usable(-$price, $user, 'used_video', $video_order->id, __('Purchase the entire dramas'), [
                'request_id'=>$video_order->id
            ]);
        });
        return true;
    }

    // 获取订单号
    public static function getSn($user_id)
    {
        $rand = $user_id < 9999 ? mt_rand(100000, 99999999) : mt_rand(100, 99999);
        $order_sn = date('Yhis') . $rand;

        $id = str_pad($user_id, (24 - strlen($order_sn)), '0', STR_PAD_BOTH);

        return $order_sn . $id;
    }

    public function video()
    {
        return $this->belongsTo('Video', 'vid', 'id', [], 'LEFT')->setEagerlyType(1);
    }


    public function episode()
    {
        return $this->belongsTo('VideoEpisodes', 'episode_id', 'id', [], 'LEFT')->setEagerlyType(1);
    }
}
