<?php
session_start();
include('server.php');

for ($x = 0; $x <= 300; $x++) {

  echo "Working on number $x";
  adv_list("remove", $x);

}


?>