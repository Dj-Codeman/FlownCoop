<?php
session_start();
$sid = $_SESSION['sid'];


if (!isset($_SESSION['sid'])) {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
}

include('server.php');

$log_query = "SELECT * FROM LoggedEvents WHERE sid = '$sid' ";
$result = mysqli_query($db, $log_query);

?>



<!DOCTYPE html>
<html>

<head>
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

</head>

<body>

  <div class="header" style="border-bottom: 8px solid #f2e711;">

    <h2 class="Welcome">THE NEST (beta)</h2>
    <div class="relative">
      <p class="account-corner"> Welcome back,
        <?= $_SESSION['Firstname']?>!
      </p>
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
      <a href="logout.php">
        <button style="padding-bottom:1%;" class="logout-corner<?php if (" $site" == "PassChange") { ?> current
          <?php
}?>">
          <i style="color:white;" class="fas fa-user"></i>
          <p class="a" style="color:white;">Logout</p>
        </button>
      </a>

    </div>


    <?php $site = basename(__FILE__, '.php'); ?>

    <div class="input-group-top">
      <button type="button" class="btn-home <?php if (" $site" == "index") { ?> current <?php }?>" 
        name="home_page"><a href="index.php">HOME</a>
      </button>
      <button type="button" class="btn-home <?php if (" $site" == "events") { ?> current <?php }?>" 
      name="events_page"><a href="events.php">EVENTS</a>
      </button>
      <button type="button" class="btn-home <?php if (" $site" == "logform") { ?> current <?php }?>" 
      name="log_page"><a href="logform.php">LOG YOUR WORK</a>
      </button>
      <button type="button" class="btn-home <?php if (" $site" == "Log") { ?> current <?php }?>" 
      name="contact_page"><a href="Log.php">YOUR LOG</a>
      </button>

    </div>
  </div>

  <div>
    <p>
      <?php



$total = "SELECT totals FROM StudentAccounts WHERE sid = '$sid'";
$t1 = mysqli_query($db, $total);
while ($row = mysqli_fetch_assoc($t1)) {
  $Totals = $row['totals'];

  echo "<div class=\"home-events\" style=\"margin-top: 10px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;\" >";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Your current total. : $Totals </p>";
  echo "</div>";
}

while ($row = mysqli_fetch_assoc($result)) {
  if ($row['credited'] == 0) {
    $Credited = "NO";
  }
  else {
    $Credited = "YES";
  }
  $uid = $row['uid'];
  $event = $row['eventname'];
  $eventdesc = $row['eventdesc'];
  $eventdura = $row['duration'];
  $imgdir = $row['Image'];
  $eventhead = $row['eventhead'];
  $eventmail = $row['eventmail'];



  echo "<div class=\"home-events\" style=\"margin-top: 10px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;\" >";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Id             : $uid </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Title          : $event </p>";
  if (!is_null($imgdir)) {
    $padding = '1';
    echo "<img src= \" $imgdir \"  style=\" border: 3px solid #000000; float: left;margin-left:0%;width:30%;height:auto;border-radius:2%;height: auto;\"> </img>";
  }
  echo "<p style=\"text-align: center; margin-left:1%; margin-top:10px; margin-bottom:8px; width: 0px auto; \"> Event Description: </p>";
  echo "<p style=\"text-align: center; margin-left:1%;";
  if ($padding == 1) {
    echo "margin-right:2%;";
  }
  echo "margin-top:10px; margin-bottom:8px; width: 0px auto; \"> $eventdesc </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Leader          : $eventhead </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Leader email    : $eventmail </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Duration        : $eventdura </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Credited ?      : $Credited </p>";
  echo "</br>";
  echo "</div>";
}

?>
    </p>
  </div>

  <div class="home-events"
    style="margin-top: 10px; overflow: hidden; margin-left: 0%; width: 100%;  height: 10%; padding-bottom: 3% ; ">
    <h3 style="color: #000000; text-align: center; ">
      Have feedback or an issue ? <a href="https://dwcloud.tk/index.php/apps/forms/KfmafYapRqJAqPQk"
        style="color:blue; padding-top: 90px; ">Click Here</a>
    </h3>
  </div>

</body>

</html>