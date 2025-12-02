define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            var configIndex = new Vue({
                el: "#configIndex",
                data() {
                    return {
                        activeName: "basic",
                        configData: {
                            basic: [],
                            platform: [],
                            payment: []
                        }
                    }
                },
                mounted() {
                    if(Config.site_id == 0){
                        this.configData['basic'] = [
                        ];
                        this.configData['platform'] = [
                        ];
                    }else{
                        this.configData['basic'] = [{
                            id: 'dramas',
                            title: __('System'),
                            tip: __('System configure'),
                            message: __('System name and logo'),
                            icon: 'dramas-icon',
                            leaf: '#6ACAA5',
                            background: 'linear-gradient(180deg, #BAF0DD 0%, #51BC99 100%)',
                            url: "{:url(dramas.config/platform?type=dramas')}",
                            button: {
                                background: '#E0F1EB',
                                color: '#13986C'
                            },
                        }, {
                            id: 'user',
                            title: __('User'),
                            tip: __('User configure'),
                            message: __('Default nickname, avatar'),
                            icon: 'user-icon',
                            leaf: '#E0B163',
                            background: 'linear-gradient(180deg, #FCE6B7 0%, #E9A848 100%)',
                            button: {
                                background: '#F7EDDD',
                                color: '#B07318'
                            },
                        }, {
                            id: 'sms',
                            title: __('Sms'),
                            tip: __('Sms configure'),
                            message: __('Login registration, verification code verification'),
                            icon: 'score-icon',
                            leaf: '#EC9371',
                            background: 'linear-gradient(180deg, #FADDC0 0%, #E47F6D 100%)',
                            button: {
                                background: '#F6E5E1',
                                color: '#D75125'
                            },
                        }, {
                            id: 'email',
                            title: __('Email'),
                            tip: __('Email configure'),
                            message: __('Login registration, verification code verification'),
                            icon: 'score-icon',
                            leaf: '#EC9371',
                            background: 'linear-gradient(180deg, #FADDC0 0%, #E47F6D 100%)',
                            button: {
                                background: '#F6E5E1',
                                color: '#D75125'
                            },
                        }, {
                            id: 'share',
                            title: __('Share'),
                            tip: __('Share configure'),
                            message: __('Share poster images and backgrounds'),
                            icon: 'share-icon',
                            leaf: '#915CF9',
                            background: 'linear-gradient(180deg, #D5B8FA 0%, #8F62C9 100%)',
                            button: {
                                background: '#E7DEF6',
                                color: '#6625CF'
                            },
                        }, {
                            id: 'withdraw',
                            title: __('Withdraw'),
                            tip: __('Withdraw configure'),
                            message: __('Handling fees, minimum and maximum amounts'),
                            icon: 'withdraw-icon',
                            leaf: '#EA6670',
                            background: 'linear-gradient(180deg, #FCB7BE 0%, #D36068 100%)',
                            button: {
                                background: '#F3DCDE',
                                color: '#D61226'
                            },
                        }];
                        if(typeof Config.addons['uploads'] != 'undefined' && Config.addons['uploads']['state'] == 1){
                            this.configData['basic'].push({
                                id: 'uploads',
                                title: __('Uploads'),
                                tip: __('Uploads configure'),
                                message: __('Alibaba Cloud OSS, Tencent Cloud COS'),
                                icon: 'store-icon',
                                leaf: '#487EE5',
                                background: 'linear-gradient(180deg, #84C4FF 0%, #3C68BE 100%)',
                                button: {
                                    background: '#DFE7EE',
                                    color: '#1C54BD'
                                },
                            });
                        }
                        // this.configData['platform'] = [{
                        //     id: 'App',
                        //     title: __('App'),
                        //     tip: __('App configure'),
                        //     message: __('Generate an app to achieve multi end synchronous use'),
                        //     icon: 'App-icon',
                        //     leaf: '#6990E6',
                        //     background: 'linear-gradient(180deg, #BED6FF 0%, #6785CD 100%)',
                        //     buttonMessage: __('Set up'),
                        //     button: {
                        //         background: '#DAE1F6',
                        //         color: '#1666D3'
                        //     },
                        // },{
                        //     id: 'H5',
                        //     title: __('H5'),
                        //     tip: __('H5 configure'),
                        //     message: __('WeChat h5 payment information'),
                        //     icon: 'h5-icon',
                        //     leaf: '#EC9371',
                        //     background: 'linear-gradient(180deg, #FADDC0 0%, #E5806D 100%)',
                        //     buttonMessage: __('Set up'),
                        //     button: {
                        //         background: '#F7E6E1',
                        //         color: '#D75E37'
                        //     }
                        // }];
                        this.configData['payment'] = [{
                        //     id: 'wechat',
                        //     title: __('Wechat'),
                        //     tip: '',
                        //     message: '',
                        //     icon: 'wechat-icon',
                        //     leaf: '#6ACAA4',
                        //     background: 'linear-gradient(180deg, #AAF0D7 0%, #5DC1A0 100%)',
                        //     button: {
                        //         background: '#DEF0EA',
                        //         color: '#0EA753'
                        //     },
                        // }, {
                            id: 'paypal',
                            title: __('PayPal'),
                            tip: '',
                            message: '',
                            icon: 'apple-icon',
                            leaf: '#6962F7',
                            background: 'linear-gradient(180deg, #C2C0FF 0%, #6563C9 100%) ',
                            button: {
                                background: '#D8D8F1',
                                color: '#1E14E0',
                                cursor: 'auto'
                            },
                        }, {
                            id: 'stripe',
                            title: __('Stripe'),
                            tip: '',
                            message: '',
                            icon: 'apple-icon',
                            leaf: '#6962F7',
                            background: 'linear-gradient(180deg, #C2C0FF 0%, #6563C9 100%) ',
                            button: {
                                background: '#D8D8F1',
                                color: '#1E14E0',
                                cursor: 'auto'
                            },
                        // }, {
                        //     id: 'alipay',
                        //     title: __('Alipay'),
                        //     tip: '',
                        //     message: '',
                        //     icon: 'alipay-icon',
                        //     leaf: '#6990E6',
                        //     background: 'linear-gradient(180deg, #BFD6FF 0%, #6786CE 100%)',
                        //     button: {
                        //         background: '#DAE1F6',
                        //         color: '#005AD7',
                        //         cursor: 'auto'
                        //     },
                        }];
                    }
                },
                methods: {
                    tabClick(tab, event) {
                        this.activeName = tab.name;
                    },
                    operation(id, title) {
                        let that = this;
                        Fast.api.open("dramas/config/platform?type=" + id + "&tab=" + that.activeName + "&title=" + title, title);
                    },
                },
            })
        },
        platform: function () {
            Vue.directive('enterInteger', {
                inserted: function (el) {
                    const input = el.nodeName === 'INPUT' ? el : el.getElementsByTagName('input')[0]
                    const fn = (e) => {
                        input.value = input.value.replace(/(^[^1-9])|[^\d]/g, '')
                        const ev = document.createEvent('HTMLEvents')
                        ev.initEvent('input', true, true)
                        input.dispatchEvent(ev)
                    }
                    input.onkeyup = fn
                    input.onblur = fn
                }
            });
            function debounce(handle, delay) {
                let time = null;
                return function () {
                    let self = this,
                        arg = arguments;
                    clearTimeout(time);
                    time = setTimeout(function () {
                        handle.apply(self, arg);
                    }, delay)
                }
            }
            var configPlatform = new Vue({
                el: "#configPlatform",
                data() {
                    return {
                        platformData: {
                            dramas: {
                                name: {},
                                domain: '',
                                lang_id: '',
                                h5: '',
                                h5_theme: 'default',
                                version: '',
                                logo: '',
                                logo_arr: [],
                                company: '',
                                company_arr: [],
                                copyright: {list: []},
                                mobile_switch: '',
                                android_autoplay: '',
                                user_protocol: {},
                                privacy_protocol: {},
                                about_us: {},
                                contact_us: {},
                                legal_notice: {},
                                usable_desc: {},
                                vip_desc: {},
                                reseller_desc: {},
                                user_protocol_title: {},
                                privacy_protocol_title: {},
                                about_us_title: {},
                                contact_us_title: {},
                                legal_notice_title: {},
                                usable_desc_title: {},
                                vip_desc_title: {},
                                reseller_desc_title: {},
                            },
                            user: {
                                nickname: '',
                                avatar: '',
                                avatar_arr: [],
                                group_id: '',
                                money: '',
                                score: '',
                            },
                            share: {
                                user_poster_bg: '',
                                user_poster_bg_arr: [],
                                user_poster_bg_color: '',
                                msg_title_bg_color_arr: ['#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3',
                                    '#03A9F4', '#00BCD4', '#009688', '#4CAF50', '#8BC34A', '#FFEB3B',
                                    '#FFC107', '#FF9800', '#FF5722', '#795548', '#9E9E9E', '#607D8B'],
                            },
                            sms: {
                                type: 'alisms',
                                alisms: {
                                    key: '',
                                    secret: '',
                                    sign: '',
                                    template: []
                                },
                                hwsms: {
                                    app_url: '',
                                    key: '',
                                    secret: '',
                                    sender: '',
                                    sign: '',
                                    template: []
                                },
                                qcloudsms: {
                                    appid: '',
                                    appkey: '',
                                    sign: '',
                                    isTemplateSender: '1',
                                    template: []
                                },
                                baosms: {
                                    username: '',
                                    password: '',
                                    sign: '',
                                    template: [
                                        {
                                            "key":"zh-cn",
                                            "value":""
                                        },
                                        {
                                            "key":"en",
                                            "value":""
                                        },
                                    ],
                                },
                            },
                            email: {
                                mail_type: '',
                                mail_smtp_host: '',
                                mail_smtp_port: '',
                                mail_smtp_user: '',
                                mail_smtp_pass: '',
                                mail_verify_type: '',
                                mail_from: '',
                                mail_template: [
                                    {
                                        "key":"zh-cn",
                                        "value":"",
                                        "title":""
                                    },
                                    {
                                        "key":"en",
                                        "value":"",
                                        "title":""
                                    },
                                ],
                            },
                            withdraw: {
                                methods: [],
                                wechat_alipay_auto: 0,
                                service_fee: '',
                                min: '',
                                max: '',
                                perday_amount: 0,
                                perday_num: 0,
                            },
                            H5: {
                                app_id: '',
                                secret: '',
                            },
                            App: {
                                app_id: '',
                                secret: '',
                            },
                            wechat: {
                                platform: [],
                                mch_id: '',
                                key: '',
                                sub_key: '',
                                cert_client: '',
                                cert_key: '',
                                sub_cert_client: '',
                                sub_cert_key: '',
                                mode: 'normal',
                                sub_mch_id: '',
                                app_id: '',
                            },
                            alipay: {
                                platform: [],
                                app_id: '',
                                ali_public_key: '',
                                app_cert_public_key: '',
                                alipay_root_cert: '',
                                private_key: '',
                                mode: 'normal',
                                pid: '',
                            },
                            wallet: {
                                platform: [],
                            },
                            paypal: {
                                platform: [],
                                environment: 'live',
                                clent_id: '',
                                client_secret: '',
                                webhook: '',
                            },
                            stripe: {
                                platform: [],
                                environment: 'live',
                                public_key: '',
                                private_key: '',
                                webhook_key: '',
                                webhook: '',
                            },
                            uploads: {
                                upload_type: '',
                                alioss: {
                                    'accessKeyId': '',
                                    'accessKeySecret': '',
                                    'bucket': '',
                                    'endpoint': '',
                                    'cdnurl': '',
                                    'uploadmode': 'server',
                                    'serverbackup': '1',
                                    'savekey': '/uploads/{year}{mon}{day}/{filemd5}{.suffix}',
                                    'expire': '600',
                                    'maxsize': '1024M',
                                    'mimetype': 'jpg,png,bmp,jpeg,gif,webp,zip,rar,wav,mp4,mp3,webm,pem,xls,m3u8,avi,mov,ipa,xlsx,apk',
                                    'multiple': '0',
                                    'thumbstyle': '',
                                    'chunking': '0',
                                    'chunksize': '4194304',
                                    'syncdelete': '1',
                                    'apiupload': '1',
                                    'noneedlogin': '',
                                    'noneedloginarr': [],
                                },
                                cos: {
                                    'appId': '',
                                    'secretId': '',
                                    'secretKey': '',
                                    'bucket': '',
                                    'region': '',
                                    'uploadmode': 'server',
                                    'serverbackup': '1',
                                    'uploadurl': '',
                                    'cdnurl': '',
                                    'savekey': '/uploads/{year}{mon}{day}/{filemd5}{.suffix}',
                                    'expire': '600',
                                    'maxsize': '1024M',
                                    'mimetype': 'jpg,png,bmp,jpeg,gif,webp,zip,rar,wav,mp4,mp3,webm,pem,xls,m3u8,avi,mov,ipa,xlsx,apk',
                                    'multiple': '0',
                                    'thumbstyle': '',
                                    'chunking': '0',
                                    'chunksize': '4194304',
                                    'syncdelete': '1',
                                    'apiupload': '1',
                                    'noneedlogin': '',
                                    'noneedloginarr': [],
                                },
                            },

                        },
                        type: new URLSearchParams(location.search).get('type'),
                        tab: new URLSearchParams(location.search).get('tab'),
                        title: new URLSearchParams(location.search).get('title'),
                        groupList: [],
                        detailForm: {},
                        must_delete: ['logo_arr', 'company_arr', 'avatar_arr', 'image_arr', 'msg_title_bg_arr', 'user_poster_bg_arr', 'msg_title_bg_color_arr', 'qrcode_arr', 'area_arr'],
                        deliverCompany: [],
                        uploadmodeList: [
                            {'model': 'client', 'name': __('Client direct transfer (fast speed, no backup)')},
                            {'model': 'server', 'name': __('Server transfer (occupying server bandwidth, can be backed up)')},
                        ],
                        //选项
                        langOptions: [],
                        langMain: ['zh-cn', 'en'],
                        lang_key: 'zh-cn',
                        agreement_key: 'zh-cn',
                    }
                },
                mounted() {
                    this.operationData();
                },
                methods: {
                    copyMessage(key) {
                        navigator.clipboard.writeText(key).then(() => {
                            this.$message.success('复制成功');
                        });
                    },
                    testmail() {
                        var that = this;
                        Layer.prompt({title: __('Please input your email'), formType: 0}, function (value, index) {
                            Backend.api.ajax({
                                url: "dramas/config/emailtest",
                                data: {
                                    row: that.detailForm,
                                    receiver: value
                                }
                            }, function (data, ret) {
                                Layer.closeAll();
                            });
                        });
                    },
                    backupDownload() {
                        this.$confirm(__('Download static resource files such as images?'), __('Warning'), {
                            confirmButtonText: __('Ok'),
                            cancelButtonText: __('Cancel'),
                            type: 'warning'
                        }).then(() => {
                            window.open('backup_download', '_blank');
                            return false;
                        }).catch(() => {
                            this.$message({
                                type: 'info',
                                message: __('Cancel download')
                            });
                        });
                    },
                    // radio取消选中
                    setUploadType(val) {
                        this.detailForm = this.platformData['uploads'];
                        val === this.detailForm.upload_type ? this.detailForm.upload_type = '' : this.detailForm.upload_type = val;
                    },
                    //添加主规格
                    addMain() {
                        this.detailForm = this.platformData['dramas']
                        this.detailForm.copyright.list.push({
                            image: '',
                            name: '',
                            url: '',
                        })
                    },
                    //删除主规格
                    deleteMain(k) {
                        // 删除主规格
                        this.detailForm = this.platformData['dramas']
                        this.detailForm.copyright.list.splice(k, 1)
                    },
                    selectColor(type, color) {
                        this.detailForm = this.platformData['share']
                        if(type == 'user_poster_bg_color'){
                            this.detailForm.user_poster_bg_color = color;
                        }else if(type == 'msg_title_bg_color'){
                            this.detailForm.msg_title_bg_color = color;
                        }
                        this.$emit('color-selected', color);
                    },
                    valueChange() {
                        this.$forceUpdate();
                    },
                    operationData() {
                        this.langOptions = Config.langList;
                        this.detailForm = this.platformData[this.type];
                        if (Config.row) {
                            for (key in this.detailForm) {
                                if (Config.row[key]) {
                                    if (Config.row[key] instanceof Object) {
                                        for (inner in Config.row[key]) {
                                            if (Config.row[key][inner]) {
                                                this.detailForm[key][inner] = Config.row[key][inner]
                                            }
                                        }
                                    } else {
                                        this.detailForm[key] = Config.row[key]
                                    }
                                }
                            }
                        }
                        if (this.type == 'dramas') {
                            const name = {};
                            const reseller_desc = {};
                            const reseller_desc_title = {};
                            const vip_desc = {};
                            const vip_desc_title = {};
                            const usable_desc = {};
                            const usable_desc_title = {};
                            const legal_notice = {};
                            const legal_notice_title = {};
                            const contact_us = {};
                            const contact_us_title = {};
                            const about_us = {};
                            const about_us_title = {};
                            const privacy_protocol = {};
                            const privacy_protocol_title = {};
                            const user_protocol = {};
                            const user_protocol_title = {};
                            Object.values(this.langOptions).forEach((item, index) => {
                                if (this.detailForm.name.hasOwnProperty(item)) {
                                    name[item] = this.detailForm.name[item];
                                } else {
                                    name[item] = '';
                                }
                                if (this.detailForm.reseller_desc.hasOwnProperty(item)) {
                                    reseller_desc[item] = this.detailForm.reseller_desc[item];
                                    reseller_desc_title[item] = this.detailForm.reseller_desc_title[item];
                                } else {
                                    reseller_desc[item] = '';
                                    reseller_desc_title[item] = '';
                                }
                                if (this.detailForm.vip_desc.hasOwnProperty(item)) {
                                    vip_desc[item] = this.detailForm.vip_desc[item];
                                    vip_desc_title[item] = this.detailForm.vip_desc_title[item];
                                } else {
                                    vip_desc[item] = '';
                                    vip_desc_title[item] = '';
                                }
                                if (this.detailForm.usable_desc.hasOwnProperty(item)) {
                                    usable_desc[item] = this.detailForm.usable_desc[item];
                                    usable_desc_title[item] = this.detailForm.usable_desc_title[item];
                                } else {
                                    usable_desc[item] = '';
                                    usable_desc_title[item] = '';
                                }
                                if (this.detailForm.legal_notice.hasOwnProperty(item)) {
                                    legal_notice[item] = this.detailForm.legal_notice[item];
                                    legal_notice_title[item] = this.detailForm.legal_notice_title[item];
                                } else {
                                    legal_notice[item] = '';
                                    legal_notice_title[item] = '';
                                }
                                if (this.detailForm.contact_us.hasOwnProperty(item)) {
                                    contact_us[item] = this.detailForm.contact_us[item];
                                    contact_us_title[item] = this.detailForm.contact_us_title[item];
                                } else {
                                    contact_us[item] = '';
                                    contact_us_title[item] = '';
                                }
                                if (this.detailForm.about_us.hasOwnProperty(item)) {
                                    about_us[item] = this.detailForm.about_us[item];
                                    about_us_title[item] = this.detailForm.about_us_title[item];
                                } else {
                                    about_us[item] = '';
                                    about_us_title[item] = '';
                                }
                                if (this.detailForm.privacy_protocol.hasOwnProperty(item)) {
                                    privacy_protocol[item] = this.detailForm.privacy_protocol[item];
                                    privacy_protocol_title[item] = this.detailForm.privacy_protocol_title[item];
                                } else {
                                    privacy_protocol[item] = '';
                                    privacy_protocol_title[item] = '';
                                }
                                if (this.detailForm.user_protocol.hasOwnProperty(item)) {
                                    user_protocol[item] = this.detailForm.user_protocol[item];
                                    user_protocol_title[item] = this.detailForm.user_protocol_title[item];
                                } else {
                                    user_protocol[item] = '';
                                    user_protocol_title[item] = '';
                                }
                            });
                            this.detailForm.name = name;
                            this.detailForm.reseller_desc = reseller_desc;
                            this.detailForm.reseller_desc_title = reseller_desc_title;
                            this.detailForm.vip_desc = vip_desc;
                            this.detailForm.vip_desc_title = vip_desc_title;
                            this.detailForm.usable_desc = usable_desc;
                            this.detailForm.usable_desc_title = usable_desc_title;
                            this.detailForm.legal_notice = legal_notice;
                            this.detailForm.legal_notice_title = legal_notice_title;
                            this.detailForm.contact_us = contact_us;
                            this.detailForm.contact_us_title = contact_us_title;
                            this.detailForm.about_us = about_us;
                            this.detailForm.about_us_title = about_us_title;
                            this.detailForm.privacy_protocol = privacy_protocol;
                            this.detailForm.privacy_protocol_title = privacy_protocol_title;
                            this.detailForm.user_protocol = user_protocol;
                            this.detailForm.user_protocol_title = user_protocol_title;

                            this.detailForm.logo_arr = []
                            this.detailForm.logo_arr.push(Fast.api.cdnurl(this.detailForm.logo))
                            this.detailForm.company_arr = []
                            this.detailForm.company_arr.push(Fast.api.cdnurl(this.detailForm.company))
                        } else if (this.type == 'user') {
                            this.groupList = Config.groupList
                            this.detailForm.avatar_arr = []
                            this.detailForm.avatar_arr.push(Fast.api.cdnurl(this.detailForm.avatar))
                        } else if (this.type == 'sms') {
                            const newArrAli = [];
                            this.langMain.forEach((item, index) => {
                                const a = this.detailForm.alisms.template.filter(i => i.key == item)[0];
                                newArrAli.push({
                                    key: item,
                                    value: a ? a.value : ""
                                });
                            });
                            this.detailForm.alisms.template = newArrAli;

                            const newArrQcloud = []
                            this.langMain.forEach((item, index) => {
                                const a = this.detailForm.qcloudsms.template.filter(i => i.key == item)[0]
                                newArrQcloud.push({
                                    key: item,
                                    value: a ? a.value : ""
                                })
                            })
                            this.detailForm.qcloudsms.template = newArrQcloud;

                            const newArrBao = []
                            this.langMain.forEach((item, index) => {
                                const a = this.detailForm.baosms.template.filter(i => i.key == item)[0]
                                newArrBao.push({
                                    key: item,
                                    value: a ? a.value : ""
                                })
                            })
                            this.detailForm.baosms.template = newArrBao;


                            // const newArrAli = []
                            // Object.values(this.langOptions).forEach((item, index) => {
                            //     const a = this.detailForm.alisms.template.filter(i => i.key == item)[0]
                            //     newArrAli.push({
                            //         key: item,
                            //         value: a ? a.value : ""
                            //     })
                            // })
                            // this.detailForm.alisms.template = newArrAli;
                            //
                            // const newArrHw = []
                            // Object.values(this.langOptions).forEach((item, index) => {
                            //     const a = this.detailForm.hwsms.template.filter(i => i.key == item)[0]
                            //     newArrHw.push({
                            //         key: item,
                            //         value: a ? a.value : ""
                            //     })
                            // })
                            // this.detailForm.hwsms.template = newArrHw;
                            //
                            // const newArrQcloud = []
                            // Object.values(this.langOptions).forEach((item, index) => {
                            //     const a = this.detailForm.qcloudsms.template.filter(i => i.key == item)[0]
                            //     newArrQcloud.push({
                            //         key: item,
                            //         value: a ? a.value : ""
                            //     })
                            // })
                            // this.detailForm.qcloudsms.template = newArrQcloud;
                            //
                            // const newArrBao = []
                            // Object.values(this.langOptions).forEach((item, index) => {
                            //     const a = this.detailForm.baosms.template.filter(i => i.key == item)[0]
                            //     newArrBao.push({
                            //         key: item,
                            //         value: a ? a.value : ""
                            //     })
                            // })
                            // this.detailForm.baosms.template = newArrBao;

                        } else if (this.type == 'email') {
                            this.detailForm.mail_type = String(this.detailForm.mail_type);
                            this.detailForm.mail_verify_type = String(this.detailForm.mail_verify_type);
                            if(!this.detailForm.hasOwnProperty('mail_template')){
                                this.detailForm.mail_template = [
                                    {
                                        "key":"zh-cn",
                                        "value":"",
                                        "title":""
                                    },
                                    {
                                        "key":"en",
                                        "value":"",
                                        "title":""
                                    },
                                ];
                            }
                        } else if (this.type == 'share') {
                            this.detailForm.image_arr = []
                            this.detailForm.image_arr.push(Fast.api.cdnurl(this.detailForm.image))
                            this.detailForm.msg_title_bg_arr = []
                            this.detailForm.msg_title_bg_arr.push(Fast.api.cdnurl(this.detailForm.msg_title_bg))
                            this.detailForm.user_poster_bg_arr = []
                            this.detailForm.user_poster_bg_arr.push(Fast.api.cdnurl(this.detailForm.user_poster_bg))
                        } else if (this.type == 'withdraw') {
                            this.detailForm.service_fee = this.detailForm.service_fee * 100
                        } else if (this.type == 'chat') {
                            if (!this.detailForm.system.ssl_type) {
                                this.$set(this.detailForm.system, 'ssl_type', 'cert')
                            }
                        } else if (this.type == 'uploads') {
                            if(this.detailForm.alioss.noneedlogin){
                                this.detailForm.alioss.noneedloginarr = this.detailForm.alioss.noneedlogin.split(',');
                            }
                            if(this.detailForm.cos.noneedlogin){
                                this.detailForm.cos.noneedloginarr = this.detailForm.cos.noneedlogin.split(',');
                            }
                        }
                    },
                    addMainSku(type) {
                        this.detailForm = this.platformData['sms']
                        if(type == 'alisms'){
                            this.detailForm.alisms.template.push({
                                key: '',
                                value: '',
                            })
                        }else if(type == 'hwsms'){
                            this.detailForm.hwsms.template.push({
                                key: '',
                                value: '',
                            })
                        }else if(type == 'qcloudsms'){
                            this.detailForm.qcloudsms.template.push({
                                key: '',
                                value: '',
                            })
                        }else if(type == 'baosms'){
                            this.detailForm.baosms.template.push({
                                key: '',
                                value: '',
                            })
                        }
                    },
                    deleteMainSku(type, k) {
                        this.detailForm = this.platformData['sms']
                        if(type == 'alisms'){
                            this.detailForm.alisms.template.splice(k, 1)
                        }else if(type == 'hwsms'){
                            this.detailForm.hwsms.template.splice(k, 1)
                        }else if(type == 'qcloudsms'){
                            this.detailForm.qcloudsms.template.splice(k, 1)
                        }else if(type == 'baosms'){
                            this.detailForm.baosms.template.splice(k, 1)
                        }
                    },

                    richtextSelect(field, key) {
                        let that = this;
                        Fast.api.open("dramas/richtext/select?lang_k="+key+"&multiple=false", __('Select'), {
                            callback: function (data) {
                                if(field == 'mail_template'){
                                    that.detailForm.mail_template[key]['value'] = String(data.data.id);
                                    that.detailForm.mail_template[key]['title'] = String(data.data.title);
                                }else{
                                    that.detailForm[field][key] = String(data.data.id);
                                    that.detailForm[field+'_title'][key] = data.data.title;
                                }
                                that.$forceUpdate();
                            }
                        });
                        return false;
                    },
                    keysSelect() {
                        Fast.api.open("dramas/aikey/index", __('Key pool management'));
                        return false;
                    },
                    check_theme() {
                        let that = this;
                        var val = that.detailForm['h5_theme'];
                        if(val == 'default'){
                            return;
                        }
                        Fast.api.ajax({
                            url: 'dramas/config/check_theme',
                            data: {
                                theme: val,
                            }
                        }, function (data, ret) {
                            return false;
                        }, function (data, ret) {
                            that.detailForm['h5_theme'] = 'default';
                        });

                    },

                    attachmentSelectArr(k) {
                        let that = this;
                        Fast.api.open("general/attachment/select?multiple=false", __('Select'), {
                            callback: function (data) {
                                that.detailForm = that.platformData['dramas'];
                                that.detailForm.copyright.list[k]['image'] = data.url;
                            }
                        });
                        return false;
                    },
                    delImgArr(k) {
                        let that = this;
                        that.detailForm = that.platformData['dramas'];
                        that.detailForm.copyright.list[k]['image'] = '';
                    },

                    attachmentSelect(type, field) {
                        let that = this;
                        Fast.api.open("general/attachment/select?multiple=false", __('Select'), {
                            callback: function (data) {
                                switch (type) {
                                    case "image":
                                        that.detailForm[field] = data.url;
                                        that.detailForm[field + '_arr'] = data.url;
                                        break;
                                    // case "file":
                                    //     that.detailForm[field] = data.url;
                                    //     break;
                                    case "ssl":
                                        that.detailForm.system[field] = data.url;
                                        break;
                                }
                            }
                        });
                        return false;
                    },
                    delImg(type, field) {
                        let that = this;
                        switch (type) {
                            case "image":
                                that.detailForm[field] = '';
                                that.detailForm[field + '_arr'] = [];
                                break;
                            case "file":
                                that.detailForm[field] = '';
                                break;
                        }
                    },
                    submitFrom(type) {
                        let that = this;
                        if (type == 'yes') {
                            let submitData = JSON.parse(JSON.stringify(that.detailForm))
                            if (that.type == 'withdraw') {
                                submitData.service_fee = (Number(submitData.service_fee) / 100).toFixed(3)
                            }
                            if (that.type == 'uploads') {
                                submitData.alioss.noneedlogin = submitData.alioss.noneedloginarr.join(',');
                                submitData.cos.noneedlogin = submitData.cos.noneedloginarr.join(',');
                            }
                            that.must_delete.forEach(i => {
                                if (submitData[i]) {
                                    delete submitData[i]
                                }
                            });
                            Fast.api.ajax({
                                url: 'dramas/config/platform?type=' + that.type,
                                loading: true,
                                type: 'POST',
                                data: {
                                    data: JSON.stringify(submitData),
                                    group: that.tab,
                                    title: that.title
                                },
                            }, function (ret, res) {
                                Fast.api.close()
                            })
                        } else {
                            Fast.api.close()
                        }
                    },
                    changeWechatType() {
                        for (key in this.detailForm) {
                            if (key != 'mode' && key != 'platform') {
                                this.detailForm[key] = ''
                            }
                        }
                    },
                    ajaxUpload(id) {
                        let that = this;
                        var formData = new FormData();
                        formData.append("file", $('#' + id)[0].files[0]);
                        $.ajax({
                            type: "post",
                            url: "ajax/upload",
                            data: formData,
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                if (data.code == 1) {
                                    that.detailForm[id] = data.data.url
                                } else {
                                    that.$notify({
                                        title: __('Warning'),
                                        message: data.msg,
                                        type: 'warning'
                                    });
                                }
                            }
                        })
                    },
                },
            })
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