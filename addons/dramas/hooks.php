<?php

$defaultHooks = [
    'share_wx_after' => [            //分享微信后
        'addons\\dramas\\listener\\task\\Share'
    ],
    'share_wxf_after' => [            //分享微信朋友圈后
        'addons\\dramas\\listener\\task\\Share'
    ],
    'share_success' => [            //邀请新用户
        'addons\\dramas\\listener\\task\\Share'
    ],
    'user_register_after' => [            //用户注册后
        'addons\\dramas\\listener\\task\\Register'
    ],
    'user_bind_name_after' => [            //用户绑定昵称后
        'addons\\dramas\\listener\\task\\Register'
    ],
    'user_bind_avatar_after' => [            //用户绑定头像后
        'addons\\dramas\\listener\\task\\Register'
    ],
    'register_after' => [            //用户注册后推广关系保存
        'addons\\dramas\\listener\\Reseller'
    ],
    'finish_after' => [            //购买成功后分润
        'addons\\dramas\\listener\\Reseller'
    ],
    'uniad_success' => [            //观看广告
        'addons\\dramas\\listener\\task\\Uniad'
    ],
];


return $defaultHooks;
