-- ----------------------------
-- Table structure for vs_dramas_block
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_block`  (
    `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `lang_id` int(11) NOT NULL DEFAULT 0 COMMENT '语言',
    `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标题',
    `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '图片',
    `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '链接',
    `video_id` int(11) NULL DEFAULT 0 COMMENT '视频',
    `parsetpl` tinyint(3) UNSIGNED NULL DEFAULT 0 COMMENT '链接类型:0=外部,1=内部',
    `weigh` int(11) NULL DEFAULT 0 COMMENT '权重',
    `createtime` bigint(20) NULL DEFAULT NULL COMMENT '添加时间',
    `updatetime` bigint(20) NULL DEFAULT NULL COMMENT '更新时间',
    `status` enum('normal','hidden') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'normal' COMMENT '状态:normal=显示,hidden=隐藏',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '区块表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_category
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_category`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(11) NOT NULL DEFAULT 0 COMMENT '站点',
    `lang_id` int(11) NOT NULL COMMENT '语言',
    `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
    `style` tinyint(1) NOT NULL DEFAULT 0 COMMENT '样式:1=一级分类,2=二级分类,3=三级分类',
    `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '类型:video=视频,year=年份,area=地区',
    `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片',
    `pid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父ID',
    `weigh` int(11) NOT NULL DEFAULT 0 COMMENT '权重',
    `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
    `status` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '状态',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    `updatetime` int(11) NULL DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `pid`(`pid`) USING BTREE,
    INDEX `weigh_id`(`weigh`, `id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '商城分类表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_config
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_config`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '变量名',
    `group` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分组',
    `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '变量标题',
    `tip` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '变量描述',
    `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '类型:string,text,int,bool,array,datetime,date,file',
    `value` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '变量值',
    `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '变量字典数据',
    `rule` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '验证规则',
    `extend` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '扩展属性',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `name`(`name`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '配置' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_cryptocard
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_cryptocard`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(11) NOT NULL DEFAULT 0 COMMENT '站点',
    `type` enum('vip','reseller','usable') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'usable' COMMENT '类型:vip=VIP套餐,reseller=分销商套餐,usable=剧场积分套餐',
    `item_id` int(11) NULL DEFAULT NULL COMMENT '套餐',
    `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '名称',
    `pwd` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '兑换码',
    `usetime` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '有效期',
    `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态:0=待使用,1=已使用',
    `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '备注',
    `usetimestart` bigint(20) NULL DEFAULT NULL COMMENT '使用时间',
    `usetimeend` bigint(20) NULL DEFAULT NULL COMMENT '使用时间',
    `createtime` bigint(20) NULL DEFAULT NULL COMMENT '创建时间',
    `deletetime` bigint(20) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `site_id`(`site_id`, `pwd`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '卡密' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_feedback
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_feedback`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `user_id` int(11) NOT NULL COMMENT '反馈用户',
    `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '反馈类型',
    `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '反馈内容',
    `images` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '图片',
    `phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '联系电话',
    `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '是否处理:0=未处理,1=已处理',
    `remark` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '处理备注',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    `updatetime` int(11) NULL DEFAULT NULL COMMENT '更新时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '意见反馈' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_reseller
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_reseller`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `lang_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '语言',
    `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分销商',
    `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '图片',
    `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '介绍',
    `price` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '价格',
    `original_price` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '原价',
    `level` tinyint(4) NOT NULL COMMENT '等级',
    `direct` decimal(20, 2) NOT NULL COMMENT '直接分润',
    `indirect` decimal(20, 2) NOT NULL COMMENT '间接分润',
    `expire` bigint(20) NOT NULL COMMENT '有效期',
    `weigh` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
    `status` enum('normal','hidden') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'normal' COMMENT '状态:normal=显示,hidden=隐藏',
    `updatetime` int(11) NOT NULL COMMENT '更新时间',
    `createtime` int(11) NOT NULL COMMENT '创建时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `level`(`site_id`, `lang_id`, `status`, `level`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '分销商' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_reseller_bind
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_reseller_bind`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `user_id` int(11) NOT NULL COMMENT '用户ID',
    `reseller_id` int(11) NOT NULL COMMENT '分销等级ID',
    `level` int(11) NOT NULL COMMENT '分销等级',
    `reseller_json` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分销参数',
    `expiretime` int(11) NOT NULL DEFAULT 0 COMMENT '过期时间',
    `createtime` int(11) NOT NULL COMMENT '创建时间',
    `updatetime` int(11) NOT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `user_id`(`user_id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户分销信息' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_reseller_log
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_reseller_log`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `type` enum('direct','indirect') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型:direct=直接佣金,indirect=间接佣金',
    `reseller_user_id` int(11) NOT NULL COMMENT '分销商ID',
    `user_id` int(11) NOT NULL COMMENT '用户ID',
    `pay_money` decimal(20, 2) NOT NULL COMMENT '支付金额',
    `ratio` decimal(20, 2) NOT NULL COMMENT '分润比例',
    `money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '佣金',
    `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '货币标准符号',
    `exchange_rate` int(11) NOT NULL DEFAULT 0 COMMENT '积分兑换比例',
    `total_money` int(11) NOT NULL COMMENT '积分佣金',
    `memo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '备注',
    `order_type` enum('vip','reseller','usable') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单类型:vip=VIP订单,reseller=分销商订单,usable=剧场积分订单',
    `order_id` int(11) NOT NULL COMMENT '订单ID',
    `createtime` int(11) NOT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '分佣记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_reseller_order
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_reseller_order`  (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `reseller_id` int(11) NOT NULL DEFAULT 0 COMMENT '分销商ID',
    `order_sn` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
    `user_id` int(11) NULL DEFAULT 0 COMMENT '用户',
    `times` int(11) NULL DEFAULT 0 COMMENT '有效期',
    `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '订单状态:-2=交易关闭,-1=已取消,0=未支付,1=已支付,2=已完成',
    `total_fee` decimal(20, 2) NOT NULL COMMENT '支付金额',
    `pay_fee` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '实际支付金额',
    `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '货币',
    `transaction_id` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易单号',
    `payment_json` varchar(2500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易原始数据',
    `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单备注',
    `pay_type` enum('wechat','alipay','wallet','score','cryptocard','system','paypal','stripe') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '支付方式:wechat=微信支付,alipay=支付宝,wallet=钱包支付,score=积分支付,cryptocard=卡密兑换,system=管理员设置,paypal=PayPal,stripe=Stripe',
    `paytime` int(11) NULL DEFAULT NULL COMMENT '支付时间',
    `ext` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '附加字段',
    `platform` enum('H5','Web','wxOfficialAccount','wxMiniProgram','App') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '平台:H5=H5,wxOfficialAccount=微信公众号,wxMiniProgram=微信小程序,Web=Web,App=APP',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    `updatetime` int(11) NULL DEFAULT NULL COMMENT '更新时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_reseller_user
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_reseller_user`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `user_id` int(10) UNSIGNED NOT NULL COMMENT '用户ID',
    `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级用户ID',
    `reseller_user_id` int(10) UNSIGNED NOT NULL COMMENT '分销商ID',
    `type` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户类型:1=直接用户,2=间接用户',
    `createtime` int(11) NOT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '分销用户' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_richtext
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_richtext`  (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `lang_id` int(11) NOT NULL DEFAULT 0 COMMENT '语言',
    `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '标题',
    `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '内容',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    `updatetime` int(11) NULL DEFAULT NULL COMMENT '更新时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '富文本' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_share
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_share`  (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `user_id` int(11) NOT NULL COMMENT '用户',
    `share_id` int(11) NOT NULL COMMENT '分享人',
    `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '识别类型:index=默认分享,add=手动添加',
    `type_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '识别标识',
    `platform` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '识别平台',
    `share_platform` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '分享来源',
    `from` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '分享方式',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户分享' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_task
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_task`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '任务标题',
    `desc` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '任务描述',
    `hook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '事件',
    `type` enum('day','first') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '任务类型:first=首次,day=每天',
    `limit` int(11) NOT NULL DEFAULT 1 COMMENT '限制次数',
    `usable` int(11) NOT NULL COMMENT '奖励次数',
    `status` enum('normal','hidden') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '状态:normal=启用,hidden=隐藏',
    `createtime` int(11) NOT NULL,
    `updatetime` int(11) NOT NULL,
    `deletetime` int(11) NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '任务' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_usable
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_usable`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `lang_id` int(11) NOT NULL DEFAULT 0 COMMENT '语言',
    `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
    `image` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片',
    `flag` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标识',
    `desc` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
    `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权益',
    `usable` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '总积分',
    `original_usable` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '原始积分',
    `give_usable` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '赠送积分',
    `price` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '总价格',
    `give_price` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '赠送金额',
    `first_price` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '首冲价格',
    `original_price` decimal(20, 2) NOT NULL COMMENT '划线价格',
    `status` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '是否启用:0=不启用,1=启用',
    `weigh` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
    `createtime` int(11) NOT NULL COMMENT '创建时间',
    `updatetime` int(11) NOT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'AI次数套餐' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_usable_order
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_usable_order`  (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `usable_id` int(11) NOT NULL DEFAULT 0 COMMENT '充值套餐',
    `order_sn` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
    `user_id` int(11) NULL DEFAULT 0 COMMENT '用户',
    `usable` int(11) NULL DEFAULT 0 COMMENT '充值次数',
    `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '订单状态:-2=交易关闭,-1=已取消,0=未支付,1=已支付,2=已完成',
    `total_fee` decimal(20, 2) NOT NULL COMMENT '支付金额',
    `pay_fee` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '实际支付金额',
    `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '货币',
    `transaction_id` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易单号',
    `payment_json` varchar(2500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易原始数据',
    `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单备注',
    `pay_type` enum('wechat','alipay','wallet','score','cryptocard','system','paypal','stripe') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '支付方式:wechat=微信支付,alipay=支付宝,wallet=钱包支付,score=积分支付,cryptocard=卡密兑换,system=管理员设置,paypal=PayPal,stripe=Stripe',
    `paytime` int(11) NULL DEFAULT NULL COMMENT '支付时间',
    `ext` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '附加字段',
    `platform` enum('H5','Web','wxOfficialAccount','wxMiniProgram','App') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '平台:H5=H5,wxOfficialAccount=微信公众号,wxMiniProgram=微信小程序,Web=Web,App=APP',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    `updatetime` int(11) NULL DEFAULT NULL COMMENT '更新时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'AI次数充值订单' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_user_bank
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_user_bank`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `user_id` int(11) NOT NULL COMMENT '用户id',
    `type` enum('bank','alipay','wechat') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '账户类型:bank=银行卡,alipay=支付宝,wechat=微信',
    `real_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '真实姓名',
    `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '银行名',
    `card_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '卡号',
    `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '收款码',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    `updatetime` int(11) NULL DEFAULT NULL COMMENT '更新时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '提现银行卡' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_user_cryptocard
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_user_cryptocard`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NULL DEFAULT NULL COMMENT '用户',
    `cryptocard_id` int(11) NULL DEFAULT NULL COMMENT '卡密',
    `type` enum('vip','reseller','usable') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'usable' COMMENT '类型:vip=VIP套餐,reseller=分销商套餐,usable=剧场积分套餐',
    `order_id` int(11) NOT NULL DEFAULT 0 COMMENT '订单 id',
    `createtime` bigint(20) NULL DEFAULT NULL COMMENT '使用时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户卡密记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_user_oauth
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_user_oauth`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `user_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '用户',
    `provider` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '厂商',
    `platform` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '平台',
    `unionid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '厂商ID',
    `openid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '平台ID',
    `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '昵称',
    `sex` tinyint(1) NULL DEFAULT 0 COMMENT '性别',
    `country` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '国家',
    `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '省',
    `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '市',
    `headimgurl` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '头像',
    `logintime` int(11) NULL DEFAULT NULL COMMENT '登录时间',
    `logincount` int(11) NULL DEFAULT 0 COMMENT '累计登陆',
    `expire_in` int(11) NULL DEFAULT NULL COMMENT '过期周期(s)',
    `expiretime` int(11) NULL DEFAULT NULL COMMENT '过期时间',
    `session_key` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT 'session_key',
    `refresh_token` varchar(110) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'refresh_token',
    `access_token` varchar(110) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'access_token',
    `createtime` int(11) NULL DEFAULT 0 COMMENT '创建时间',
    `updatetime` int(11) NULL DEFAULT 0 COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `openid`(`openid`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '第三方授权' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_user_wallet_apply
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_user_wallet_apply`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `user_id` int(11) NOT NULL COMMENT '提现用户',
    `apply_sn` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '提现单号',
    `apply_type` enum('bank','wechat','alipay') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '收款类型:bank=银行卡,wechat=微信零钱,alipay=支付宝',
    `money` decimal(20, 2) NOT NULL COMMENT '提现积分',
    `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '货币标准符号',
    `exchange_rate` int(11) NOT NULL COMMENT '积分兑换比例',
    `pay_money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '提现金额',
    `actual_money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '实际到账',
    `charge_money` decimal(20, 2) NOT NULL COMMENT '手续费',
    `service_fee` decimal(10, 3) NULL DEFAULT NULL COMMENT '手续费率',
    `apply_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '打款信息',
    `status` tinyint(1) NULL DEFAULT 0 COMMENT '提现状态:-1=已拒绝,0=待审核,1=处理中,2=已处理',
    `platform` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '平台',
    `payment_json` varchar(2500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易原始数据',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '申请时间',
    `updatetime` int(11) NULL DEFAULT NULL COMMENT '操作时间',
    `log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '操作日志',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `apply_sn`(`apply_sn`) USING BTREE COMMENT '提现单号'
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户提现' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_user_wallet_log
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_user_wallet_log`  (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志 id',
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户',
    `wallet` decimal(20, 2) NOT NULL COMMENT '变动金额',
    `wallet_type` enum('money','score','usable') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '日志类型:money=余额,score=积分,usable=AI次数',
    `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '变动类型',
    `before` decimal(20, 2) NOT NULL COMMENT '变动前',
    `after` decimal(20, 2) NOT NULL COMMENT '变动后',
    `item_id` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '项目 id',
    `memo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注',
    `ext` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '附加字段',
    `oper_type` enum('user','admin','system') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user' COMMENT '操作人类型',
    `oper_id` int(11) NOT NULL DEFAULT 0 COMMENT '操作人',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    `updatetime` int(11) NULL DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '钱包日志' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_version
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_version`  (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `site_id` int(11) NOT NULL DEFAULT 0,
    `oldversion` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '旧版本号',
    `newversion` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '新版本号',
    `packagesize` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '包大小',
    `content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '升级内容',
    `downloadurl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '下载地址',
    `enforce` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '强制更新',
    `createtime` bigint(20) NULL DEFAULT NULL COMMENT '创建时间',
    `updatetime` bigint(20) NULL DEFAULT NULL COMMENT '更新时间',
    `weigh` int(11) NOT NULL DEFAULT 0 COMMENT '权重',
    `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '状态:normal=正常,hidden=隐藏',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '版本表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_video
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_video`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(11) NOT NULL DEFAULT 0,
    `lang_id` int(11) NOT NULL DEFAULT 0 COMMENT '语言',
    `category_ids` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '分类',
    `area_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '地区',
    `year_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '年份',
    `title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
    `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '副标题',
    `image` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '封面',
    `flags` set('hot','recommend') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '标志:hot=热门,recommend=推荐',
    `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '简介',
    `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标签',
    `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '图文详情',
    `price` int(11) NOT NULL COMMENT '价格',
    `vprice` int(11) NOT NULL COMMENT 'VIP价格',
    `episodes` int(11) NOT NULL COMMENT '总集数',
    `score` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '评分',
    `sales` int(11) NOT NULL DEFAULT 0 COMMENT '销量',
    `favorites` int(11) NOT NULL DEFAULT 0 COMMENT '收藏量',
    `views` int(11) NOT NULL DEFAULT 0 COMMENT '播放量',
    `shares` int(11) NOT NULL DEFAULT 0 COMMENT '转发量',
    `likes` int(11) NOT NULL DEFAULT 0 COMMENT '点赞量',
    `fake_views` int(11) NOT NULL DEFAULT 0 COMMENT '虚拟播放量',
    `fake_favorites` int(11) NOT NULL DEFAULT 0 COMMENT '虚拟收藏量',
    `fake_shares` int(11) NOT NULL DEFAULT 0 COMMENT '虚拟转发量',
    `fake_likes` int(11) NOT NULL DEFAULT 0 COMMENT '虚拟点赞量',
    `weigh` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
    `status` enum('up','down') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'up' COMMENT '商品状态:up=上架,down=下架',
    `createtime` int(11) NOT NULL COMMENT '添加时间',
    `updatetime` int(11) NOT NULL COMMENT '更新时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '短剧' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_video_episodes
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_video_episodes`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(11) NOT NULL DEFAULT 0,
    `lang_id` int(11) NOT NULL DEFAULT 0 COMMENT '语言',
    `vid` int(11) NOT NULL DEFAULT 0 COMMENT '短剧',
    `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
    `image` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '封面',
    `video` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '视频',
    `duration` int(11) NOT NULL COMMENT '时长',
    `price` int(11) NOT NULL COMMENT '价格',
    `vprice` int(11) NOT NULL COMMENT 'VIP价格',
    `sales` int(11) NOT NULL DEFAULT 0 COMMENT '销量',
    `likes` int(11) NOT NULL DEFAULT 0 COMMENT '点赞量',
    `views` int(11) NOT NULL DEFAULT 0 COMMENT '播放量',
    `favorites` int(11) NOT NULL DEFAULT 0 COMMENT '收藏量',
    `shares` int(11) NOT NULL DEFAULT 0 COMMENT '转发量',
    `fake_likes` int(11) NOT NULL DEFAULT 0 COMMENT '虚拟点赞量',
    `fake_views` int(11) NOT NULL DEFAULT 0 COMMENT '虚拟播放量',
    `fake_favorites` int(11) NOT NULL DEFAULT 0 COMMENT '虚拟收藏量',
    `fake_shares` int(11) NOT NULL DEFAULT 0 COMMENT '虚拟转发量',
    `weigh` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
    `status` enum('normal','hidden') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'normal' COMMENT '商品状态:normal=显示,hidden=隐藏',
    `updatetime` int(11) NOT NULL COMMENT '更新时间',
    `createtime` int(11) NOT NULL COMMENT '添加时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '剧集' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_video_favorite
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_video_favorite`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(11) NOT NULL DEFAULT 0,
    `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型:like=点赞,favorite=收藏',
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户',
    `vid` int(11) NOT NULL DEFAULT 0 COMMENT '短剧',
    `episode_id` int(11) NOT NULL DEFAULT 0 COMMENT '剧集',
    `createtime` int(11) NOT NULL COMMENT '添加时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '收藏点赞' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_video_images
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_video_images`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(11) NOT NULL DEFAULT 0,
    `vid` int(11) NOT NULL COMMENT '短剧',
    `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '壁纸名称',
    `image` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '壁纸图片',
    `views` int(11) NOT NULL DEFAULT 0 COMMENT '浏览量',
    `downloads` int(11) NOT NULL DEFAULT 0 COMMENT '下载量',
    `createtime` int(11) NOT NULL COMMENT '添加时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '剧情壁纸' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_video_log
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_video_log`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(11) NOT NULL DEFAULT 0,
    `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型:log=记录,favorite=追剧',
    `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户',
    `vid` int(11) NOT NULL DEFAULT 0 COMMENT '短剧',
    `episode_id` int(11) NOT NULL DEFAULT 0 COMMENT '剧集',
    `view_time` int(11) NOT NULL DEFAULT 0 COMMENT '观看时间',
    `createtime` int(11) NOT NULL COMMENT '添加时间',
    `updatetime` int(11) NOT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '追剧记录' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_video_order
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_video_order`  (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `vid` int(11) NOT NULL DEFAULT 0 COMMENT '短剧',
    `episode_id` int(11) NOT NULL DEFAULT 0 COMMENT '剧集',
    `order_sn` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
    `user_id` int(11) NULL DEFAULT 0 COMMENT '用户',
    `total_fee` int(10) NOT NULL DEFAULT 0 COMMENT '支付积分',
    `platform` enum('H5','Web','wxOfficialAccount','wxMiniProgram','App') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '平台:H5=H5,wxOfficialAccount=微信公众号,wxMiniProgram=微信小程序,Web=Web,App=APP',
    `createtime` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
    `updatetime` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `vid`(`user_id`, `vid`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_video_performer
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_video_performer`  (
    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(11) NOT NULL DEFAULT 0,
    `vid` int(11) NOT NULL DEFAULT 0 COMMENT '短剧',
    `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '类型:director=导演,performer=演员',
    `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '姓名',
    `en_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '英文名',
    `avatar` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '头像',
    `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标签',
    `play` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '饰演',
    `profile` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '简介',
    `weigh` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
    `createtime` bigint(20) NOT NULL COMMENT '创建时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '演员表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_vip
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_vip`  (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `lang_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '语言',
    `type` enum('d','m','q','y') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '充值类型:d=天,m=月,q=季,y=年',
    `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
    `image` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标识',
    `desc` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
    `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权益',
    `price` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '价格',
    `first_price` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '首冲价格',
    `original_price` decimal(20, 2) NOT NULL COMMENT '划线价格',
    `num` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '充值数量',
    `status` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '是否启用:0=不启用,1=启用',
    `weigh` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
    `createtime` int(11) NOT NULL COMMENT '创建时间',
    `updatetime` int(11) NOT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户充值会员价格' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_vip_order
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_vip_order`  (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `site_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
    `vip_id` int(11) NOT NULL DEFAULT 0 COMMENT 'VIP ID',
    `order_sn` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
    `user_id` int(11) NULL DEFAULT 0 COMMENT '用户',
    `times` int(11) NULL DEFAULT 0 COMMENT 'VIP时长',
    `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '订单状态:-2=交易关闭,-1=已取消,0=未支付,1=已支付,2=已完成',
    `total_fee` decimal(20, 2) NOT NULL COMMENT '支付金额',
    `pay_fee` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '实际支付金额',
    `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '货币',
    `transaction_id` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易单号',
    `payment_json` varchar(2500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易原始数据',
    `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单备注',
    `pay_type` enum('wechat','alipay','wallet','score','cryptocard','system','paypal','stripe') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '支付方式:wechat=微信支付,alipay=支付宝,wallet=钱包支付,score=积分支付,cryptocard=卡密兑换,system=管理员设置,paypal=PayPal,stripe=Stripe',
    `paytime` int(11) NULL DEFAULT NULL COMMENT '支付时间',
    `ext` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '附加字段',
    `platform` enum('H5','Web','wxOfficialAccount','wxMiniProgram','App') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '平台:H5=H5,wxOfficialAccount=微信公众号,wxMiniProgram=微信小程序,Web=Web,App=APP',
    `createtime` int(11) NULL DEFAULT NULL COMMENT '创建时间',
    `updatetime` int(11) NULL DEFAULT NULL COMMENT '更新时间',
    `deletetime` int(11) NULL DEFAULT NULL COMMENT '删除时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vs_dramas_wechat
-- ----------------------------
CREATE TABLE IF NOT EXISTS `__PREFIX__dramas_wechat`  (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `site_id` int(11) NOT NULL DEFAULT 0 COMMENT '站点',
    `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '配置类型',
    `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
    `rules` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '规则',
    `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '内容',
    `createtime` int(11) NOT NULL COMMENT '创建时间',
    `updatetime` int(11) NOT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '微信管理' ROW_FORMAT = Compact;

UPDATE `__PREFIX__auth_rule` SET `remark` = '您现在是在超管后台，您需要退出当前用户，使用站点的账号密码进行登录则可管理您的网站信息。\r\n<br />默认站点是指您的主站，域名URL里不会带后置参数。' WHERE `name` = 'sites';

UPDATE `__PREFIX__auth_rule` SET `remark` = '编辑富文本信息用于前端页面显示。\r\n<br />请在：剧场管理》系统配置》剧场配置》系统信息 里面绑定富文本信息。' WHERE `name` = 'dramas/richtext';

ALTER TABLE `__PREFIX__dramas_reseller` MODIFY COLUMN `expire` bigint(20) NOT NULL COMMENT '有效期' AFTER `indirect`;

ALTER TABLE `__PREFIX__dramas_task` ADD COLUMN `lang_id` int(0) NOT NULL DEFAULT 1 COMMENT '语言' AFTER `site_id`;

ALTER TABLE `__PREFIX__dramas_usable_order` MODIFY COLUMN `pay_type` enum('wechat','alipay','wallet','score','cryptocard','system','paypal','stripe') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '支付方式:wechat=微信支付,alipay=支付宝,wallet=钱包支付,score=积分支付,cryptocard=卡密兑换,system=管理员设置,paypal=PayPal,stripe=Stripe' AFTER `remark`;

ALTER TABLE `__PREFIX__dramas_reseller_order` MODIFY COLUMN `pay_type` enum('wechat','alipay','wallet','score','cryptocard','system','paypal','stripe') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '支付方式:wechat=微信支付,alipay=支付宝,wallet=钱包支付,score=积分支付,cryptocard=卡密兑换,system=管理员设置,paypal=PayPal,stripe=Stripe' AFTER `remark`;

ALTER TABLE `__PREFIX__dramas_vip_order` MODIFY COLUMN `pay_type` enum('wechat','alipay','wallet','score','cryptocard','system','paypal','stripe') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '支付方式:wechat=微信支付,alipay=支付宝,wallet=钱包支付,score=积分支付,cryptocard=卡密兑换,system=管理员设置,paypal=PayPal,stripe=Stripe' AFTER `remark`;

ALTER TABLE `__PREFIX__sms` ADD COLUMN `lang` varchar(16) NULL COMMENT '语言标识' AFTER `id`;
ALTER TABLE `__PREFIX__sms` ADD COLUMN `nation_code` varchar(16) NULL DEFAULT 0 COMMENT '国际区号' AFTER `event`;

ALTER TABLE `__PREFIX__lang` ADD COLUMN `currency` varchar(255) NOT NULL COMMENT '货币标准符号' AFTER `nation_code`;
ALTER TABLE `__PREFIX__lang` ADD COLUMN `exchange_rate` int(11) NOT NULL COMMENT '积分兑换比例' AFTER `currency`;
UPDATE `__PREFIX__lang` SET `currency` = 'CNY', `nation_code` = '86', `exchange_rate` = 10000 WHERE `id` = 1;
UPDATE `__PREFIX__lang` SET `currency` = 'USD', `nation_code` = '1', `exchange_rate` = 71000 WHERE `id` = 3;
UPDATE `__PREFIX__lang` SET `currency` = 'HKD', `nation_code` = '85', `exchange_rate` = 9100 WHERE `id` = 4;
UPDATE `__PREFIX__lang` SET `currency` = 'THP', `nation_code` = '66', `exchange_rate` = 2000 WHERE `id` = 5;
UPDATE `__PREFIX__lang` SET `currency` = 'ESP', `nation_code` = '34', `exchange_rate` = 500 WHERE `id` = 7;
UPDATE `__PREFIX__lang` SET `currency` = 'SAR', `nation_code` = '97', `exchange_rate` = 19000 WHERE `id` = 8;
UPDATE `__PREFIX__lang` SET `currency` = 'VND', `nation_code` = '84', `exchange_rate` = 3 WHERE `id` = 9;

ALTER TABLE `__PREFIX__dramas_reseller_log`
    ADD COLUMN `currency` varchar(255) NOT NULL COMMENT '货币标准符号' AFTER `money`,
    ADD COLUMN `exchange_rate` int(11) NOT NULL DEFAULT 0 COMMENT '积分兑换比例' AFTER `currency`,
    ADD COLUMN `total_money` int(11) NOT NULL COMMENT '积分佣金' AFTER `exchange_rate`;

ALTER TABLE `__PREFIX__dramas_user_wallet_apply`
    CHANGE COLUMN `actual_money` `pay_money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '提现金额' AFTER `money`,
    MODIFY COLUMN `money` decimal(20, 2) NOT NULL COMMENT '提现积分' AFTER `apply_type`,
    ADD COLUMN `currency` varchar(255) NOT NULL COMMENT '货币标准符号' AFTER `money`,
    ADD COLUMN `exchange_rate` int(11) NOT NULL COMMENT '积分兑换比例' AFTER `currency`,
    ADD COLUMN `actual_money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '实际到账' AFTER `pay_money`;

ALTER TABLE `__PREFIX__dramas_vip_order` ADD COLUMN `currency` varchar(255) NULL DEFAULT '' COMMENT '货币' AFTER `pay_fee`;
ALTER TABLE `__PREFIX__dramas_reseller_order` ADD COLUMN `currency` varchar(255) NULL DEFAULT '' COMMENT '货币' AFTER `pay_fee`;
ALTER TABLE `__PREFIX__dramas_usable_order` ADD COLUMN `currency` varchar(255) NULL DEFAULT '' COMMENT '货币' AFTER `pay_fee`;

ALTER TABLE `__PREFIX__user`MODIFY COLUMN `money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '余额' AFTER `bio`;
ALTER TABLE `__PREFIX__dramas_reseller`
    MODIFY COLUMN `original_price` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '原价' AFTER `price`,
    MODIFY COLUMN `direct` decimal(20, 2) NOT NULL COMMENT '直接分润' AFTER `level`,
    MODIFY COLUMN `indirect` decimal(20, 2) NOT NULL COMMENT '间接分润' AFTER `direct`;
ALTER TABLE `__PREFIX__dramas_reseller_log`
    MODIFY COLUMN `pay_money` decimal(20, 2) NOT NULL COMMENT '支付金额' AFTER `user_id`,
    MODIFY COLUMN `ratio` decimal(20, 2) NOT NULL COMMENT '分润比例' AFTER `pay_money`,
    MODIFY COLUMN `money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '佣金' AFTER `ratio`;
ALTER TABLE `__PREFIX__dramas_reseller_order`
    MODIFY COLUMN `total_fee` decimal(20, 2) NOT NULL COMMENT '支付金额' AFTER `status`,
    MODIFY COLUMN `pay_fee` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '实际支付金额' AFTER `total_fee`;
ALTER TABLE `__PREFIX__dramas_usable`
    MODIFY COLUMN `first_price` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '首冲价格' AFTER `give_price`,
    MODIFY COLUMN `original_price` decimal(20, 2) NOT NULL COMMENT '划线价格' AFTER `first_price`;
ALTER TABLE `__PREFIX__dramas_usable_order`
    MODIFY COLUMN `total_fee` decimal(20, 2) NOT NULL COMMENT '支付金额' AFTER `status`,
    MODIFY COLUMN `pay_fee` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '实际支付金额' AFTER `total_fee`;
ALTER TABLE `__PREFIX__dramas_user_wallet_apply`
    MODIFY COLUMN `money` decimal(20, 2) NOT NULL COMMENT '提现积分' AFTER `apply_type`,
    MODIFY COLUMN `pay_money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '提现金额' AFTER `exchange_rate`,
    MODIFY COLUMN `actual_money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '实际到账' AFTER `pay_money`,
    MODIFY COLUMN `charge_money` decimal(20, 2) NOT NULL COMMENT '手续费' AFTER `actual_money`;
ALTER TABLE `__PREFIX__dramas_user_wallet_log`
    MODIFY COLUMN `wallet` decimal(20, 2) NOT NULL COMMENT '变动金额' AFTER `user_id`,
    MODIFY COLUMN `before` decimal(20, 2) NOT NULL COMMENT '变动前' AFTER `type`,
    MODIFY COLUMN `after` decimal(20, 2) NOT NULL COMMENT '变动后' AFTER `before`;
ALTER TABLE `__PREFIX__dramas_vip`
    MODIFY COLUMN `first_price` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '首冲价格' AFTER `price`,
    MODIFY COLUMN `original_price` decimal(20, 2) NOT NULL COMMENT '划线价格' AFTER `first_price`;
ALTER TABLE `__PREFIX__dramas_vip_order`
    MODIFY COLUMN `total_fee` decimal(20, 2) NOT NULL COMMENT '支付金额' AFTER `status`,
    MODIFY COLUMN `pay_fee` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '实际支付金额' AFTER `total_fee`;
ALTER TABLE `__PREFIX__user_money_log`
    MODIFY COLUMN `money` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '变更余额' AFTER `user_id`,
    MODIFY COLUMN `before` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '变更前余额' AFTER `money`,
    MODIFY COLUMN `after` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '变更后余额' AFTER `before`;

ALTER TABLE `__PREFIX__dramas_block` DROP COLUMN `type`, DROP COLUMN `name`,
    ADD COLUMN `lang_id` int(11) NOT NULL DEFAULT 0 COMMENT '语言' AFTER `site_id`,
    ADD COLUMN `video_id` int(11) NOT NULL DEFAULT 0 COMMENT '视频' AFTER `url`;

ALTER TABLE `__PREFIX__dramas_reseller_order`
    MODIFY COLUMN `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易单号' AFTER `currency`;
ALTER TABLE `__PREFIX__dramas_usable_order`
    MODIFY COLUMN `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易单号' AFTER `currency`;
ALTER TABLE `__PREFIX__dramas_vip_order`
    MODIFY COLUMN `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '交易单号' AFTER `currency`;

COMMIT;