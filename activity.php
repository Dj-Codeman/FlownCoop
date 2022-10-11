<?php
  session_start();
  include('server.php');

$sid = $_SESSION['sid'];
$email = $_SESSION['email'];
$advisory = $_SESSION['advisory'];
$name = $_SESSION['FirstName'];
$name .= $_SESSION['LastName'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="slideshow.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

</head>
<body>

<div class="header" style="border-bottom: 8px solid #f2e711;">
	<h2 class="Welcome">THE NEST (beta)</h2>
  <div class="relative">
	<p class="account-corner"> Welcome back, <?=$_SESSION['Firstname']?>!</p>
  <!-- profile button -->

  <!-- <button class="profile-corner"><a href="profile.php" >
    <i class="fas fa-user"></i> -->
    <style>

    a {
      text-decoration: none;
      color: #ffffff;
    }
    </style>
    <!-- <p class="a">Profile</p>
    </a></button> -->

    <!-- logout button -->

    <button class="logout-corner"><a href="logout.php" >
      <i class="fas fa-user-lock"></i>
      <p class="a">Logout</p>
      </a></button>
  </div>
  <?php $site = basename(__FILE__, '.php');  ?>

		<div class="input-group-top">
      <button type="button" class="btn-home <?php if ( "$site" == "index")        { ?> current <?php } ?>" name="home_page"><a href="index.php"           >HOME</a></button>
      <button type="button" class="btn-home <?php if ( "$site" == "events")       { ?> current <?php } ?>" name="events_page"><a href="events.php"        >EVENTS</a></button>
      <button type="button" class="btn-home <?php if ( "$site" == "logform")      { ?> current <?php } ?>" name="log_page"><a href="logform.php"          >LOG YOUR WORK</a></button>
      <button type="button" class="btn-home <?php if ( "$site" == "Log")          { ?> current <?php } ?>" name="List_page"><a href="Log.php"             >YOUR LOG</a></button>
      <button type="button" class="btn-home <?php if ( "$site" == "activity")     { ?> current <?php } ?>" name="List_page"><a href="Log.php"             >ACTIVITY</a></button>

		</div>
</div>

<!-- Selection query for the event -->

<?php

echo "<div>";

// Determining event id
$id = $_GET['id'];
if (empty($id)) {
$id = $_POST['event-number'];
}

include('errors.php');
echo "</div>";

// Selecting Event data based on the id tag in the url
$db = mysqli_connect('207.144.242.167', 'admin', 'Danny9518!', 'Nest');



// Initial query.

$query = " SELECT * FROM ListedEvents WHERE id = $id" ;
$result = mysqli_query($db, $query);
$data = mysqli_fetch_array($result);
$EventName = $data['Title'];
$EventEmail = $data['Email'];
// Converting DB storded date to a more acceptable format MM-DD-YYYY
$RawDate = $data['Date'];
$TmpDate = str_replace('-', '/', $RawDate);
$EventDate = date('m-d-Y', strtotime($TmpDate));
$EventDescription = $data['Description'];
$EventPicture = $data['PictureUrl'];
$EventBegin = $data['Listed_Time_Begin'];
$EventEnd = $data['Listed_Time_End'];
$EventTime = date("h:i a", strtotime($EventBegin));
$EventTime .= " - ";
$EventTime .= date("h:i a", strtotime($EventEnd));


// weird oop section
$start_date = new DateTime("$EventBegin");
$since_start = $start_date->diff(new DateTime("$EventEnd"));

$EventDuration = $since_start->h. 'hour(s) and ';
$EventDuration .= $since_start->i. 'minute(s)';

$EventOrganizer = $data['Organizer'];
$EventLocation = $data['Location'];



echo " <!-- Begining of the new BODY -->
<div  style=\"margin-top: 1%; overflow: hidden; width: 100%; height: auto;\">
  <form style=\" width: 100%; border: 0px; background-color: transparent; border  \" method=\"post\" action=\"activity.php\" />
  <img src= $EventPicture style=\" border: 3px solid #000000; float: left; margin-left:0%;width:30%;height:auto;border-radius:2%;height: auto;\"> </img>
    <h1 style=\" word-wrap:break-word; text-align: center; margin-left:1%; width: 0px auto;\"> $EventName </h1>
    <h3 style=\" margin-top: 2%; text-align: center; margin-left:1%; width: 0px auto;\"> TIME:     $EventTime </h3>
    <h3 style=\" margin-top: 1%; text-align: center; margin-left:1%; width: 0px auto;\"> Date: $EventDate </h3>
    <h3 style=\" margin-top: 1%; text-align: center; margin-left:1%; width: 0px auto;\"> Organizer: $EventOrganizer </h3>
    <h3 style=\" margin-top: 1%; text-align: center; margin-left:1%; width: 0px auto;\"> Organizer Email: $EventEmail </h3>
    <h3 style=\" margin-right: -30%; margin-top: 1%; text-align: center; margin-left:1%; width: 0px auto;\"> Location: $EventLocation </h3>
    <h2 style=\" margin-top: 1%; text-align: center; width: 50%; float: right; margin-right: 10% ;  \"> $EventDescription </h2>
    <input type = \"hidden\" name = \"sid\" value = \"$sid\" />
    <input type = \"hidden\" name = \"email\" value = \"$email\" />
    <input type = \"hidden\" name = \"name\" value = \"$name\" />
    <input type = \"hidden\" name = \"event-number\" value = \"$id\" />

";


// th

$query = "SELECT uid FROM Nest.LoggedEvents WHERE sid = '$sid' AND eventname = '$EventName'";
$result = mysqli_query($db, $query);
if ($result) {
  if (mysqli_num_rows($result) > 0) {
      relax();
} else {
  echo " <button type=\"submit\" class=\"btn-login\" name=\"Event-Register\" style=\"
  font-size: 200%;  position: absolute; left: 140px; margin-top: 3.4%; margin-right: 3%;
   float: left;\"> Register </button> ";
}

} else {
  echo 'Error: '.mysql_error();
}

echo "
  </form>
  </div>
";



?>

<!-- END OF PAGE -->
<div class="home-events" style="margin-top: 120px; overflow: hidden; margin-left: 0%; width: 100%;  height: 10%; padding-bottom: 3% ; " >
  <h3 style="color: #000000; text-align: center; ">
    Have feedback or an issue ? <a href="https://dwcloud.tk/index.php/apps/forms/KfmafYapRqJAqPQk" style="color:blue; padding-top: 90px; "   >Click Here</a>
  </h3>
</div>

</body>
</html>




<?php
// shittty php organizing structure thing

// Registering studetns for events
if (isset($_POST['Event-Register'])) {
// add current event to pending student.


$uniqid = MD5(uniqid());
$Eventname = $EventName;
$Eventdesc = $EventDescription;
// Converting Date back to db format date
$Eventdate_db = date('Y-m-d', strtotime($EventDate));
$Eventmail = $EventEmail;
$Eventhead = $EventOrganizer;
$Eventloca = $EventLocation;
$Eventbegin = $EventBegin ;
$Eventend = $EventEnd;
$target_file = $EventPicture;
$Credited = '0';
$Flagged = '0';
$Deleted = '0';

$query = "INSERT INTO Nest.LoggedEvents (sid, uid, eventname, eventdesc, eventdate, eventmail, eventhead, eventloca, eventbegi, eventend, Image, credited, flagged, deleted )
			VALUES('$sid', '$uniqid', '$Eventname', '$Eventdesc', '$Eventdate_db', '$Eventmail', '$Eventhead', '$Eventloca', '$Eventbegin', '$Eventend', '$target_file', '$Credited', '$Flagged', '$Deleted' )";
mysqli_query($db, $query);
echo $query;


// email recipt of the log submited
$from    = 'noreply@dwcloud.tk';
$subject = 'You have registered for "' . $Eventname . '" and it has already been submitted to your advisor !';
$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
$headers .= "Bcc: darrionjw@outlook.com\r\n";
$tracker_link = 'https://www.audubonnest.tk/single-event.php?code=' . $uniqid;
$message = '<p> You have been registered for the event titled:  ' . $Eventname . ' !</p>';
$message .= '<p> If there was information not provided on the listing such as a link, room number or address please contact your advisor !</p>';
$message .= '<p> If you want to see the status of this event click here: <a href="' . $tracker_link . '"> ' . $uniqid . '</p>';

mail($email, $subject, $message, $headers);
// array_push($errors, "THING SUBMITTED");


$query = "SELECT email FROM StaffAccounts WHERE Advisory = $advisory";
$result = mysqli_query($db, $query);
while($row = mysqli_fetch_assoc($result)) {
$email_2 = $row['email'];

$from    = 'noreply@dwcloud.tk';
$subject = "$name has registered for the $eventName event ! ";
$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
$headers .= "Bcc: darrionjw@outlook.com\r\n";
$tracker_link = 'https://audubonnest.tk/staff-login.php' . $uniqid;
$message = '<p>' . $name . ' has registered for the event titile' . $EventName . ' there email address is as follows ' . $email . 'If you excluded any information such as a link or an address from the listing now is the time to communicate with students and finalize that information. </p>';
$message .= "</br>";
$message .= "</br>";
$message .= "</br>";
$message .= "<p> Good luck and Thank you! </p>";
$message .= "</br>";
$message .= "<p> Audubon SSAC team </p>";

mail($email_2, $subject, $message, $headers);
// staff email for submitted emails.
}


$Javaname = "\"$Eventname\"";
echo '<script type="text/javascript">';
echo "alert('You have been registered for ".$Javaname." !');";
echo 'window.location.href = "index.php";';
echo '</script>';

}
?>
