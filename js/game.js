        var currentNumber = 0;
        var level = 1;

        $("#playButton").on('click tap', function () {
            $("#overlay").css("z-index:0;");
            $("#overlay").fadeOut();
            
            if (currentNumber == 0) {
                setNumbers();
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

        function loss() {
            var audio = new Audio('audio/loss.mp3');
            audio.play();
            $("#overlayTitle").text("Failed at round " + level);
            $("#playButton").text("Play again");
            resetGame();
            level = 1;
        }

        function victory() {
            var audio = new Audio('audio/victory.mp3');
            audio.play();
            $("#overlayTitle").text("Passed round " + level);
            $("#playButton").text("Continue");
            resetGame();
        }

        //Resets game by removing all white tiles and emptying contents of every tile
        function resetGame() {
            $(".content").removeClass("whiteTile").html("");
            currentNumber = 0;
            $("#overlay").fadeIn();
            $("#overlay").css("z-index:2;");
        }

        function setNumbers() {
            var i;
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
