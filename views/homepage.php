<?php 
$account = $this->getValue("account");
?>
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
<?php
if ($account) {
?>
来自SensiblePHP框架的问候，<?php echo $account->username->getValue(); ?>。
你的权限是
<?php
	$privilege = $account->privilege->getValue();
	if ($privilege == 4) {
		echo "普通用户";
	}
	if ($privilege == 3) {
		echo "人力资源管理人员";
	}
	if ($privilege == 2) {
		echo "教师";
	}
	if ($privilege == 1) {
		echo "管理员";
	}
?>
。
<a href="/Account/logout"><input type="button" value="登出" /></a>
<?php
}
else {
?>
	<form action="/Account/processLogin" method="POST">
	用户名：<input name="username" /> 
	密码：<input type="password" name="password" /> 
	<input type="submit" value="登录" />
	<a href="/Account/register"><input type="button" value="注册" /></a>
	</form>
<?php
}
?>
	</div>
	<div id="content">
<?php 
if ($account) { 
$privilege = $account->privilege->getValue();
if ($privilege == 4) {
	$info = $this->getValue("info");
	if ($info) {
?>
<h3>资本信息</h3>
<p>用户标识：<?php echo $account->user_id->getValue(); ?></p>
<p>权限：普通用户 </p>
<p>员工号：<?php echo $info->employee_id->getValue(); ?></p>
<p>真实姓名：<?php echo $info->real_name->getValue(); ?></p>
<?php
		$application = $this->getValue("application");
		if ($application) {
			if ($application->success()) {
?>
	<h3>最新部门信息</h3>
<?php
				$deptInfo = $this->getValue("deptInfo");
				if ($deptInfo) {
					$latestDeptInfo = $deptInfo[0];
?>
	<p>部门号：<?php echo $latestDeptInfo->department_id->getValue(); ?></p>
	<p>生效时间：<?php echo $latestDeptInfo->active_time->getValue(); ?></p>
<?php
				}
				else {
					echo "<p>您还没有被分配到任何部门！</p>";
				}
?>
	<h3>最新薪资信息</h3>
<?php
				$payInfo = $this->getValue("paymentInfo");
				if ($payInfo) {
					$latestPaymentInfo = $payInfo[0];
?>
	<p>薪水：<?php echo $latestPaymentInfo->payment->getValue(); ?>元</p>
	<p>生效时间：<?php echo $latestPaymentInfo->active_time->getValue(); ?></p>
<?php
				}
				else {
					echo "<p>您的薪资信息还没有被录入系统！</p>";
				}
?>
	<h3>培训历史</h3>
<?php
				$trainHistory = $this->getValue("trainingHistory");
				if ($trainHistory) {
					foreach ($trainHistory as $trainInfo) {
?>
	<p>您在 <?php echo $trainInfo->train_time->getValue(); ?> 参加培训项目 <?php echo $trainInfo->train_program->getValue(); ?>。</p>
<?php
					}
				}
				else {
					echo "<p>您还没有参加过任何培训！</p>";
				}
?>
	<h3>工作时间管理</h3>
<?php
				$workingTimes = $this->getValue("workingTimes");
				if ($workingTimes) {
					$latestWorkingTime = $workingTimes[0];
					if ($latestWorkingTime->isWorking()) {
?>
	<p>您已与 <?php echo $latestWorkingTime->start_time->getValue(); ?> 开展工作。</p>
	<p>点击 <a href="/WorkingTime/off"><input type="button" value="下班" /></a> 回家。</p>
<?php
					}
					else {
?>
	<p>上一次工作从 <?php echo $latestWorkingTime->start_time->getValue(); ?> 持续到 <?php echo $latestWorkingTime->end_time->getValue(); ?>。</p>
	<p>点击 <a href="/WorkingTime/on"><input type="button" value="上班" /></a> 开始新一天的工作！</p>
<?php
					}
				}
				else {
?>
	<p>您还没有工作经历。点击 <a href="/WorkingTime/on"><input type="button" value="上班" /></a> 展开全新的生涯！</p>
<?php
				}
			}
			else {
?>
<h3>申请状态</h3>
<p>申请号：<?php echo $application->application_id->getValue(); ?></p>
<p>主人事决定：<?php if ($application->hasFirstHrDecision()) { if ($application->first_hr_decision->getValue()) { echo "通过"; } else { echo "不通过"; }} else { echo "未作决定"; } ?>！</p>
<p>副人事决定：<?php if ($application->hasSecondHrDecision()) { if ($application->second_hr_decision->getValue()) { echo "通过"; } else { echo "不通过"; }} else { echo "未作决定"; } ?>！</p>
<p>人事决定：<?php if ($application->hasHrDecision()) { if ($application->hrDecision()) { echo "通过"; } else { echo "不通过"; }} else { echo "未作决定"; } ?>！</p>
<p>最终决定：<?php if ($application->hasTeacherDecision()) { if ($application->teacherDecision()) { echo "通过"; } else { echo "<span style=\"color:red;\">对不起，您的申请是不成功的！</span>"; }} else { echo "请等待最终结果"; } ?>！</p>
<?php
			}
		}
		else {
?>
<p>
<span style="color:red;">现在您可以</span>
<a href="/Application/apply">申请工作了</a>！
</p>
<?php
		}
	}
	else {
?>
<p>
<span style="color:red;">您必须在申请工作之前填写您的个人信息！</span>
<a href="/BasicInfo/newInfo">填写个人信息</a>
</p>
<?php
	}
}
if ($privilege == 3) {
?>
	<h3>需要处理的申请</h3>
	<ul style="margin-left: 30px;">
<?php
	$toDoApps = $this->getValue("toDoApps");
	foreach ($toDoApps as $app) {
?>
	<li>第 <?php echo $app->application_id->getValue(); ?> 号申请人 <?php echo $app->user_id->getValue(); ?> ，<a href="/Application/hrDecide?appId=<?php echo $app->user_id->getValue(); ?>&action=1">通过</a> | <a href="/Application/hrDecide?appId=<?php echo $app->user_id->getValue(); ?>&action=0">拒绝</a></li>
<?php	
	}
?>
	</ul>
	<h3>员工管理</h3>
	<ul style="margin-left: 30px;">
<?php
	$employees = $this->getValue("employees");
	foreach ($employees as $employee) {
?>
	<li><a href="/Homepage/manage?user_id=<?php echo $employee->user_id->getValue(); ?>"><?php echo $employee->real_name->getValue(); ?></a></li>
<?php
	}
}
if ($privilege == 2) {
?>
	<h3>需要处理的申请</h3>
	<ul style="margin-left: 30px;">
<?php
	$toDoApps = $this->getValue("toDoApps");
	foreach ($toDoApps as $app) {
?>
	<li><form action="/Application/teaDecide?appId=<?php echo $app->user_id->getValue(); ?>&action=1" method="POST">申请号为 <?php echo $app->application_id->getValue(); ?> 的申请人 <?php echo $app->user_id->getValue(); ?> ，该份申请在人事管理人员的审核结果为 
	<?php
		if ($app->hasHrDecision()) {
			if ($app->hrDecision()) {
				echo "<span style=\"color:green\">通过</span>";
			}
			else {
				echo "<span style=\"color:red\">未通过</span>";
			}
		}
		else {
			echo "<span style=\"color:blue\">等待</span>";
		}
	?>
	 ，您可以输入其起薪 <input name="payment" /> 并选择 <input type="submit" value="通过" /> | <a href="/Application/teaDecide?appId=<?php echo $app->user_id->getValue(); ?>&action=0">拒绝</a></form></li>
<?php	
	}
?>
	</ul>
	<h3>员工管理</h3>
	<ul style="margin-left: 30px;">
<?php
	$employees = $this->getValue("employees");
	foreach ($employees as $employee) {
?>
	<li><a href="/Homepage/manage?user_id=<?php echo $employee->user_id->getValue(); ?>"><?php echo $employee->real_name->getValue(); ?></a></li>
<?php
	}
?>
	</ul>
	<h3>添加新人事管理人员</h3>
	<form action="/Account/newHr" method="POST">
	<p>用户名：<input name="username" /></p>
	<p>密码：<input type="password" name="password" /></p>
	<p><input type="submit" value="添加" /></p>
	</form>
	<h3>部门管理</h3>
	<form action="/Department/manage" method="POST">
	<p>新部门名称：<input name="name" /></p>
	<p>新部门介绍：<textarea name="descrption"></textarea></p>
	<p><input type="submit" value="添加" /></p>
	</form>
	<ul style="margin-left: 30px; ">
<?php
  $departments = $this->getValue("departments");
  foreach ($departments as $dept) {
?>
	<li><form action="/Department/manage" method="POST">第 <?php echo $dept->department_id->getValue(); ?> 号部门，<input type="hidden" name="department_id" value="<?php echo $dept->department_id->getValue(); ?>" />名称 <input name="name" value="<?php echo $dept->name->getValue(); ?>" />，介绍 <input name="descrption" value="<?php echo $dept->description->getValue(); ?>" />。<input type="submit" value="更新" /></form></li>
<?php
	}
?>
	</ul>
<?php
}
if ($privilege == 1) {
?>
	<h3>添加新教师</h3>
	<form action="/Account/newTeacher" method="POST">
	<p>用户名：<input name="username" /></p>
	<p>密码：<input type="password" name="password" /></p>
	<p><input type="submit" value="添加" /></p>
	</form>
<?php
}
} else {?>
<p>请先<a href="/Account/login">登录</a>！</p>
<?php } ?>
	</div>
	<div id="footer">
		<div id="copyright">版权所有 &copy; 2010 华东理工大学</div>
	</div>
</body>
</html>