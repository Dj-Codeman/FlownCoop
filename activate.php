<?php
// Change this to your connection info.
include('server.php');

// Try and connect using the info above.

if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
include('errors.php');
// First we check if the email and code exists...
$old_code = $_GET['code'];
$email = $_GET['email'];

$newcode = 'activated';
$user_check_query1 = "SELECT email, activation_code FROM StudentAccounts WHERE email = '$email' LIMIT 1";
$result_1 = mysqli_query($db, $user_check_query1);
$data = mysqli_fetch_assoc($result_1);



// If username Exists
if (empty($data['email'])) {
	$user_check_query = "SELECT email, activation_code FROM StaffAccounts WHERE email = '$email' LIMIT 1";
	$results = mysqli_query($db, $user_check_query);
	$data_1 = mysqli_fetch_assoc($results);
	if (empty($data_1['email'])) {
		echo "We were unable to activate your account at this time.";
		echo "</br>";
		echo "Please email audubonssac@outlook.com and attach the following values:";
		echo "</br> Email: $email </br> Activation code: $old_code";
		echo "</br> Code: Stu_Inv_Link </br>";
		echo "<a href='index.php'>Login</a>";
	}
	else {
		echo "We were unable to activate your account an unexpected error occoured.";
		echo "</br>";
		echo "Please email audubonssac@outlook.com and attach the following values:";
		echo "</br> Email: $email </br> Activation code: $old_code  <br>";
		echo "</br> Code: Stu_Acc_Msp";
		echo "<a href='index.php'>Login</a>";
	}
}
else {


	$activated_query = "UPDATE StudentAccounts SET activation_code = '$newcode' WHERE activation_code = '$old_code' ";
	mysqli_query($db, $activated_query);
	echo '<script type="text/javascript">';
	echo "alert('Congratulations ! Your account has been activated.');";
	echo 'window.location.href = "index.php";';
	echo '</script>';


}


?>