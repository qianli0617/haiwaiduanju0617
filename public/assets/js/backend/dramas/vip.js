define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'dramas/vip/index' + location.search,
                    add_url: 'dramas/vip/add',
                    edit_url: 'dramas/vip/edit',
                    del_url: 'dramas/vip/del',
                    multi_url: 'dramas/vip/multi',
                    import_url: 'dramas/vip/import',
                    table: 'dramas_vip',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                fixedColumns: true,
                fixedRightNumber: 1,
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'lang_id', title: __('Lang_id'), searchList: Config.langList, formatter: function (value, row, index) {
                                return Config.langList[value];
                            }},
                        {field: 'type', title: __('Type'), searchList: {"d":__('Day'),"m":__('Month'),"q":__('Quarter'),"y":__('Year')}, formatter: Table.api.formatter.normal},
                        {field: 'title', title: __('Title'), operate: 'LIKE'},
                        {field: 'desc', title: __('Desc'), operate: 'LIKE'},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        // {field: 'first_price', title: __('First_price'), operate:'BETWEEN'},
                        {field: 'original_price', title: __('Original_price'), operate:'BETWEEN'},
                        {field: 'num', title: __('Num')},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1')}, formatter: Table.api.formatter.status},
                        {field: 'weigh', title: __('Weigh'), operate: false},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            $(document).on('click', '.btn-sync', function () {
                Layer.confirm(__('Import test data'), {icon: 3, title: __('Import'), btn: [__('Ok'), __('Cancel')]}, function () {
                    Fast.api.ajax({
                        url: 'dramas/vip/sync',
                    }, function (data, ret) {
                        $(".btn-refresh").trigger("click");
                        Layer.closeAll();
                    });
                });
                return false;
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
