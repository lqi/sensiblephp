<a href="/">Back to main page</a>
<div id="content">
<?php
	$info = $this->getValue("info");
	if ($info) {
?>
<h3>Basic Info</h3>
<p>User Id: <?php echo $info->user_id->getValue(); ?></p>
<p>Privilege: Normal </p>
<p>Employee Id: <?php echo $info->employee_id->getValue(); ?></p>
<p>Real Name: <?php echo $info->real_name->getValue(); ?></p>
<?php
		$application = $this->getValue("application");
		if ($application) {
			if ($application->success()) {
?>
	<h3>Department Information History</h3>
	<form action="/DeptInfo/insertDeptInfo" method="POST">
	<input type="hidden" name="user_id" value="<?php echo $info->user_id->getValue(); ?>" />
	<input name="department" />
	<input type="submit" value="Change Position" />
	</form>
	<ul>
<?php
				$deptInfo = $this->getValue("deptInfo");
				if ($deptInfo) {
					foreach ($deptInfo as $latestDeptInfo) {
?>
	<li><?php echo $latestDeptInfo->active_time->getValue(); ?> : <?php echo $latestDeptInfo->department_id->getValue(); ?></li>
<?php
					}
				}
				else {
					echo "<p>You have not been assigned to any department!</p>";
				}
?>
	</ul>
	<h3>Payment Information History</h3>
	<!--
	<form action="/PaymentInfo/insertPayInfo" method="POST">
	<input type="hidden" name="user_id" value="<?php echo $info->user_id->getValue(); ?>" />
	<input name="payment" />
	<input type="submit" value="Change Salary" />
	</form>
	-->
	<ul>
<?php
				$payInfo = $this->getValue("paymentInfo");
				if ($payInfo) {
					foreach ($payInfo as $latestPaymentInfo) {
?>
	<li><?php echo $latestPaymentInfo->active_time->getValue(); ?> : <?php echo $latestPaymentInfo->payment->getValue(); ?></li>
<?php
					}
				}
				else {
					echo "<p>You have not been assigned any payment!</p>";
				}
?>
	</ul>
	<h3>Training History</h3>
	<form action="/TrainingRecord/insertTrainRecord" method="POST">
	<input type="hidden" name="user_id" value="<?php echo $info->user_id->getValue(); ?>" />
	<p>Training Program Name: <input name="name" /></p>
	<p>Discription: <input name="discription" /></p>
	<p><input type="submit" value="Add Training Log" /></p>
	</form>
	<ul>
<?php
				$trainHistory = $this->getValue("trainingHistory");
				if ($trainHistory) {
					foreach ($trainHistory as $trainInfo) {
?>
	<li><?php echo $trainInfo->train_time->getValue(); ?>: <?php echo $trainInfo->train_program->getValue(); ?> (<?php echo $trainInfo->train_description->getValue(); ?>).</li>
<?php
					}
				}
				else {
					echo "<p>You have no training history log!</p>";
				}
?>
	</ul>
	<h3>Working Time Management</h3>
	<ul>
<?php
				$workingTimes = $this->getValue("workingTimes");
				if ($workingTimes) {
					foreach ($workingTimes as $latestWorkingTime) {
						
						if ($latestWorkingTime->isWorking()) {
?>
	<li><?php echo $latestWorkingTime->start_time->getValue(); ?> - Working</li>
<?php
						}
						else {
?>
	<li><?php echo $latestWorkingTime->start_time->getValue(); ?> - <?php echo $latestWorkingTime->end_time->getValue(); ?></li>
<?php
						}
					}
				}
				else {
?>
	<p>No working history yet!</p>
<?php
				}
?>
	</ul>
<?php
			}
			else {
?>
<h3>Application Pending</h3>
<?php
			}
		}
		else {
?>
<h3>No Job For This User</h3>
<?php
		}
	}
	else {
?>
<h3>Information Pending</h3>
<?php
	}
?>
</div>