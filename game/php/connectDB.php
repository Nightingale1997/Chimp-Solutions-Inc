<?php

/**
* Database connection
* 
* Function to connect to the database*
*/

?>

<?php
function connect(){
$con = new mysqli("chimpsolutions.se.mysql","chimpsolutions_sebananadb","ixduniverseum","chimpsolutions_sebananadb") or die("Connection failed: %s\n".$con->error);
mysqli_set_charset($con,'utf8'); //sÃ¤tter teckenkod utf8
return $con;
}

function disconnect($con) {
    $con->close();
} 
?>
