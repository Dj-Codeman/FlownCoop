<?php

// echo "
// <!DOCTYPE html>
// <html>
// <head>
//
// <title> Staff Gen </title>
// ";
$uniqid = uniqid();
$staffid = MD5(uniqid());
$Password = "Dardar7816!";
$salt = random_int(7, 952018);
$newpassword = crypt($Password, $salt);

$sid = 's8615200';
$suid = MD5($sid);
echo "suid $suid";
echo "</br>";
echo "</br>";

echo "uid $uniqid";
echo "</br>";
echo "Staffid $staffid ";
echo "</br>";
echo "Salt $salt";
echo "</br>";
echo "Password $newpassword";
echo "</br>";
?>