<?php

session_start();

if (!isset($_SESSION['Staff_id'])) {
  $_SESSION['msg'] = "You must log in first";
  header('location: staff-login.php');
}
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['Staff_id']);
  header("location: staff-login.php");
}

$advisory = $_SESSION['Advisory'];
$Staffid = $_SESSION['Staff_id'];
include('server.php');

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

        <!-- Change account details -->
        <a href="PassChange.php">
        <button class="profile-corner">
        <i style="color:white;" class="fas fa-user-lock"></i>
        <p class="a" style="font-size:17px; color:white;">Change account details</p>
        </button>
        </a>

        <!-- logout button -->
          <a href="logout.php" >
          <button style="padding-bottom:1%;" class="logout-corner<?php if ( "$site" == "PassChange")        { ?> current <?php } ?>">
          <i style="color:white;" class="fas fa-user"></i>
          <p class="a" style="color:white;">Logout</p>
          </button>
          </a>

      </div>
  <?php $site = basename(__FILE__, '.php');  ?>

		<div class="input-group-top">
      <button type="button" class="btn-home <?php if ( "$site" == "staff-home")    { ?> current <?php } ?>" name="home_page"><a href="staff-home.php"           >HOME</a></button>
      <button type="button" class="btn-home <?php if ( "$site" == "Class")         { ?> current <?php } ?>" name="Classmngt_page"><a href="Class.php"        >Class Management</a></button>
      <button type="button" class="btn-home <?php if ( "$site" == "Flag")         { ?> current <?php } ?>" name="Flagged_page"><a href="Flag.php"        >Flagged Events</a></button>

		</div>
</div>

<?php
include('errors.php');
if ($Staffid == 'fea029189753b974827ee28948c38a96') {
  echo "<div class=\"home-events\" style=\"margin-top: 10px; overflow: hidden; margin-left: 25%; width: 50%;  height: auto;\" >";
  echo "<form style=\"background-color:#dcddde; width:50%; border-color:#dcddde;\" method=\"post\" action=\"Class.php\">";
  echo "<div class=\"input-group\" style=\"overflow: hidden; padding-bottom:2%;\" >";
  echo "<label style=\" overflow: hidden; \" >Advisory Number</label>";
  echo "<textarea class=\"input-group\" type=\"text\" style=\"height:5%;\" name=\"newadv\" placeholder=\"Current $advisory\" value=\"<?php echo $newadv;?>\" ></textarea>";
  echo "</div>";
  echo "<button type=\"submit\" class=\"btn-login\" name=\"Admin_Class\" style=\" position: absolute; right: 0px; bottom: 0px; margin-top: 3.4%; margin-right: 4%; float: right;\"> Change </button>";
  echo "</form>";
  echo "</div>";
}

$current = "SELECT * FROM Class_$advisory ";
$result1 = mysqli_query($db, $current);

while($row1 = mysqli_fetch_assoc($result1)) {
  $sid = $row1['sid'];
  $firstname = $row1['FirstName'];
  $lastname = $row1['LastName'];
  $email = $row1['email'];
  $username = $row1['username'];
  $pending = $row1['pending'];
  $totals = $row1['totals'];

  echo "<div class=\"home-events\" style=\"margin-top: 10px; overflow: hidden; margin-left: 25%; width: 50%;  height: auto;\" >";
  echo "<form style=\"background-color:#dcddde; width:100%; border-color:#dcddde;\" method=\"post\" action=\"staff-home.php\">";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Student          : $firstname $lastname </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Student id       : $sid </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Media Release ?  : $media </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Email            : $email </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Pending  Hours   : $pending </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Total Hours      : $totals / 120:00:00 </p>";
  echo "<input type = \"hidden\" name = \"sid\" value = \"$sid\" />";
  echo "<a href=\"https://nest.ramfield.net/profile.php?sid=$sid\"";
  echo "<button class=\"btn-login\" style=\" position: absolute; right: 0px; bottom: 0px; margin-top: 3.4%; margin-right: 0%; margin-left: 2%; float: right;\"> View Student </button>";
  echo "</a>";
  echo "</form>";
  echo "</div>";
  echo "</br>";

}

?>

<div class="home-events" style="margin-top: 10px; overflow: hidden; margin-left: 0%; width: 100%;  height: 10%; padding-bottom: 3%; margin-top: 50%;" >
  <h3 style="color: #000000; text-align: center; ">
    Have feedback or an issue ? <a href="https://dwcloud.tk/index.php/apps/forms/KfmafYapRqJAqPQk" style="color:blue; padding-top: auto; "   >Click Here</a>
  </h3>
</div>
