<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>wxtang</title>
    <link rel="stylesheet" type="text/css" href="<?php echo _PUBLIC_ ?>css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo _PUBLIC_ ?>css/main.css"/>
    <script type="text/javascript" src="<?php echo _PUBLIC_ ?>js/libs/modernizr.min.js"></script>
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <ul class="navbar-list clearfix">
                <li><a class="on" href="<?php echo site_url('c=admin&m=index') ;?>">首页</a></li>
            </ul>

        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="javascript:void(0)">您好: <?php echo $this->session->userdata('username') ?></a></li>
                <li><a onclick="return confirm('您确定要退出吗？');" href="<?php echo site_url('c=admin&m=logout') ?>">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container clearfix">
    <div class="sidebar-wrap">
        <div class="sidebar-title">
            <h1>微信管理菜单</h1>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <li>
                    <a href="javascript:void(0)"><i class="icon-font">&#xe003;</i>常用操作</a>
                    <ul class="sub-menu">
                        <li><a href="<?php echo site_url('c=Message&m=sendPicText') ;?>"><i class="icon-font">&#xe008;</i>每日图文推送</a></li>
                        <li><a href="<?php echo site_url('c=Menu&m=updateMuneInfo') ;?>"><i class="icon-font">&#xe005;</i>更新菜单推荐</a></li>
                        <li><a href="<?php echo site_url('c=Message&m=sendALL') ;?>"><i class="icon-font">&#xe006;</i>每日推送</a></li>
                        <li><a href="<?php echo site_url('c=User&m=lst') ;?>"><i class="icon-font">&#xe005;</i>用户列表</a></li>
                        <li><a href="<?php echo site_url('c=Message&m=liuYan') ;?>"><i class="icon-font">&#xe012;</i>留言查看</a></li>
                        <li><a href="<?php echo site_url('c=Message&m=exchange') ;?>"><i class="icon-font">&#xe012;</i>文本信息查看</a></li>
                        <li><a href="<?php echo site_url('c=Message&m=sendDay') ;?>"><i class="icon-font">&#xe005;</i>每日推荐查看</a></li>
                        <!-- <li><a href="design.html"><i class="icon-font">&#xe052;</i>账号管理</a></li> -->
                    </ul>
                </li>
            </ul>
        </div>
    </div>