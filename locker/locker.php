<?php
// list throught folder 

// $files

// Session need to contain 
// sid
// firstname
// lastname
// adv num
$photo = array(
    "1" => "jpg",
    "2" => "png",
    "3" => "jpeg",
    "4" => "gif",
    "5" => "heic",
);


function relax()
{
    shell_exec("echo \"HELLO OUT THERE\" > /dev/null");
}

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
    $basedir = "../uploads/$base/";
    return $basedir;
}


function locker_initialize($base)
{
    $basedir = locate($base);
    // Specifying the file types
    $Sfiles = glob("$basedir*.{jpg,png,jpeg,gif,heic}", GLOB_BRACE);
    foreach ($Sfiles as $Wfile) {

        $canonicalpath = $basedir;
        $canonicalpath .= $Wfile;

        if ($canonicalpath != "$basedir." && $canonicalpath != "$basedir..") {

            $oldfile = locker_san(realpath($canonicalpath));
            //  Cleanign the white spaces and underscore for encore compatibility
            // https://github.com/Dj-Codeman/encryption-core
            $newfile = item_san($oldfile);

            shell_exec("mv -v $oldfile $newfile");
        }
        else {
            relax();
        }

    }
}

// This should be ran on its own cronjob with an db tie in script
function locker_trim($base)
{
    $basedir = locate($base);
    locker_unlock($base);
    locker_destroy($base);
    shell_exec("bash /tmp/locker/read");
    shell_exec("bash /tmp/locker/destroy");
    shell_exec("rm -v $basedir*.ind");
    shell_exec("rm -v /tmp/locker/read");
    shell_exec("rm -v /tmp/locker/destroy");
    // locker_lock($base);
    // shell_exec("bash /tmp/locker/write");
    // shell_exec("rm -v /tmp/locker/read");

}


// Front facing actions
// locking and unlocking user directories 

function locker_lock($base)
{
    locker_initialize($base);
    $basedir = locate($base);
    $files = glob("$basedir*.{jpg,png,jpeg,gif,heic,HEIC,TIFF,tiff,raw,RAW}", GLOB_BRACE);
    foreach ($files as $file) {
        // do your thang 
        $fname = pathinfo($file, PATHINFO_FILENAME);
        $fext = pathinfo($file, PATHINFO_EXTENSION);

        // Formating for my shittily designed script
        $name = locker_san($fname);

        // ignore . dir and blank .. dir
        if ($name != "'.'" && $name != "''") {

            // making unique class name. retrivable by database entry
            $name = md5($name);

            // This section combines all all the individule parts we extracted to get a usable path while
            // retaining individule parts
            $fname = item_san($fname);
            
            $item = "./$basedir";
            $item .= "$fname";
            $item .= ".$fext";

            // Hopefully this is the part that encrypts it
            encore_write($item, $name, $base);
            shell_exec("touch $basedir$name.ind");
        }
        else {
            relax();
        }
    }
}


function locker_unlock($base)
{
    locker_initialize($base);
    $basedir = locate($base);
    // https://stackoverflow.com/questions/6155533/loop-code-for-each-file-in-a-directory
    $files = glob("$basedir*.ind", GLOB_ERR);
    foreach ($files as $file) {
        // do your thang 

        $string = str_replace(".ind", "", "$file");

        // Formating for my shittily designed script
        $name = locker_san($string);

        // ignore . dir and blank .. dir
        if ($name != "'.'" && $name != "''") {

            // The finishing touch. This should decrypt the file
            encore_read($base, $name, $base);
        }
        else {
            relax();
        }
    }
}


// THIS IS ONLY TO BE USED IN TRIM WHEN THE SATES OF THE FILES ARE KNOWN
// encore is kinda shitty the  LEAVE_IN_PEACE flag might not work
// if called when files arent decrypted, you run the risk of them
// being lost or destroyed 
function locker_destroy($base)
{
    locker_initialize($base);
    $basedir = locate($base);
    // https://stackoverflow.com/questions/6155533/loop-code-for-each-file-in-a-directory
    $files = glob("$basedir*.ind", GLOB_ERR);
    foreach ($files as $file) {
        // do your thang 

        $string = str_replace(".ind", "", "$file");

        // Formating for my shittily designed script
        $name = locker_san($string);

        // ignore . dir and blank .. dir
        if ($name != "'.'" && $name != "''") {

            // The finishing touch. This should decrypt the file
            encore_destroy($base, $name, $base);
        }
        else {
            relax();
        }
    }
}

//  Cleaning and formatting sections
function item_san($canonicalpath)
{
    $string = str_replace("'", "qt", "$canonicalpath");
    $string .= str_replace(" ", "", "$string");
    $string .= str_replace("_", "=", "$string");
    $string .= str_replace("(", "bx", "$string");
    return $string;
}

function locker_san($string)
{
    $string = "'$string'";
    return $string;
}

// encore queing
// The queue is used to keep the website moving quick
// while leaving this heavy job in the background
// if locker.sh was called by shell_exec instead of a seprate process
// php execeution would bee delayed till potintially thousands of pictures
// are processed!

function encore_destroy($base, $name, $class)
{
    $basedir = locate($base);
    $name = str_replace("'", "", "$name");
    $name = str_replace("$basedir", "", "$name");
    shell_exec("mkdir -pv /tmp/locker");
    shell_exec("touch /tmp/locker/destroy");
    $fappen = fopen('/tmp/locker/destroy', 'a');
    fwrite($fappen, "encore destroy $name $class \n");
    fclose($fappen);
}

function encore_write($item, $name, $class)
{
    //  writing the write commands to a queue thats ran every X
    shell_exec("mkdir -pv /tmp/locker");
    shell_exec("touch /tmp/locker/write");
    $fappen = fopen('/tmp/locker/write', 'a');
    $item = locker_san($item);
    fwrite($fappen, "encore write $item $name $class \n");
    fclose($fappen);

}

function encore_read($base, $name, $class)
{
    $basedir = locate($base);
    $name = str_replace("'", "", "$name");
    $name = str_replace("$basedir", "", "$name");
    shell_exec("mkdir -pv /tmp/locker");
    shell_exec("touch /tmp/locker/read");
    $fappen = fopen('/tmp/locker/read', 'a');
    fwrite($fappen, "encore read $name $class \n");
    fclose($fappen);
}

// integrated 
// locker_initialize("s8640418");


// locker_trim("s8640418");
// locker_trim("s9064462");
// locker_unlock("s8640418");
// locker_unlock("s9064462");
// locker_lock("s8640418");
// locker_lock("s9064462");
?>