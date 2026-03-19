<?php session_start();
if(isset($_SESSION['user'])){?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <title>Rules for the game</title>
</head>
<body>
    <header>
        <div class="border"></div>
        <div class="navbar">
            <div class="buttons">
                <input type="button" id="about" class="button" value="About" onclick="window.location.href='indexafterlogin.php'">
                <input type="button" id="ruleofgame" class="button" value="Rules of games" style="background-color:white;" onclick="window.location.href='rule.php'">
                <input type="button" id="scorecard" class="button" value="Score card" style="background-color:#F2E9E4;" onclick="window.location.href='score.php'">
                <input type="button" id="log-sign" class="button" value="Login/Signup" onclick="window.location.href='signup.php'">
                <img src="profile.png" alt="profile" id="profile" onclick="window.location.href='Profile.php'">
            </div>
        </div>
    </header>
    <content>
        <div class="head">
            <div id="div-logo"><img src="logo.jpeg" alt="logo" id="logo"></div>
            <div id="topic">Rules of the game : </div>
        </div>
        <div id="rule">
            <div class="head-content">
                <div id="name">Tic-Tac-Toe</div>
                <div id="button-head"><input type="button" id="playnow" class="button" value="Play Now" onclick="window.location.href='Game.php'"></div>
            </div>
            <p class="rulescontent">
                <b>Players:</b><br><p id="cont">Two players</p><br>
                <b>Objective:</b><br><p id="cont">Be the first player to get three of your marks (X or O) in a row, horizontally, vertically, or diagonally.</p><br>
                <b>Setup:</b><br><ul>
                <li>Draw a 3x3 grid on paper, a board, or use a dedicated Tic Tac Toe game.</li>
                <li>Players choose their symbol, X or O. Traditionally, X goes first.</li></ul><br>
                <b>Gameplay:</b><br><ul>
                    <li>Players take turns marking empty squares on the grid with their chosen symbol.</li>
                    <li>Once a square is marked, it cannot be played on again.</li>
                    <li>The game continues until one player achieves a line of three or all nine squares are filled.</li></ul>
                <br>
                <b>Winning:</b><br><ul>
                    <li>The player who achieves a line of three of their marks wins the game.</li>
                    <li>If all nine squares are filled and no player has a line of three, the game ends in a draw, also known as a "cat's game".</li>
                </ul>
                <br>
            </p>
        </div>
    </content>
    <footer id="footer">
        <div></div>
    </footer>
</body>
</html> 
<?php } else { 
  header("Location: login.php");
} ?>