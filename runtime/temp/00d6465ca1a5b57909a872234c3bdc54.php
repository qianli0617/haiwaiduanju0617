<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:88:"/www/wwwroot/duanju.doukang.shop/public/../application/admin/view/dramas/user/index.html";i:1764058658;s:75:"/www/wwwroot/duanju.doukang.shop/application/admin/view/layout/default.html";i:1715757697;s:72:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/meta.html";i:1715757698;s:74:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/script.html";i:1715757698;}*/ ?>
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
    #userIndex {
        color: #444;
        background: #fff;
    }

    .custom-header {
        padding: 0 20px;
        margin-bottom: 10px;
    }

    .color-7536D0 {
        color: #7536D0;
        cursor: pointer;
    }

    .common-btn {
        height: 32px;
        cursor: pointer;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .el-input__inner,
    .el-input__icon {
        line-height: 32px;
        height: 32px;
    }

    .btn-box {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        justify-content: space-between;
    }

    .refresh-btn {
        width: 32px;
        border: 1px solid #E6E6E6;
        font-size: 14px;
        margin-right: 20px;
    }

    .create-goods,
    .add-params,
    .add-level1-sku {
        width: 98px;
        background: #7536D0;
        color: #fff;
    }

    .create-goods {
        margin-right: 40px;
    }

    .create-goods span,
    .add-params span,
    .add-level1-sku span {
        margin-left: 8px;
    }

    .platform-name span {
        display: flex;
    }

    .goods-img {
        width: 34px;
        height: 34px;
        margin-right: 10px;
        border: 1px solid #e6e6e6;
    }

    .display-flex {
        display: flex;
        align-items: center;
    }


    .label-auto {
        width: 100%;
        height: 100%;
    }

    .one-ellipsis {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .sort-order {
        margin-left: 6px;
        color: #C0C4CC;
        flex-direction: row-reverse;
    }

    .recycle-btn {
        width: 88px;
        color: #444;
        border: #444 1px solid;
    }

    .recycle-btn i {
        margin-right: 6px;
        font-size: 14px;
    }

    .status-box {
        width: 100%;
        justify-content: space-between;
    }

    .status-btn {
        width: 56px;
        height: 26px;
        border: 1px solid #7438D5;
        color: #7438D5;
        font-size: 12px;
    }

    .status-btn-2 {
        color: #FF5959;
        border-color: #FF5959;
    }

    .status-btn-3 {
        color: #999;
        border-color: #999;
    }

    .icon-top {
        margin-left: -5px;
    }

    .edit-text,
    .del-text,
    .enable-text,
    .disable-text {
        cursor: pointer;
        color: #444;
        margin-right: 14px;
    }

    .edit-text {
        color: #7438D5;
    }

    .enable-text {
        color: #01CFA1;
    }

    .del-text {
        color: #FF5959;
    }

    .el-popover {
        left: 46px;
        top: 10px;
        padding: 16px;
    }

    .choose-container {
        margin-bottom: 10px;
        color: #666;
    }

    .custom-choose,
    .custom-choose-type,
    .custom-choose-sub {
        height: 50px;
        border-radius: 4px;
        justify-content: space-between;
        padding: 0 20px;
        background: #fff;
    }

    .custom-choose-type,
    .custom-choose-sub {
        justify-content: flex-start;
    }

    .custom-choose-sub {
        height: 70px;
        padding: 0 10px 20px 20px;
    }

    .choose-status-tip {
        margin-right: 12px;
    }

    .custom-choose-type-tip {
        margin-right: 16px;
    }

    .choose-btn {
        width: 80px;
        border: 1px solid #E6E6E6;
        margin-right: 10px;
        height: 30px;
    }

    .choose-btn-active {
        background-color: #7536D0;
        border: none;
        color: #fff;
    }

    .custom-table {
        /* padding: 20px 20px 30px; */
        padding: 0px 20px 30px;
        background: #fff;
    }

    label {
        margin-bottom: 0;
    }

    .page-container {
        justify-content: flex-end;
        margin-top: 30px;
    }

    .goods-title {
        margin-bottom: 4px;
        width: 154px;
        line-height: 14px;
    }

    .activity-type {
        justify-content: space-around;
    }

    .activity-type-btn {
        width: 40px;
        height: 20px;
        padding-top: 2px;
        border-radius: 4px;
        color: #fff;
        justify-content: center;
    }

    .groupon-btn {
        background: #A17BDF;
    }

    .seckill-btn {
        background: #FE9387;
    }

    .score-btn {
        background: #FBB74A;
    }

    .el-table .bg-color {
        background: #f9f9f9;
    }

    .cell-left .cell {
        justify-content: flex-start !important;
    }

    .el-table_1_column_11.is-leaf,
    .el-table_1_column_11 {
        border-color: #EBEEF5 !important;
    }

    .avatar-img {
        width: 26px;
        height: 26px;
        border: 1px solid #E5E5E5;
    }

    .el-popover {
        padding-bottom: 6px;
        color: #444;
    }

    .popover-container>div {
        margin-bottom: 10px;
    }

    .popover-tip {
        width: 56px;
        color: #666;
        text-align: justify;
        text-align-last: justify;
    }

    .custom-table {
        padding-top: 14px;
    }

    [v-cloak] {
        display: none
    }
</style>
<script src="/assets/addons/dramas/libs/vue.js"></script>
<script src="/assets/addons/dramas/libs/element/element.js"></script>
<script src="/assets/addons/dramas/libs/Sortable.min.js"></script>
<script src="/assets/addons/dramas/libs/vuedraggable.js"></script>
<script src="/assets/addons/dramas/libs/moment.js"></script>
<div id="userIndex" v-cloak>
    <div class="custom-header display-flex">
        <div class="choose-status" style="font-size: 14px;">
            {{__('User List')}}
        </div>
        <div class="custom-search">
            <el-input :placeholder="__('Please enter search content')" suffix-icon="el-icon-search" v-model="searchKey">
            </el-input>
        </div>
    </div>
    <div class="display-flex-b" style="padding: 0 20px;">
        <div class="custom-refresh display-flex-c" @click="getData">
            <i class="el-icon-refresh"></i>
        </div>
    </div>
    <div class="custom-table">
        <div class="custom-table-border">
            <el-table ref="multipleTable" :data="data" tooltip-effect="dark" style="width: 100%" border
                :row-class-name="tableRowClassName" :cell-class-name="tableCellClassName"
                :header-cell-class-name="tableCellClassName" @row-dblclick="operation">
                <el-table-column label="ID" prop="id" min-width="60">
                </el-table-column>
                <el-table-column :label="__('Avatar')" min-width="60">
                    <template slot-scope="scope">
                        <div>
                            <img class="avatar-img" v-if="scope.row.avatar"
                                :src="Fast.api.cdnurl(scope.row.avatar)">
                                <span v-if="!scope.row.avatar">-</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column :label="__('Nickname')" min-width="120">
                    <template slot-scope="scope">
                        <div class="ellipsis-item">{{scope.row.nickname}}</div>
                    </template>
                </el-table-column>
                <el-table-column :label="__('Mobile')" min-width="110">
                    <template slot-scope="scope">
                        <div><span v-if="scope.row.mobile">{{scope.row.mobile}}</span><span v-else>-</span></div>
                    </template>
                </el-table-column>
                <el-table-column :label="__('Email')" min-width="120">
                    <template slot-scope="scope">
                        <div><span v-if="scope.row.email">{{scope.row.email}}</span><span v-else>-</span></div>
                    </template>
                </el-table-column>
<!--
                <el-table-column :label="__('Third platform')" prop="id" min-width="140">
                    <template slot-scope="scope">
                        <div class="platform-name display-flex-c">
                            <template v-if="scope.row.third_platform.length>0">
                                <el-popover placement="bottom" trigger="hover"
                                    :title="operation('platformname',i.platform)" width="360"
                                    v-for="(i,index) in scope.row.third_platform">
                                    <div class="popover-container">
                                        <div class="display-flex">
                                            <div class="display-flex"><div class="popover-tip">{{__('Avatar')}}</div>：</div>
                                            <img class="avatar-img"
                                :src="Fast.api.cdnurl(i.headimgurl)">
                                        </div>
                                        <div class="display-flex">
                                            <div class="display-flex"><div class="popover-tip">{{__('Gender')}}</div>：</div>
                                            <div class="color-7536D0">{{i.sex==2?__('Woman'):__('Man')}}</div>
                                        </div>
                                        <div class="display-flex">
                                            <div class="display-flex"><div class="popover-tip">{{__('Country')}}</div>：</div>
                                            <div class="color-7536D0">{{i.country}}</div>
                                        </div>
                                        <div class="display-flex">
                                            <div class="display-flex"><div class="popover-tip">{{__('Province city')}}</div>：</div>
                                            <div class="color-7536D0">{{i.province}}-{{i.city}}</div>
                                        </div>
                                        <div class="display-flex">
                                            <div class="display-flex"><div class="popover-tip">OpenId</div>：</div>
                                            <div class="color-7536D0">{{i.openid}}</div>
                                        </div>
                                        <div class="display-flex">
                                            <div class="display-flex"><div class="popover-tip">UnionId</div>：</div>
                                            <div class="color-7536D0">{{i.unionid}}</div>
                                        </div>
                                        <div class="display-flex">
                                            <div class="display-flex"><div class="popover-tip">{{__('Createtime')}}</div>：</div>
                                            <div class="color-7536D0">
                                                {{moment(i.createtime*1000).format("YYYY-MM-DD HH:mm:ss")}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ellipsis-item cursor-pointer" slot="reference">
                                        <img style="width: 30px;height: 30px;" :style="{'margin-right':index!=scope.row.third_platform.length-1?'5px':''}"
                                            :src="'/assets/addons/dramas/img/user/'+i.provider+'-'+i.platform+'.png'">
                                    </div>
                                </el-popover>
                            </template>
                            <span v-else>-</span>
                        </div>
                    </template>
                </el-table-column>
-->
                <el-table-column :label="__('Money')" prop="money" min-width="120">
                </el-table-column>
                <!--<el-table-column label="积分" prop="score" min-width="120">-->
                <!--</el-table-column>-->
                <el-table-column :label="__('Usable')" prop="usable" min-width="120">
                </el-table-column>
                <el-table-column :label="__('Jointime')" min-width="160">
                    <template slot-scope="scope">
                        <div>
                            {{moment(scope.row.logintime*1000).format("YYYY-MM-DD HH:mm:ss")}}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column fixed="right" :label="__('Operate')" min-width="180">
                    <template slot-scope="scope">
                        <div>
                            <?php if($auth->check('dramas/user/profile')): ?>
                            <span class="edit-text" @click="operation('edit',scope.row.id)">{{__('Detail')}}</span>
                            <?php endif; if($auth->check('dramas/user/del')): ?>
                            <span class="del-text" @click="operation('del',scope.row.id)">{{__('Delete')}}</span>
                            <?php endif; ?>
                        </div>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <div class="page-container display-flex">
            <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                :current-page="currentPage" :page-sizes="[10, 20, 30, 40]" :page-size="limit"
                layout="total, sizes, prev, pager, next, jumper" :total="totalPage">
            </el-pagination>
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
