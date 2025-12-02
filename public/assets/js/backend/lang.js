define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            var langIndex = new Vue({
                el: "#langIndex",
                data() {
                    return {
                        tabsData: [],
                        langData: [],
                        langListData: [],
                        activeName: null,
                        activeId: null,
                        activeIndex: null,
                        langTranslate: '',
                        lang_file: '',
                        isAjax: true,
                        translate: false,
                        langTranslateList: [
                            'en',
                            'jp',
                            'kor',
                            'fra',
                            'spa',
                            'th',
                            'ara',
                            'ru',
                            'pt',
                            'de',
                            'it',
                            'el',
                            'nl',
                            'pl',
                            'bul',
                            'est',
                            'dan',
                            'fin',
                            'cs',
                            'rom',
                            'slo',
                            'swe',
                            'hu',
                            'cht',
                            'vie',
                        ],
                    };
                },
                mounted() {
                    this.getData(null);
                },
                methods: {
                    getLangList(lang){
                        let that = this;
                        Fast.api.ajax({
                                url: 'lang/get_lang_list',
                                loading: false,
                                type: "GET",
                                data: {
                                    name: lang
                                }
                            }, function (ret, res) {
                                that.langData = res.data;
                                that.langListData = [];
                                return false;
                            }
                        );
                    },
                    getData(id) {
                        let that = this;
                        Fast.api.ajax({
                            url: 'lang/index',
                            loading: false,
                            type: "GET",
                        }, function (ret, res) {
                            that.tabsData = [];
                            res.data.forEach(i => {
                                that.tabsData.push(i);
                            });
                            if (that.tabsData.length > 0) {
                                if (id == null) {
                                    that.activeName = that.tabsData[0].lang;
                                    that.activeId = that.tabsData[0].id;
                                    that.activeIndex = 0;
                                    that.getLangList(that.activeName);
                                } else {
                                    that.activeId = id;
                                    that.tabsData.forEach((i, index) => {
                                        if (i.id == id) {
                                            that.activeName = i.lang;
                                            that.activeIndex = index;
                                        }
                                    });
                                    that.getLangList(that.activeName);
                                }
                            }
                            that.isAjax=false;
                            return false;
                        });
                    },
                    operation(type, id) {
                        let that = this;
                        switch (type) {
                            case 'config':
                                Fast.api.open("lang/config", __('Setting'));
                                break;
                            case 'addLang':
                                Fast.api.open("lang/add", __('Add'), {
                                    callback: function (data) {
                                        that.getData(data.id);
                                    }
                                });
                                break;
                            case 'editLang':
                                Fast.api.open("lang/edit?ids=" + id, __('Edit'), {
                                    callback: function (data) {
                                        if (data.type == 'edit') {
                                            that.getData(data.id);
                                        } else {
                                            that.getData(null);
                                        }
                                    }
                                });
                                break;
                        }
                    },
                    handleClick(tab) {
                        let that = this;
                        let index = Number(tab.index);
                        that.activeIndex = index;
                        that.activeId = that.tabsData[index].id;
                        that.activeName = that.tabsData[index].lang;
                        that.getLangList(that.activeName);
                    },
                    showLeft(p, c, a, s) {
                        if (p != null && a === null && c === null && s === null) {
                            this.langData[p].show = !this.langData[p].show;
                        }
                        if (p != null && c != null && a == null && s === null) {
                            this.langData[p].children[c].show = !this.langData[p].children[c].show;
                        }
                        if (p != null && c != null && a != null && s === null) {
                            this.langData[p].children[c].children[a].show = !this.langData[p].children[c].children[a].show;
                        }
                        this.$forceUpdate();
                        this.selectLangLeft(p, c, a, s);
                    },
                    selectLangLeft(p, c, a, s) {
                        this.langData.forEach(i => {
                            i.selected = false;
                            if (i.children && i.children.length > 0) {
                                i.children.forEach(j => {
                                    j.selected = false;
                                    if (j.children && j.children.length > 0) {
                                        j.children.forEach(k => {
                                            k.selected = false;
                                            if (k.children && k.children.length > 0) {
                                                k.children.forEach(l => {
                                                    l.selected = false;
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });
                        let lang_path = null;
                        let lang_type = null;
                        if (p != null && a === null && c === null && s === null) {
                            this.langData[p].selected = !this.langData[p].selected;
                            lang_path = this.langData[p].path;
                            lang_type = this.langData[p].type;
                        }
                        if (p != null && c != null && a == null && s === null) {
                            this.langData[p].children[c].selected = !this.langData[p].children[c].selected;
                            lang_path = this.langData[p].children[c].path;
                            lang_type = this.langData[p].children[c].type;
                        }
                        if (p != null && c != null && a != null && s === null) {
                            this.langData[p].children[c].children[a].selected = !this.langData[p].children[c].children[a].selected;
                            lang_path = this.langData[p].children[c].children[a].path;
                            lang_type = this.langData[p].children[c].children[a].type;
                        }
                        if (p != null && c != null && a != null && s != null) {
                            this.langData[p].children[c].children[a].children[s].selected = !this.langData[p].children[c].children[a].children[s].selected;
                            lang_path = this.langData[p].children[c].children[a].children[s].path;
                            lang_type = this.langData[p].children[c].children[a].children[s].type;
                        }
                        if(lang_type == 'file'){
                            this.getLangData(lang_path);
                            this.lang_file = lang_path;
                        }
                        this.$forceUpdate();
                    },
                    getLangData(lang_path){
                        let that = this;
                        Fast.api.ajax({
                            url: 'lang/get_lang_data',
                            loading: true,
                            data: {
                                'lang': that.activeName,
                                'lang_path': lang_path
                            },
                            type: 'POST'
                        }, function (ret, res) {
                            that.langListData = res.data;
                            return false;
                        });
                    },
                    updateLangData(){
                        let that = this;
                        Fast.api.ajax({
                            url: 'lang/set_lang_data',
                            loading: true,
                            data: {
                                'lang': that.activeName,
                                'lang_path': that.lang_file,
                                'lang_data': JSON.stringify(that.langListData)
                            },
                            type: 'POST'
                        }, function (ret, res) {});
                    },
                    //删除
                    delLangItem(i) {
                        this.langListData.splice(i, 1);
                    },
                    //添加
                    addLangItem() {
                        if(this.langListData.length > 0){
                            const item = {};
                            item['key'] = '';
                            item['zh-cn'] = '';
                            if(this.activeName != 'zh-cn'){
                                item[this.activeName] = '';
                            }
                            this.langListData.push(item);
                        }
                    },
                    //翻译
                    addTranslate(){
                        this.translate = false;
                        let that = this;
                        this.$nextTick(() => {
                            Fast.api.ajax({
                                url: 'lang/multi_translate',
                                loading: true,
                                data: {
                                    'lang': that.activeName,
                                    'to': that.langTranslate,
                                    'lang_data': JSON.stringify(that.langListData)
                                },
                                type: 'POST'
                            }, function (ret, res) {
                                that.langListData = res.data;
                                return false;
                            },function (ret, res) {
                                that.langListData = res.data;
                            });
                        });
                    },
                    setTranslate(val){
                        this.translate = val;
                    },
                },
            });
        },
        add: function () {
            Controller.detailInit('add');
        },
        edit: function () {
            Controller.detailInit('edit');
        },
        detailInit: function (type) {
            var langDetail = new Vue({
                el: "#langDetail",
                data() {
                    return {
                        optType: type,
                        detailForm: {},
                        detailFormInit: {
                            lang: '',
                            lang_cn: '',
                            nation_code: '',
                            currency: '',
                            exchange_rate: 1,
                        },
                        rulesForm: {
                            lang: [{
                                required: true,
                                message: __('Please enter your lang'),
                                trigger: 'blur'
                            }],
                            lang_cn: [{
                                required: true,
                                message: __('Please enter your lang_cn'),
                                trigger: 'blur'
                            }],
                            nation_code: [{
                                required: true,
                                message: __('Please enter your nation_code'),
                                trigger: 'blur'
                            }],
                            currency: [{
                                required: true,
                                message: __('Please enter your currency'),
                                trigger: 'blur'
                            }],
                            exchange_rate: [{
                                required: true,
                                message: __('Please enter your exchange rate'),
                                trigger: 'blur'
                            }],
                        },
                    };
                },
                mounted() {
                    this.detailForm = JSON.parse(JSON.stringify(this.detailFormInit));
                    if (this.optType == 'edit') {
                        for (key in this.detailForm) {
                            this.detailForm[key] = Config.row[key];
                        }
                    }
                },
                methods: {
                    deletelang() {
                        let that = this;
                        that.$confirm(__('This operation will delete all relevant data for the language pack. Do you want to continue?'), __('Warning'), {
                            confirmButtonText: __('Ok'),
                            cancelButtonText: __('Cancel'),
                            type: 'warning'
                        }).then(() => {
                            Fast.api.ajax({
                                url: 'lang/del/ids/' + Config.row.id,
                                loading: true,
                                type: 'POST'
                            }, function (ret, res) {
                                Fast.api.close({
                                    data: true,
                                    id: Config.row.id,
                                    type: 'delete'
                                });
                            });
                        }).catch(() => {
                            that.$message({
                                type: 'info',
                                message: __('Cancel')
                            });
                        });
                    },
                    submitForm(check) {
                        let that = this;
                        this.$refs[check].validate((valid) => {
                            if (valid) {
                                if (that.optType != 'add') {
                                    Fast.api.ajax({
                                        url: 'lang/edit?ids=' + Config.row.id,
                                        loading: true,
                                        type: "POST",
                                        data: {
                                            data: JSON.stringify(this.detailForm)
                                        }
                                    }, function (ret, res) {
                                        Fast.api.close({
                                            data: true,
                                            id: Config.row.id,
                                            type: 'edit'
                                        });
                                    });
                                } else {
                                    Fast.api.ajax({
                                        url: 'lang/add',
                                        loading: true,
                                        type: "POST",
                                        data: {
                                            data: JSON.stringify(this.detailForm)
                                        }
                                    }, function (ret, res) {
                                        Fast.api.close({
                                            data: true,
                                            id: res.data
                                        });
                                    });
                                }
                            } else {
                                return false;
                            }
                        });
                    }
                }
            });
        },
        config: function () {
            var langConfig = new Vue({
                el: "#langConfig",
                data() {
                    return {
                        configForm: {},
                        configFormInit: {
                            app_id: '',
                            sec_key: '',
                        },
                        rulesForm: {
                            app_id: [{
                                required: true,
                                message: __('Please enter app_id'),
                                trigger: 'blur'
                            }],
                            sec_key: [{
                                required: true,
                                message: __('Please enter sec_key'),
                                trigger: 'blur'
                            }],
                        },
                    };
                },
                mounted() {
                    this.configForm = JSON.parse(JSON.stringify(this.configFormInit));
                    for (key in this.configForm) {
                        this.configForm[key] = Config.row[key];
                    }
                },
                methods: {
                    submitForm(check) {
                        this.$refs[check].validate((valid) => {
                            if (valid) {
                                Fast.api.ajax({
                                    url: 'lang/config',
                                    loading: true,
                                    type: "POST",
                                    data: this.configForm
                                }, function (ret, res) {
                                    Fast.api.close({
                                        data: true,
                                        type: 'config'
                                    });
                                });
                            } else {
                                return false;
                            }
                        });
                    }
                }
            });
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});
