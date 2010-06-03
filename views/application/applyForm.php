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
	<h3>选择申请的工作</h3>
<?php 
if ($this->getValue("errMsg")) {
?>
<div style="color:red;"><?php echo $this->getValue("errMsg"); ?></div>
<?php } ?>
<p>您的用户标识为：<?php echo $this->getValue("userId"); ?></p>
<form action="/Application/processApply" method="POST">
<p>选择您要申请的工作部门：
<ul style="padding-left: 30px;" >
<?php
foreach ($this->getValue("departments") as $dept) {
	echo "<li><input type=\"radio\" value=\"" . $dept->department_id->getValue() . "\" name=\"department\" />" . $dept->name->getValue() . "</li>";
}
?>
</ul>
</p>
<p><input type="submit" value="递交申请" /></p>
</form>
</div>
<div id="footer">
		<div id="copyright">版权所有 &copy; 2010 华东理工大学</div>
	</div>
</body>
</html>