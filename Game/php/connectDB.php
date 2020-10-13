<?php

/**
* Database connection
* 
* Function to connect to the database*
*/

?>

<?php
function connect(){
$con = new mysqli("localhost","root","","chimpSolutions_db") or die("Connection failed: %s\n".$con->error);
mysqli_set_charset($con,'utf8'); //sÃ¤tter teckenkod utf8
return $con;
}

function disconnect($con) {
    $con->close();
} 
?>