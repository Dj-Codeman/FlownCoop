<?php
# This is the beginning of the debugging script 
# there will be some comments placed to help add whats need to support 
# the code that youre running 


# ? What if any file need to be included
include('server.php');


# ? What variables need to be set

$env = "Debuging";

function check_enviornment() {
    global $env;

    echo $env;

    if ( "$env" == "Debugging" ) {
        $enviornment = "Debugging";
    } elseif ( "$env" == "Production" ) {
        $enviornment = "Production";
    } else {
        $enviornment = "Liminal";
    }
    echo "The enviornment has been defined. Proceed";
    // sleep('5');
}

check_enviornment();
var_dump($env);

?>