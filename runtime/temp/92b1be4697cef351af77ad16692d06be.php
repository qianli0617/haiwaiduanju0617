<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:66:"/www/wwwroot/duanju.doukang.shop/addons/epay/view/index/index.html";i:1715757642;s:69:"/www/wwwroot/duanju.doukang.shop/addons/epay/view/layout/default.html";i:1715757641;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title; ?> - <?php echo $site['name']; ?></title>

    <link href="/assets/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/addons/epay/css/common.css?v=<?php echo $site['version']; ?>" rel="stylesheet">
    <link href="/assets/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo addon_url('epay/index/index'); ?>"><?php echo $site['name']; ?></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                </li>
                <?php if($user): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">欢迎你! <?php echo htmlentities($user['nickname']); ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo url('index/user/index'); ?>">会员中心</a>
                        </li>
                        <li>
                            <a href="<?php echo url('index/user/profile'); ?>">个人资料</a>
                        </li>
                        <li>
                            <a href="<?php echo url('index/user/logout'); ?>">退出登录</a>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="dropdown">
                    <a href="<?php echo url('index/user/index'); ?>" class="dropdown-toggle" data-toggle="dropdown">会员中心 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo url('index/user/login'); ?>">登录</a>
                        </li>
                        <li>
                            <a href="<?php echo url('index/user/register'); ?>">注册</a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<style>
    #prepare .col-md-4 .panel-default {
        min-height: 210px;
    }
</style>
<!-- Header Carousel -->
<header id="myCarousel" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <a href="javascript:">
                <div class="fill"
                     style="background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzOTMiIGhlaWdodD0iMjI2Ij48cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJyZ2IoNjMsIDE0MywgODUpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjE0MTMzMzMzMzMzMzMzIiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLCAtMzcuODMzMzMzMzMzMzMzKSByb3RhdGUoMTgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMTQxMzMzMzMzMzMzMzMiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsIDE4OS4xNjY2NjY2NjY2Nykgcm90YXRlKDE4MCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjA2MzMzMzMzMzMzMzMzMyIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjUuNTI5MjU1NTUzMDIzLCAtMzcuODMzMzMzMzMzMzMzKSByb3RhdGUoMCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjA2MzMzMzMzMzMzMzMzMyIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjUuNTI5MjU1NTUzMDIzLCAxODkuMTY2NjY2NjY2NjcpIHJvdGF0ZSgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDgwNjY2NjY2NjY2NjY3IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMzEuMDU4NTExMTA2MDUsIC0zNy44MzMzMzMzMzMzMzMpIHJvdGF0ZSgxODAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wODA2NjY2NjY2NjY2NjciIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDEzMS4wNTg1MTExMDYwNSwgMTg5LjE2NjY2NjY2NjY3KSByb3RhdGUoMTgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDQ2IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxOTYuNTg3NzY2NjU5MDcsIC0zNy44MzMzMzMzMzMzMzMpIHJvdGF0ZSgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDQ2IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxOTYuNTg3NzY2NjU5MDcsIDE4OS4xNjY2NjY2NjY2Nykgcm90YXRlKDAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wODkzMzMzMzMzMzMzMzMiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Mi4xMTcwMjIyMTIwOSwgLTM3LjgzMzMzMzMzMzMzMykgcm90YXRlKDE4MCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjA4OTMzMzMzMzMzMzMzMyIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjYyLjExNzAyMjIxMjA5LCAxODkuMTY2NjY2NjY2NjcpIHJvdGF0ZSgxODAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4xNDEzMzMzMzMzMzMzMyIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzI3LjY0NjI3Nzc2NTExLCAtMzcuODMzMzMzMzMzMzMzKSByb3RhdGUoMCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjE0MTMzMzMzMzMzMzMzIiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMjcuNjQ2Mjc3NzY1MTEsIDE4OS4xNjY2NjY2NjY2Nykgcm90YXRlKDAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wMiIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMCwgMCkgcm90YXRlKDAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wMjg2NjY2NjY2NjY2NjciIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDY1LjUyOTI1NTU1MzAyMywgMCkgcm90YXRlKDE4MCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjExNTMzMzMzMzMzMzMzIiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMzEuMDU4NTExMTA2MDUsIDApIHJvdGF0ZSgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDgwNjY2NjY2NjY2NjY3IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxOTYuNTg3NzY2NjU5MDcsIDApIHJvdGF0ZSgxODAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wODA2NjY2NjY2NjY2NjciIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Mi4xMTcwMjIyMTIwOSwgMCkgcm90YXRlKDAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wMiIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzI3LjY0NjI3Nzc2NTExLCAwKSByb3RhdGUoMTgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDgwNjY2NjY2NjY2NjY3IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLCAzNy44MzMzMzMzMzMzMzMpIHJvdGF0ZSgxODAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wMiIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMpIHJvdGF0ZSgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDk4IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxMzEuMDU4NTExMTA2MDUsIDM3LjgzMzMzMzMzMzMzMykgcm90YXRlKDE4MCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjE1IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxOTYuNTg3NzY2NjU5MDcsIDM3LjgzMzMzMzMzMzMzMykgcm90YXRlKDAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wMjg2NjY2NjY2NjY2NjciIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Mi4xMTcwMjIyMTIwOSwgMzcuODMzMzMzMzMzMzMzKSByb3RhdGUoMTgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDQ2IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMjcuNjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykgcm90YXRlKDAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wMzczMzMzMzMzMzMzMzMiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsIDc1LjY2NjY2NjY2NjY2Nykgcm90YXRlKDAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4wMiIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjUuNTI5MjU1NTUzMDIzLCA3NS42NjY2NjY2NjY2NjcpIHJvdGF0ZSgxODAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4xNSIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTMxLjA1ODUxMTEwNjA1LCA3NS42NjY2NjY2NjY2NjcpIHJvdGF0ZSgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMDIiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDE5Ni41ODc3NjY2NTkwNywgNzUuNjY2NjY2NjY2NjY3KSByb3RhdGUoMTgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDk4IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyNjIuMTE3MDIyMjEyMDksIDc1LjY2NjY2NjY2NjY2Nykgcm90YXRlKDAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiMyMjIiIGZpbGwtb3BhY2l0eT0iMC4wNjMzMzMzMzMzMzMzMzMiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMyNy42NDYyNzc3NjUxMSwgNzUuNjY2NjY2NjY2NjY3KSByb3RhdGUoMTgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMTI0IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLCAxMTMuNSkgcm90YXRlKDE4MCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjE1IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg2NS41MjkyNTU1NTMwMjMsIDExMy41KSByb3RhdGUoMCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjEyNCIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTMxLjA1ODUxMTEwNjA1LCAxMTMuNSkgcm90YXRlKDE4MCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjEwNjY2NjY2NjY2NjY3IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgxOTYuNTg3NzY2NjU5MDcsIDExMy41KSByb3RhdGUoMCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjEyNCIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjYyLjExNzAyMjIxMjA5LCAxMTMuNSkgcm90YXRlKDE4MCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjEzMjY2NjY2NjY2NjY3IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMjcuNjQ2Mjc3NzY1MTEsIDExMy41KSByb3RhdGUoMCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iI2RkZCIgZmlsbC1vcGFjaXR5PSIwLjEwNjY2NjY2NjY2NjY3IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLCAxNTEuMzMzMzMzMzMzMzMpIHJvdGF0ZSgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDYzMzMzMzMzMzMzMzMzIiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg2NS41MjkyNTU1NTMwMjMsIDE1MS4zMzMzMzMzMzMzMykgcm90YXRlKDE4MCwgMzIuNzY0NjI3Nzc2NTExLCAzNy44MzMzMzMzMzMzMzMpIi8+PHBvbHlsaW5lIHBvaW50cz0iMCwgMCwgNjUuNTI5MjU1NTUzMDIzLCAzNy44MzMzMzMzMzMzMzMsIDAsIDc1LjY2NjY2NjY2NjY2NywgMCwgMCIgZmlsbD0iIzIyMiIgZmlsbC1vcGFjaXR5PSIwLjA4MDY2NjY2NjY2NjY2NyIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utb3BhY2l0eT0iMC4wMiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTMxLjA1ODUxMTEwNjA1LCAxNTEuMzMzMzMzMzMzMzMpIHJvdGF0ZSgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjZGRkIiBmaWxsLW9wYWNpdHk9IjAuMDIiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDE5Ni41ODc3NjY2NTkwNywgMTUxLjMzMzMzMzMzMzMzKSByb3RhdGUoMTgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48cG9seWxpbmUgcG9pbnRzPSIwLCAwLCA2NS41MjkyNTU1NTMwMjMsIDM3LjgzMzMzMzMzMzMzMywgMCwgNzUuNjY2NjY2NjY2NjY3LCAwLCAwIiBmaWxsPSIjMjIyIiBmaWxsLW9wYWNpdHk9IjAuMDk4IiBzdHJva2U9IiMwMDAiIHN0cm9rZS1vcGFjaXR5PSIwLjAyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgyNjIuMTE3MDIyMjEyMDksIDE1MS4zMzMzMzMzMzMzMykgcm90YXRlKDAsIDMyLjc2NDYyNzc3NjUxMSwgMzcuODMzMzMzMzMzMzMzKSIvPjxwb2x5bGluZSBwb2ludHM9IjAsIDAsIDY1LjUyOTI1NTU1MzAyMywgMzcuODMzMzMzMzMzMzMzLCAwLCA3NS42NjY2NjY2NjY2NjcsIDAsIDAiIGZpbGw9IiNkZGQiIGZpbGwtb3BhY2l0eT0iMC4xMjQiIHN0cm9rZT0iIzAwMCIgc3Ryb2tlLW9wYWNpdHk9IjAuMDIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMyNy42NDYyNzc3NjUxMSwgMTUxLjMzMzMzMzMzMzMzKSByb3RhdGUoMTgwLCAzMi43NjQ2Mjc3NzY1MTEsIDM3LjgzMzMzMzMzMzMzMykiLz48L3N2Zz4=');"></div>
                <div class="carousel-body">
                    <div class="container">
                        <h1 class="display-1 text-white">微信支付宝整合</h1>
                        <h2 class="display-4 text-white">微信支付宝整合示例</h2>
                    </div>
                </div>
            </a>
        </div>
    </div>
</header>

<!-- Page Content -->
<div class="container">

    <div class="row" id="prepare">
        <div class="col-lg-12">
            <h2 class="page-header">
                开始接入
            </h2>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-check"></i> 准备工作</h4>
                </div>
                <div class="panel-body">
                    <p><a href="https://b.alipay.com/" target="_blank">申请支付宝相应的支付产品，并获取相关配置</a></p>
                    <p><a href="https://pay.weixin.qq.com" target="_blank">申请微信相应的支付产品，并获取相关配置</a></p>
                    <p>插件管理中配置相应的微信或支付宝参数</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-gift"></i> 开发工作</h4>
                </div>
                <div class="panel-body">
                    <p>在你的PHP代码中调用相关代码进行支付，请参考控制器代码</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-compass"></i> 开始测试</h4>
                </div>
                <div class="panel-body">
                    <p>请选择对应的支付金额和支付方式</p>
                    <p>
                        <span class="input-group">
                            <input type="number" name="amount" step="0.01" value="1.01"
                                   class="form-control" placeholder="请输入一个随机金额"/>
                            <span class="input-group-addon" style="padding:0;width:150px;">
                                <select class="form-control" name="method" id="method" style="border:none;height: 32px;">
                                    <option value="web">PC网页支付</option>
                                    <option value="wap">H5手机网页支付</option>
                                    <option value="app">APP支付</option>
                                    <option value="scan">扫码支付</option>
                                    <option value="mp">公众号支付(不支持支付宝)</option>
                                    <option value="miniapp">小程序支付(不支持支付宝)</option>
                                </select>
                            </span>
                        </span>
                    </p>
                    <button data-type="alipay" class="btn btn-info btn-experience"><i class="fa fa-money"></i> 支付宝支付</button>
                    <button data-type="wechat" class="btn btn-success btn-experience"><i class="fa fa-wechat"></i> 微信支付</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

</div>


<div class="container">
    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <hr>
                <p>Copyright &copy; <?php echo $site['name']; ?> 2017-2022</p>
            </div>
        </div>
    </footer>

</div>
<!-- /.container -->

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets/libs/fastadmin-layer/dist/layer.js?v=<?php echo $site['version']; ?>"></script>
<script src="/assets/addons/epay/js/jquery.qrcode.min.js?v=<?php echo $site['version']; ?>"></script>
<script src="/assets/addons/epay/js/common.js?v=<?php echo $site['version']; ?>"></script>

</body>
</html>
