<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:101:"/www/wwwroot/duanju.doukang.shop/public/../application/admin/view/dramas/user_wallet_apply/index.html";i:1764058658;s:75:"/www/wwwroot/duanju.doukang.shop/application/admin/view/layout/default.html";i:1715757697;s:72:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/meta.html";i:1715757698;s:74:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/script.html";i:1715757698;}*/ ?>
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
    #userWalletApply {
        padding-bottom: 30px;
        background: #fff;
        border-radius: 10px 10px 0px 0px;
    }

    .custom-tabs-wrap {
        padding: 12px 24px 0;
        border-bottom: 2px solid #e6e6e6;
        margin-bottom: 20px;
        position: relative;
    }

    .custom-tabs-wrap .el-tabs__header {
        margin: 0;
    }

    .custom-tabs-wrap .tabs-export {
        position: absolute;
        top: 24px;
        right: 24px;
        color: #7438D5;
        cursor: pointer;
    }

    .custom-tabs-wrap .tabs-export i {
        margin-right: 6px;
    }

    .custom-refresh-button {
        margin-right: 14px;
    }

    .custom-filter-wrap .custom-refresh-button {
        margin-bottom: 14px;
    }

    .custom-filter-wrap {
        flex-wrap: wrap;
        padding: 0 24px;
    }

    .custom-filter-wrap .custom-filter-item {
        margin-bottom: 14px;
        margin-right: 24px;
    }

    .custom-filter-wrap .custom-filter-button-wrap {
        margin-bottom: 14px;
    }

    .custom-filter-wrap .custom-filter-label {
        flex-shrink: 0;
        margin-right: 14px;
        font-size: 12px;
        color: #666;
    }

    .custom-filter-wrap .custom-filter-content-input {
        width: 104px;
    }

    .custom-table-wrap {
        margin: 0 24px;
    }

    .custom-margin-14 {
        margin-right: 14px !important;
    }

    .custom-table-operation-text {
        margin-right: 14px;
        cursor: pointer;
    }

    .custom-table-operation-text:last-child {
        margin-right: 0;
    }

    .custom-table-image {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 1px solid #E6E6E6;
        margin-right: 8px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .custom-table-color-primary {
        color: #6E3DC8;
    }

    .custom-table-color-success {
        color: #70C140;
    }

    .custom-table-color-error {
        color: #ED5B56;
    }

    .custom-table-color-warning {
        color: #EFAF41;
    }

    .custom-table-color-info {
        color: #999999;
    }

    .pagination-container-b {
        justify-content: space-between;
    }

    .table-checked-all {
        margin-right: 12px !important;
    }

    .get-type-iamge {
        width: 26px;
        height: 26px;
        margin-right: 8px;
        border-radius: none;
        border: none;
    }

    .refuse-dialog.el-dialog {
        width: 474px !important;
    }

    .refuse-dialog.el-dialog .el-dialog__body {
        padding: 10px 20px 0;
    }

    .refuse-dialog.el-dialog .el-dialog__title {
        font-size: 18px !important;
        color: #444;
    }

    .agree-dialog.el-dialog .el-dialog__body {
        display: none;
    }

    .el-date-editor.el-input,
    .el-date-editor.el-input__inner {
        width: 350px;
    }

    .el-range-editor--small .el-range-separator {
        line-height: 25px;
    }

    .el-date-editor .el-range-separator {
        width: 7%;
    }

    .table-popover-jump {
        cursor: pointer;
        color: #7438D5;
    }

    .log-dialog.el-dialog {
        width: fit-content !important;
    }

    .custom-table-checkbox .el-table__header .el-table_1_column_1.el-table-column--selection .el-checkbox {
        display: none;
    }

    .custom-copy-message {
        margin-left: 14px;
        cursor: pointer;
    }

    .custom-copy-message:hover {
        color: #7438D5;
    }
</style>
<script src="/assets/addons/dramas/libs/vue.js"></script>
<script src="/assets/addons/dramas/libs/element/element.js"></script>
<script src="/assets/addons/dramas/libs/moment.js"></script>
<script src="/assets/addons/dramas/libs/clipboard.min.js"></script>
<div id="userWalletApply" v-cloak>
    <div class="custom-tabs-wrap">
        <el-tabs v-model="searchForm.status" @tab-click="changeApplyStatus">
            <el-tab-pane v-for="w in filterRule.status" :label="w.name" :name="w.type+''">
            </el-tab-pane>
        </el-tabs>
    </div>
    <div class="custom-filter-wrap display-flex">
        <div class="custom-refresh display-flex custom-refresh-button" @click="getWalletApply(offset,limit)">
            <i class="el-icon-refresh"></i>
        </div>
        <div class="custom-filter-item display-flex">
            <div class="custom-filter-label">{{__('Createtime')}}</div>
            <div class="custom-filter-content">
                <el-date-picker v-model="searchForm.createtime" type="daterange" value-format="yyyy-MM-dd HH:mm:ss"
                    format="yyyy-MM-dd HH:mm:ss" range-separator="-" :start-placeholder="__('Start time')" :end-placeholder="__('End time')"
                    :picker-options="pickerOptions" align="right" size="small" :default-time="['00:00:00', '23:59:59']">
                </el-date-picker>
            </div>
        </div>
        <div class="custom-filter-item display-flex">
            <div class="custom-filter-label">{{__('Updatetime')}}</div>
            <div class="custom-filter-content">
                <el-date-picker v-model="searchForm.updatetime" type="daterange" value-format="yyyy-MM-dd HH:mm:ss"
                    format="yyyy-MM-dd HH:mm:ss" range-separator="-" :start-placeholder="__('Start time')" :end-placeholder="__('End time')"
                    :picker-options="pickerOptions" align="right" size="small" :default-time="['00:00:00', '23:59:59']">
                </el-date-picker>
            </div>
        </div>
        <div class="custom-filter-item display-flex">
            <div class="custom-filter-content">
                <el-input :placeholder="__('Please enter')" v-model="searchForm.form_1_value" class="input-with-select" size="small">
                    <el-select v-model="searchForm.form_1_key" slot="prepend" :placeholder="__('Please select')">
                        <el-option :label="__('User id')" value="user_id"></el-option>
                        <el-option :label="__('User nickname')" value="user_nickname"></el-option>
                        <el-option :label="__('User mobile')" value="user_mobile"></el-option>
                    </el-select>
                </el-input>
            </div>
        </div>
        <div class="custom-filter-item display-flex">
            <div class="custom-filter-label">{{__('Apply_type')}}</div>
            <div class="custom-filter-content custom-filter-content-input">
                <el-select v-model="searchForm.apply_type" size="small">
                    <el-option v-for="type in filterRule.apply_type" :label="type.name" :value="type.type">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="custom-filter-button-wrap display-flex">
            <el-button class="filter-reset-button" @click="filterEmpty" size="small">{{__('Reset')}}</el-button>
            <el-button class="filter-button" @click="filterConfirm()" type="primary" size="small">{{__('Filter')}}</el-button>
        </div>
    </div>
    <div class="custom-table-wrap"
        :class="(searchForm.status!='0' && searchForm.status!='1')?'custom-table-checkbox':''">
        <el-table ref="multipleTable" :data="walletApplyData" :empty-text="__('No data')" border stripe @selection-change="tableSelect">
            <el-table-column type="selection" width="40" align="center" :selectable="checkSelectable">
            </el-table-column>
            <el-table-column prop="id" min-width="74" label="ID">
            </el-table-column>
            <el-table-column min-width="120" :label="__('Apply user')" align="left">
                <template slot-scope="scope">
                    <template v-if="scope.row.user">
                        <div v-if="scope.row.user.avatar" class="custom-table-image">
                            <el-image :src="Fast.api.cdnurl(scope.row.user.avatar)" fit="cover">
                                <div slot="error" class="image-slot">
                                    <i class="el-icon-picture-outline"></i>
                                </div>
                            </el-image>
                        </div>
                        <el-popover placement="top" width="200" trigger="hover">
                            <div class="table-popover-wrap">
                                <div>
                                    <span>{{__('User id')}}：</span>
                                    <!-- @click="openUser(scope.row.user.id)"-->
                                    <span class="table-popover-jump">{{scope.row.user.id}}</span>
                                </div>
                                <div>
                                    <span>{{__('User mobile')}}：</span>
                                    <span>{{scope.row.user.mobile?scope.row.user.mobile:'-'}}</span>
                                </div>
                            </div>
                            <div class="ellipsis-item table-popover-jump" slot="reference">
                                <!-- @click="openUser(scope.row.user.id)"-->
                                <span>{{scope.row.user.nickname}}</span>
                            </div>
                        </el-popover>
                    </template>
                    <template v-else>-</template>
                </template>
            </el-table-column>
            <el-table-column width="200" :label="__('Actual_money')">
                <template slot-scope="scope">
                    {{scope.row.actual_money}}({{scope.row.currency}})/{{scope.row.pay_money}}({{scope.row.currency}})
                </template>
            </el-table-column>
            <el-table-column width="200" :label="__('Money')">
                <template slot-scope="scope">
                    {{scope.row.money}}(1{{scope.row.currency}}={{scope.row.exchange_rate}})
                </template>
            </el-table-column>
            <el-table-column min-width="150" :label="__('Charge_money')">
                <template slot-scope="scope">
                    <span>{{scope.row.service_fee*100}}%</span>/<span>{{scope.row.charge_money}}</span>
                </template>
            </el-table-column>
            <el-table-column width="120" :label="__('Apply_type')" align="left">
                <template slot-scope="scope">
                    <div class="custom-table-image get-type-iamge">
                        <el-image :src="'/assets/addons/dramas/img/user_wallet_apply/'+scope.row.apply_type+'.png'"
                            fit="cover">
                            <div slot="error" class="image-slot">
                                <i class="el-icon-picture-outline"></i>
                            </div>
                        </el-image>
                    </div>
                    <div class="ellipsis-item">{{scope.row.apply_type_text}}</div>
                </template>
            </el-table-column>
            <el-table-column width="240" :label="__('Apply_info')" align="left">
                <template slot-scope="scope">
                    <div>
                        <template v-if="scope.row.apply_info">
                            <div class="display-flex" v-for="(key,kindex) in scope.row.apply_info_text">
                                <span v-if="kindex == 'Payment code' && key" class="ellipsis-item">{{__(kindex)}}:&nbsp;
                                    <el-image style="width: 20px;height: 20px" :src="Fast.api.cdnurl(key)" fit="contain"
                                              :preview-src-list="showImg(Fast.api.cdnurl(key))">
                                    </el-image>
                                </span>

                                <span v-if="kindex != 'Payment code' && key" class="ellipsis-item">{{__(kindex)}}:&nbsp;{{key}}</span>
                                <span v-if="kindex != 'Payment code' && key" class="custom-copy-message" :class="'custom-copy-message'+scope.$index+key"
                                      :data-clipboard-text="key" @click="copyMessage(key)">
                                    <i class="el-icon-copy-document"></i>
                                </span>
                            </div>
                        </template>
                        <template v-if="!scope.row.apply_info">-</template>
                    </div>
                </template>
            </el-table-column>
            <el-table-column width="150" :label="__('Createtime')">
                <template slot-scope="scope">
                    {{moment(scope.row.createtime*1000).format('YYYY-MM-DD HH:mm:ss')}}
                </template>
            </el-table-column>
            <el-table-column width="150" :label="__('Updatetime')">
                <template slot-scope="scope">
                    {{moment(scope.row.updatetime*1000).format('YYYY-MM-DD HH:mm:ss')}}
                </template>
            </el-table-column>
            <el-table-column width="88" fixed="right" :label="__('Status')">
                <template slot-scope="scope">
                    <span v-if="scope.row.status==-1" class="custom-table-color-error">{{scope.row.status_text}}</span>
                    <span v-if="scope.row.status==0" class="custom-table-color-info">{{scope.row.status_text}}</span>
                    <span v-if="scope.row.status==1" class="custom-table-color-warning">{{scope.row.status_text}}</span>
                    <span v-if="scope.row.status==2" class="custom-table-color-success">{{scope.row.status_text}}</span>
                </template>
            </el-table-column>
            <el-table-column min-width="140" fixed="right" :label="__('Operate')" align="left">
                <template slot-scope="scope">
                    <span v-if="scope.row.status==0" class="custom-table-operation-text custom-table-color-primary"
                        @click="openAgreeDialog(scope.row)">{{__('Agree')}}</span>
                    <span v-if="scope.row.status==1" class="custom-table-operation-text custom-table-color-primary"
                        @click="openImmediatelyDialog(scope.row)">{{__('Make payment immediately')}}</span>
                    <span v-if="scope.row.status==0 || scope.row.status==1"
                        class="custom-table-operation-text custom-table-color-error"
                        @click="openRefuseDialog(scope.row)">{{__('Reject')}}</span>
                    <span class="custom-table-operation-text custom-table-color-primary"
                        @click="openLogDialog(scope.row.id)">
                        <i class="el-icon-time"></i>
                    </span>
                </template>
            </el-table-column>
        </el-table>
        <div class="pagination-container" :class="(searchForm.status=='0' || searchForm.status=='1')?'pagination-container-b':''">
            <div v-if="searchForm.status=='0' || searchForm.status=='1'">
                <el-checkbox class="table-checked-all" :indeterminate="isIndeterminate"
                    :disabled="walletApplyData.length==0" v-model="tableCheckedAll" @change="changeCheckedAll">
                </el-checkbox>
                <el-button v-if="searchForm.status=='0'" :type="tableCheckedAll?'primary':''"
                    :disabled="!tableCheckedAll" plain size="small" @click="openAgreeDialog(multipleSelection)">{{__('Agree')}}
                </el-button>
                <el-button v-if="searchForm.status=='1'" :type="tableCheckedAll?'primary':''"
                    :disabled="!tableCheckedAll" plain size="small" @click="openImmediatelyDialog(multipleSelection)">
                    {{__('Make payment immediately')}}
                </el-button>
                <el-button v-if="searchForm.status=='0' || searchForm.status=='1'" :type="tableCheckedAll?'danger':''"
                    :disabled="!tableCheckedAll" plain size="small" @click="openRefuseDialog(multipleSelection)">{{__('Reject')}}
                </el-button>
            </div>
            <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                :current-page="currentPage" :page-sizes="[10, 20, 30, 40]" :page-size="limit"
                layout="total, sizes, prev, pager, next, jumper" :total="totalPage">
            </el-pagination>
        </div>
    </div>
    <!-- 同意 -->
    <el-dialog custom-class="refuse-dialog agree-dialog" :title="__('Oper tip')" :visible.sync="agreeDialogVisible"
        :before-close="closeAgreeDialog">
        <span slot="footer">
            <el-button @click="closeAgreeDialog" size="small">{{__('Cancel')}}</el-button>
            <el-button type="primary" @click="agreePayment()" size="small" plain>{{__('Agree')}}</el-button>
            <el-button type="primary" @click="confirmPayment()" size="small">{{__('Agree&Make payment')}}</el-button>
        </span>
    </el-dialog>
    <!-- 立即打款 -->
    <el-dialog custom-class="refuse-dialog agree-dialog" :title="__('Oper tip')" :visible.sync="immediatelyDialogVisible"
        :before-close="closeImmediatelyDialog">
        <span slot="footer">
            <el-button @click="closeImmediatelyDialog" size="small">{{__('Cancel')}}</el-button>
            <el-button type="primary" @click="immediatelyPayment()" size="small" plain>{{__('OK')}}</el-button>
        </span>
    </el-dialog>
    <!-- 拒绝 -->
    <el-dialog custom-class="refuse-dialog" :title="__('Reason for refusal')" :visible.sync="refuseDialogVisible"
        :before-close="closeRefuseDialog">
        <div>
            <el-input v-model="refuseForm.status_msg" :placeholder="__('Please enter the reason for rejection')"></el-input>
        </div>
        <span slot="footer">
            <el-button @click="closeRefuseDialog" size="small">{{__('Cancel')}}</el-button>
            <el-button type="danger" @click="refusePayment()" size="small">{{__('Reject')}}</el-button>
        </span>
    </el-dialog>
    <!-- 操作日志 -->
    <el-dialog custom-class="log-dialog" :title="__('Log')" :visible.sync="logDialogVisible" :before-close="closeLogDialog">
        <div>
            <el-table :data="logList" border stripe max-height="450">
                <el-table-column prop="oper_info" min-width="300" :label="__('Log')" align="left">
                    <template slot-scope="scope">
                        {{scope.row.oper_info}}
                    </template>
                </el-table-column>
                <el-table-column width="100" :label="__('Oper type')">
                    <template slot-scope="scope">
                        <span v-if="scope.row.oper">{{scope.row.oper.type}}</span>
                        <span v-else>-</span>
                    </template>
                </el-table-column>
                <el-table-column width="150" :label="__('Oper user')" align="left">
                    <template slot-scope="scope">
                        <div v-if="scope.row.oper" class="display-flex">
                            <div v-if="scope.row.oper.avatar" class="custom-table-image">
                                <el-image :src="Fast.api.cdnurl(scope.row.oper.avatar)" fit="cover">
                                    <div slot="error" class="image-slot">
                                        <i class="el-icon-picture-outline"></i>
                                    </div>
                                </el-image>
                            </div>
                            <span class="ellipsis-item">{{scope.row.oper.name}}</span>
                        </div>
                        <span v-else>-</span>
                    </template>
                </el-table-column>
                <el-table-column width="150" :label="__('Oper time')">
                    <template slot-scope="scope">
                        {{moment(scope.row.oper_time*1000).format('YYYY-MM-DD HH:mm:ss')}}
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </el-dialog>
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
