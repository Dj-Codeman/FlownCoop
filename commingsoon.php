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
  include('server.php');
?>


<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

</head>
<body>

<div class="header">
	<h2 class="Welcome">This page is comming soon</h2>
  <div class="relative">
	<p class="account-corner"> Welcome back, <?=$_SESSION['Firstname']?>!</p>
  <!-- profile button -->
    <button class="profile-corner"><a href="profile.php" >
      <i class="fas fa-user"></i>
      <style>
      a {
        text-decoration: none;
        color: #ffffff;
      }
      </style>
      <p class="a">Profile</p>
      </a></button>
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
    <button type="button" class="btn-home <?php if ( "$site" == "commingsoon")  { ?> current <?php } ?>" name="contact_page"><a href="commingsoon.php"  >CONTACT US</a></button>

  </div>
</div>
<div class="cs-events">
  <p class="cs-events"> The team is hard at work bringing this progect to life. Please bear with us </p>
</div>
