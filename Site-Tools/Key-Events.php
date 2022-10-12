<?php
$array = array();
for ($k = 0; $k < 1000; $k++) {
  for ($i = 0; $i < 1000; $i++) {

    include('../server.php');
    $UID = MD5(uniqid());
    echo $UID;
    echo "</br>";
    $query = "UPDATE LoggedEvents SET uid = '$UID' WHERE id = '$i' ";
    mysqli_query($db, $query);
  }

}
echo 'DONE';
?>