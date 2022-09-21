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
<div> <P>
  <?php

  $db = mysqli_connect('192.168.0.3', 'Client', 'Y&0E1{8u){S?', 'Nest');

    include('errors.php');




# auto pupulating class
    $class = "SELECT * FROM StudentAccounts WHERE Advisory = '$advisory' AND Inclass = '0' ";
     $result = mysqli_query($db, $class);

  while($row = mysqli_fetch_assoc($result)) {
    $uid = $row['uid'];
    $sid = $row['sid'];
    $FirstName = $row['FirstName'];
    $LastName = $row['LastName'];
    $email = $row['email'];
    $username = $row['username'];
    $total = $row['totals'];
    $pending = $row['pending'];
    $media = $row['media'];

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

            // Check if adv num is saved in db
            $adv_num_check = "SELECT * FROM adv_list WHERE adv_num='$advisory' LIMIT 1";
            $adv_result = mysqli_query($db, $adv_num_check);
            $data = mysqli_fetch_assoc($adv_result);
            // If email Exists
                if ($data['adv_num'] === $advisory) {
                    ;
                } else {
                  adv_list("add", $advisory);
                }

    $addclass = "INSERT INTO Class_$advisory (uid, FirstName, LastName, username, email, sid, pending, totals, media )
    			VALUES('$uid', '$FirstName', '$LastName', '$username', '$email', '$sid', '$pending', '$total', '$media')";
          mysqli_query($db, $addclass);
    $classstatus = " UPDATE StudentAccounts SET Inclass = '1' WHERE uid = '$uid' ";
          mysqli_query($db, $classstatus);
  }
# auto populating class end

  $current = "SELECT * FROM Class_$advisory ORDER BY RAND() ";
  $result1 = mysqli_query($db, $current);

  while($row1 = mysqli_fetch_assoc($result1)) {
    $sid = $row1['sid'];
    $firstname = $row1['FirstName'];
    $lastname = $row1['LastName'];
    $email = $row1['email'];
    $media = $row1['media'];
    $pull = "SELECT * FROM Nest.LoggedEvents WHERE sid = '$sid' AND credited = '0' AND flagged = '0' AND deleted = '0'  ORDER BY RAND() LIMIT 5 ";
    $result_1 = mysqli_query($db, $pull);
    while($row2 = mysqli_fetch_assoc($result_1)) {
      $eventname = $row2['eventname'];
      $eventdesc = $row2['eventdesc'];
      $eventdura = $row2['duration'];
      $eventhead = $row2['eventhead'];
      $imgdir = $row2['Image'];
      $uid = $row2['uid'];
      $eventmail = $row2['eventmail'];


      echo "<div class=\"home-events\" style=\"margin-top: 10px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;\" >";
      echo "<form style=\"background-color:#dcddde; width:100%; border-color:#dcddde;\" method=\"post\" action=\"staff-home.php\">";
      echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Student          : $firstname $lastname </p>";
      // echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Media Release ?  : $media </p>";
      echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Student id       : $sid </p>";
      // echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Unique id        : $uid </p>";
      echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Title      : $eventname </p>";
      if(!is_null($imgdir)){
      $padding = '1';
      echo "<img src= \" $imgdir \"  style=\" border: 3px solid #000000; float: left;margin-left:0%;width:30%;height:auto;border-radius:2%;height: auto;\"> </img>";
      }
      echo "<p style=\"text-align: center; margin-left:1%; margin-top:10px; margin-bottom:8px; width: 0px auto; \"> Event Description: </p>";
      echo "<p style=\"text-align: center; margin-left:1%;"; if( $padding == 1 ){ echo"margin-right:2%;"; } echo"margin-top:10px; margin-bottom:8px; width: 0px auto; \"> $eventdesc </p>";
      echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Head       : $eventhead </p>";
      echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Email      : $eventmail </p>";
      echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Event Duration   : $eventdura </p>";
      echo "<input type = \"hidden\" name = \"uid\" value = \"$uid\" />";
      echo "<input type = \"hidden\" name = \"sid\" value = \"$sid\" />";
      echo "<input type = \"hidden\" name = \"email\" value = \"$email\" />";
      echo "<input type = \"hidden\" name = \"first\" value = \"$firstname\" />";
      echo "<input type = \"hidden\" name = \"last\" value = \"$lastname\" />";
      echo "<input type = \"hidden\" name = \"ename\" value = \"$eventname\" />";
      echo "<input type = \"hidden\" name = \"edesc\" value = \"$eventdesc\" />";
      echo "<button type=\"submit\" class=\"btn-login\" name=\"Credited_Events\" style=\" position: absolute; right: 0px; bottom: 0px; margin-top: 3.4%; margin-right: 4%; float: right;\"> Credit </button>";
      echo "</form>";
      echo "</br>";
      echo "<form style=\"background-color:#dcddde; width:100%; border-color:#dcddde;\" method=\"post\" action=\"staff-home.php\">";
      echo "<input type = \"hidden\" name = \"uid\" value = \"$uid\" />";
      echo "<input type = \"hidden\" name = \"sid\" value = \"$sid\" />";
      echo "<input type = \"hidden\" name = \"email\" value = \"$email\" />";
      echo "<input type = \"hidden\" name = \"first\" value = \"$firstname\" />";
      echo "<input type = \"hidden\" name = \"last\" value = \"$lastname\" />";
      echo "<input type = \"hidden\" name = \"ename\" value = \"$eventname\" />";
      echo "<input type = \"hidden\" name = \"edesc\" value = \"$eventdesc\" />";
      echo "<button type=\"submit\" class=\"btn-login\" name=\"Flag_Events\" style=\" position: absolute; right: 100px; bottom: 0px; margin-top: 3.4%; margin-right: 4%; float: right;\"> Flag </button>";
      echo "</form>";
      echo "</div>";

    }
  }
   ?>
</div> </p>
<div class="home-events" style="margin-top: 10px; overflow: hidden; margin-left: 0%; width: 100%;  height: 10%; padding-bottom: 3% ; " >
  <h3 style="color: #000000; text-align: center; ">
    Have feedback or an issue ? <a href="https://dwcloud.tk/index.php/apps/forms/KfmafYapRqJAqPQk" style="color:blue; padding-top: auto; "   >Click Here</a>
  </h3>
</div>
<!--  organizers verify email for certain events.
staff password changes
passwords
ldap intergrations
ldap intergrations
pros and cons for each aspects
add aspects for stake holders emailing stake holders
covering students event descriptions
teacher aspect
what we have and what were missing
-->
