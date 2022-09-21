<?php
session_start();
include('server.php');
$db = mysqli_connect('192.168.0.3', 'Client', 'Y&0E1{8u){S?', 'Nest');

		for($x = 0; $x <= 300; $x++){

      echo "Working on number $x";
      adv_list("remove", $x);

    }


?>
