<?php session_start();
if(isset($_SESSION['user'])){?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/game.css">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <title>Game</title>
</head>
<body>
    <header>
        <div class="border"></div>
        <div class="navbar">
            <div class="buttons">
                <input type="button" id="about" class="button" value="About">
                <input type="button" id="ruleofgame" class="button" value="Rules of games" style="background-color:#F2E9E4;" onclick="window.location.href='rules.php'">
                <input type="button" id="scorecard" class="button" value="Score card" style="background-color:#F2E9E4;" onclick="window.location.href='scorecard.php'">
                <input type="button" id="log-sign" class="button" value="Login/Signup">
                <img src="images/profile.png" alt="profile" id="profile" onclick="window.location.href='images/profile.php'">
            </div>
        </div>
    </header>
    <content>
        <div class="head">
            <div id="div-logo"><img src="logo.jpeg" alt="logo" id="logo"></div>
            <div id="topic">Tic-Tac-Toe:</div>
        </div>
        <div id="msg-container">
            <div id="msg"></div>
        </div>
        <div class="gamecontent">
            <div id="player1">
                <img src="profilemale.png" alt="play1" id="play1">
                <div id="play1_name"><?php echo $_SESSION['user'];?></div>
                <div>
                    match record:<br>
                    total <input type="number" id="totalp1" name="totalp1" value="0" readonly><br>
                    wins <input type="number" id="winp1" name="winp1" value="0" readonly> <br>
                    lost <input type="number" id="lostp1" name="winp1" value="0" readonly><br>
                </div>
            </div>
            <div class="game">
                <button class="box" id="box0"  onclick="boxclick('0');"></button>
                <button class="box" id="box1"  onclick="boxclick('1');"></button>
                <button class="box" id="box2"  onclick="boxclick('2');"></button>
                <button class="box" id="box3"  onclick="boxclick('3');"></button>
                <button class="box" id="box4"  onclick="boxclick('4');"></button>
                <button class="box" id="box5"  onclick="boxclick('5');"></button>
                <button class="box" id="box6"  onclick="boxclick('6');"></button>
                <button class="box" id="box7"  onclick="boxclick('7');"></button>
                <button class="box" id="box8"  onclick="boxclick('8');"></button>
            </div>
            <div id="player2">
                <img src="images/profilefemale.png" alt="play1" id="play2">
                <div id="play2_name"> </div>
                <div>
                    match record:<br>
                    total <input type="number" id="totalp2" name="totalp2" value="0" readonly> <br>
                    wins <input type="number" id="winp2" name="winp1" value="0" readonly> <br>
                    lost <input type="number" id="lostp2" name="winp2" value="0" readonly><br>
                </div>
            </div>
        </div>
        <div class="restart">
            <input type="submit" name="button" class="restat" value="Restart Game" onclick="reset();">
        </div> 
        
    
    </content>
    <footer id="footer">
        <div></div>
    </footer>
    <script src="js/game.js?ver=4.3"></script>
</body>
</html>
<?php } else { 
  header("Location: login.php");
} ?>