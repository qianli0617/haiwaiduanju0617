<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:81:"/www/wwwroot/duanju.doukang.shop/public/../application/admin/view/lang/index.html";i:1715757698;s:75:"/www/wwwroot/duanju.doukang.shop/application/admin/view/layout/default.html";i:1715757697;s:72:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/meta.html";i:1715757698;s:74:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/script.html";i:1715757698;}*/ ?>
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
    #langIndex {
        color: #444;
        background: #fff;
        padding: 0 0 20px;
    }

    .custom-tabs-header {
        /* border-bottom: 1px solid #e6e6e6; */
        margin-bottom: 20px;
        /* padding: 0 20px; */
        overflow-x: auto;
        height: 56px;
    }

    .custom-tabs-header::-webkit-scrollbar {
        width: 6px;
        height: 4px;
    }

    .custom-tabs-header::-webkit-scrollbar-thumb {
        width: 6px;
        background: #e6e6e6;
        height: 1px;
        border-radius: 3px;
    }

    .add-lang {
        margin-left: 14px;
        color: #7438D5;
        cursor: pointer;
        min-width: 60px;
        height: 50px;
    }

    .add-lang i {
        margin-right: 4px;
    }

    .tab-icons {
        margin-left: 6px;
        width: 12px;
        height: 12px;
    }

    .custom-tabs-line {
        height: 1px;
        background: #e6e6e6;
        width: 100%
    }

    .custom-tabs-items {
        display: flex;
        align-items: center;
        padding: 0 20px;
        width: 100%;
        height: 50px;
    }

    .custom-tabs-body {
        padding: 0 20px;
    }

    .dialog-left {
        width: 300px;
        border-right: 1px solid #e6e6e6;
        padding: 9px 20px 0;
        overflow: auto;
        flex-shrink: 0;
    }

    .dialog-left::-webkit-scrollbar {
        width: 6px;
    }

    .dialog-left::-webkit-scrollbar-thumb {
        width: 6px;
        background: #e6e6e6;
        height: 20px;
        border-radius: 3px;
    }

    .dialog-right {
        flex: 1;
    }

    .level-item-1,
    .level-item-2,
    .level-item-3,
    .level-item-4 {
        height: 26px;
        line-height: 26px;
        display: flex;
        align-items: center;
    }

    .level-item-2 {
        padding-left: 20px;
    }

    .level-item-3 {
        padding-left: 40px;
    }

    .level-item-4 {
        padding-left: 73px;
    }

    .el-icon-arrow-down {
        color: #666;
    }

    .arrow-open {
        transform: rotateZ(90deg);
        transition: transform .25s linear;
    }

    .arrow-selected {
        color: #7438D5;
        background: rgba(116, 56, 213, 0.14);
        border-radius: 4px;
    }

    .item-name {
        cursor: pointer;
        flex: 1;
    }

    .el-icon-caret-right {
        color: #666;
    }

    .i-container {
        margin-right: 6px;
    }

    .el-table td,
    .el-table th {
        padding: 5px 0 6px;
    }

    .activity-text {
        margin-right: 8px;
    }

    .activity-text:last-child {
        margin-right: 0;
    }

    .btn-common {
        line-height: 32px;
        height: 32px;
        cursor: pointer;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .add-params {
        width: 98px;
        background: #7536D0;
        color: #fff;
        margin-left: 8px;
    }

    .dialog-footer {
        display: flex;
        justify-content: flex-end;
        padding: 0 30px;
    }

    .all-edit-img {
        width: 14px;
        height: 14px;
        margin-left: 6px;
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
<div id="langIndex" v-cloak v-loading="isAjax">
    <div class="custom-tabs-header display-flex" style="flex-direction: column;">
        <div class="custom-tabs-items">
            <el-tabs v-if="tabsData.length>0" v-model="activeName" @tab-click="handleClick">
                <el-tab-pane :name="tab.lang" v-for="tab in tabsData">
                    <span slot="label">{{__(tab.lang)}}
                        <img v-if="tab.id==activeId" class="tab-icons" src="/assets/addons/dramas/img/category/edit.png"
                             @click.stop="operation('editLang',tab.id)">
                    </span>
                </el-tab-pane>
            </el-tabs>
            <div class="add-lang flex-1 display-flex">
                <div class="display-flex" @click="operation('addLang')" style="width: 60px;">
                    <i class="el-icon-plus"></i>
                    <span style="line-height: 13px;">{{__('Add')}}</span>
                </div>
                <div class="display-flex" @click="operation('config')" style="width: 60px;">
                    <span style="line-height: 13px;">{{__('Setting')}}</span>
                </div>
            </div>
        </div>
        <div class="custom-tabs-line"></div>
    </div>
    <div class="custom-tabs-body display-flex" style="align-items: flex-start;">
        <div class="dialog-left">
            <div v-for="(level1,p) in langData" :key="p">
                <div class="level-item-1" :class="level1.selected?'arrow-selected':''">
                    <div class="i-container" @click="showLeft(p, null, null,null)">
                        <i v-if="level1.children && level1.children.length>0" class="el-icon-caret-right"
                           :class="level1.show?'arrow-open':''"></i>
                        <i :class="level1.type == 'folder' ? 'el-icon-folder':'el-icon-document'"></i>
                        <span class="item-name">{{level1.name}}</span>
                    </div>
                </div>
                <el-collapse-transition v-for="(level2,c) in level1.children">
                    <div :key="c" v-show="level1.show">
                        <div class="level-item-2" :class="level2.selected?'arrow-selected':''">
                            <div class="i-container" @click="showLeft(p, c, null,null)">
                                <i v-if="level2.children && level2.children.length>0" class="el-icon-caret-right"
                                   :class="level2.show?'arrow-open':''"></i>
                                <i :class="level2.type == 'folder' ? 'el-icon-folder':'el-icon-document'"></i>
                                <span class="item-name">{{level2.name}}</span>
                            </div>
                        </div>
                        <el-collapse-transition v-for="(level3,a) in level2.children">
                            <div :key="a" v-show="level2.show">
                                <div class="level-item-3" :class="level3.selected?'arrow-selected':''">
                                    <div class="i-container" @click="showLeft(p, c, a,null)">
                                        <i v-if="level3.children && level3.children.length>0"
                                           class="el-icon-caret-right" :class="level3.show?'arrow-open':''"></i>
                                        <i :class="level3.type == 'folder' ? 'el-icon-folder':'el-icon-document'"></i>
                                        <span class="item-name">{{level3.name}}</span>
                                    </div>
                                </div>
                                <el-collapse-transition v-for="(level4,s) in level3.children">
                                    <div :key="s" v-show="level3.show">
                                        <div class="level-item-4" :class="level4.selected?'arrow-selected':''">
                                            <i class="el-icon-document"></i>
                                            <span class="item-name"
                                                  @click="selectLangLeft(p, c, a,s)">{{level4.name}}</span>
                                        </div>
                                    </div>
                                </el-collapse-transition>
                            </div>
                        </el-collapse-transition>
                    </div>
                </el-collapse-transition>
            </div>
        </div>
        <div class="dialog-right" v-if="langListData.length > 0">
            <div class="category-tip">
                {{__('Translation is based on simplified Chinese using Baidu Translate.  Please select the correct language for translation.  Machine translation has certain errors, and it is necessary to manually check and adjust the translation results.')}}
                <br />
                {{__('Translate a maximum of 100 pieces of data at a time, and do not duplicate translations for existing data. Ensure that all translations are made and saved!')}}
            </div>

            <span class="table-box">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{__('key')}}</th>
                        <th>{{__('zh-cn')}}</th>
                        <th v-if="activeName != 'zh-cn'">
                            <div class="display-flex">
                                <span>{{__(activeName)}}</span>
                                <img class="all-edit-img" @click="setTranslate(true)" src="/assets/addons/dramas/img/batch.png">
                                <div class="display-flex" v-if="translate">
                                    <el-popover :title="__('Translate')" placement="top" width="200" v-model="activeName">
                                        <el-select v-model="langTranslate" :placeholder="__('Select')" size="small">
                                            <el-option v-for="(item, i) in langTranslateList" :label="__(item)"
                                                       :value="item">
                                            </el-option>
                                        </el-select>
                                        <div style="text-align: right; margin: 0">
                                            <el-button size="mini" type="text"
                                                       @click="setTranslate(false)">{{__('Cancel')}}</el-button>
                                            <el-button type="primary" size="mini"
                                                       @click="addTranslate">{{__('Ok')}}</el-button>
                                        </div>
                                    </el-popover>
                                </div>
                            </div>
                        </th>
<!--                        <th v-if="activeName != 'zh-cn'">{{__('Delete')}}</th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, i) in langListData" :key="i">
                        <td>
                            <el-input class="table-input" v-model="item['key']"></el-input>
                        </td>
                        <td>
                            <el-input class="table-input" v-model="item['zh-cn']"></el-input>
                        </td>
                        <td v-if="activeName != 'zh-cn'">
                            <el-input class="table-input" v-model="item[activeName]"></el-input>
                        </td>
<!--                        <td v-if="activeName != 'zh-cn'">-->
<!--                            <div style="width: 20px;height: 20px;" @click="delLangItem(i)">-->
<!--                                <img class="label-auto" src="/assets/addons/dramas/img/close.png">-->
<!--                            </div>-->
<!--                        </td>-->
                    </tr>
                    </tbody>
                </table>
            </span>
            <span class="dialog-footer">
<!--                <div v-if="activeName == 'zh-cn'" class="btn-common add-params" @click="addLangItem">-->
<!--                    <i class="el-icon-plus"></i>-->
<!--                    <span>{{__('Add')}}</span>-->
<!--                </div>-->
                <div class="btn-common add-params" @click="updateLangData">
                    {{__('Save&Update')}}
                </div>
            </span>
        </div>
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
