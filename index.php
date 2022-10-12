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

<!-- Hopefully a working slideshow for events -->
<!-- This was copied from https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_slideshow_auto for refrence -->
<div class="slideshow-container " style="overflow: hidden;">

<div class="mySlides fade">
<?php
$SlideId = "1";
SlideShow();
?>
  <div class="numbertext">1 / 3</div>
  <img src="<?php echo $SlidePicture; ?>" style="float: left; width:60%; height:600px;">
  <h1 class="text" style=" font-size: 200%; color:#000000; right: 0px; padding-top: 5%; ">
    <?php echo $SlideName; ?>
  </h1>
  <h3 class="text" style="color:#000000; right: 0px; padding-top: 5%; ">
    <?php echo $SlideDescription; ?>
  </h3>
</div>

<div class="mySlides fade">
<?php
$SlideId = "2";
SlideShow();
?>
  <div class="numbertext">2 / 3</div>
  <img src="<?php echo $SlidePicture; ?>" style="float: left; width:60%; height:600px;">
  <h1 class="text" style="  font-size: 200%; color:#000000; right: 0px; padding-top: 5%; ">
    <?php echo $SlideName; ?>
  </h1>
  <h3 class="text" style="color:#000000; right: 0px; padding-top: 5%; ">
    <?php echo $SlideDescription; ?>
  </h3>
</div>


<div class="mySlides fade">
<?php
$SlideId = "3";
SlideShow();
?>
  <div class="numbertext">3 / 3</div>
  <img src="<?php echo $SlidePicture; ?>" style="float: left; width:60%; height:600px;">
  <h1 class="text" style="  font-size: 200%; color:#000000; right: 0px; padding-top: 5%; ">
    <?php echo $SlideName; ?>
  </h1>
  <h3 class="text" style="color:#000000; right: 0px; padding-top: 5%; ">
    <?php echo $SlideDescription; ?>
  </h3>
</div>


</div>
<br>

<div style="text-align:center">
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
</div>

<script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 5000); // Change image every 5 seconds
}
</script>

<!-- First event not manageg by database yet    https://dwcloud.tk/index.php/s/mLsskKD8QmTCFBz -->


<?php
$eventid = '1';
PullEvent();
?>
  <div class="home-events" style="margin-top: 40px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;">
    <img src=<?php echo "$EventPicture";?> style=" border: 3px solid #000000; float: left;margin-left:0%;width:30%;height:auto;border-radius:2%;height: auto;"> </img>
    <h2 style=" text-align: center; margin-left:1%; width: 0px auto;"> <?php echo  "$EventName" ; ?> </h2>
    <h2 style=" padding-bottom: 5% ; text-align: center; padding-top: 5%; padding-left:20%; padding-right:5%; "> <?php echo "$EventDescription";?></h2>
    <?php
    $button = "<a href=\"https://nest.ramfield.net/activity.php?id=$eventid \">";
    $button .= "<button style=\"position: absolute; right: 0px; bottom: 0px; margin-top: 4%; float: right;\" type=\"submit\" class=\"btn-login\" name=\" More Info \" > More Info </button>";
    $button .= "</a>";
    echo $button;
    ?>
    </div>
<!-- EVENT 2 -->
<?php
$eventid = '2';
PullEvent();
?>
  <div class="home-events" style="margin-top: 40px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;">
    <img src=<?php echo "$EventPicture";?> style=" border: 3px solid #000000; float: right;margin-left:0%;width:30%;height:auto;border-radius:2%;height: auto;"> </img>
      <h2 style=" text-align: center; margin-left:1%; width: 0px auto;"> <?php echo  "$EventName" ; ?> </h2>
      <h2 style="text-align: left; padding-top: 3%; padding-left:5%; padding-right:20%; "> <?php echo "$EventDescription";?>
      </h2>
      <?php
      $button = "<a href=\"https://nest.ramfield.net/activity.php?id=$eventid \">";
      $button .= "<button type=\"submit\" class=\"btn-login\" name=\" More Info \" > More Info </button>";
      $button .= "</a>";
      echo $button;
      ?>
    </div>
<!-- Event 3 -->
<?php
$eventid = '3';
PullEvent();
?>
<div class="home-events" style=" margin-top: 40px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;">
  <img src=<?php echo "$EventPicture";?> style=" border: 3px solid #000000; float: left;margin-left:0%;width:30%;height:auto;border-radius:2%;height: auto;"> </img>
  <h2 style=" text-align: center; margin-left:1%; width: 0px auto;"> <?php echo  "$EventName" ; ?> </h2>
  <h2 style=" padding-bottom: 5% ; text-align: center; padding-top: 5%; padding-left:20%; padding-right:5%; "> <?php echo "$EventDescription";?></h2>
  <?php
  $button = "<a href=\"https://nest.ramfield.net/activity.php?id=$eventid \">";
  $button .= "<button style=\"position: absolute; right: 0px; bottom: 0px; margin-top: 4%; float: right;\" type=\"submit\" class=\"btn-login\" name=\" More Info \" > More Info </button>";
  $button .= "</a>";
  echo $button;
  ?>
</div>
<!-- Event 4  -->
<?php
$eventid = '4';
PullEvent();
?>
  <div class="home-events" style="margin-top: 40px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;">
    <img src=<?php echo "$EventPicture";?> style=" border: 3px solid #000000; float: right;margin-left:0%;width:30%;height:auto;border-radius:2%;height: auto;"> </img>
      <h2 style=" text-align: center; margin-left:1%; width: 0px auto;"> <?php echo  "$EventName" ; ?> </h2>
      <h2 style="text-align: left; padding-top: 3%; padding-left:5%; padding-right:20%; "> <?php echo "$EventDescription";?>
      </h2>
      <?php
      $button = "<a href=\"https://nest.ramfield.net/activity.php?id=$eventid \">";
      $button .= "<button type=\"submit\" class=\"btn-login\" name=\" More Info \" > More Info </button>";
      $button .= "</a>";
      echo $button;
      ?>
    </div>
    <!-- Event 5 -->
    <?php
    $eventid = '5';
    PullEvent();
    ?>
    <div class="home-events" style=" margin-top: 40px; margin-bottom: 50px; overflow: hidden; margin-left: 10%; width: 80%;  height: auto;">
      <img src=<?php echo "$EventPicture";?> style=" border: 3px solid #000000; float: left;margin-left:0%;width:30%;height:auto;border-radius:2%;height: auto;"> </img>
      <h2 style=" text-align: center; margin-left:1%; width: 0px auto;"> <?php echo  "$EventName" ; ?> </h2>
      <h2 style=" padding-bottom: 5% ; text-align: center; padding-top: 5%; padding-left:20%; padding-right:5%; "> <?php echo "$EventDescription";?></h2>
      <?php
      $button = "<a href=\"https://nest.ramfield.net/activity.php?id=$eventid \">";
      $button .= "<button style=\"position: absolute; right: 0px; bottom: 0px; margin-top: 4%; float: right;\" type=\"submit\" class=\"btn-login\" name=\" More Info \" > More Info </button>";
      $button .= "</a>";
      echo $button;
      ?>
    </div>

    <!-- begining of test function -->


    <?php
    function PullEvent() {
      global $eventid, $EventDescription, $EventPicture, $EventName, $db;
      $query = " SELECT * FROM ListedEvents WHERE id = $eventid LIMIT 1" ;
      $result = mysqli_query($db, $query);
      $row = mysqli_fetch_array($result);
      $EventName = $row['Title'];
      $EventDescription = $row['Short_Description'];
      $EventPicture = $row['PictureUrl'];
    }





    function SlideShow() {
      global $SlideId, $SlideName, $SlideDescription, $SlidePicture, $db;
      $query = " SELECT * FROM SlideShow WHERE id = $SlideId" ;
      $Slide2 = mysqli_query($db, $query);
      $Slide = mysqli_fetch_array($Slide2);
      $SlideName = $Slide['Title'];
      $SlideDescription = $Slide['Description'];
      $SlidePicture = $Slide['Picture'];
    }
    ?>

    <!-- end of test function -->
    <div class="home-events" style="margin-top: 40px; overflow: hidden; margin-left: 0%; width: 100%;  height: 10%; padding-bottom: 3% ; " >
      <h3 style="color: #000000; text-align: center; ">
        Have feedback or an issue ? <a href="https://cloud.ramfield.net/apps/forms/XmPTc8JniqbFtzqm" style="color:blue; padding-top: 90px; "   >Click Here</a>
      </h3>
    </div>

</body>
</html>
