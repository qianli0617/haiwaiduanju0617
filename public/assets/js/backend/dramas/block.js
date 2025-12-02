define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'dramas/block/index' + location.search,
                    add_url: 'dramas/block/add',
                    edit_url: 'dramas/block/edit',
                    del_url: 'dramas/block/del',
                    multi_url: 'dramas/block/multi',
                    import_url: 'dramas/block/import',
                    table: 'dramas_block',
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
                        {field: 'title', title: __('Title'), operate: 'LIKE'},
                        {field: 'image', title: __('Image'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'parsetpl', title: __('Parsetpl'), searchList: {"0":__('Parsetpl 0'),"1":__('Parsetpl 1')}, formatter: Table.api.formatter.normal},
                        {field: 'url', title: __('Url'), operate: false, formatter: function (value, row, index) {
                                var urlObj = $.extend({}, this);
                                if(row['parsetpl'] == 0){
                                    return Table.api.formatter.url.call(urlObj, value, row, index);
                                }else{
                                    //'https://video.nymaite.cn/h5/?edum#/pages/video/play?id='
                                    value = row['video_id'] === null  || row['video_id'].length === 0 ? '' : row['video_id'].toString();
                                    if(value != ''){
                                        value = Config.video_url+value;
                                    }
                                    return Table.api.formatter.url.call(urlObj, value, row, index);
                                }
                            }},
                        {field: 'video_id', title: __('Video_id'),
                            visible: false,
                            addclass: 'selectpage',
                            extend: 'data-source="dramas/video/index" data-field="title"',
                            operate: '=',
                            formatter: Table.api.formatter.search
                        },
                        {field: 'weigh', title: __('Weigh'), operate: false},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"normal":__('Status normal'),"hidden":__('Status hidden')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            $(document).on('click', '.btn-sync', function () {
                Layer.confirm(__('Import test data'), {icon: 3, title: __('Import'), btn: [__('Ok'), __('Cancel')]}, function () {
                    Fast.api.ajax({
                        url: 'dramas/block/sync',
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
                $(document).on("change", "#c-parsetpl", function () {
                    if($(this).val() == 1){
                        $(".video_id").show();
                        $(".url").hide();
                        $("#c-url").val('');
                    }else{
                        $(".url").show();
                        $(".video_id").hide();
                        if($("#c-video_id").val() > 0){
                            $("#c-video_id").selectPageClear();
                        }
                    }
                });
                if ($("#c-parsetpl").val() >= 0) {
                    $("#c-parsetpl").trigger("change", true);
                }
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
