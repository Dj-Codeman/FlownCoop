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
include('errors.php');

$db = mysqli_connect('192.168.0.3', 'Client', 'Y&0E1{8u){S?', 'Nest');

$class = "SELECT * FROM StudentAccounts WHERE Advisory = '$advisory' AND Inclass = '0' ";
$result = mysqli_query($db, $class);

while ($row = mysqli_fetch_assoc($result)) {
  $id = $row['id'];
  $sid = $row['sid'];
  $FirstName = $row['FirstName'];
  $LastName = $row['LastName'];
  $email = $row['email'];
  $username = $row['username'];
  $total = $row['totals'];
  $addclass = "INSERT INTO Class_$advisory (FirstName, LastName, username, email, sid, totals )
        VALUES('$FirstName', '$LastName', '$username', '$email', '$sid', '$total')";
  mysqli_query($db, $addclass);
  $classstatus = " UPDATE StudentAccounts SET Inclass = '1' WHERE id = '$id' ";
  mysqli_query($db, $classstatus);
}
?>