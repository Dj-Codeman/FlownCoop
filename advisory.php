<?php
include('server.php');

echo "Working";
$advisory = "112";

$class = "CREATE TABLE IF NOT EXISTS Nest.Class_$advisory (
        id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        FirstName VARCHAR(255) NOT NULL,
        LastName VARCHAR(255) NOT NULL,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        sid VARCHAR(255) NOT NULL,
        totals VARCHAR(255) NOT NULL
)";
mysqli_query($db, $class);


?>