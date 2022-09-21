<?php
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
$Eventid = $_GET['code'];
$event_check_query = "SELECT * FROM LoggedEvents WHERE uid = '$Eventid'";
$results = mysqli_query($db, $event_check_query);
$data = mysqli_fetch_assoc($results);

if (isset($data['id'])) {
}else {
	echo " Event uid is invalid please email audubonssac@outlook.com ";
}



?>

<!DOCTYPE html>
<html>
<head>
  <title>Nest Recipt</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<p> EVENT ID: <?php echo  $data['uid'] ;?> </p>
<br>
<p> EVENT NAME: <?php echo $data['eventname'];?> </p>
<br>
<p> EVENT DESCRIPTION: <?php echo $data['eventdesc'];?> </p>
<br>
<p> EVENT DATE: <?php echo $data['eventdate'];?> </p>
<br>
<p> EVENT EMAIL: <?php echo $data['eventmail'];?> </p>
<br>
<?php
if ($data['credited'] == "1"){
	$Credited = "Yes";
}else{
	$Credited = "No";
}
?>
<p> EVENT DURATION: <?php echo $data['duration'];?> </p>
<br>
<p> EVENT Credited: <?php echo $Credited;?> </p>
</body>
</html>
