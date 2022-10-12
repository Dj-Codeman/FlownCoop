<?php
include('server.php')?>

<!DOCTYPE html>
<html>

<head>
	<title>Nest Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="header-login">
		<h2>Staff Login</h2>
	</div>

	<form method="post" action="staff-login.php">
		<?php include('errors.php'); ?>
		<div class="input-group">
			<label>Email</label>
			<input type="text" name="email">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn-login" name="login_staff">Login</button>
		</div>
		<p>
			Student? Log in here <a href="login.php">Student Login</a>
		</p>
	</form>
</body>

</html>