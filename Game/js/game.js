        var currentNumber = 0;
        var level = 1;
        var round = 1;
        var idle = true;
        var sound = true;
        var tiles = 0;
        var startTime, endTime;
        var timeArray = new Array();


        $("#soundSwitch").on('click tap', function () {
            if (sound) {
                sound = false;
                $("#soundSwitch").attr('src', 'img/soundoff.png');
            } else {
                sound = true;
                $("#soundSwitch").attr('src', 'img/soundon.png');
            }


        });


        $("body").on('click tap', function (evt) {
            if (evt.target.id == "soundSwitch")
                return;

            if (idle == true) {
                idle = false;


                $("#overlay").css("z-index:0;");
                $("body").addClass("gameBackground");


                //  $("#chimpOverlay").fadeOut();
                moveJungle();
            } else {

            }


        });




        $("#playButton").on('click tap', function () {
            $("#overlay").css("z-index:0;");
            $("body").addClass("gameBackground");



            if (currentNumber == 0) {
                countDown();
            }


        });



        $(".content").on('click tap', function (e) {
            //Ignore click if game hasn't started
            if (currentNumber != 0) {


                //Find pressed tile
                var pressedTile = $(e.target);
                console.log($(e.target));
                //Check if tile has a number
                logTime();
                if ($(pressedTile).text().length > 0) {

                    //Check if the number is the correct number

                    if (parseInt(pressedTile.text()) == currentNumber) {
                        $(pressedTile).html("").removeClass("whiteTile");
                        currentNumber++;

                        console.log(currentNumber);
                        console.log(level);
                        console.log(currentNumber > level);
                        if (currentNumber > level) {
                            victory();
                            level += 2;
                            round++;
                        }
                        /*
                        //Hide numbers after first is pressed
                        else if (currentNumber == 2) {
                            $(".content").each(function () {
                                if ($(this).text().length > 0) {
                                    $(this).addClass("whiteTile");
                                }
                            });
                        }
                        */
                    } else {
                        loss();
                    }
                }

            }

        });

        function moveJungle() {
            if (sound) {
                var audio = new Audio('audio/gamestart.mp3');
                audio.play();
            }
            $("#jungleTopRight").addClass("jungleTopRightAnimation");
            $("#jungleTopLeft").addClass("jungleTopLeftAnimation");
            $("#jungleBottomRight").addClass("jungleBottomRightAnimation");
            $("#jungleBottomLeft").addClass("jungleBottomLeftAnimation");
            $("#ayumu").fadeOut();
            $("#startTitle").fadeOut();
            setTimeout(function () {
                countDown();
                $("#chimpOverlay").fadeOut();
            }, 1000);


        }

        function loss() {
            console.log(round);
            for (i = 1; i < (round + 1); i++) {
                tiles += 1 + ((i - 1) * 2);
            }
            tiles -= (level - (timeArray.length - 1));
            $("#time").attr('value', "'" + timeArray[timeArray.length - 1] + "'");
            $("#tiles").attr('value', "'" + tiles + "'");
            $("#scoreButton").fadeIn();
            if (sound) {
                var audio = new Audio('audio/loss.mp3');
                audio.play();
            }




            $("#overlayTitle").text("FAILED AT ROUND " + round + " YOU GOT " + (timeArray.length - 1) + "/" + level + " IN " + timeArray[timeArray.length - 1] + " SECONDS");
            $("#playButton").text("PLAY AGAIN");
            level = 1;
            round = 1;
            tiles = 0;
            resetGame();

        }





        function countDown() {
            $("#overlay").fadeIn();
            $("#overlayTitle").hide();
            $("#playButton").hide();
            $("#countdown").text("3");
            $("#countdown").fadeIn();
            //Count down from 3
            if (sound) {
                var audio = new Audio('audio/countdown.mp3');
                audio.play();
            }
            setTimeout(function () {
                $("#gameTiles").fadeIn(2000);
                $("#countdown").text("2");
                if (sound) {
                    var audio = new Audio('audio/countdown.mp3');
                    audio.play();
                }
                setTimeout(function () {
                    if (sound) {
                        var audio = new Audio('audio/countdown.mp3');
                        audio.play();
                    }
                    $("#countdown").text("1");
                    setTimeout(function () {
                        if (sound) {
                            var audio = new Audio('audio/countdownend.mp3');
                            audio.play();
                        }
                        $("#countdown").hide();
                        setNumbers();
                        $("#overlay").fadeOut();

                    }, 1000);
                }, 1000);
            }, 1000);
        }

        function victory() {

            if (sound) {
                var audio = new Audio('audio/victory.mp3');
                audio.play();
            }
            $("#overlayTitle").text("Passed round " + round);
            $("#playButton").text("Continue");



            resetGame();
            countDown();


        }

        //Resets game by removing all white tiles and emptying contents of every tile
        function resetGame() {
            $(".content").removeClass("whiteTile").html("");
            currentNumber = 0;
            timeArray = new Array();
            $("#overlay").fadeIn();
            $("#overlayTitle").fadeIn();
            $("#playButton").fadeIn();
            $("#overlay").css("z-index:2;");
        }

        function setNumbers() {
            var i;
            //Add amount of numbers equal to current level
            for (i = 0; i < level; i++) {
                //Randomize row and column
                row = Math.floor(Math.random() * 5) + 1;
                column = Math.floor(Math.random() * 8);

                //Translate row to corresponding ID
                switch (row) {
                    case 1:
                        row = "#rowOne";
                        break;
                    case 2:
                        row = "#rowTwo";
                        break;
                    case 3:
                        row = "#rowThree";
                        break;
                    case 4:
                        row = "#rowFour";
                        break;
                    case 5:
                        row = "#rowFive";
                        break;
                }

                //Select the row, then the column and finally the inner div
                chosenSquare = $(row).children('div').eq(column).children('div').eq(0);

                if ($(chosenSquare).text().length > 0) {
                    //If this box already has a number, randomize again
                    i--;
                } else {
                    //Put the current number in the box
                    $(chosenSquare).html((i + 1).toString());
                }
            }
            //Start
            currentNumber = 1;
            hideNumbers();
        }

        function hideNumbers() {

            setTimeout(function () {
                $(".content").each(function () {
                    if ($(this).text().length > 0) {
                        $(this).addClass("whiteTile");
                    }
                });
                startTimer();
            }, 200);

        }

        function startTimer() {
            startTime = new Date();
        };

        function logTime() {
            endTime = new Date();
            var timeDiff = endTime - startTime; //in ms
            // strip the ms
            timeDiff /= 1000;

            // get seconds 
            var seconds = Math.round(timeDiff);
            timeArray.push(seconds);
        }
