<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"/www/wwwroot/duanju.doukang.shop/public/../application/admin/view/index/login.html";i:1764557765;s:72:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/meta.html";i:1715757698;s:74:"/www/wwwroot/duanju.doukang.shop/application/admin/view/common/script.html";i:1715757698;}*/ ?>
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


    <!--@formatter:off-->
    <style type="text/css">
        body {
            min-width: 375px;
            overflow: hidden;
            font-size: 14px;
            line-height: 1.5715;
            margin: 0;
            color: #999;
            background: radial-gradient(ellipse at bottom,#5db8ff 0,#0076d1 100%);
        }
        .container {
            min-height: 100vh;
            flex-direction: column;
            width: 100%;
        }
        .container .login-wrapper {
            justify-content: center;
            align-items: center;
            padding-top: 10%;
            display: flex;
        }
        .login-screen {
            border: 1px solid #eeeeee;
            background-color: #fff;
            height: 450px;
            border-radius: 1.2rem;
            overflow:hidden;
            float: left;
        }
        .login-head {
            width: 470px;
            display: none;
            line-height: 445px;
            float: left;
        }
        .login-head img{
            width: 470px;
        }
        .login-form {
            padding-left: 3rem;
            padding-right: 6rem;
            padding-top: 4.5rem;
            width: 375px;
            float: left;
        }
        @media (min-width: 800px){
            .login-head {
                display: inline-block;
            }
            .login-form {
                width: 465px;
            }
        }
        .lg_sec_tit {
            color: #555555;
            display: inline-block;
            width: 100%;
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin: 0 auto 8px auto;
            padding-right: 5px;
            zoom: 1;
        }
        .lg_sec_tit img {
            height: 50px;
            border-radius: 25px;
            margin-right: 5px;
        }
        #login-form {
            margin-top: 20px;
        }
        #login-form .input-group {
            margin-bottom: 15px;
        }
        #login-form .form-control {
            font-size: 13px;
            border: 1px solid #cccccc;
            outline: none;
            line-height: 40px;
            height: 40px;
            font-size: 14px;
        }
        #login-form .checkbox {
            margin-bottom: 20px;
        }
        .copyright {
            color: #EEE;
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
        }
    </style>
    <!--@formatter:on-->
</head>
<body>
<div class="container" id="mydiv">
    <div class="login-wrapper">
        <div class="login-screen">
            <div class="login-head">
                <img src="/assets/img/login_image.jpg" />
            </div>
            <div class="login-form">
                <h2 class="lg_sec_tit"><img src="<?php echo $logo; ?>"> <?php echo $title; ?> </h2>
                <form action="" method="post" id="login-form">
                    <!--@AdminLoginFormBegin-->
                    <div id="errtips" class="hide"></div>
                    <?php echo token(); ?>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                        <input type="text" class="form-control" id="pd-form-username" placeholder="<?php echo __('Username'); ?>" name="username" autocomplete="off" value="" data-rule="<?php echo __('Username'); ?>:required;username"/>
                    </div>

                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
                        <input type="password" class="form-control" id="pd-form-password" placeholder="<?php echo __('Password'); ?>" name="password" autocomplete="off" value="" data-rule="<?php echo __('Password'); ?>:required;password"/>
                    </div>
                    <!--@CaptchaBegin-->
                    <?php if(\think\Config::get('fastadmin.login_captcha')): ?>
<!--                    <div class="input-group">-->
<!--                        <div class="input-group-addon"><span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span></div>-->
<!--                        <input type="text" name="captcha" class="form-control" placeholder="<?php echo __('Captcha'); ?>" data-rule="<?php echo __('Captcha'); ?>:required;length(<?php echo \think\Config::get('captcha.length'); ?>)" autocomplete="off"/>-->
<!--                        <span class="input-group-addon" style="padding:0;border:none;cursor:pointer;">-->
<!--                                    <img src="<?php echo rtrim('/', '/'); ?>/index.php?s=/captcha" width="100" height="30" onclick="this.src = '<?php echo rtrim('/', '/'); ?>/index.php?s=/captcha&r=' + Math.random();"/>-->
<!--                            </span>-->
<!--                    </div>-->
                    <?php endif; ?>
                    <!--@CaptchaEnd-->
                    <?php if($keeyloginhours>0): ?>
                    <div class="form-group checkbox">
                        <label class="inline" for="keeplogin" data-toggle="tooltip" title="<?php echo __('The duration of the session is %s hours', $keeyloginhours); ?>">
                            <input type="checkbox" name="keeplogin" id="keeplogin" value="1"/>
                            <?php echo __('Keep login'); ?>
                        </label>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block" style="background:#708eea;"><?php echo __('Sign in'); ?></button>
                    </div>
                    <!--@AdminLoginFormEnd-->
                </form>
            </div>
        </div>
    </div>
</div>
<div class="copyright"> <?php echo $copyright; ?> </div>
<script type="text/javascript" src="/assets/js/canvas-particle.js"></script>
<script type="text/javascript">
    //配置
    var config = {
        vx: 4,	//小球x轴速度,正为右，负为左
        vy: 4,	//小球y轴速度
        height: 2,	//小球高宽，其实为正方形，所以不宜太大
        width: 2,
        count: 150,		//点个数
        color: "121,255,255", 	//点颜色
        stroke: "130,255,255", 		//线条颜色
        dist: 6000, 	//点吸附距离
        e_dist: 20000, 	//鼠标吸附加速距离
        max_conn: 10 	//点到点最大连接数
    }
    //调用
    CanvasParticle(config);
</script>

<script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
</body>
</html>
