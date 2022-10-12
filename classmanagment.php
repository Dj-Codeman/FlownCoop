<?php
session_start();



for ($i = 0; $i < 300; $i++) {

      $advisory = $i;

      echo "Working on advisory $advisory";


      include('server.php');
      include('errors.php');


      $class = "SELECT * FROM StudentAccounts WHERE Advisory = '$advisory' AND Inclass = '0' ";
      $result = mysqli_query($db, $class);

      while ($row = mysqli_fetch_assoc($result)) {
            $uid = $row['uid'];
            $sid = $row['sid'];
            $FirstName = $row['FirstName'];
            $LastName = $row['LastName'];
            $email = $row['email'];
            $username = $row['username'];
            $total = $row['totals'];
            $media = $row['media'];
            $addclass = "INSERT INTO Class_$advisory (uid, FirstName, LastName, username, email, sid, totals, media )
        VALUES('$uid', '$FirstName', '$LastName', '$username', '$email', '$sid', '$total', '$media')";
            mysqli_query($db, $addclass);
            $classstatus = " UPDATE StudentAccounts SET Inclass = '1' WHERE uid = '$uid' ";
            mysqli_query($db, $classstatus);

            echo "Student added $FirstName";
            echo "</br>";
      }
}
?>