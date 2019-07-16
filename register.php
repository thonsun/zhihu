<?php
    session_start();   //*
    //在页首先要开启session,
    //error_reporting(2047);
    session_destroy();  //*
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="description" content="Free Bootstrap Themes by Html5xCss3 dot com - Free Responsive Html5 Templates">
	<meta name="author" content="#">

	<title>问答社区|注册</title>

	<link rel="stylesheet" href="css/menu.css">

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap/css/_bootswatch.scss">
	<link rel="stylesheet" type="text/css" href="css/bootstrap/css/_variables.scss">

	<!-- Custom Fonts -->
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css" type="text/css">

	<link rel="stylesheet" href="css/lightbox.css">

	<!-- Core JavaScript Files -->


	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#C83935;">
	<div class="center">
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="navbar-brand" href="index.php">TalkWith</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href='index.php'><span class="fa fa-home" aria-hidden="true">首页</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href='submit_question.php'><span class="fa fa-pencil-square-o" aria-hidden="true">写问题</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="profile.php"><span class="fa fa-bell-o" aria-hidden="true">通知</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="login.php"><span class="fa fa-user" aria-hidden="true">登录</span></a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<div id="page-content" class="sub-page">
	<div class="container">
		<center>
			<article>
				<h2 class="center">注册</h2>
				<div id="contact_form">
					<form name="form1" id="ff" method="post" action="addmember.php">
						<label>
							<span>用户名:</span>
							<input type="text" name="name" id="name" required>
						</label>
						<label>
							<span>邮箱:</span>
							<input type="email" name="email"  required>
						</label>
						<label>
							<span>性别:</span>
							<select name="sex">
								<option value='男'>男</option>
								<option value='女'>女</option>
							</select>
						</label>
						<label>
							<span>密码:</span>
							<input type="password" name="password"  required>
						</label>
						<label>
							<span>重复密码:</span>
							<input type="password" name="password_again" required>
						</label>
						<label>
							<span>验证码:</span>
							<img title="点击刷新" src="captcha.php" style="border-radius: 10px" onclick="this.src='captcha.php?'+Math.random();">
							<input type="text" width="100" name="validate">
						</label>
						<center><input class="sendButton" type="submit" value="提交"></center> <!--name="submitcontact"-->
					</form>
				</div>
			</article>
		</center>
	</div>
</div>

<!-- Once the page is loaded, initialized the plugin. -->
<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="js/jquery.smartmenus.js"></script>

<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>

<script src="js/lightbox-plus-jquery.min.js"></script>
</body>
</html>