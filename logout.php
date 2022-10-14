<?php
session_start();
require('locker/locker.php');
$sid = $_SESSION['sid'];
locker_trim($sid);
locker_lock($sid);
session_destroy();
// Redirect to the login page:
header('Location: login.php');
?>