<?php
$array = array();
for ($k=0; $k<1000; $k++){
for ($i=0; $i<1000; $i++)
{

  $db = mysqli_connect('localhost', 'Client', 'Y&0E1{8u){S?', 'Nest');
   $UID = MD5(uniqid());
   echo $UID;
   echo "</br>";
   $query = "UPDATE LoggedEvents SET uid = '$UID' WHERE id = '$i' ";
   mysqli_query($db, $query);
}

}
echo 'DONE';
?>
