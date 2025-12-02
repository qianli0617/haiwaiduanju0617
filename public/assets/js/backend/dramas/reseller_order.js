define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'dramas/reseller_order/index' + location.search,
                    add_url: 'dramas/reseller_order/add',
                    edit_url: 'dramas/reseller_order/edit',
                    del_url: 'dramas/reseller_order/del',
                    multi_url: 'dramas/reseller_order/multi',
                    import_url: 'dramas/reseller_order/import',
                    table: 'dramas_reseller_order',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'reseller_id', title: __('Reseller_id'),
                            visible: false,
                            addclass: 'selectpage',
                            extend: 'data-source="dramas/reseller/index" data-field="name"',
                            operate: '=',
                            formatter: Table.api.formatter.search
                        },
                        {field: 'order_sn', title: __('Order_sn'), operate: 'LIKE'},
                        {field: 'user_id', title: __('User_id'),
                            visible: false,
                            addclass: 'selectpage',
                            extend: 'data-source="dramas/user/index" data-field="nickname"',
                            operate: '=',
                            formatter: Table.api.formatter.search
                        },
                        {field: 'reseller.name', title: __('Reseller.name'), operate: 'LIKE'},
                        {field: 'user.nickname', title: __('User.nickname'), operate: 'LIKE'},
                        {field: 'times', title: __('Times'), operate: false, formatter: function (value, row, index) {
                                if(value == 0){
                                    return __('Forever');
                                }else{
                                    return value/86400 + __('Day');
                                }
                            }, visible: false},
                        {field: 'status', title: __('Status'), searchList: {"-2":__('Status -2'),"-1":__('Status -1'),"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.status},
                        {field: 'currency', title: __('Currency')},
                        {field: 'total_fee', title: __('Total_fee'), operate:'BETWEEN'},
                        {field: 'pay_fee', title: __('Pay_fee'), operate:'BETWEEN'},
                        {field: 'transaction_id', title: __('Transaction_id'), operate: false, visible: false},
                        {field: 'remark', title: __('Remark'), operate: false, visible: false},
                        {field: 'pay_type', title: __('Pay_type'), searchList: {"wechat":__('Pay_type wechat'),"alipay":__('Pay_type alipay'),"wallet":__('Pay_type wallet'),"score":__('Pay_type score'),"cryptocard":__('Pay_type cryptocard'),"system":__('Pay_type system')}, formatter: Table.api.formatter.normal},
                        {field: 'paytime', title: __('Paytime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'ext', title: __('Ext'), operate: false, visible: false},
                        {field: 'platform', title: __('Platform'), searchList: {"H5":__('Platform h5'),"wxOfficialAccount":__('Platform wxofficialaccount'),"wxMiniProgram":__('Platform wxminiprogram'),"Web":__('Platform web')}, formatter: Table.api.formatter.normal},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime, visible: false},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        recyclebin: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    'dragsort_url': ''
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: 'dramas/reseller_order/recyclebin' + location.search,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {
                            field: 'deletetime',
                            title: __('Deletetime'),
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            formatter: Table.api.formatter.datetime
                        },
                        {
                            field: 'operate',
                            width: '140px',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'Restore',
                                    text: __('Restore'),
                                    classname: 'btn btn-xs btn-info btn-ajax btn-restoreit',
                                    icon: 'fa fa-rotate-left',
                                    url: 'dramas/reseller_order/restore',
                                    refresh: true
                                },
                                {
                                    name: 'Destroy',
                                    text: __('Destroy'),
                                    classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',
                                    icon: 'fa fa-times',
                                    url: 'dramas/reseller_order/destroy',
                                    refresh: true
                                }
                            ],
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },

        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
