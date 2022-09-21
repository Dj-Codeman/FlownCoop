<?php
$uniqid = MD5(uniqid());
$target_dir = "uploads/";
$target_file = "$target_dir $uniqid.txt";
$filename = $target_file;
if (touch($filename)) {
    echo $filename . ' modification time has been changed to present time';
} else {
    echo 'Sorry, could not change modification time of ' . $filename;
}
?>
