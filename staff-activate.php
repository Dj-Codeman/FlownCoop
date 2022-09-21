<?php
// note this activation php was copied from a w3c school site but its been changed drastically
// some of the comments dont reflect the actuall code
// Change this to your connection info.
$DATABASE_HOST = '192.168.0.3';
$DATABASE_USER = 'Client';
$DATABASE_PASS = 'Y&0E1{8u){S?';
$DATABASE_NAME = 'Nest';
// Try and connect using the info above.
$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
include('errors.php');
// First we check if the email and code exists...
$old_code = $_GET['code'];
$email = $_GET['email'];
echo $data['email'];
$newcode = 'activated';
$user_check_query = "SELECT email, activation_code FROM StaffAccounts WHERE email = '$email' LIMIT 1";
$result_1 = mysqli_query($db, $user_check_query);
$data = mysqli_fetch_assoc($result_1);



// If username Exists
      if (empty($data['email'])) {
				$user_check_query = "SELECT email, activation_code FROM StudentAccounts WHERE email = '$email' LIMIT 1";
				$results = mysqli_query($db, $user_check_query);
				$data_1 = mysqli_fetch_assoc($results);
				if (empty($data_1['email'])) {
							  echo "We were unable to activate your account at this time.";
								echo "</br>";
								echo "Please email audubonssac@outlook.com and attach the following values:";
								echo "</br> Email: $email </br> Activation code: $old_code";
								echo "</br> Code: Invalid_Act_Link </br>";
								echo "<a href='index.php'>Login</a>";
							} else {
								echo "We were unable to activate your account an unexpected error occoured.";
								echo "</br>";
								echo "Please email audubonssac@outlook.com and attach the following values:";
								echo "</br> Email: $email </br> Activation code: $old_code  <br>";
								echo "</br> Code: Account_Misplace";
								echo "<a href='index.php'>Login</a>";
							}
				} else {


      $activated_query = "UPDATE StaffAccounts SET activation_code = '$newcode' WHERE activation_code = '$old_code' ";
      mysqli_query($db, $activated_query );
			echo '<script type="text/javascript">';
			echo "alert('Congratulations ! Your account has been activated.');";
			echo 'window.location.href = "index.php";';
			echo '</script>';


      }


?>
