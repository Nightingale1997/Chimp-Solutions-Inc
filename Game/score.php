<?php
    /**
    * Saves highscores
    */
    require "php/connectDB.php";
    $con = connect(); //Connects to Database

    $nameCheck = false;
    $scoreCheck = false;
    $timeCheck = false;
    
    if (isset($_GET['round'])&& !empty ($_GET['round']))
    {
       $score = $_GET['round'];
       $score = mysqli_real_escape_string($con, $score);
       $scoreCheck = true;
    }

    if (isset($_GET['time'])&& !empty ($_GET['time']))
    {
       $time = $_GET['time'];
       $time = mysqli_real_escape_string($con, $time);
       $timeCheck = true;
    }
 /**
  * right now, only inserting score
 */

    if ($scoreCheck)
    {
        $sql = "INSERT INTO highscore(score, time) VALUES($score, 00:00:01)";

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
        
        $levelList = array(0,0,0,0,0);

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
        $cP = mysqli_query($con, $sql_currentPlayer);
        $currentPlayer = array();
        while($playerInfo = mysqli_fetch_assoc($cP)) {
            $currentPlayer[0] = $playerInfo["score_id"];
            $currentPlayer[1] = $playerInfo["score"];
            $currentPlayer[2] = $playerInfo["time"];
        } 




        // echo gmdate("H:i:s", 685); //converts seconds into 


    disconnect($con);

?>

<HTML>
<HEAD>
<link rel="stylesheet" href="css/styles.css">
</HEAD>

<BODY id=resultsBackground>
<h1 id="resultsTitle">DINA RESULTAT:</h1>

    <img src="img/L1.png" class="logs" id="log1">
    <img src="img/L2.png" class="logs" id="log2">
    <img src="img/L3.png" class="logs" id="log3">
    <img src="img/L4.png" class="logs"  id="log4">
    <img src="img/L5.png" class="logs" id="log5">

    <p class="levelText" id="text1">NIVÅ 1</p>
    <p class="levels" id="level1"></p>
    <script>
        document.getElementById("level1").innerHTML = <?php echo $levelList[0]?>;
    </script>

    <p class="levelText" id="text2">NIVÅ 2</p>
    <p class="levels" id="level2"></p>
    <script>
        document.getElementById("level2").innerHTML = <?php echo $levelList[1]?>;
    </script>

    <p class="levelText" id="text3">NIVÅ 3</p>
    <p class="levels" id="level3"></p>
    <script>
        document.getElementById("level3").innerHTML = <?php echo $levelList[2]?>;
    </script>

    <p class="levelText" id="text4">NIVÅ 4</p>
    <p class="levels" id="level4"></p>
    <script>
        document.getElementById("level4").innerHTML = <?php echo $levelList[3]?>;
    </script>

    <p class="levelText" id="text5">NIVÅ 5</p>
    <p class="levels" id="level5"></p>
    <script>
        document.getElementById("level5").innerHTML = <?php echo $levelList[4]?>;
    </script>

    <img src="img/monkey banana.png" id="ayumu">


    
    <img src="img/humans.png" class="humansIcon" id="human1">
    <img src="img/humans.png" class="humansIcon" id="human2">
    <img src="img/humans.png" class="humansIcon" id="human3">
    <img src="img/humans.png" class="humansIcon" id="human4">
    <img src="img/humans.png" class="humansIcon" id="human5">
  
    <p class = "playerPosition" id="player1">DU</p>
    <script type="text/javascript">
            if (<?php echo $currentPlayer[1]?> == 1) {
                document.getElementById("player1").style.display = initial;
            }
    </script>


    <p class = "playerPosition" id="player2">DU</p>
    <script type="text/javascript">
            if (<?php echo $currentPlayer[1]?> == 2) {
                document.getElementById("player2").style.display = initial;
            }
    </script>


    <p class = "playerPosition" id="player3">DU</p>
    <script type="text/javascript">
            if (<?php echo $currentPlayer[1]?> == 3) {
                document.getElementById("player3").style.display = "initial";
            }
    </script>


    <p class = "playerPosition" id="player4">DU</p>
    <script type="text/javascript">
            if (<?php echo $currentPlayer[1]?> == 4) {
                document.getElementById("player4").style.display = initial;
            }
    </script>


    <p class = "playerPosition" id="player5">DU</p>
    <script type="text/javascript">
            if (<?php echo $currentPlayer[1]?> == 5) {
                document.getElementById("player5").style.display = initial;
            }
    </script>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="js/scripts.js">
 
</BODY>

</HTML>
