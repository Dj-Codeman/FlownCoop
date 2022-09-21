<?php

$remove = '-';
$replace = '';

$db = mysqli_connect('192.168.0.3', 'Client', 'Y&0E1{8u){S?', 'Nest');
$user_check_query = "SELECT sid FROM StudentAccounts ";
$result = mysqli_query($db, $user_check_query);

while($row = mysqli_fetch_array($result)) {
  $user[] = $row['sid'];
}

foreach($user as $sid) {
  #### duration checking
    $duration_check_query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration)))
    FROM LoggedEvents WHERE sid = '$sid' and Credited = '1'";

    $result = mysqli_query($db, $duration_check_query);


    while($row1 = mysqli_fetch_array($result)) {
      $durations[] = $row1['SEC_TO_TIME(SUM(TIME_TO_SEC(duration)))'];
    }
      foreach ($durations as $raw_duration) {



      }

      $duration = str_replace("-", "", "$raw_duration");
      if($duration < 1 ) {$duration = '0';}
      echo "</br>  $sid, $duration" ;
      echo "</br>";
      $update_total_query = "UPDATE StudentAccounts SET totals = '$duration' WHERE sid = '$sid'";
      mysqli_query($db, $update_total_query);

    #####  pending check begin
    $query = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duration)))
    FROM Nest.LoggedEvents WHERE sid = '$sid'  AND credited = '0'";
    $result = mysqli_query($db, $query);
    while($row = mysqli_fetch_assoc($result)) {
    $pending = $row['SEC_TO_TIME(SUM(TIME_TO_SEC(duration)))'];
    $set_pending = "UPDATE StudentAccounts SET pending = '$pending' WHERE sid = '$sid'";
    mysqli_query($db, $set_pending);
  #  mysqli_query($db, "UPDATE LoggedEvents SET duration = '0' where deleted = '0'");
    echo "$set_pending";
    }
}

### pending begin


?>
