<?php
    /**
    * Saves highscores
    */
    require "connectDB.php";
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
        echo "no data available";
        
    }
    $sql_highscore = "SELECT * FROM highscore ORDER BY score DESC, time";
        if ($result = mysqli_query($con, $sql_highscore)) {
            echo " ^^ " ;
         } 
        else 
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
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
            echo " ^__^ " ;
         } 
        else 
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
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
<link rel="stylesheet" src="css/styles.css">
<TITLE>Your Title Here</TITLE>

</HEAD>

<BODY BGCOLOR="FFFFFF">

<div id="view"> 
        <div id="container">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Time</th>
                </tr>
            <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
            ?>
                    <tr>
                        <th><?php echo $row["name"]?></th>
                        <th><?php echo $row["score"]?></th>
                        <th><?php echo $row["time"]?></th>
                    </tr>  

                <?php } 
             }
             else {
                 echo "no table";
             } ?>
            </table>
            <br>
            <br>
            <table>
                <tr>
                    <th>Level</th>
                    <th>Number of People</th>
                </tr>
            <?php
                if ($levelList > 0) {
                    $levNum = 1;
                    foreach($levelList as $value) {
                        
            ?>
                    <tr>
                        <th><?php echo $levNum?></th>
                        <th><?php echo $value?></th>
                    </tr>  
                <?php   
                $levNum +=1; 
                    }
                }
                ?>
            </table>
        </div>
 </div>    





<HR>

<a href="http://somegreatsite.com">Link Name</a>

is a link to another nifty site

    <H1>ChimpSolutions</H1>

<H2>This is a Medium Header</H2>

Send me mail at <a href="mailto:support@yourcompany.com">

support@yourcompany.com</a>.

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<P> This is a new paragraph!

<P> <B>This is a new paragraph!</B>

<BR> <B><I>This is a new sentence without a paragraph break, in bold italics.</I></B>

<HR>

</BODY>

</HTML>
