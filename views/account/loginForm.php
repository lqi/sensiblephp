<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>华东理工大学勤办人事管理系统</title>
	<link rel="stylesheet" href="/css/base.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="/css/layout.css" type="text/css" media="screen" />
</head>
<body id="layout">
	<div id="header">
		<div id="title">华东理工大学勤办人事管理系统</div>
	</div>
	<div id="navigation">
		<a href="/"><input type="button" value="回到首页" /></a>
</div>
<div id="content">
	<h3>登录</h3>
	<?php 
if ($this->getValue("errMsg")) {
?>
<div style="color:red;"><?php echo $this->getValue("errMsg"); ?></div>
<?php } ?>
<form action="/Account/processLogin" method="POST">
<p>用户名：<input name="username" /></p>
<p>密码：<input type="password" name="password" /></p>
<p><input type="submit" value="登录" /></p>
</form>
</div>
<div id="footer">
		<div id="copyright">版权所有 &copy; 2010 华东理工大学</div>
	</div>
</body>
</html>