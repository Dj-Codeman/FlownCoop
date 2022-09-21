<?php
  session_start();

  if (isset($_SESSION['username'])) {
    $account = "Student";
    // echo "student";
} elseif (isset($_SESSION['Staff_id'])) {
    $account = "Staff";
    // echo "staff";
} else {
  $_SESSION['msg'] = "You must log in first";
  session_destroy();
  header('location: login.php');
}


  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }


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
      <button type="button" class="btn-home <?php if ( "$site" == "index")        { ?> current <?php } ?>" name="home_page"><a href="index.php"           >HOME</a></button>
      <button type="button" class="btn-home <?php if ( "$site" == "events")       { ?> current <?php } ?>" name="events_page"><a href="events.php"        >EVENTS</a></button>
      <button type="button" class="btn-home <?php if ( "$site" == "logform")      { ?> current <?php } ?>" name="log_page"><a href="logform.php"          >LOG YOUR WORK</a></button>
      <button type="button" class="btn-home <?php if ( "$site" == "Log")          { ?> current <?php } ?>" name="List_page"><a href="Log.php"             >YOUR LOG</a></button>

		</div>
</div>

</div class="home-events" style="height:20%;">
<?php

$uid = $_SESSION['uid'];
$staffid = $_SESSION['Staff_id'];
$email = $_SESSION['email'];
$adv = $_SESSION['email'];

  // if there is a row in the db

  $query = "SELECT * FROM StaffAccounts WHERE Staff_id = $staffid";
  $result = mysqli_query($db, $query);
		if($result->num_rows){
      while($row = mysqli_fetch_assoc($result)) {

      }
      echo "<div class=\"home-events\" style=\"margin-top: 40px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;\">";
      echo "<form style=\"background-color:#dcddde; width:100%; border-color:#dcddde;\" method=\"post\" action=\"staff-home.php\">";
      echo "<p> Staff account </p>";
      echo "</form>";
      echo "</div>";

    }

    $query = "SELECT * FROM StudentAccounts WHERE uid = $uid";
    $result = mysqli_query($db, $query);
    if($result->num_rows){
      while($row = mysqli_fetch_assoc($result)) {
        $uid2 = $row['uid'];
      }
      echo "<div class=\"home-events\" style=\"margin-top: 40px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;\">";
      echo "<form style=\"background-color:#dcddde; width:100%; border-color:#dcddde;\" method=\"post\" action=\"staff-home.php\">";
      echo "<h1> Student Account ".$uid2." </h1>";
      echo "</from>";
      echo "</div>";


   }

  // echo '<script type="text/javascript">';
  // echo "alert('data ".$account." !');";
  // echo 'window.location.href = "index.php";';
  // echo '</script>';



?>

</div>

<div class="home-events" style="margin-top: 40px; overflow: hidden; margin-left: 0%; width: 100%;  height: 10%; padding-bottom: 3% ; " >
  <h3 style="color: #000000; text-align: center; ">
    Have feedback or an issue ? <a href="https://dwcloud.tk/index.php/apps/forms/KfmafYapRqJAqPQk" style="color:blue; padding-top: 90px; "   >Click Here</a>
  </h3>
</div>
