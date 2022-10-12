<?php
session_start();

// initializing variables
//     <3
$username = "";
$email = "";
$sid = "";
$errors = array();
$salt = random_int(7, 952018);
$accounts = "";

$activated = "activated";

// include('home.php');


// database credentials



$db = mysqli_connect('207.244.242.167', 'Client', 'Y&0E1{8u){S?', 'Nest');



// DIE statment
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
//Staff Registration
if (isset($_POST['reg_staff'])) {


	//  $sid = mysqli_real_escape_string($db, $_POST['sid']);
	$advisory = mysqli_real_escape_string($db, $_POST['advisory']);
	//  $username = mysqli_real_escape_string($db, $_POST['username']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
	$FirstName = mysqli_real_escape_string($db, $_POST['FirstName']);
	$LastName = mysqli_real_escape_string($db, $_POST['LastName']);

	// data validation.
	// array_push prints the corresponding error

	// Ensure no feild is empty
//  if (empty($sid)) { array_push($errors, "Student id is required"); }
	if (empty($advisory)) {
		array_push($errors, "Please enter your advisory number");
	}
	//  if (empty($username)) { array_push($errors, "Username is required"); }
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	/*  if (empty($FirstName)) { array_push($errors, "First and Last name required."); }
	 if (empty($LastName)) { array_push($errors, "First and Last name required."); }
	 */
	// Filter out any bs and ensure passwords are decent
	// These strings were copied from an older string using the $_POST thing
	// Email
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Email is not valid!");
	}
	// Password
	if (strlen($password_1) > 20 || strlen($password_1) < 5) {
		array_push($errors, "Password must be between 5 and 20 characters long!");
	}

	//Advisory number verification
	if (preg_match('/[A-Za-z]+/', $advisory) == 1) {
		array_push($errors, "Please use your advisory room number. ");
	}

	if ($password_1 == $username) {
		array_push($errors, "please pick a diffrent username or password ");
	}

	// Names

	// name filtering has to be added still
/*
//First
	if (preg_match( "^-?[1-9]\d*$", $FirstName ) == 1) {
    array_push($errors, "Names dont have numbers");
	}
  */
	// Checking if a user exists         z_nayE-q@$ui
	$user_check_query = "SELECT * FROM StaffAccounts WHERE email='$email' OR Advisory='$advisory' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);



	// If email Exists
	if ($user['email'] === $email) {
		array_push($errors, "This email adress is registered with and account");
	}

	if ($user['Advisory'] === $advisory) {
		array_push($errors, "This email adress is registered with and account");
	}


	if (count($errors) == 0) {
		$password = crypt($password_1, $salt); // Password hashed with salt
		// This password is one way encryped


		$uniqid = uniqid();
		$staffid = MD5(uniqid());

		$query = "INSERT INTO Nest.StaffAccounts ( uid, FirstName, LastName, email, password, salt, Advisory, activation_code, Staff_id)
  			  VALUES( '$uniqid', '$FirstName', '$LastName', '$email', '$password', '$salt', '$advisory', '$uniqid', '$staffid')";
		mysqli_query($db, $query);

		$advisory = mysqli_real_escape_string($db, $_POST['advisory']);

		$class = "CREATE TABLE IF NOT EXISTS Nest.Class_$advisory (
		        id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
		        FirstName VARCHAR(255) NOT NULL,
		        LastName VARCHAR(255) NOT NULL,
		        username VARCHAR(255) NOT NULL,
		        email VARCHAR(255) NOT NULL,
		        sid VARCHAR(255) NOT NULL,
		        pending VARCHAR(255) NOT NULL,
		        totals VARCHAR(255) NOT NULL
		)";
		mysqli_query($db, $class);

		//	$_SESSION['FirstName'] = $FirstName;
//	$_SESSION['LastName'] = $LastName;
		$from = 'noreply@dwcloud.tk';
		$subject = 'Account Activation Required';
		$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "Bcc: darrionjw@outlook.com\r\n";
		$activate_link = 'https://www.audubonnest.tk/staff-activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
		$message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
		//		$message .= '<p>' . $class . '</a></p>';
		mail($_POST['email'], $subject, $message, $headers);

		$result = $query;
		if ($result === false) {
			exit('DEBUG: STORING TO DATABASE ERROR: ' . mysqli_connect_error());

		}
		array_push($errors, "Please check your email to activate your account. This email may also be in your spam folder. </br>
	 You may close this page. ");

	}
}



// data collection
if (isset($_POST['reg_student'])) {


	$sid = mysqli_real_escape_string($db, $_POST['sid']);
	$uid = MD5($sid);
	$advisory = mysqli_real_escape_string($db, $_POST['advisory']);
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
	$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
	$FirstName = mysqli_real_escape_string($db, $_POST['FirstName']);
	$LastName = mysqli_real_escape_string($db, $_POST['LastName']);

	// data validation.
	// array_push prints the corresponding error

	// Ensure no feild is empty
	if (empty($sid)) {
		array_push($errors, "Student id is required");
	}
	if (empty($advisory)) {
		array_push($errors, "Please enter your advisory number");
	}
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}
	/*  if (empty($FirstName)) { array_push($errors, "First and Last name required."); }
	 if (empty($LastName)) { array_push($errors, "First and Last name required."); }
	 */
	// Filter out any bs and ensure passwords are decent
	// These strings were copied from an older string using the $_POST thing
	// Email
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Email is not valid!");
	}
	// Password
	if (strlen($password_1) > 20 || strlen($password_1) < 5) {
		array_push($errors, "Password must be between 5 and 20 characters long!");
	}
	// Usernames
	if (preg_match('/[A-Za-z0-9]+/', $username) == 0) {
		array_push($errors, "Username is not valid!");
	}
	//Advisory number verification
	if (preg_match('/[A-Za-z]+/', $advisory) == 1) {
		array_push($errors, "Please use your advisory room number. ");
	}
	// needs to be changed to preg_match later
	if (strlen($sid) != 8) {
		array_push($errors, "Student id error : Invalid legnth ");
	}
	else {
		if (preg_match('/s......./', $sid) == 0) {
			array_push($errors, "Student id error : Invalid charaters ");
		}
		if ($password_1 == $username) {
			array_push($errors, "please pick a diffrent username or password ");
		}
	}
	// Names

	// name filtering has to be added still
/*
//First
	if (preg_match( "^-?[1-9]\d*$", $FirstName ) == 1) {
    array_push($errors, "Names dont have numbers");
	}
  */
	// Checking if a user exists         z_nayE-q@$ui
	$user_check_query = "SELECT * FROM StudentAccounts WHERE username='$username' OR email='$email' OR sid='$sid' OR uid='$uid' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);


	// If username Exists
	if ($user['username'] === $username) {
		array_push($errors, "Username already exists");
	}
	// If email Exists
	if ($user['email'] === $email) {
		array_push($errors, "This email adress is registered with and account");
	}
	// If Sid exists
	if ($user['sid'] == $sid) {
		array_push($errors, "Student id is registered with an account already");
	}

	if (count($errors) == 0) {
		$password = crypt($password_1, $salt); // Password hashed with salt
		// This password is one way encryped


		$uniqid = uniqid();

		$query = "INSERT INTO Nest.StudentAccounts (uid, sid, FirstName, LastName, email, username, password, Advisory, salt, activation_code)
  			  VALUES('$uid', '$sid', '$FirstName', '$LastName', '$email', '$username', '$password', '$advisory', '$salt', '$uniqid')";
		mysqli_query($db, $query);
		//	$_SESSION['FirstName'] = $FirstName;
//	$_SESSION['LastName'] = $LastName;
		$from = 'noreply@dwcloud.tk';
		$subject = 'Account Activation Required';
		$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "Bcc: darrionjw@outlook.com\r\n";
		$activate_link = 'https://www.audubonnest.tk/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
		$message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
		mail($_POST['email'], $subject, $message, $headers);
		array_push($errors, "Please check your email to activate your account. You can close this tab. ");

		$result = $query;
		if ($result === false) {
			exit('DEBUG: STORING TO DATABASE ERROR: ' . mysqli_connect_error());

		}
		array_push($errors, "Please check your email to activate your account. This email may also be in your spam folder. </br>
 You may close this page. ");
	}

}





// LOGIN USER
if (isset($_POST['login_student'])) {
	// login is escaped
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {

		$query = " SELECT uid, sid, FirstName, activation_code, email, password, salt FROM StudentAccounts WHERE username='$username'";

		$result = mysqli_query($db, $query);
		$row = mysqli_fetch_array($result);
		$salt = $row['salt'];
		$sid = $row['sid'];
		$uid = $row['uid'];
		$code = $row['activation_code'];
		$email = $row['email'];
		$FirstName = $row['FirstName'];
		$oldpassword = $row['password'];


		$newpassword = crypt($password, $salt);


		if ($newpassword == $oldpassword) {
			$_SESSION['username'] = $username;
			$_SESSION['uid'] = $uid;
			$_SESSION['sid'] = $sid;
			$_SESSION['email'] = $email;
			$_SESSION['Firstname'] = $FirstName;
			$_SESSION['Activated'] = $code;
			$_SESSION['Activated'] = $code;
			$_SESSION['success'] = "You are now logged in";
			if ($code != $activated) {
				array_push($errors, "You must activate your account first ! ");
				session_destroy();
				unset($_SESSION['username']);
			}
			else {
				header('location: index.php');
			}
		}
		else {
			array_push($errors, "Wrong username/password combination ");
		}


	}
}
// Staff login section
// note: this section is a copy of the student login section adjusted to login with emails
// instead of usernames.
if (isset($_POST['login_staff'])) {
	// login is escaped
	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password = mysqli_real_escape_string($db, $_POST['password']);

	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {

		$query = " SELECT activation_code, Advisory, Staff_id, FirstName, salt, password FROM StaffAccounts WHERE email='$email'";

		$result = mysqli_query($db, $query);
		$row = mysqli_fetch_array($result);
		$salt = $row['salt'];
		$code = $row['activation_code'];
		$adv = $row['Advisory'];
		$staffid = $row['Staff_id'];
		$FirstName = $row['FirstName'];
		$oldpassword = $row['password'];

		$newpassword = crypt($password, $salt);

		if ($newpassword == $oldpassword) {
			$_SESSION['email'] = $email;
			$_SESSION['Firstname'] = $FirstName;
			$_SESSION['Activated'] = $code;
			$_SESSION['Staff_id'] = $staffid;
			$_SESSION['Advisory'] = $adv;
			$_SESSION['success'] = "You are now logged in";

			if ($code != $activated) {
				array_push($errors, "You must activate your account first ! ");
				session_destroy();
				unset($_SESSION['username']);
			}
			else {
				header('location: staff-home.php');
			}
		}
		else {
			array_push($errors, "Wrong username/password combination ");
		}

	}
}

// events loggin section ----

if (isset($_POST['Log_Event'])) {

	$uniqid = MD5(uniqid());
	$sid = $_SESSION['sid'];
	$email = $_SESSION['email'];

	$Eventname = mysqli_real_escape_string($db, $_POST['Eventname']);
	$Eventdesc = mysqli_real_escape_string($db, $_POST['Eventdesc']);
	$Eventdate = mysqli_real_escape_string($db, $_POST['Eventdate']);
	$Eventmail = mysqli_real_escape_string($db, $_POST['Eventmail']);
	$Eventhead = mysqli_real_escape_string($db, $_POST['Eventhead']);
	$Eventloca = mysqli_real_escape_string($db, $_POST['Eventloca']);
	$Eventbegin = mysqli_real_escape_string($db, $_POST['Eventbegin']);
	$Eventend = mysqli_real_escape_string($db, $_POST['Eventend']);

	if (empty($Eventname)) {
		array_push($errors, "Event name is required");
	}

	if (empty($Eventdesc)) {
		array_push($errors, "Event description is required");
	}

	if (empty($Eventdate)) {
		array_push($errors, "Event date is required");
	}

	if (empty($Eventmail)) {
		array_push($errors, "Email is required");
	}

	if (empty($Eventhead)) {
		array_push($errors, "Supervisor name is required");
	}

	if (empty($Eventloca)) {
		array_push($errors, "Event location is required");
	}

	if (empty($Eventbegin)) {
		array_push($errors, "Begining time is required");
	}

	if (empty($Eventend)) {
		array_push($errors, "Ending time is required");
	}

	//  Email Filter
	if (!filter_var($Eventmail, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Email is not valid!");
	}
	// image submission portion

	// submit to database




	if (count($errors) == 0) {
		$directoryName = "uploads/$sid/";
		if (!is_dir($directoryName)) {
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0777);
		}
		$target_dir = "uploads/$sid/";
		$target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		// Check if image file is a actual image or fake image
		if (isset($_POST["submit"])) {
			$check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
			if ($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			}
			else {
				array_push($errors, "File is not an image.");
				$uploadOk = 0;
			}
		}

		// Check if file already exists
		if (file_exists($target_file)) {
			array_push($errors, "Sorry, file already exists.");
			$uploadOk = 0;
		}

		// Check file size
		if ($_FILES["imageUpload"]["size"] > 500000) {
			array_push($errors, "Sorry, your file is too large.");
			$uploadOk = 0;
		}

		// Allow certain file formats
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif") {
			array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
			$uploadOk = 0;
		}

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			array_push($errors, "Sorry, your file was not uploaded.");
		// if everything is ok, try to upload file
		}
		else {
			if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
			// echo "The file ". basename( $_FILES["imageUpload"]["name"]). " has been uploaded.";
			}
			else {
				array_push($errors, "Sorry, there was an error uploading your file.");
			}
		} // closing the isset for pictures


		$Credited = '0';
		$query = "INSERT INTO Nest.LoggedEvents (sid, uid, eventname, eventdesc, eventdate, eventmail, eventhead, eventloca, eventbegi, eventend, Image, credited )
			VALUES('$sid', '$uniqid','$Eventname', '$Eventdesc', '$Eventdate', '$Eventmail', '$Eventhead', '$Eventloca', '$Eventbegin', '$Eventend', '$target_file', '$Credited' )";
		mysqli_query($db, $query);

		// email recipt of the log submited
		$from = 'noreply@dwcloud.tk';
		$subject = 'You have submitted ' . $Eventname . 'for review !';
		$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "Bcc: darrionjw@outlook.com\r\n";
		$tracker_link = 'https://www.audubonnest.tk/single-event.php?code=' . $uniqid;
		$message = '<p> You have submitted an event titled:  ' . $Eventname . ' for review !</p>';
		$message .= '<p> If you want to see the status of this event click here: <a href="' . $tracker_link . '"> ' . $uniqid . '</p>';

		mail($email, $subject, $message, $headers);
		// array_push($errors, "THING SUBMITTED");


		$query = "SELECT email FROM StaffAccounts WHERE Advisory = $advisory";
		$result = mysqli_query($db, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$email_2 = $row['email'];

			$from = 'noreply@dwcloud.tk';
			$subject = 'A student submitted ' . $Eventname . 'for review !';
			$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
			$headers .= "Bcc: darrionjw@outlook.com\r\n";
			$tracker_link = 'https://audubonnest.tk/staff-login.php' . $uniqid;
			$message = '<p> A student has submitted an event titled:  ' . $Eventname . ' for review !</p>';
			$message .= '<p> If you want to credit or flag this event click here and login: <a href="' . $tracker_link . '"> ' . $uniqid . '</p>';

			mail($email_2, $subject, $message, $headers);
		// staff email for submitted emails.
		}

		header('location: index.php');

	}

}

if (isset($_POST['Credited_Events'])) {
	$uid = $_POST['uid'];
	$sid = $_POST['sid'];
	$email = $_POST['email'];
	$firstname = $_POST['first'];
	$lastname = $_POST['last'];
	$eventname = $_POST['ename'];
	$eventdesc = $_POST['edesc'];
	$credit = "UPDATE LoggedEvents SET credited = '1' WHERE uid = '$uid' ";
	mysqli_query($db, $credit);
	shell_exec('curl https://www.audubonnest.tk/Total.php >> /dev/null');
	$query = "SELECT totals FROM StudentAccounts WHERE sid = '$sid' ";
	$sid3 = mysqli_query($db, $query);
	$sid2 = mysqli_fetch_array($sid3);
	$total = $sid2['totals'];
	// debuging line	array_push($errors, "$total");
	array_push($errors, "Event $eventname Credited");
	// mail to the student when the event is credited
	// email recipt of the log submited
	$from = 'noreply@dwcloud.tk';
	$subject = 'An event has been credited! ';
	$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
	$headers .= "Bcc: darrionjw@outlook.com\r\n";
	$message = '<p> Hi ' . $firstname . ', good news!</p>';
	$message .= '<p> The event you submited titled: ' . $eventname . ', has been Credited ! This puts your current total at : ' . $total . ' out of 120:00:00. Keep up the good work! </p>';

	mail($email, $subject, $message, $headers);
}

if (isset($_POST['Admin_Class'])) {
	unset($_SESSION['Advisory']);
	$Newadvisory = mysqli_real_escape_string($db, $_POST['newadv']);
	$_SESSION['Advisory'] = $Newadvisory;

	$advisory = $_SESSION['Advisory'];

	$class = "CREATE TABLE IF NOT EXISTS Nest.Class_$advisory (
					uid VARCHAR(255) NOT NULL PRIMARY KEY,
					FirstName VARCHAR(255) NOT NULL,
					LastName VARCHAR(255) NOT NULL,
					username VARCHAR(255) NOT NULL,
					email VARCHAR(255) NOT NULL,
					sid VARCHAR(255) NOT NULL,
					pending VARCHAR(255) NOT NULL,
					totals VARCHAR(255) NOT NULL,
					media VARCHAR(255) NOT NULL
	)";
	mysqli_query($db, $class);

	$class = "SELECT * FROM StudentAccounts WHERE Advisory = '$advisory' AND Inclass = '0' ";
	$result = mysqli_query($db, $class);

	while ($row = mysqli_fetch_assoc($result)) {
		$id = $row['id'];
		$sid = $row['sid'];
		$FirstName = $row['FirstName'];
		$LastName = $row['LastName'];
		$email = $row['email'];
		$username = $row['username'];
		$pending = $row['pending'];
		$total = $row['totals'];
		$media = $row['media'];
		$addclass = "INSERT INTO Class_$advisory (uid, FirstName, LastName, username, email, sid, pending, totals, media )
				VALUES('$uid', '$FirstName', '$LastName', '$username', '$email', '$sid', '$pending', '$total', '$media')";
		mysqli_query($db, $addclass);
		$classstatus = " UPDATE StudentAccounts SET Inclass = '1' WHERE uid = '$uid' ";
		mysqli_query($db, $classstatus);

		array_push($errors, "Student added $FirstName");
		echo "</br>";
	}

	array_push($errors, "Advisory Changed");
}

if (isset($_POST['Flag_Events'])) {
	$uid = mysqli_real_escape_string($db, $_POST['uid']);
	$sid = $_POST['sid'];
	$email = $_POST['email'];
	$firstname = $_POST['first'];
	$lastname = $_POST['last'];
	$eventname = $_POST['ename'];
	$eventdesc = $_POST['edesc'];
	$query = "SELECT * FROM LoggedEvents WHERE uid = '$uid' ";
	mysqli_query($db, $query);
	$flag = " UPDATE LoggedEvents SET flagged = '1' WHERE uid = '$uid' ";
	mysqli_query($db, $flag);

	array_push($errors, "Event $eventname Flagged!");

	$from = 'noreply@dwcloud.tk';
	$subject = 'An event you submitted has been flagged! ';
	$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
	$headers .= "Bcc: darrionjw@outlook.com\r\n";
	$message = '<p> Hi ' . $firstname . '!</p>';
	$message .= '<p> The event you submited titled: ' . $eventname . ', has been flagged by your advisor! Please contact for advisor with questions and concerns. </p>';

	mail($email, $subject, $message, $headers);
}

if (isset($_POST['Delete_Events'])) {
	$uid = mysqli_real_escape_string($db, $_POST['uid']);
	$sid = $_POST['sid'];
	$email = $_POST['email'];
	$firstname = $_POST['first'];
	$lastname = $_POST['last'];
	$eventname = $_POST['ename'];
	$eventdesc = $_POST['edesc'];
	$query = "SELECT * FROM LoggedEvents WHERE uid = '$uid' ";
	mysqli_query($db, $query);
	$delete = " UPDATE LoggedEvents SET deleted = '1' WHERE uid = '$uid' ";
	mysqli_query($db, $delete);

	array_push($errors, "Event $eventname Deleted!");

	$from = 'noreply@dwcloud.tk';
	$subject = 'An event you submitted has been deleted! ';
	$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
	$headers .= "Bcc: darrionjw@outlook.com\r\n";
	$message = '<p> Hi ' . $firstname . '!</p>';
	$message .= '<p> The event you submited titled: ' . $eventname . ', has been deleted by your advisor! Please contact for advisor with questions and concerns. </p>';

	mail($email, $subject, $message, $headers);
}
if (isset($_POST['Unflag_Events'])) {
	$uid = mysqli_real_escape_string($db, $_POST['uid']);
	$sid = $_POST['sid'];
	$email = $_POST['email'];
	$firstname = $_POST['first'];
	$lastname = $_POST['last'];
	$eventname = $_POST['ename'];
	$eventdesc = $_POST['edesc'];
	$query = "SELECT * FROM LoggedEvents WHERE uid = '$uid' ";
	mysqli_query($db, $query);
	$flag = " UPDATE LoggedEvents SET flagged = '0' WHERE uid = '$uid' ";
	mysqli_query($db, $flag);

	array_push($errors, "Event $eventname unflagged!");

	$from = 'noreply@dwcloud.tk';
	$subject = 'An event you submitted has been unflagged! ';
	$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
	$headers .= "Bcc: darrionjw@outlook.com\r\n";
	$message = '<p> Hi ' . $firstname . ', Good News!</p>';
	$message .= '<p> The event you submited titled: ' . $eventname . ', has been unflagged by your advisor! Please contact for advisor with questions and concerns. </p>';

	mail($email, $subject, $message, $headers);
}



function PullEventPage()
{
	global $db;
	for ($x = 0; $x <= 20; $x++) {
		$query = " SELECT * FROM ListedEvents WHERE id = $x LIMIT 1";
		$result = mysqli_query($db, $query);
		$row = mysqli_fetch_array($result);
		global $populated;
		$EventDescription = $row['Short_Description'];
		$EventPicture = $row['PictureUrl'];
		$EventName = $row['Title'];
		if ($result->num_rows) {

			echo "    <div class=\"home-events\" style=\"margin-top: 40px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;\">";
			echo "    <img src=$EventPicture style=\" border: 3px solid #000000; float: left;margin-left:0%;width:30%;height:auto;border-radius:2%;height: auto;\"> </img>";
			echo "    <h2 style=\" text-align: center; margin-left:1%; width: 0px auto;\"> $EventName </h2>";
			echo "    <h2 style=\" padding-bottom: 5% ; text-align: center; padding-top: 5%; padding-left:20%; padding-right:5%; \"> $EventDescription</h2>";

			$button = "<a href=\"https://www.audubonnest.tk/activity.php?id=$eventid \">";
			$button .= "<button style=\"position: absolute; right: 0px; bottom: 0px; margin-top: 4%; float: right;\" type=\"submit\" class=\"btn-login\" name=\" More Info \" > More Info </button>";
			$button .= "</a>";
			echo "$button";
			echo "</div>";
		}

	}

}

function adv_list($opp, $num)
{
	global $db;

	if ($opp == "add") {
		$operation = "Insert INTO Nest.adv_list (adv_num) VALUES('$num')";
	}
	if ($opp == "remove") {
		$operation = "Delete From Nest.adv_list WHERE adv_num = $num";
		$zero_class = "UPDATE Nest.StudentAccounts SET Inclass = '0' WHERE Advisory = '$num' ";
		$drop = "DROP TABLE Class_$num";

	}

	mysqli_query($db, $operation);
	mysqli_query($db, $drop);
	mysqli_query($db, $zero_class);
}

?>