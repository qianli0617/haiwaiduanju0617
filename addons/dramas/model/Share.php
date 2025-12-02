<?php
/*
  开发作者：duanju0
  QQ:0
*/

namespace addons\dramas\model;

use think\Db;
use think\Log;
use think\Model;

/**
 * 分享模型
 */
class Share extends Model
{

    // 表名,不含前缀
    protected $name = 'dramas_share';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    protected $deleteTime = false;

    protected $hidden = [];

    // 追加属性
    protected $append = [];

    protected static $eventMap = [
        'type' => [
            'index' => 'Index',
            'add' => 'Manual settings',
        ],
        'share_platform' => [
            'H5' => 'H5',
            'App' => 'APP',
            'Admin' => 'System backend',
        ],
        'from' => [
            'forward' =>  'Forward',
            'poster' => 'Poster',
            'link' => 'Link',
            'add' => 'Additional recording'
        ]
    ];

    public static function getEventMap($type){
        return self::$eventMap[$type];
    }

    public static function add($spm, $platform, $user=null)
    {
        if($user == null){
            $user = User::info();
        }
        $shareParams = [];
        $spm = explode('.', $spm);
        $share_id = intval($spm[0]);
        $shareParams['user_id'] = $user->id;
        $shareParams['site_id'] = $user->site_id;
        $last = self::where($shareParams)->find();
        if ($last) {
            // return false;
            Log::error('share-error:'.implode('.', $spm).'-'.$user->id);
            throw new \Exception(__('Existing sharing records'));
        }
        $shareParams['share_id'] = $share_id;

        // 不能分享给自己
        if ($user->id == $shareParams['share_id']) {
            // return false;
            Log::error('share-error:'.implode('.', $spm).'-'.$user->id);
            throw new \Exception(__('Cannot share with myself'));
        }
        
        $shareUser = User::get($shareParams['share_id']);
        if (empty($shareUser)) {
            // return false;
            Log::error('share-error:'.implode('.', $spm).'-'.$user->id);
            throw new \Exception(__('No sharer found'));
        }
        if($shareUser['parent_user_id'] == $user->id){
            Log::error('share-error:'.implode('.', $spm).'-'.$user->id);
            throw new \Exception(__('Cannot set sharers for each other'));
        }
        // 判断入口
        $typeArray = array_keys(self::$eventMap['type']);
        if(isset($typeArray[$spm[1] - 1])) {
            $type = $typeArray[$spm[1] - 1];
        }else {
            // return false;
            Log::error('share-error:'.implode('.', $spm).'-'.$user->id);
            throw new \Exception(__('Wrong sharing page'));
        }
        $shareParams['type'] = $type;
        $shareParams['type_id'] = $spm[2];

        // 判断来源
        $sharePlatformArray = array_keys(self::$eventMap['share_platform']);
        if(isset($sharePlatformArray[$spm[3] - 1])) {
            $share_platform = $sharePlatformArray[$spm[3] - 1];
        }else {
            // return false;
            Log::error('share-error:'.implode('.', $spm).'-'.$user->id);
            throw new \Exception(__('Wrong sharing platform'));
        }
        $shareParams['share_platform'] = $share_platform;

        $fromArray = array_keys(self::$eventMap['from']);
        if(isset($fromArray[$spm[1] - 1])) {
            $from = $fromArray[$spm[1] - 1];
        }else {
            // return false;
            Log::error('share-error:'.implode('.', $spm).'-'.$user->id);
            throw new \Exception(__('Wrong sharing source'));
        }
        $shareParams['from'] = $from;

        // 新用户不能分享给老用户 按需打开 TODO:分享配置可设置
        // if($user->id > $spm[0]) {
        //    throw new \Exception('不是新用户');
        // }

        // 查询用户分享
        $last = self::where($shareParams)->find();
        if ($last) {
            // return false;
            Log::error('share-error:'.implode('.', $spm).'-'.$user->id);
            throw new \Exception(__('Existing sharing records'));
        }

        $shareParams['createtime'] = time();
        $shareParams['platform'] = $platform;
        
        $share = self::create($shareParams);
        return $share;
    }

    /**
     * 分享记录
     */
    public static function getList($params)
    {
        $user = User::info();
        extract($params);
        $type = $type ?? 'all';

        $shares = self::with(['user' => function ($query) {
            $query->withField('id,nickname,avatar');
        }])->where('share_id', $user->id);

        if ($type != 'all' && in_array($type, ['index'])) {
            $shares = $shares->{$type}();
        }

        $shares = $shares->order('id', 'desc')->paginate($per_page ?? 10);
        $shares = $shares->toArray();

        // 取出来商品和拼团信息，专门进行查询
        $sharesData = $shares['data'];

        // 组合数据
        foreach ($sharesData as $key => &$share) {
            $share['type_data'] = null;
            // 提示信息
            $share['msg'] = __('Accessing (%s) through (%s)', __(self::$eventMap['from'][$share['from']]), self::getLookMsg($share, $user));
        }

        $shares['data'] = $sharesData;
        return $shares;
    }

    /**
     * 拼接查看内容
     */
    private static function getLookMsg($data, $user)
    {
        $msg = __('dramas system');
        return $msg;
    }


    public function scopeIndex($query)
    {
        return $query->where('type', 'index');
    }


    public function user()
    {
        return $this->belongsTo(\addons\dramas\model\User::class, 'user_id')->field('id,nickname,avatar');
    }

}
