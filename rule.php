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
      <nav class="navigation">
        <a href="index.php">Home</a>
        <a class="current-page">Game Rules</a>
        <a href="score.php">Scorecard</a> 
      </nav>

      <a href="profile.php" class="profile-container">
          <img src="images/profile.png" alt="profile" id="profile">
      </a>
    </header>


    <content class="content">
        <div class="head">
            <div id="topic">Game Rules: </div>
            <div id="div-logo">
                <img src="images/logo.jpeg" alt="logo" id="logo">
            </div>
        </div>

        <div id="rule">
            <div class="head-content">
                <div class="headings">Tic-Tac-Toe</div>

                <a href="Game.php" class="playnow">
                    Play Now
                </a>
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


    <footer class="fotter">

    </footer>
</body>
</html> 
<?php } else { 
  header("Location: login.php");
} ?>