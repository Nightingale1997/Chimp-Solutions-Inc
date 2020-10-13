<?php
    /**
    * Saves highscores
    */
    require "php/connectDB.php";
    $con = connect(); //Connects to Database

    $nameCheck = false;
    $scoreCheck = false;
    $timeCheck = false;

    if (isset($_GET['name']) && !empty ($_GET['name']))
    {
       $name = $_GET['name']; 
       $name = mysqli_real_escape_string($con, $name);
       $nameCheck = true;
    }
    
    if (isset($_GET['score'])&& !empty ($_GET['score']))
    {
       $score = $_GET['score'];
       $score = mysqli_real_escape_string($con, $score);
       $scoreCheck = true;
    }

    if (isset($_GET['time'])&& !empty ($_GET['time']))
    {
       $time = $_GET['time'];
       $time = mysqli_real_escape_string($con, $time);
       $timeCheck = true;
    }

    if ($nameCheck && $scoreCheck && $timeCheck)
    {
        $sql = "INSERT INTO highscore(name, score, time) VALUES($name, $score, $time)";
    
        

    }
    else
    {
  //      echo "no data available";
        
    }
    $sql_highscore = "SELECT * FROM highscore ORDER BY score DESC, time";
        if ($result = mysqli_query($con, $sql_highscore)) {
            //echo " ^^ " ;
         } 
        else 
        {
         //   echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    
        /**
         * 9 variables in which you store the number of people who have made it to each level
         * 2 variables to show the current player's level and time
         */

        /**
         *  $levelList is an array that contains the value of the total number of people to have achieved each level.
         * The index numbers in the array represent the level, so index 0 is level 1
         */
        
        $levelList = array(0,0,0,0,0,0,0,0,0);

        $sql_levelscore = "SELECT score_id, score FROM highscore ORDER BY score DESC, time";
        if ($result2 = mysqli_query($con, $sql_levelscore)) {
           // echo " ^__^ " ;
         } 
        else 
        {
           // echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

        if (mysqli_num_rows($result2) > 0) {

            while($listRow = mysqli_fetch_assoc($result2)) {
                $levelList[$listRow["score"]-1] += 1;
            } 
        }

        /**
         * Fetches the current player's data from the database and stores the row in the $currentPlayer variable. 
         * The current player is identified with having the highest ID number
         */
        $sql_currentPlayer = "SELECT * FROM highscore WHERE score_id = (SELECT MAX(score_id)
        FROM highscore)";
        $currentPlayer = mysqli_query($con, $sql_currentPlayer);



        // echo gmdate("H:i:s", 685); //converts seconds into 


    disconnect($con);

?>

<HTML>
<HEAD>
<link rel="stylesheet" href="css/styles.css?v=1.0">
<TITLE>Your Title Here</TITLE>

</HEAD>

<BODY id=resultsBody>
<h1 id="resultsTitle">DINA RESULTAT:</h1>
<img src="img/L1.png" class="logs" id="log1">
<img src="img/L2.png" class="logs" id="log2">
<img src="img/L3.png" class="logs" id="log3">
<img src="img/L4.png" class="logs"  id="log4">
<img src="img/L5.png" class="logs" id="log5">
<div id="view"> 
        <div>
           
        </div>
 </div>    





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/scripts.js">
 
</BODY>

</HTML>
