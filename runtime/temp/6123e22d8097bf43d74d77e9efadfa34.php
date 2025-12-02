<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:79:"/www/wwwroot/duanju.doukang.shop/public/../application/admin/view/lang/add.html";i:1715757698;s:75:"/www/wwwroot/duanju.doukang.shop/application/admin/view/layout/default.html";i:1715757697;s:72:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/meta.html";i:1715757698;s:74:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/script.html";i:1715757698;}*/ ?>
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
    #langDetail {
        color: #444;
        background: #fff;
        padding: 0 20px 20px;
    }

    .category-image {
        width: 90px;
        height: 100px;
        border: 1px solid #E6E6E6;
        border-radius: 4px;
        margin-right: 20px;
        overflow: hidden;
        position: relative;
    }

    .el-popover {
        padding: 0;
    }

    .image-selected {
        border-color: #7438D5;
    }

    .category-style-title {
        padding-right: 20px;
        flex-direction: column;
    }

    .dialog-cancel-btn {
        color: #FF5959
    }

    img {
        width: 100%;
        /* height: 100%; */
    }

    .category-style-title-container {
        position: relative;
    }

    .category-style-tip {
        /* margin-left: 6px; */
        /* color: #DDDDDD;
        position: absolute;
        left: 6px; */
        color: #DDDDDD;
        position: absolute;
        right: -20px;
        top: 3px;
    }

    .popover-img {
        width: 180px;
        height: 294px;
        border-radius: 1px;
    }

    .popover-img img {
        height: 100%;
    }

    .selected-image-show {
        position: absolute;
        right: -2px;
        bottom: -2px;
        width: 20px;
        height: 20px;
    }
    .category-tip{
        margin-bottom: 20px;
        border-radius: 5px;
        background-color: #F1EBFA;
        padding: 16px;
    }

    [v-cloak] {
        display: none
    }
</style>
<script src="/assets/addons/dramas/libs/vue.js"></script>
<script src="/assets/addons/dramas/libs/element/element.js"></script>
<script src="/assets/addons/dramas/libs/moment.js"></script>
<div id="langDetail" v-cloak>
    <el-form :model="detailForm" :rules="rulesForm" ref="detailForm" label-width="108px" class="detail-form">
        <div class="category-tip">
            {{__('Exchange rate')}}
            <li>1CNY = 10000</li>
            <li>1USD = 7.1CNY = 71000</li>
            <li>1HKD = 0.91CNY = 9100</li>
        </div>
        <el-form-item :label="__('Lang')" prop="lang">
            <el-input type="input" v-model="detailForm.lang" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="__('Lang_cn')" prop="lang_cn">
            <el-input type="input" v-model="detailForm.lang_cn" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="__('Nation_code')" prop="nation_code">
            <el-input type="input" v-model="detailForm.nation_code" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="__('Currency')" prop="currency">
            <el-input type="input" v-model="detailForm.currency" size="small"></el-input>
        </el-form-item>
        <el-form-item :label="__('Exchange rate')" prop="exchange_rate">
            <el-input type="number" :min="1" v-model="detailForm.exchange_rate" size="small"></el-input>
        </el-form-item>
    </el-form>
    <div class="dialog-footer display-flex">
        <div @click="submitForm('detailForm')" class="dialog-define-btn display-flex-c cursor-pointer">{{__('Ok')}}</div>
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
