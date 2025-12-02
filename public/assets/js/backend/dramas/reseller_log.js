define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'dramas/reseller_log/index' + location.search,
                    add_url: 'dramas/reseller_log/add',
                    edit_url: 'dramas/reseller_log/edit',
                    del_url: 'dramas/reseller_log/del',
                    multi_url: 'dramas/reseller_log/multi',
                    import_url: 'dramas/reseller_log/import',
                    table: 'dramas_reseller_log',
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
                        {field: 'type', title: __('Type'), searchList: {"direct":__('Type direct'),"indirect":__('Type indirect')}, formatter: Table.api.formatter.normal},
                        {field: 'reseller_user_id', title: __('Reseller_user_id'),
                            visible: false,
                            addclass: 'selectpage',
                            extend: 'data-source="dramas/user/index" data-field="nickname"',
                            operate: '=',
                            formatter: Table.api.formatter.search
                        },
                        {field: 'user_id', title: __('User_id'),
                            visible: false,
                            addclass: 'selectpage',
                            extend: 'data-source="dramas/user/index" data-field="nickname"',
                            operate: '=',
                            formatter: Table.api.formatter.search
                        },
                        {field: 'user.nickname', title: __('User.nickname'), operate: 'LIKE'},
                        {field: 'reseller.nickname', title: __('Reseller.nickname'), operate: 'LIKE'},
                        {field: 'pay_money', title: __('Pay_money'), operate:'BETWEEN'},
                        {field: 'ratio', title: __('Ratio'), operate:'BETWEEN'},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'currency', title: __('Currency')},
                        {field: 'exchange_rate', title: __('Exchange rate'), operate:false},
                        {field: 'total_money', title: __('Total_money'), operate:false},
                        {field: 'memo', title: __('Memo'), operate: 'LIKE'},
                        {field: 'order_type', title: __('Order_type'), searchList: {"vip":__('Order_type vip'),"reseller":__('Order_type reseller')}, formatter: Table.api.formatter.normal},
                        {field: 'order_id', title: __('Order_id')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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
