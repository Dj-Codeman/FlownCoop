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
<?php
$select = "SELECT LoggedEvents.*, Class_$advisory.* FROM Nest.LoggedEvents, Nest.Class_$advisory WHERE LoggedEvents.flagged = '1' AND LoggedEvents.sid = Class_$advisory.sid AND deleted = '0'";
$result = mysqli_query($db, $select);
if(mysqli_num_rows($result) > 0){
while($row = mysqli_fetch_assoc($result)) {
  $sid = $row['sid'];
  $uid = $row['uid'];
  $firstname = $row['FirstName'];
  $lastname = $row['LastName'];
  $eventname = $row['eventname'];
  $eventdesc = $row['eventdesc'];
  $eventhead = $row['eventhead'];
  $eventmail = $row['eventmail'];
  $eventdura = $row['duration'];
  $email = $row['email'];
  echo "<div class=\"home-events\" style=\"margin-top: 10px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;\" >";
  echo "<form style=\"background-color:#dcddde; width:100%; border-color:#dcddde;\" method=\"post\" action=\"staff-home.php\">";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Student          : $firstname $lastname </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Student id       : $sid </p>";
  echo "<p style=\"text-align: center; margin-left:1%; margin-bottom:8px; width: 0px auto; \"> Unique id        : $uid </p>";
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
  echo "<input type = \"hidden\" name = \"uid\" value = \"$uid\" />";
  echo "<input type = \"hidden\" name = \"sid\" value = \"$sid\" />";
  echo "<input type = \"hidden\" name = \"email\" value = \"$email\" />";
  echo "<input type = \"hidden\" name = \"first\" value = \"$firstname\" />";
  echo "<input type = \"hidden\" name = \"last\" value = \"$lastname\" />";
  echo "<input type = \"hidden\" name = \"ename\" value = \"$eventname\" />";
  echo "<input type = \"hidden\" name = \"edesc\" value = \"$eventdesc\" />";
  echo "<button type=\"submit\" class=\"btn-login\" name=\"Delete_Events\" style=\" position: absolute; right: 0px; bottom: 0px; margin-top: 3.4%; margin-right: 4%; float: right;\"> Delete </button>";
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
  echo "<button type=\"submit\" class=\"btn-login\" name=\"Unflag_Events\" style=\" position: absolute; right: 100px; bottom: 0px; margin-top: 3.4%; margin-right: 4%; float: right;\"> Unflag </button>";
  echo "</form>";
  echo "</div>";
}
} else {
  echo "<div class=\"home-events\" style=\"margin-top: 10px; overflow: hidden; margin-left: 0%; width: 100%;  height: 10%; padding-bottom: 3% ; \" >";
  echo "<h3 style=\"color: #000000; text-align: center; \">";
  echo "NOTHING FLAGGED, HURRAY ! ";
  echo "</h3>";
  echo "</div>";
}
?>
</div> </p>
<div class="home-events" style="margin-top: 10px; overflow: hidden; margin-left: 0%; width: 100%;  height: 10%; padding-bottom: 3% ; " >
  <h3 style="color: #000000; text-align: center; ">
    Have feedback or an issue ? <a href="https://dwcloud.tk/index.php/apps/forms/KfmafYapRqJAqPQk" style="color:blue; padding-top: auto; "   >Click Here</a>
  </h3>
</div>
