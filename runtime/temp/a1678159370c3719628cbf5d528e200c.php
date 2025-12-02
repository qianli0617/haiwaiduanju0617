<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:90:"/www/wwwroot/duanju.doukang.shop/public/../application/admin/view/dramas/config/index.html";i:1764058658;s:75:"/www/wwwroot/duanju.doukang.shop/application/admin/view/layout/default.html";i:1715757697;s:72:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/meta.html";i:1715757698;s:74:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/script.html";i:1715757698;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">
<meta name="robots" content="noindex, nofollow">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>

    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <link rel="stylesheet" href="/assets/addons/dramas/libs/element/element.css">
<link rel="stylesheet" href="/assets/addons/dramas/libs/common.css">
<style>
    #configIndex {
        background: #fff;
        border-radius: 10px 10px 0px 0px;
        color: #444;
        font-weight: 500;
    }

    .el-tabs__nav {
        margin-left: 30px;
    }

    .el-tabs__header {
        margin-bottom: 0;
    }

    .el-tabs__item {
        margin-bottom: 8px;
        width: 120px;
    }

    .el-tabs__active-bar {
        width: 80px !important;
        left: 10px;
        height: 3px;
    }

    .el-tabs--top .el-tabs__item.is-top:last-child {
        padding-right: 20px;
    }

    .custom-tabs {
        padding-top: 12px;
    }

    .custom-body {
        padding: 30px 30px 0;
    }

    .tip-container {
        padding: 0 10px;
    }

    .config-item {
        width: 100%;
        /* max-width: 370px; */
        height: 254px;
        border-radius: 20px;
        padding: 0 10px 24px;
        margin-bottom: 30px;
        display: flex;
        align-items: stretch;
        color: #fff;
        justify-content: space-between;
    }

    .config-item-icon-container {
        /* width: 48px; */
        height: 48px;
    }

    .config-title {
        font-size: 22px;
        margin-top: 28px;
    }

    .config-tip {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
        margin-top: 14px;
    }

    .config-message {
        font-size: 14px;
        max-width: 170px;
        margin-top: 26px;
    }

    .set-container {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .config-item-btn {
        width: 98px;
        height: 40px;
        border-radius: 20px;
        font-size: 14px;
        cursor: pointer;
    }

    .item-icon-1 {
        width: 48px;
        height: 48px;
        border-radius: 50%;
    }

    .item-icon-1 img {
        width: 100%;
        height: 100%;
    }

    .item-icon-2 {
        width: 48px;
        height: 48px;
        background: #fff;
        border-radius: 50%;
        position: absolute;
        left: 36px;
        opacity: 0.5;
    }

    .config-item-leaf-container {
        display: flex;
        flex: 1;
    }

    .leaf {
        width: 54px;
        height: 54px;
    }

    .leaf-11 {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 0px 34px;
    }

    .leaf-12 {
        border-radius: 0px 35px;
        transform: matrix(-1, 0, 0, 1, 0, 0);
    }

    .leaf-13 {
        background: rgba(255, 255, 255, 0.66);
        border-radius: 0px 34px;
    }

    .item-leaf-2 {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 6px;
        transform: rotate(-45deg);
        margin-top: 86px;
        margin-left: 10px;
    }

    .config-item {
        cursor: pointer;
        transition: all 0.2s;
    }

    .config-item:hover {
        transform: scale(1.05);
        filter: drop-shadow(0px 1px 8px rgba(0, 0, 0, 0.1));
    }

    [v-cloak] {
        display: none
    }
</style>
<script src="/assets/addons/dramas/libs/vue.js"></script>
<script src="/assets/addons/dramas/libs/element/element.js"></script>
<div id="configIndex" v-cloak>
    <div class="custom-tabs">
        <el-tabs v-model="activeName" @tab-click="tabClick">
            <el-tab-pane v-if="configData['basic'].length != 0" :label="__('Basic')" name="basic"></el-tab-pane>
            <el-tab-pane v-if="configData['platform'].length != 0" :label="__('Platform')" name="platform"></el-tab-pane>
            <el-tab-pane v-if="configData['payment'].length != 0" :label="__('Payment')" name="payment"></el-tab-pane>
        </el-tabs>
    </div>
    <div class="custom-body">
        <el-row :gutter="30">
            <el-col :xs="24" :sm="12" :md="8" :lg="6" :xl="6" v-for="item in configData[activeName]">
                <div class="config-item" :style="{background:item.background}">
                    <div class="tip-container">
                        <div class="config-item-icon-container"
                            style="margin-top: 30px;position: relative;display: flex;">
                            <div class="item-icon-1"><img :src="'/assets/addons/dramas/img/config/'+item.icon+'.png'" />
                            </div>
                            <div class="item-icon-2"></div>
                        </div>
                        <div class="config-title">{{item.title}}</div>
                        <div class="config-tip ellipsis-item">{{item.tip}}</div>
                        <div class="config-message ellipsis-item">{{item.message}}</div>
                    </div>
                    <div class="set-container">
                        <div class="config-item-leaf-container">
                            <div class="item-leaf-1">
                                <div class="leaf leaf-11"></div>
                                <div class="leaf leaf-12" :style="{background:item.leaf}"></div>
                                <div class="leaf leaf-13"></div>
                            </div>
                            <div class="item-leaf-2"></div>
                        </div>
                        <div v-if="item.id!='alipay'" class="config-item-btn display-flex-c" :style="item.button"
                            @click="operation(item.id,item.title)">{{item.buttonMessage?item.buttonMessage:__('Set up')}}</div>
                        <div v-if="item.id=='alipay'" class="config-item-btn display-flex-c" :style="item.button">{{__('Not activated')}}
                        </div>
                    </div>
                </div>
            </el-col>
        </el-row>
    </div>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
