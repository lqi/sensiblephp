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
<?php
	$info = $this->getValue("info");
	if ($info) {
?>
<h3>资本信息</h3>
<p>用户标识：<?php echo $info->user_id->getValue(); ?></p>
<p>权限：普通用户 </p>
<p>员工号：<?php echo $info->employee_id->getValue(); ?></p>
<p>真实姓名：<?php echo $info->real_name->getValue(); ?></p>
<?php
		$application = $this->getValue("application");
		if ($application) {
			if ($application->success()) {
?>
	<h3>部门信息管理</h3>
	<form action="/DeptInfo/insertDeptInfo" method="POST">
	<input type="hidden" name="user_id" value="<?php echo $info->user_id->getValue(); ?>" />
	<input name="department" />
	<input type="submit" value="更改职位" />
	</form>
	<ul style="margin-left: 30px;">
<?php
				$deptInfo = $this->getValue("deptInfo");
				if ($deptInfo) {
					foreach ($deptInfo as $latestDeptInfo) {
?>
	<li>从 <?php echo $latestDeptInfo->active_time->getValue(); ?> 开始在第 <?php echo $latestDeptInfo->department_id->getValue(); ?> 号部门工作。</li>
<?php
					}
				}
				else {
					echo "<p>该用户还没有被分配到任何部门！</p>";
				}
?>
	</ul>
	<h3>薪资管理</h3>
	<!--
	<form action="/PaymentInfo/insertPayInfo" method="POST">
	<input type="hidden" name="user_id" value="<?php echo $info->user_id->getValue(); ?>" />
	<input name="payment" />
	<input type="submit" value="更改薪水" />
	</form>
	-->
	<ul style="margin-left: 30px;">
<?php
				$payInfo = $this->getValue("paymentInfo");
				if ($payInfo) {
					foreach ($payInfo as $latestPaymentInfo) {
?>
	<li>从 <?php echo $latestPaymentInfo->active_time->getValue(); ?> 开始薪水为 <?php echo $latestPaymentInfo->payment->getValue(); ?> 元。</li>
<?php
					}
				}
				else {
					echo "<p>该用户还没有任何薪水信息！</p>";
				}
?>
	</ul>
	<h3>培训经历管理</h3>
	<form action="/TrainingRecord/insertTrainRecord" method="POST">
	<input type="hidden" name="user_id" value="<?php echo $info->user_id->getValue(); ?>" />
	<p>培训项目名称：<input name="name" /></p>
	<p>培训项目内容：<textarea name="discription"></textarea></p>
	<p><input type="submit" value="增加项目经历" /></p>
	</form>
	<ul style="margin-left: 30px;">
<?php
				$trainHistory = $this->getValue("trainingHistory");
				if ($trainHistory) {
					foreach ($trainHistory as $trainInfo) {
?>
	<li>于 <?php echo $trainInfo->train_time->getValue(); ?> 参加 <?php echo $trainInfo->train_program->getValue(); ?> 培训项目，内容为 <?php echo $trainInfo->train_description->getValue(); ?> 。</li>
<?php
					}
				}
				else {
					echo "<p>该员工还未有培训记录！</p>";
				}
?>
	</ul>
	<h3>工作时间管理</h3>
	<ul style="margin-left: 30px;">
<?php
				$workingTimes = $this->getValue("workingTimes");
				if ($workingTimes) {
					foreach ($workingTimes as $latestWorkingTime) {
						
						if ($latestWorkingTime->isWorking()) {
?>
	<li>工作中：于 <?php echo $latestWorkingTime->start_time->getValue(); ?> 开始。</li>
<?php
						}
						else {
?>
	<li>工作于 <?php echo $latestWorkingTime->start_time->getValue(); ?> 到 <?php echo $latestWorkingTime->end_time->getValue(); ?> 。</li>
<?php
						}
					}
				}
				else {
?>
	<p>该员工还未开展工作！</p>
<?php
				}
?>
	</ul>
<?php
			}
			else {
?>
<h3>申请等待</h3>
<?php
			}
		}
		else {
?>
<h3>该用户当前没有工作</h3>
<?php
		}
	}
	else {
?>
<h3>个人信息等待</h3>
<?php
	}
?>
</div>
<div id="footer">
		<div id="copyright">版权所有 &copy; 2010 华东理工大学</div>
	</div>
</body>
</html>