<?php include('server.php')?>
<!DOCTYPE html>
<html>

<head>
	<title>Nest Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="header-login">
		<h2>Student Login</h2>
	</div>

	<form method="post" action="login.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Username</label>
			<input type="text" name="username">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn-login" name="login_student">Login</button>
		</div>
		<p>
			Not yet a member? <a href="register.php">Sign up</a>
		</p>
		<p>
			Staff? Log in here <a href="staff-login.php">Staff Login</a>
		</p>
	</form>
</body>

</html>