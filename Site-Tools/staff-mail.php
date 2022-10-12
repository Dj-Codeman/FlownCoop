<?php

$from = 'noreply@dwcloud.tk';
$subject = 'Account Activation Required';
$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
$headers .= "Bcc: darrionjw@outlook.com\r\n";
$activate_link = 'https://www.audubonnest.tk/staff-activate.php?email=Jackelhx@milwaukee.k12.wi.us&code=5ff3413e9a8e4';
$message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
$message .= "Your password is: Wl672Mlh8QtW </br>";
$message .= 'Please do not reply to this email.';
mail('Jackelhx@milwaukee.k12.wi.us', $subject, $message, $headers);

?>