<?php
function locate($base)
{
    if (!empty($base)) {
        relax();
        echo "base imported \n";
    }
    else {
        echo "Base not provided sourcing ...";
        $base = $_SESSION['sid'];

        if (!empty($base)) {
            echo "base sourced";
            relax();
        } else {
            echo "no base provided";
            exit;
        }
    }
    $basedir = "uploads/$base/";
    return $basedir;
}
?>