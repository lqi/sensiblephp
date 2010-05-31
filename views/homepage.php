<?php 
$account = $this->getValue("account");
if ($account) {
?>
<div style="color:blue;">
Loged-in Account: <br />
username: <?php echo $account->username->getValue(); ?><br />
privilege: <?php echo $account->privilege->getValue(); ?><br />
</div>
<?php } ?>
<p><a href="/Account/register">Register</a></p>
<?php if ($account) { ?>
<p><a href="/Account/logout">Logout</a></p>
<?php 
	$info = $this->getValue("info");
	if ($info) {
?>
<h3>Basic Info</h3>
<p>User Id: <?php echo $account->user_id->getValue(); ?></p>
<p>Privilege: 
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
</p>
<p>Employee Id: <?php echo $info->employee_id->getValue(); ?></p>
<p>Real Name: <?php echo $info->real_name->getValue(); ?></p>
<?php
		$application = $this->getValue("application");
		if ($application) {
			if ($application->success()) {
				echo "TODO: employee information.";
			}
			else {
?>
<h3>Application Status</h3>
<p>Application Id: <?php echo $application->application_id->getValue(); ?></p>
<p>First Hr: <?php if ($application->hasFirstHrDecision()) { if ($application->first_hr_decision->getValue()) { echo "Success!"; } else { echo "Fail!"; }} else { echo "Decision Pending..."; } ?></p>
<p>Second Hr: <?php if ($application->hasSecondHrDecision()) { if ($application->second_hr_decision->getValue()) { echo "Success!"; } else { echo "Fail!"; }} else { echo "Decision Pending..."; } ?></p>
<p>Hr Decision: <?php if ($application->hasHrDecision()) { if ($application->hrDecision()) { echo "Success!"; } else { echo "Fail!"; }} else { echo "Decision Pending..."; } ?></p>
<p>Final Decision: <?php if ($application->hasTeacherDecision()) { if ($application->teacherDecision()) { echo "Success!"; } else { echo "Fail!"; }} else { echo "Decision Pending..."; } ?></p>
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
} else {?>
<p><a href="/Account/login">Login</a></p>
<?php } ?>