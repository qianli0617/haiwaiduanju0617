<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:93:"/www/wwwroot/duanju.doukang.shop/public/../application/admin/view/dramas/config/platform.html";i:1764058658;s:75:"/www/wwwroot/duanju.doukang.shop/application/admin/view/layout/default.html";i:1715757697;s:72:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/meta.html";i:1715757698;s:74:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/script.html";i:1715757698;}*/ ?>
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
    #configPlatform {
        color: #444;
        padding: 0 20px 40px 0;
        background-color: #fff;
        position: relative;
        height: calc(100vh - 40px);
        overflow-y: auto;
    }

    .wx-type .el-radio {
        margin-bottom: 10px;
        margin-right: 10px;
    }

    .platform-images {
        width: 60px;
        height: 60px;
        border-radius: 4px;
        position: relative;
        border: 1px solid #7438D5;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .el-image {
        width: 100%;
        height: 100%;
        border-radius: 4px;
    }

    .del-image-btn {
        position: absolute;
        width: 14px;
        height: 14px;
        line-height: 14px;
        text-align: center;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 600;
        background: #fff;
        color: #7438D5;
        top: -8px;
        right: -8px;
        font-size: 16px;
    }

    .add-img {
        width: 60px;
        height: 60px;
        border: 1px dashed #E6E6E6;
        border-radius: 4px;
        justify-content: center;
    }

    .form-item-tip {
        color: #999;
    }

    .form-item-tip>p {
        line-height: 20px;
    }

    .el-form-item {
        margin-bottom: 10px;
    }

    .el-image__error {
        font-size: 12px
    }

    .divider-title {
        font-weight: 600;
        margin-bottom: 20px;
        color: #666;
        padding-left: 20px;
    }

    .el-input-group__append,
    .el-input-group__prepend {
        background: #f9f9f9;
    }

    .dialog-footer {
        position: fixed;
        right: 20px;
        bottom: 0px;
        width: 100%;
        background: #fff;
        padding: 30px 10px 30px;
    }

    .el-input-group__append {
        line-height: 30px !important;
    }

    #configPlatform .el-form-item__content .el-input-group {
        vertical-align: middle;
    }

    .detailForm-href {
        margin-left: 30px;
        flex-shrink: 0;
    }

    .detailForm-href a {
        color: #7438D5;
        cursor: pointer;
    }

    .select-option-container .option-item {
        width: 50%;
    }

    .detailForm-sender {
        margin-right: 20px;
    }

    .detailForm-sender:last-child {
        margin-right: 0px;
    }

    .local-ajax-upload-wrap label {
        color: #7536D0;
    }

    .local-ajax-upload-wrap .local-ajax-upload {
        display: none !important;
    }

    .sa-template-wrap {
        color: var(--sa-font);
    }

    .sa-template-wrap .title {
        width: inherit;
        background: rgba(245, 245, 245, 1);
        margin: 0 0 12px;
        font-size: 12px;
        display: flex;
        align-items: center;
    }

    .sa-template-wrap .key {
        padding: 0 16px;
        flex: 1;
    }

    .sa-template-wrap .oper {
        flex: none;
        width: 120px;
    }

    .sa-template-wrap .item {
        display: flex;
    }

    .sa-template-wrap .item>.el-form-item {
        flex: 1;
        margin-right: 0;
        margin-bottom: 24px;
        padding: 0 16px;
    }

    .sa-template-wrap .item>.el-form-item.oper {
        flex: none;
        width: 120px;
    }

    .sa-template-wrap .el-form-item__content {
        display: flex;
        align-items: center;
    }

    .color-options {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .color-option {
        width: 30px;
        height: 30px;
        margin: 5px;
        border-radius:50%;
    }

    .color-option.active {
        border: 2px solid #FFFFFF;
    }

    [v-cloak] {
        display: none
    }
</style>
<script src="/assets/addons/dramas/libs/vue.js"></script>
<script src="/assets/addons/dramas/libs/element/element.js"></script>
<script src="/assets/addons/dramas/libs/moment.js"></script>
<script src="/assets/addons/dramas/libs/Sortable.min.js"></script>
<script src="/assets/addons/dramas/libs/vuedraggable.js"></script>
<div id="configPlatform" class="dramas-container-scrollbar" v-cloak>
    <el-form :model="detailForm" ref="detailForm" label-width="168px" class="demo-detailForm">
        <div v-if="type=='dramas'">
            <el-form-item :label="__('Site name')">
                <el-radio-group v-model="lang_key" v-for="val, key in detailForm.name">
                    <el-radio :label="key" style="height: 20px;line-height: 20px;margin: 5px;">{{__(key)}}</el-radio>
                </el-radio-group>
                <div v-for="(val, key) in detailForm.name" :key="key">
                    <el-input @input="valueChange" v-if="lang_key == key" v-model="detailForm.name[key]" size="small"></el-input>
<!--                    <input style="height: 32px; line-height: 32px; width: 100%" v-if="lang_key == key" v-model="detailForm.name[key]" size="small"></input>-->
                </div>
            </el-form-item>
            <el-form-item :label="__('Front domain')">
                <el-input v-model="detailForm.h5" disabled size="small">
                    <template slot="append">
                        <div class="theme-color cursor-pointer" @click="copyMessage(detailForm.h5)">{{__('Copy')}}</div>
                    </template>
                </el-input>
                <div class="form-item-tip">{{__('Current site mobile (H5) domain name')}}：<a :href="detailForm.h5" target="_blank">{{__('Go to')}}</a></div>
            </el-form-item>
            <el-form-item :label="__('Lang_id')">
                <div class="display-flex">
                    <div class="flex-1">
                        <el-select v-model="detailForm.lang_id" :placeholder="__('Select')" size="small">
                            <el-option v-for="(key, item) in langOptions" :label="__(key)"
                                       :value="item">
                            </el-option>
                        </el-select>
                    </div>
                </div>
            </el-form-item>

            <!--
                        <el-form-item :label="__('Front theme')">
                            <el-radio-group v-model="detailForm.h5_theme" @change="check_theme()">
                                <el-radio label="default">{{__('Default')}}</el-radio>
                                <el-radio label="simple">{{__('Simplicity')}}</el-radio>
                            </el-radio-group>
                        </el-form-item>
            -->

            <el-form-item :label="__('Version')">
                <el-input v-model="detailForm.version" disabled size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Logo 1')">
                <div class="display-flex">
                    <div class="platform-images" v-if="detailForm.logo">
                        <el-image :src="Fast.api.cdnurl(detailForm.logo)" fit="contain"
                                  :preview-src-list="detailForm.logo_arr">
                        </el-image>
                        <div class="del-image-btn" @click="delImg('image','logo')">
                            <i class="el-icon-error"></i>
                        </div>
                    </div>
                    <div class="add-img display-flex" @click="attachmentSelect('image','logo')" v-if="!detailForm.logo">
                        <i class="el-icon-plus"></i>
                    </div>
                </div>
                <div class="form-item-tip">{{__('Suggested size: %d * %d pixels', 797, 797)}}</div>
            </el-form-item>
            <el-form-item :label="__('Logo 2')">
                <div class="display-flex">
                    <div class="platform-images" v-if="detailForm.company">
                        <el-image :src="Fast.api.cdnurl(detailForm.company)" fit="contain"
                                  :preview-src-list="detailForm.company_arr">
                        </el-image>
                        <div class="del-image-btn" @click="delImg('image','company')">
                            <i class="el-icon-error"></i>
                        </div>
                    </div>
                    <div class="add-img display-flex" @click="attachmentSelect('image','company')" v-if="!detailForm.company">
                        <i class="el-icon-plus"></i>
                    </div>
                </div>
                <div class="form-item-tip">{{__('Suggested size: %d * %d pixels', 464, 116)}}</div>
            </el-form-item>
            <el-form-item :label="__('Copyright')" v-if="detailForm.copyright">
                <div class="add-sku-box">
                    <div class="" v-for="(s, k) in detailForm.copyright.list">
                        <div class="display-flex sku-item" style="justify-content: space-between;">
                            <div class="display-flex">
                                <div>{{__('Icon')}}：</div>
                                <div class="platform-images" v-if="detailForm.copyright.list[k]['image']">
                                    <el-image :src="Fast.api.cdnurl(detailForm.copyright.list[k]['image'])" fit="contain">
                                    </el-image>
                                    <div class="del-image-btn" @click="delImgArr(k)">
                                        <i class="el-icon-error"></i>
                                    </div>
                                </div>
                                <div class="add-img display-flex" @click="attachmentSelectArr(k)"
                                     v-if="!detailForm.copyright.list[k]['image']">
                                    <i class="el-icon-plus"></i>
                                </div>
                            </div>
                            <div style="width: 20px;height: 20px;" @click="deleteMain(k)">
                                <img class="label-auto" src="/assets/addons/dramas/img/close.png">
                            </div>
                        </div>
                        <div class="display-flex sku-item" style="justify-content: space-between;">
                            <div class="display-flex">
                                <div>{{__('Copyright')}}：</div>
                                <div style="width: 300px;">
                                    <el-input type="input" v-model="detailForm.copyright.list[k]['name']" maxlength="128">
                                    </el-input>
                                </div>
                            </div>
                        </div>
                        <div class="display-flex sku-item" style="justify-content: space-between;">
                            <div class="display-flex">
                                <div>{{__('Url')}}：</div>
                                <div style="width: 300px;">
                                    <el-input type="input" v-model="detailForm.copyright.list[k]['url']" maxlength="512">
                                    </el-input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="display-flex sku-item">
                        <div class="btn-common add-level1-sku" @click="addMain">
                            <i class="el-icon-plus"></i>
                            <span>{{__('Copyright')}}</span>
                        </div>
                    </div>
                </div>
            </el-form-item>
            <el-form-item :label="__('Login phone')">
                <el-radio-group v-model="detailForm.mobile_switch">
                    <el-radio label="0">{{__('Off')}}</el-radio>
                    <el-radio label="1">{{__('On')}}</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item :label="__('Auto play android')">
                <el-radio-group v-model="detailForm.android_autoplay">
                    <el-radio label="0">{{__('Off')}}</el-radio>
                    <el-radio label="1">{{__('On')}}</el-radio>
                </el-radio-group>
            </el-form-item>

            <el-form-item :label="__('Setting agreement')">
                <el-radio-group v-model="agreement_key" v-for="val, key in detailForm.name">
                    <el-radio :label="key" style="height: 20px;line-height: 20px;margin: 5px;">{{__(key)}}</el-radio>
                </el-radio-group>
            </el-form-item>
            <div v-for="(val, key) in detailForm.name" :key="key">
                <el-form-item v-if="agreement_key == key" :label="__('User agreement')">
                    <el-input v-model="detailForm.user_protocol_title[key]" size="small">
                        <template slot="append">
                            <div class="theme-color cursor-pointer" @click="richtextSelect('user_protocol', key)">{{__('Select')}}</div>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item v-if="agreement_key == key" :label="__('Privacy agreement')">
                    <el-input v-model="detailForm.privacy_protocol_title[key]" size="small">
                        <template slot="append">
                            <div class="theme-color cursor-pointer" @click="richtextSelect('privacy_protocol', key)">{{__('Select')}}</div>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item v-if="agreement_key == key" :label="__('About Us')">
                    <el-input v-model="detailForm.about_us_title[key]" size="small">
                        <template slot="append">
                            <div class="theme-color cursor-pointer" @click="richtextSelect('about_us', key)">{{__('Select')}}</div>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item v-if="agreement_key == key" :label="__('Contact Us')">
                    <el-input v-model="detailForm.contact_us_title[key]" size="small">
                        <template slot="append">
                            <div class="theme-color cursor-pointer" @click="richtextSelect('contact_us', key)">{{__('Select')}}</div>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item v-if="agreement_key == key" :label="__('Legal Notice')">
                    <el-input v-model="detailForm.legal_notice_title[key]" size="small">
                        <template slot="append">
                            <div class="theme-color cursor-pointer" @click="richtextSelect('legal_notice', key)">{{__('Select')}}</div>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item v-if="agreement_key == key" :label="__('Recharge Agreement')">
                    <el-input v-model="detailForm.usable_desc_title[key]" size="small">
                        <template slot="append">
                            <div class="theme-color cursor-pointer" @click="richtextSelect('usable_desc', key)">{{__('Select')}}</div>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item v-if="agreement_key == key" :label="__('VIP Agreement')">
                    <el-input v-model="detailForm.vip_desc_title[key]" size="small">
                        <template slot="append">
                            <div class="theme-color cursor-pointer" @click="richtextSelect('vip_desc', key)">{{__('Select')}}</div>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item v-if="agreement_key == key" :label="__('Reseller Agreement')">
                    <el-input v-model="detailForm.reseller_desc_title[key]" size="small">
                        <template slot="append">
                            <div class="theme-color cursor-pointer" @click="richtextSelect('reseller_desc', key)">{{__('Select')}}</div>
                        </template>
                    </el-input>
                </el-form-item>
            </div>
        </div>
        <div v-if="type=='user'">
            <el-form-item :label="__('Default nickname')">
                <el-input v-model="detailForm.nickname" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Default avatar')">
                <div class="display-flex">
                    <div class="platform-images" v-if="detailForm.avatar">
                        <el-image :src="Fast.api.cdnurl(detailForm.avatar)" fit="contain"
                                  :preview-src-list="detailForm.avatar_arr">
                        </el-image>
                        <div class="del-image-btn" @click="delImg('image','avatar')">
                            <i class="el-icon-error"></i>
                        </div>
                    </div>
                    <div class="add-img display-flex" @click="attachmentSelect('image','avatar')"
                         v-if="!detailForm.avatar">
                        <i class="el-icon-plus"></i>
                    </div>
                </div>
            </el-form-item>
            <el-form-item :label="__('Default group')">
                <el-select v-model="detailForm.group_id" filterable :placeholder="__('Select')" size="small">
                    <el-option v-for="item in groupList" :key="item.id" :label="item.name" :value="item.id+''">
                    </el-option>
                </el-select>
            </el-form-item>
        </div>
        <div v-if="type=='share'">
            <el-form-item :label="__('Poster sharing background')" style="margin-top: 30px;">
                <div class="display-flex">
                    <div class="platform-images" v-if="detailForm.user_poster_bg">
                        <el-image :src="Fast.api.cdnurl(detailForm.user_poster_bg)" fit="contain"
                                  :preview-src-list="detailForm.user_poster_bg_arr">
                        </el-image>
                        <div class="del-image-btn" @click="delImg('image','user_poster_bg')">
                            <i class="el-icon-error"></i>
                        </div>
                    </div>
                    <div class="add-img display-flex" @click="attachmentSelect('image','user_poster_bg')"
                         v-if="!detailForm.user_poster_bg">
                        <i class="el-icon-plus"></i>
                    </div>
                </div>
            </el-form-item>
            <el-form-item :label="__('Poster sharing background color')">
                <el-input v-model="detailForm.user_poster_bg_color" type="color" placeholder="" size="small" style="width: 200px"></el-input>
                <div class="color-options">
                    <div v-for="(color, index) in detailForm.msg_title_bg_color_arr" :key="index"
                         class="color-option" :style="{ backgroundColor: color }" @click="selectColor('user_poster_bg_color', color)"

                         :class="{ active: color === detailForm.user_poster_bg_color }"></div>
                </div>
            </el-form-item>
        </div>
        <div v-if="type=='sms'">
            <div class="divider-title">
                <el-form-item :label="__('Sms type')">
                    <el-radio-group v-model="detailForm.type">
                        <el-radio label="alisms">{{__('Alibaba Cloud SMS')}}</el-radio>
                        <!--<el-radio label="hwsms">{{__('Huawei Cloud SMS')}}</el-radio>-->
                        <el-radio label="qcloudsms">{{__('Tencent Cloud SMS')}}</el-radio>
                        <el-radio label="baosms">{{__('Smsbao SMS')}}</el-radio>
                    </el-radio-group>
                    <div v-if="detailForm.type=='alisms'" class="form-item-tip">
                        {{__('Registration application address')}}：
                        <a href="https://www.aliyun.com" target="_blank">{{__('Go to')}}</a>
                    </div>
                    <div v-if="detailForm.type=='hwsms'" class="form-item-tip">
                        {{__('Registration application address')}}：
                        <a href="https://www.huaweicloud.com/product/msgsms.html" target="_blank">{{__('Go to')}}</a>
                    </div>
                    <div v-if="detailForm.type=='qcloudsms'" class="form-item-tip">
                        {{__('Registration application address')}}：
                        <a href="https://cloud.tencent.com/act/pro/csms" target="_blank">{{__('Go to')}}</a>
                    </div>
                    <div v-if="detailForm.type=='baosms'" class="form-item-tip">
                        {{__('Registration application address')}}：
                        <a href="http://www.smsbao.com/reg?r=HSHW" target="_blank">{{__('Go to')}}</a>
                    </div>
                </el-form-item>
            </div>
            <div style="margin-bottom: 40px;" v-if="detailForm.alisms && detailForm.type=='alisms'">
                <div class="divider-title">{{__('Alibaba Cloud SMS')}}</div>
                <el-form-item :label="__('App key')">
                    <el-input v-model="detailForm.alisms.key" placeholder="" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('App secret')">
                    <el-input v-model="detailForm.alisms.secret" placeholder="" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('Sign')">
                    <el-input v-model="detailForm.alisms.sign" placeholder="" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('SMS template')">
                    <div class="add-sku-box">
                        <div class="" v-for="(s, k) in detailForm.alisms.template">
                            <div class="display-flex sku-item" style="justify-content: space-between;">
                                <div class="display-flex">
                                    <div style="width: 70px;">{{__('Key lang')}}：</div>
                                    <div style="width: 90px;">
                                        <el-input type="input" v-model="detailForm.alisms.template[k]['key']" :readonly="true">
                                        </el-input>
                                    </div>
                                    <div style="width: 60px;">{{__('Template id')}}：</div>
                                    <div style="width: 300px;">
                                        <el-input type="input" v-model="detailForm.alisms.template[k]['value']">
                                        </el-input>
                                    </div>
                                </div>
                                <!--
                                <div style="width: 20px;height: 20px;" @click="deleteMainSku('alisms', k)">
                                    <img class="label-auto" src="/assets/addons/dramas/img/close.png">
                                </div>
                                -->
                            </div>
                        </div>
                        <!--
                        <div class="display-flex sku-item">
                            <div class="btn-common add-level1-sku" @click="addMainSku('alisms')">
                                <i class="el-icon-plus"></i>
                                <span>{{__('Add}}</span>
                            </div>
                        </div>
                        -->
                    </div>
                </el-form-item>
            </div>
            <div style="margin-bottom: 40px;" v-if="detailForm.hwsms && detailForm.type=='hwsms'">
                <div class="divider-title">{{__('Huawei Cloud SMS')}}</div>
                <el-form-item :label="__('App url')">
                    <el-input v-model="detailForm.hwsms.app_url" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('App key')">
                    <el-input v-model="detailForm.hwsms.key" placeholder="" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('App secret')">
                    <el-input v-model="detailForm.hwsms.secret" placeholder="" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('Sender')">
                    <el-input v-model="detailForm.hwsms.sender" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('Sign')">
                    <el-input v-model="detailForm.hwsms.sign" placeholder="" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('SMS template')">
                    <div class="add-sku-box">
                        <div class="" v-for="(s, k) in detailForm.hwsms.template">
                            <div class="display-flex sku-item" style="justify-content: space-between;">
                                <div class="display-flex">
                                    <div style="width: 70px;">{{__('Key lang')}}：</div>
                                    <div style="width: 90px;">
                                        <el-input type="input" v-model="detailForm.hwsms.template[k]['key']">
                                        </el-input>
                                    </div>
                                    <div style="width: 60px;">{{__('Template id')}}：</div>
                                    <div style="width: 300px;">
                                        <el-input type="input" v-model="detailForm.hwsms.template[k]['value']">
                                        </el-input>
                                    </div>
                                </div>

<!--
                                <div style="width: 20px;height: 20px;" @click="deleteMainSku('hwsms', k)">
                                    <img class="label-auto" src="/assets/addons/dramas/img/close.png">
                                </div>
-->
                            </div>
                        </div>
<!--
                        <div class="display-flex sku-item">
                            <div class="btn-common add-level1-sku" @click="addMainSku('hwsms')">
                                <i class="el-icon-plus"></i>
                                <span>{{__('Add')}}</span>
                            </div>
                        </div>
-->
                    </div>
                </el-form-item>
            </div>
            <div style="margin-bottom: 40px;" v-if="detailForm.qcloudsms && detailForm.type=='qcloudsms'">
                <div class="divider-title">{{__('Tencent Cloud SMS')}}</div>
                <el-form-item :label="__('App id')">
                    <el-input v-model="detailForm.qcloudsms.appid" placeholder="" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('App key')">
                    <el-input v-model="detailForm.qcloudsms.appkey" placeholder="" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('Sign')">
                    <el-input v-model="detailForm.qcloudsms.sign" placeholder="" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('Use SMS template')">
                    <el-switch v-model="detailForm.qcloudsms.isTemplateSender" disabled active-color="#7438D5" inactive-color="#eee"
                               active-value="1" inactive-value="0">
                    </el-switch>
                </el-form-item>
                <el-form-item :label="__('SMS template')">
                    <div class="add-sku-box">
                        <div class="" v-for="(s, k) in detailForm.qcloudsms.template">
                            <div class="display-flex sku-item" style="justify-content: space-between;">
                                <div class="display-flex">
                                    <div style="width: 70px;">{{__('Key lang')}}：</div>
                                    <div style="width: 90px;">
                                        <el-input type="input" v-model="detailForm.qcloudsms.template[k]['key']">
                                        </el-input>
                                    </div>
                                    <div style="width: 60px;">{{__('Template id')}}：</div>
                                    <div style="width: 300px;">
                                        <el-input type="input" v-model="detailForm.qcloudsms.template[k]['value']">
                                        </el-input>
                                    </div>
                                </div>

<!--
                                <div style="width: 20px;height: 20px;" @click="deleteMainSku('qcloudsms', k)">
                                    <img class="label-auto" src="/assets/addons/dramas/img/close.png">
                                </div>
-->
                            </div>
                        </div>
<!--
                        <div class="display-flex sku-item">
                            <div class="btn-common add-level1-sku" @click="addMainSku('qcloudsms')">
                                <i class="el-icon-plus"></i>
                                <span>{{__('Add')}}</span>
                            </div>
                        </div>
-->
                    </div>
                </el-form-item>
            </div>
            <div style="margin-bottom: 40px;" v-if="detailForm.baosms && detailForm.type=='baosms'">
                <div class="divider-title">{{__('Smsbao SMS')}}</div>
                <el-form-item :label="__('Username')">
                    <el-input v-model="detailForm.baosms.username" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('Password')">
                    <el-input v-model="detailForm.baosms.password" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('Sign')">
                    <el-input v-model="detailForm.baosms.sign" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('SMS template')">
                    <div class="add-sku-box">
                        <div class="" v-for="(s, k) in detailForm.baosms.template">
                            <div class="display-flex sku-item" style="justify-content: space-between;">
                                <div class="display-flex">
                                    <div style="width: 70px;">{{__('Key lang')}}：</div>
                                    <div style="width: 90px;">
                                        <el-input type="input" disabled v-model="detailForm.baosms.template[k]['key']">
                                        </el-input>
                                    </div>
                                    <div style="width: 60px;">{{__('Template')}}：</div>
                                    <div style="width: 300px;">
                                        <el-input type="input" v-model="detailForm.baosms.template[k]['value']">
                                        </el-input>
                                    </div>
                                </div>

                                <!--
                                                                <div style="width: 20px;height: 20px;" @click="deleteMainSku('baosms', k)">
                                                                    <img class="label-auto" src="/assets/addons/dramas/img/close.png">
                                                                </div>
                                -->
                            </div>
                        </div>
                        <!--
                                                <div class="display-flex sku-item">
                                                    <div class="btn-common add-level1-sku" @click="addMainSku('baosms')">
                                                        <i class="el-icon-plus"></i>
                                                        <span>{{__('Add')}}</span>
                                                    </div>
                                                </div>
                        -->
                    </div>
                </el-form-item>
            </div>
        </div>
        <div v-if="type=='email'">
            <el-form-item :label="__('Mail type')">
                <el-select v-model="detailForm.mail_type" :placeholder="__('Select')" size="small">
                    <el-option :label="__('Select')" value="0"></el-option>
                    <el-option label="SMTP" value="1"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item :label="__('Mail smtp host')">
                <el-input v-model="detailForm.mail_smtp_host" size="small"></el-input>
                <div class="form-item-tip">{{__('Incorrect configuration can cause the sending email server to time out')}}</div>
            </el-form-item>
            <el-form-item :label="__('Mail smtp port')">
                <el-input v-model="detailForm.mail_smtp_port" size="small"></el-input>
                <div class="form-item-tip">{{__('Default 25 for non encryption, 465 for SSL, and 587 for TLS')}}</div>
            </el-form-item>
            <el-form-item :label="__('Mail smtp user')">
                <el-input v-model="detailForm.mail_smtp_user" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Mail smtp password')">
                <el-input v-model="detailForm.mail_smtp_pass" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Mail vertify type')">
                <el-select v-model="detailForm.mail_verify_type" :placeholder="__('Select')" size="small">
                    <el-option :label="__('None')" value="0"></el-option>
                    <el-option label="TLS" value="1"></el-option>
                    <el-option label="SSL" value="2"></el-option>
                </el-select>
                <div class="form-item-tip">{{__('SMTP authentication method [recommended SSL]')}}</div>
            </el-form-item>
            <el-form-item :label="__('Mail from')">
                <el-input v-model="detailForm.mail_from" size="small">
                    <template slot="append">
                        <div class="theme-color cursor-pointer" @click="testmail">{{__('Send a test message')}}</div>
                    </template>
                </el-input>
            </el-form-item>

            <el-form-item :label="__('Mail template')">
                <div class="add-sku-box">
                    <div class="" v-for="(s, k) in detailForm.mail_template">
                        <div class="display-flex sku-item" style="justify-content: space-between;">
                            <div class="display-flex">
                                <div style="width: 70px;">{{__('Key lang')}}：</div>
                                <div style="width: 90px;">
                                    <el-input type="input" v-model="detailForm.mail_template[k]['key']" :readonly="true">
                                    </el-input>
                                </div>
                                <div style="width: 60px;">{{__('Template')}}：</div>
                                <div style="width: 300px;">
                                    <el-input v-model="detailForm.mail_template[k]['title']" size="small">
                                        <template slot="append">
                                            <div class="theme-color cursor-pointer" @click="richtextSelect('mail_template', k)">{{__('Select')}}</div>
                                        </template>
                                    </el-input>
                                    </el-input>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </el-form-item>

        </div>
        <div v-if="type=='withdraw'">
            <div class="divider-title">{{__('Withdraw')}}</div>
            <el-form-item :label="__('Withdraw method')" v-if="detailForm.methods != undefined">
                <el-checkbox-group v-model="detailForm.methods">
                    <el-checkbox label="wechat">{{__('Withdraw wechat')}}</el-checkbox>
                    <el-checkbox label="alipay">{{__('Withdraw alipay')}}</el-checkbox>
                    <el-checkbox label="bank">{{__('Bank')}}</el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item :label="__('Commission')">
                <el-input v-model="detailForm.service_fee" type="number" size="small">
                    <template slot="append">%</template>
                </el-input>
            </el-form-item>
            <el-form-item :label="__('Minimum withdrawal amount per time')">
                <el-input v-model="detailForm.min" type="number" size="small">
                </el-input>
            </el-form-item>
            <el-form-item :label="__('Maximum withdrawal amount per time')">
                <el-input v-model="detailForm.max" type="number" size="small">
                </el-input>
            </el-form-item>
            <el-form-item :label="__('Maximum daily withdrawal amount')">
                <el-input v-model="detailForm.perday_amount" type="number" size="small">
                </el-input>
                <div class="form-item-tip">{{__('0 is unlimited')}}</div>
            </el-form-item>
            <el-form-item :label="__('Maximum daily withdrawals')">
                <el-input v-model="detailForm.perday_num" type="number" size="small">
                </el-input>
                <div class="form-item-tip">{{__('0 is unlimited')}}</div>
            </el-form-item>
        </div>
        <div v-if="type=='H5'">
            <el-form-item :label="__('WeChat AppID')">
                <el-input v-model="detailForm.app_id" size="small"></el-input>
                <div class="form-item-tip">{{__('Used for H5 WeChat payment')}}</div>
            </el-form-item>
            <el-form-item :label="__('WeChat Secret')">
                <el-input v-model="detailForm.secret" size="small"></el-input>
            </el-form-item>
        </div>
        <div v-if="type=='App'">
            <el-form-item :label="__('WeChat AppID')">
                <el-input v-model="detailForm.app_id" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('WeChat Secret')">
                <el-input v-model="detailForm.secret" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Warning')" style="color:red;">
                https://kf.qq.com/faq/170116MvIvei170116m2AbUb.html
            </el-form-item>
        </div>
        <div v-if="type=='wechat'">
            <el-form-item :label="__('App platform')" v-if="detailForm.platform">
                <el-checkbox-group v-model="detailForm.platform">
                    <el-checkbox label="App">APP</el-checkbox>
                    <el-checkbox label="H5">H5</el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item :label="__('Merchant type')">
                <el-radio-group v-model="detailForm.mode" @change="changeWechatType">
                    <el-radio label="normal">{{__('Ordinary merchants')}}</el-radio>
                    <el-radio label="service" :disabled="true">{{__('Service providers')}}</el-radio>
                </el-radio-group>
            </el-form-item>
            <div v-if="detailForm.mode=='normal'">
                <el-form-item :label="__('Merchant ID')">
                    <el-input v-model="detailForm.mch_id" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('Payment Key')">
                    <el-input v-model="detailForm.key" size="small"></el-input>
                </el-form-item>
                <el-form-item :label="__('Merchant certificate')">
                    <el-input class="local-ajax-upload-wrap" v-model="detailForm.cert_client" size="small">
                        <template slot="append">
                            <label for="cert_client">{{__('Upload')}}</label>
                            <input class="local-ajax-upload" id="cert_client" type="file"
                                   @change="ajaxUpload('cert_client')">
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Merchant Key Certificate')">
                    <el-input class="local-ajax-upload-wrap" v-model="detailForm.cert_key" size="small">
                        <template slot="append">
                            <label for="cert_key">{{__('Upload')}}</label>
                            <input class="local-ajax-upload" id="cert_key" type="file" @change="ajaxUpload('cert_key')">
                        </template>
                    </el-input>
                </el-form-item>
            </div>
        </div>
        <div v-if="type=='alipay'">
            <el-form-item :label="__('App platform')" v-if="detailForm.platform">
                <el-checkbox-group v-model="detailForm.platform">
                    <el-checkbox label="App">APP</el-checkbox>
                    <el-checkbox label="H5">H5</el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item :label="__('Merchant type')">
                <el-radio-group v-model="detailForm.mode" @change="changeWechatType">
                    <el-radio label="normal">{{__('Ordinary merchants')}}</el-radio>
                    <el-radio label="service" :disabled="true">{{__('Service providers')}}</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item :label="__('App id')">
                <el-input v-model="detailForm.app_id" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Alipay public key')">
                <el-input class="local-ajax-upload-wrap" v-model="detailForm.ali_public_key" size="small">
                    <template slot="append">
                        <label for="ali_public_key">{{__('Upload')}}</label>
                        <input class="local-ajax-upload" id="ali_public_key" type="file"
                               @change="ajaxUpload('ali_public_key')">
                    </template>
                </el-input>
                <div class="form-item-tip">alipayCertPublicKey_RSA2.crt</div>
            </el-form-item>
            <el-form-item :label="__('App cert public key')">
                <el-input class="local-ajax-upload-wrap" v-model="detailForm.app_cert_public_key" size="small">
                    <template slot="append">
                        <label for="app_cert_public_key">{{__('Upload')}}</label>
                        <input class="local-ajax-upload" id="app_cert_public_key" type="file"
                               @change="ajaxUpload('app_cert_public_key')">
                    </template>
                </el-input>
                <div class="form-item-tip">appCertPublicKey_*.crt</div>
            </el-form-item>
            <el-form-item :label="__('Alipay root cert')">
                <el-input class="local-ajax-upload-wrap" v-model="detailForm.alipay_root_cert" size="small">
                    <template slot="append">
                        <label for="alipay_root_cert">{{__('Upload')}}</label>
                        <input class="local-ajax-upload" id="alipay_root_cert" type="file"
                               @change="ajaxUpload('alipay_root_cert')">
                    </template>
                </el-input>
                <div class="form-item-tip">alipayRootCert.crt</div>
            </el-form-item>
            <el-form-item :label="__('Private key')">
                <el-input v-model="detailForm.private_key" size="small">
                </el-input>
            </el-form-item>
        </div>
        <div v-if="type=='wallet'">
            <el-form-item :label="__('App platform')">
                <el-checkbox-group v-model="detailForm.platform" v-if="detailForm.platform">
                    <el-checkbox label="H5">H5</el-checkbox>
                    <el-checkbox label="App">App</el-checkbox>
                </el-checkbox-group>
            </el-form-item>
        </div>
        <div v-if="type=='paypal'">
            <el-form-item :label="__('App platform')">
                <el-checkbox-group v-model="detailForm.platform" v-if="detailForm.platform">
                    <el-checkbox label="H5">H5</el-checkbox>
                    <el-checkbox label="App">App</el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item :label="__('Environment')">
                <el-radio-group v-model="detailForm.environment">
                    <el-radio label="sandbox">{{__('Sandbox')}}</el-radio>
                    <el-radio label="live">{{__('Live')}}</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item :label="__('Clent id')">
                <el-input v-model="detailForm.clent_id" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Clent secret')">
                <el-input v-model="detailForm.client_secret" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Webhook')">
                <el-input v-model="detailForm.webhook" disabled size="small">
                    <template slot="append">
                        <div class="theme-color cursor-pointer" @click="copyMessage(detailForm.webhook)">{{__('Copy')}}</div>
                    </template>
                </el-input>
                <div class="form-item-tip">{{__('Please configure a webhook address for PayPal payment')}}</div>
            </el-form-item>
        </div>
        <div v-if="type=='stripe'">
            <el-form-item :label="__('App platform')">
                <el-checkbox-group v-model="detailForm.platform" v-if="detailForm.platform">
                    <el-checkbox label="H5">H5</el-checkbox>
                    <el-checkbox label="App">App</el-checkbox>
                </el-checkbox-group>
            </el-form-item>
            <el-form-item :label="__('Environment')">
                <el-radio-group v-model="detailForm.environment">
                    <el-radio label="sandbox">{{__('Sandbox')}}</el-radio>
                    <el-radio label="live">{{__('Live')}}</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item :label="__('Public key')">
                <el-input v-model="detailForm.public_key" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Private key')">
                <el-input v-model="detailForm.private_key" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Webhook key')">
                <el-input v-model="detailForm.webhook_key" size="small"></el-input>
            </el-form-item>
            <el-form-item :label="__('Webhook')">
                <el-input v-model="detailForm.webhook" disabled size="small">
                    <template slot="append">
                        <div class="theme-color cursor-pointer" @click="copyMessage(detailForm.webhook)">{{__('Copy')}}</div>
                    </template>
                </el-input>
                <div class="form-item-tip">{{__('Please configure a webhook address for Stripe payment')}}</div>
            </el-form-item>
        </div>
        <div v-if="type=='uploads'">
            <div class="divider-title">
                <el-form-item :label="__('Uploads')">
                    <el-radio-group v-model="detailForm.upload_type">
                        <el-radio label="alioss" @click.native.prevent="setUploadType('alioss')">{{__('Alibaba Cloud OSS')}}</el-radio>
                        <el-radio label="cos" @click.native.prevent="setUploadType('cos')">{{__('Tencent Cloud COS')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
            </div>
            <div class="divider-title">
                <el-form-item :label="__('Download static resource files')">
                    <div @click="backupDownload()" class="dialog-define-btn display-flex-c cursor-pointer">{{__('Download')}}</div>
                    <div class="form-item-tip">{{__('If the static resource file displays abnormally, please try downloading the resource file. After downloading the resource file, please unzip it and upload the directories [assets] and [uploads] to the cloud space.')}}</div>
                    <div class="form-item-tip">{{__('If the download of resource files fails, please contact the administrator and modify the PHP configuration [memory_limit] (script memory limit) to set a larger value to ensure normal downloading.')}}</div>
                </el-form-item>
            </div>
            <div style="margin-bottom: 40px;" v-if="detailForm.alioss && detailForm.upload_type=='alioss'">
                <el-form-item :label="__('AccessKey ID')">
                    <el-input v-model="detailForm.alioss.accessKeyId" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('AccessKey Secret')">
                    <el-input v-model="detailForm.alioss.accessKeySecret" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Bucket name')">
                    <el-input v-model="detailForm.alioss.bucket" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Endpoint')">
                    <el-input v-model="detailForm.alioss.endpoint" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('CDN url')">
                    <el-input v-model="detailForm.alioss.cdnurl" size="small">
                    </el-input>
                    <div class="form-item-tip">{{__('Please fill in the CDN address, which must start with http (s)://')}}</div>
                </el-form-item>
                <el-form-item :label="__('Upload mode')">
                    <el-select style="width: 100%;" v-model="detailForm.alioss.uploadmode" filterable size="small" :placeholder="__('Select')">
                        <el-option v-for="item in uploadmodeList" :key="item.model" :label="item.name"
                                   :value="item.model">
                            <div class="select-option-container display-flex">
                                <div class="option-item">{{ item.name }}</div>
                            </div>
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item :label="__('Server Transfer Mode Backup')">
                    <el-radio-group v-model="detailForm.alioss.serverbackup">
                        <el-radio label="1">{{__('Backup (Attachment management will generate 2 records)')}}</el-radio>
                        <el-radio label="0">{{__('Do not backup')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('Save file name')">
                    <el-input v-model="detailForm.alioss.savekey" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Upload valid duration')">
                    <el-input v-model="detailForm.alioss.expire" size="small">
                    </el-input>
                    <div class="form-item-tip">{{__('The effective duration of user stay on page upload, in seconds')}}</div>
                </el-form-item>
                <el-form-item :label="__('Maximum Uploadable')">
                    <el-input v-model="detailForm.alioss.maxsize" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Uploadable suffix format')">
                    <el-input v-model="detailForm.alioss.mimetype" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Multiple file uploads')">
                    <el-radio-group v-model="detailForm.alioss.multiple">
                        <el-radio label="1">{{__('On')}}</el-radio>
                        <el-radio label="0">{{__('Off')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('Thumbnail Style')">
                    <el-input v-model="detailForm.alioss.thumbstyle" size="small">
                    </el-input>
                    <div class="form-item-tip">{{__('Used for backend list thumbnail style, can use:')}} ?x-oss-process=image/resize,m_lfit,w_120,h_90</div>
                </el-form-item>
                <el-form-item :label="__('Chunking')">
                    <el-radio-group v-model="detailForm.alioss.chunking">
                        <el-radio label="1">{{__('On')}}</el-radio>
                        <el-radio label="0">{{__('Off')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('Chunksize')">
                    <el-input v-model="detailForm.alioss.chunksize" type="number" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Delete cloud storage when delete attachments')">
                    <el-radio-group v-model="detailForm.alioss.syncdelete">
                        <el-radio label="1">{{__('On')}}</el-radio>
                        <el-radio label="0">{{__('Off')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('API interface using cloud storage')">
                    <el-radio-group v-model="detailForm.alioss.apiupload">
                        <el-radio label="1">{{__('On')}}</el-radio>
                        <el-radio label="0">{{__('Off')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('No login upload')">
                    <el-checkbox-group v-model="detailForm.alioss.noneedloginarr">
                        <el-checkbox label="api">{{__('Api')}}</el-checkbox>
                        <el-checkbox label="index">{{__('Front')}}</el-checkbox>
                        <el-checkbox label="admin">{{__('Admin')}}</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>

            </div>
            <div style="margin-bottom: 40px;" v-if="detailForm.cos && detailForm.upload_type=='cos'">
                <el-form-item :label="__('AppID COS')">
                    <el-input v-model="detailForm.cos.appId" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('SecretId')">
                    <el-input v-model="detailForm.cos.secretId" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('SecretKey')">
                    <el-input v-model="detailForm.cos.secretKey" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Bucket name')">
                    <el-input v-model="detailForm.cos.bucket" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Region')">
                    <el-input v-model="detailForm.cos.region" size="small">
                    </el-input>
                    <div class="form-item-tip">{{__('Please enter the geographical abbreviation, please use English (ap guangzhou)')}}</div>
                </el-form-item>
                <el-form-item :label="__('Upload mode')">
                    <el-select style="width: 100%;" v-model="detailForm.cos.uploadmode" filterable size="small" :placeholder="__('Select')">
                        <el-option v-for="item in uploadmodeList" :key="item.model" :label="item.name"
                                   :value="item.model">
                            <div class="select-option-container display-flex">
                                <div class="option-item">{{ item.name }}</div>
                            </div>
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item :label="__('Server Transfer Mode Backup')">
                    <el-radio-group v-model="detailForm.cos.serverbackup">
                        <el-radio label="1">{{__('Backup (Attachment management will generate 2 records)')}}</el-radio>
                        <el-radio label="0">{{__('Do not backup')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('CDN url')">
                    <el-input v-model="detailForm.cos.cdnurl" size="small">
                    </el-input>
                    <div class="form-item-tip">{{__('Please fill in the CDN address, which must start with http (s)://')}}</div>
                </el-form-item>
                <el-form-item :label="__('Save file name')">
                    <el-input v-model="detailForm.cos.savekey" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Upload valid duration')">
                    <el-input v-model="detailForm.cos.expire" size="small">
                    </el-input>
                    <div class="form-item-tip">{{__('The effective duration of user stay on page upload, in seconds')}}</div>
                </el-form-item>
                <el-form-item :label="__('Maximum Uploadable')">
                    <el-input v-model="detailForm.cos.maxsize" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Uploadable suffix format')">
                    <el-input v-model="detailForm.cos.mimetype" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Multiple file uploads')">
                    <el-radio-group v-model="detailForm.cos.multiple">
                        <el-radio label="1">{{__('On')}}</el-radio>
                        <el-radio label="0">{{__('Off')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('Thumbnail Style')">
                    <el-input v-model="detailForm.cos.thumbstyle" size="small">
                    </el-input>
                    <div class="form-item-tip">{{__('Used for backend list thumbnail style, can use:')}} ?x-oss-process=image/resize,m_lfit,w_120,h_90</div>
                </el-form-item>
                <el-form-item :label="__('Chunking')">
                    <el-radio-group v-model="detailForm.cos.chunking">
                        <el-radio label="1">{{__('On')}}</el-radio>
                        <el-radio label="0">{{__('Off')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('Chunksize')">
                    <el-input v-model="detailForm.cos.chunksize" type="number" size="small">
                    </el-input>
                </el-form-item>
                <el-form-item :label="__('Delete cloud storage when delete attachments')">
                    <el-radio-group v-model="detailForm.cos.syncdelete">
                        <el-radio label="1">{{__('On')}}</el-radio>
                        <el-radio label="0">{{__('Off')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('API interface using cloud storage')">
                    <el-radio-group v-model="detailForm.cos.apiupload">
                        <el-radio label="1">{{__('On')}}</el-radio>
                        <el-radio label="0">{{__('Off')}}</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item :label="__('No login upload')">
                    <el-checkbox-group v-model="detailForm.cos.noneedloginarr">
                        <el-checkbox label="api">{{__('Api')}}</el-checkbox>
                        <el-checkbox label="index">{{__('Front')}}</el-checkbox>
                        <el-checkbox label="admin">{{__('Admin')}}</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
            </div>
        </div>
    </el-form>
    <div class="dialog-footer">
        <div @click="submitFrom" class="dialog-cancel-btn display-flex-c cursor-pointer">{{__('Cancel')}}</div>
        <div @click="submitFrom('yes')" class="dialog-define-btn display-flex-c cursor-pointer">{{__('Ok')}}</div>
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
