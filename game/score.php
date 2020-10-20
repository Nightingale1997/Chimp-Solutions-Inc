<?php
    /**
    * Saves highscores
    */
    require "php/connectDB.php";
    $con = connect(); //Connects to Database


    $scoreCheck = false;
    $gameCheck = false;

    
    if (isset($_POST['round']) && !empty($_POST['round']))
    {
        $score = (int) $_POST['round'];
        $score -=1;
        
        //echo "<p class='test'>round received ".$score."</p>";
        //$score = mysqli_real_escape_string($con, $score);
        $scoreCheck = true;
        $gameCheck = true;
    }

 /**
  * right now, only inserting score
 */

    if ($scoreCheck)
    {
        $sql = "INSERT INTO highscore(score) VALUES('$score')";
        mysqli_query($con, $sql);
    }
    else
    {
  //      echo "no data available";
        
    }
    $sql_highscore = "SELECT * FROM highscore ORDER BY score DESC";
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

        $sql_levelscore = "SELECT score_id, score FROM highscore ORDER BY score DESC";
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
        } 




        // echo gmdate("H:i:s", 685); //converts seconds into 


    disconnect($con);

?>

<html>

<head>
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/site.webmanifest">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <title>Chimp Solutions</title>
    <meta name="description" content="Go bananas!">
    <meta name="author" content="Chimp Solutions">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body id=resultsBackground>
    <h1 id="resultsTitle">DITT RESULTAT:</h1>

    <article class="logContainer" id="container1">
        <img src="img/L1.png" id="log1">
        <p class="levelText" id="text1">NIVÅ 1</p>
        <p class="levels" id="level1"><?php echo $levelList[0];?></p> 
        <img src="img/humans.png" class="humansIcon" id="human1">
    </article>


    <article class="logContainer" id="container2">
        <img src="img/L2.png" class="logs" id="log2">
        <p class="levelText" id="text2">NIVÅ 2</p>
        <p class="levels" id="level2"><?php echo $levelList[1];?></p>
        <img src="img/humans.png" class="humansIcon" id="human2">
    </article>

    <article class="logContainer" id="container3">
        <img src="img/L3.png" class="logs" id="log3">
        <p class="levelText" id="text3">NIVÅ 3</p>
        <p class="levels" id="level3"><?php echo $levelList[2];?></p>
        <img src="img/humans.png" class="humansIcon" id="human3">
    </article>

    <article class="logContainer" id="container4">
        <img src="img/L4.png" class="logs" id="log4">
        <p class="levelText" id="text4">NIVÅ 4</p>
        <p class="levels" id="level4"><?php echo $levelList[3];?></p>
        <img src="img/humans.png" class="humansIcon" id="human4">
    </article>

    <article class="logContainer" id="container5">
        <img src="img/L5.png" class="logs" id="log5">
        <p class="levelText" id="text5">NIVÅ 5</p>
        <p class="levels" id="level5"><?php echo $levelList[4];?></p>
        <img src="img/monkey banana.png" id="scoreAyumu">
        <img src="img/humans.png" class="humansIcon" id="human5">
    </article>

    <p class="playerPosition" id="player1">
        <?php 
       if($gameCheck && $currentPlayer[1] == 1){
           echo "DU";
       }
       ?></p>


    <p class="playerPosition" id="player2"><?php 
       if($gameCheck && $currentPlayer[1] == 2){
           echo "DU";
       }
       ?></p>


    <p class="playerPosition" id="player3"><?php 
       if($gameCheck && $currentPlayer[1] == 3){
           echo "DU";
       }
       ?></p>


    <p class="playerPosition" id="player4"><?php 
       if($gameCheck && $currentPlayer[1] == 4){
           echo "DU";
       }
       ?></p>



    <p class="playerPosition" id="player5"><?php 
       if($gameCheck && $currentPlayer[1] == 5){
           echo "DU";
       }
       ?></p>

    <a href="./index.html"> 
        <img src="img/try again.png" id="retry">
    </a>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
