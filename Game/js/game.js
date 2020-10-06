        var currentNumber = 0;
        var level = 1;
        var idle = true;



        $("body").on('click tap', function () {
            if (idle == true) {
                idle = false;


                $("#overlay").css("z-index:0;");
                $("body").addClass("gameBackground");

                $("#gameTiles").fadeIn();
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
                            level++;
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
                        resetGame();
                    }
                }

            }

        });

        function moveJungle() {
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
            var audio = new Audio('audio/loss.mp3');
            audio.play();
            $("#overlayTitle").text("Failed at round " + level);
            $("#playButton").text("Play again");
            level = 1;
            resetGame();

        }

        function countDown() {
            $("#overlay").fadeIn();
            $("#overlayTitle").hide();
            $("#playButton").hide();
            $("#countdown").text("3");
            $("#countdown").fadeIn();
            //Count down from 3
            setTimeout(function () {
                $("#countdown").text("2");
                setTimeout(function () {
                    $("#countdown").text("1");
                    setTimeout(function () {
                        $("#countdown").hide();
                        setNumbers();

                    }, 1000);
                }, 1000);
            }, 1000);
        }

        function victory() {

            var audio = new Audio('audio/victory.mp3');
            audio.play();
            $("#overlayTitle").text("Passed round " + level);
            $("#playButton").text("Continue");

            resetGame();

            countDown();


        }

        //Resets game by removing all white tiles and emptying contents of every tile
        function resetGame() {
            $(".content").removeClass("whiteTile").html("");
            currentNumber = 0;

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
            }, 200);

        }
