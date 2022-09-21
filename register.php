<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Nest Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header-login">
  	<h2>Register</h2>
  </div>

  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
	<!-- First Name -->
	<div class="input-group">
  	  <label>First Name</label>
  	  <input type="text" name="FirstName" value="<?php echo $FirstName; ?>">
  	</div>
	<!-- Last Name -->
	<div class="input-group">
  	  <label>Last Name</label>
  	  <input type="text" name="LastName" value="<?php echo $LastName; ?>">
  	</div>
	<!-- username -->
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>
	<!-- advisory number -->
	<div class="input-group">
  	  <label>Advisory Number</label>
  	  <input type="text" name="advisory" value="<?php echo $advisory; ?>">
  	</div>
	<!-- Student id -->
	<div class="input-group">
  	  <label>Student Id</label>
  	  <input type="text" name="sid" value="<?php echo $sid; ?>">
  	</div>
	<!-- Other stuff  -->
  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>
  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn-login" name="reg_student">Register</button>


  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>
