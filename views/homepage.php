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
Greetings from SensiblePHP, <?php echo $account->username->getValue(); ?>. 
Your privilege is 
<?php
	$privilege = $account->privilege->getValue();
	if ($privilege == 4) {
		echo "Normal";
	}
	if ($privilege == 3) {
		echo "Human Resource";
	}
	if ($privilege == 2) {
		echo "Teacher";
	}
	if ($privilege == 1) {
		echo "Administration";
	}
?>
. 
<a href="/Account/logout">Logout</a>
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
<h3>Basic Info</h3>
<p>User Id: <?php echo $account->user_id->getValue(); ?></p>
<p>Privilege: Normal </p>
<p>Employee Id: <?php echo $info->employee_id->getValue(); ?></p>
<p>Real Name: <?php echo $info->real_name->getValue(); ?></p>
<?php
		$application = $this->getValue("application");
		if ($application) {
			if ($application->success()) {
?>
	<h3>Latest Department Information</h3>
<?php
				$deptInfo = $this->getValue("deptInfo");
				if ($deptInfo) {
					$latestDeptInfo = $deptInfo[0];
?>
	<p>Deparment: <?php echo $latestDeptInfo->department_id->getValue(); ?></p>
	<p>Active Time: <?php echo $latestDeptInfo->active_time->getValue(); ?></p>
<?php
				}
				else {
					echo "<p>You have not been assigned to any department!</p>";
				}
?>
	<h3>Latest Payment Information</h3>
<?php
				$payInfo = $this->getValue("paymentInfo");
				if ($payInfo) {
					$latestPaymentInfo = $payInfo[0];
?>
	<p>Payment: <?php echo $latestPaymentInfo->payment->getValue(); ?></p>
	<p>Active Time: <?php echo $latestPaymentInfo->active_time->getValue(); ?></p>
<?php
				}
				else {
					echo "<p>You have not been assigned any payment!</p>";
				}
?>
	<h3>Training History</h3>
<?php
				$trainHistory = $this->getValue("trainingHistory");
				if ($trainHistory) {
					foreach ($trainHistory as $trainInfo) {
?>
	<p><?php echo $trainInfo->train_time->getValue(); ?>: <?php echo $trainInfo->train_program->getValue(); ?>.</p>
<?php
					}
				}
				else {
					echo "<p>You have no training history log!</p>";
				}
?>
	<h3>Working Time Management</h3>
<?php
				$workingTimes = $this->getValue("workingTimes");
				if ($workingTimes) {
					$latestWorkingTime = $workingTimes[0];
					if ($latestWorkingTime->isWorking()) {
?>
	<p>Work started at <?php echo $latestWorkingTime->start_time->getValue(); ?></p>
	<p>Ready to go home? Click <a href="/WorkingTime/off">HERE</a>.</p>
<?php
					}
					else {
?>
	<p>Latest time on work from <?php echo $latestWorkingTime->start_time->getValue(); ?> to <?php echo $latestWorkingTime->end_time->getValue(); ?>.</p>
	<p>Start your brand new day by clicking <a href="/WorkingTime/on">HERE</a>!</p>
<?php
					}
				}
				else {
?>
	<p>You have no working history! Start your new carrer by clicking <a href="/WorkingTime/on">HERE</a>!</p>
<?php
				}
			}
			else {
?>
<h3>Application Status</h3>
<p>Application Id: <?php echo $application->application_id->getValue(); ?></p>
<p>First Hr: <?php if ($application->hasFirstHrDecision()) { if ($application->first_hr_decision->getValue()) { echo "Success!"; } else { echo "Fail!"; }} else { echo "Decision Pending..."; } ?></p>
<p>Second Hr: <?php if ($application->hasSecondHrDecision()) { if ($application->second_hr_decision->getValue()) { echo "Success!"; } else { echo "Fail!"; }} else { echo "Decision Pending..."; } ?></p>
<p>Hr Decision: <?php if ($application->hasHrDecision()) { if ($application->hrDecision()) { echo "Success!"; } else { echo "Fail!"; }} else { echo "Decision Pending..."; } ?></p>
<p>Final Decision: <?php if ($application->hasTeacherDecision()) { if ($application->teacherDecision()) { echo "Success!"; } else { echo "We are sorry, but you are not admitted!"; }} else { echo "Please wait for final decision"; } ?></p>
<?php
			}
		}
		else {
?>
<p>
<span style="color:red;">Now you can apply for jobs.</span>
<a href="/Application/apply">Apply jobs</a>
</p>
<?php
		}
	}
	else {
?>
<p>
<span style="color:red;">You must have your basic info before processing</span>
<a href="/BasicInfo/newInfo">Fill in Basic Information</a>
</p>
<?php
	}
}
if ($privilege == 3) {
?>
	<h3>Applications to be Examined</h3>
	<ul style="margin-left: 30px;">
<?php
	$toDoApps = $this->getValue("toDoApps");
	foreach ($toDoApps as $app) {
?>
	<li><?php echo $app->application_id->getValue(); ?> | <?php echo $app->user_id->getValue(); ?> | <a href="/Application/hrDecide?appId=<?php echo $app->user_id->getValue(); ?>&action=1">Approve</a> | <a href="/Application/hrDecide?appId=<?php echo $app->user_id->getValue(); ?>&action=0">Reject</a></li>
<?php	
	}
?>
	</ul>
	<h3>Employee Management</h3>
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
	<h3>Applications to be Examined</h3>
	<ul style="margin-left: 30px;">
<?php
	$toDoApps = $this->getValue("toDoApps");
	foreach ($toDoApps as $app) {
?>
	<li>Application Id: <?php echo $app->application_id->getValue(); ?> | User Id: <?php echo $app->user_id->getValue(); ?> | Decision of HR: 
	<?php
		if ($app->hasHrDecision()) {
			if ($app->hrDecision()) {
				echo "Pass";
			}
			else {
				echo "Fail";
			}
		}
		else {
			echo "Pending";
		}
	?>
	 | <a href="/Application/teaDecide?appId=<?php echo $app->user_id->getValue(); ?>&action=1">Approve</a> | <a href="/Application/teaDecide?appId=<?php echo $app->user_id->getValue(); ?>&action=0">Reject</a></li>
<?php	
	}
?>
	</ul>
	<h3>Employee Management</h3>
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
	<h3>Add New HR</h3>
	<form action="/Account/newHr" method="POST">
	<p>Username: <input name="username" /></p>
	<p>Password: <input type="password" name="password" /></p>
	<p><input type="submit" value="Submit" /></p>
	</form>
<?php
}
if ($privilege == 1) {
?>
	<h3>Add New Teacher</h3>
	<form action="/Account/newTeacher" method="POST">
	<p>Username: <input name="username" /></p>
	<p>Password: <input type="password" name="password" /></p>
	<p><input type="submit" value="Submit" /></p>
	</form>
<?php
}
} else {?>
<p>You have to login before processing.</p>
<?php } ?>
	</div>
	<div id="footer">
		<div id="copyright">版权所有 &copy; 2010 华东理工大学</div>
	</div>
</body>
</html>