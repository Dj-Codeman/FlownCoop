<?php  include('server.php'); ?>
<?php
  session_start();

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }

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
    <button type="button" class="btn-home <?php if ( "$site" == "commingsoon")  { ?> current <?php } ?>" name="contact_page"><a href="Log.php"  >YOUR LOG</a></button>

  </div>
</div>

<div>
<form style="height:100%; width:90%; margin: auto;" method="post" action="logform.php" enctype="multipart/form-data">
  <?php include('errors.php'); ?>
<!-- Event Name -->
<div class="input-group" style="width:50%; margin:auto; overflow: hidden;">
    <label>Event Name</label>
    <input type="text" placeholder="Give this event a name you will remember like: Park Cleanup." name="Eventname" value="<?php echo $Eventname; ?>">
  </div>
<!-- Event Description -->
<div class="input-group" style=" position: relative; width:50%;  margin:auto;">
    <label>Event Description</label>
    <textarea class="input-group" type="text" style="height:5%;" name="Eventdesc" placeholder="Describe what you did during this event." value="<?php echo $Eventdesc;?>" ></textarea>
  </div>
<!-- Titels for the event date and photos
 -->

<!-- event head -->
<div class="input-group" style="width:50%; margin:auto;">
    <label>Supervisor</label>
    <input type="text" name="Eventhead" value="<?php echo $Eventhead; ?>">
  </div>
  <!-- event head email -->
  <div class="input-group" style="width:50%; margin:auto;">
      <label>Supervisor's Email</label>
      <input type="email" name="Eventmail" value="<?php echo $Eventmail; ?>">
    </div>
<!-- Event Location -->
<div class="input-group" style="width:50%; margin:auto;">
    <label>Event Location</label>
    <input type="text" name="Eventloca" value="<?php echo $Eventloca; ?>">
  </div>
  <!-- Date and  -->
  <div class="input-group" style="width:50%; margin:auto; overflow:hidden; ">

      <label style="float:left;">Event Date : </label>  <label style=" margin-left: 33%; float:margin-left:40%;">Event Photo: (Optinal) </label>
      <input type="date" style="width:25%; float:left;" name="Eventdate" value="<?php echo $Eventdate; ?>">
      <input style="float:right; text-align:left; width:60%; margin-right:5%;" type="file" name="imageUpload" id="imageUpload">
      <!-- The process of uploading pictures still has to be worked out -->
    </div>
<!-- Start and End time -->
  <div class="input-group" style="width:50%; margin:auto;overflow:hidden;">
      <label style="float:left;">Start Time : </label>  <label style="  margin-left:48%;">End Time</label>
      <input type="time" style="width:45%; text-align:center; float:left;" name="Eventbegin" value="<?php echo $Eventdate; ?>">
      <input type="time" style="width:45%; text-align:center; float:left;" name="Eventend" value="<?php echo $Eventdate; ?>">
  </div>
  <!--  -->




  <div class="input-group">
    <button style="margin-left:25%;" type="submit" class="btn-login" name="Log_Event">Submit</button>


  </div>


</form>
<div class="home-events" style="margin-top: 10px; overflow: hidden; margin-left: 0%; width: 100%;  height: 10%; padding-bottom: 3% ; " >
  <h3 style="color: #000000; text-align: center; ">
    Have feedback or an issue ? <a href="https://dwcloud.tk/index.php/apps/forms/KfmafYapRqJAqPQk" style="color:blue; padding-top: 90px; "   >Click Here</a>
  </h3>
</div>
</body>
</html>
