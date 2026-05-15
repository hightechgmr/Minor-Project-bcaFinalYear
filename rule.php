<?php session_start();
if(isset($_SESSION['user'])){?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/responsive.css">
    <title>Rules for the game</title>
</head>
<body>
    <header>
      <nav class="navigation">
        <a href="indexafterlogin.php">Home</a>
        <a href="games_list.php">Our Games</a>
        <a class="current-page">Game Rules</a>
        <a href="score.php">Scorecard</a> 
      </nav>

      <a href="profile.php" class="profile-container">
          <img src="images/profile.png" alt="profile" id="profile">
      </a>
    </header>


    <content class="rules-content">
        <div class="rules-head">
            <div class="headings">Game Rules: </div>
            <div class="div-logo-rules">
                <img src="images/logo.jpeg" alt="logo" class="logo-rules">
            </div>
        </div>

        <div class="rule">
            <div class="head-content-rules">
                <div class="headings2">Tic-Tac-Toe</div>

                <a href="tictactoe.php" class="playnowbutton">
                    Play Now
                </a>
            </div>

            <p class="rulescontent">
                <b>Players:</b><br><p class="cont">Two players</p><br>
                <b>Objective:</b><br><p class="cont">Be the first player to get three of your marks (X or O) in a row, horizontally, vertically, or diagonally.</p><br>
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

        <div class="rule">
            <div class="head-content-rules">
                <div class="headings2">8-Puzzle Problem</div>

                <a href="eight_puzzle.php" class="playnowbutton">
                    Play Now
                </a>
            </div>
        <p class="rulescontent">
            <b>Players:</b><br>
            <p class="cont">One player</p><br>

            <b>Objective:</b><br>
            <p class="cont">
                Arrange the numbered tiles in the correct order by sliding them into the empty space. 
                The goal is to place the numbers from 1 to 8 in sequence with the blank space in the final position.
            </p><br>

            <b>Setup:</b><br>
            <ul>
                <li>Create a 3x3 grid containing eight numbered tiles and one empty space.</li>
                <li>The tiles are shuffled randomly at the start of the game.</li>
                <li>The target arrangement is:
                    <br>
                    1 2 3 <br>
                    4 5 6 <br>
                    7 8 _
                </li>
            </ul><br>

            <b>Gameplay:</b><br>
            <ul>
                <li>The player slides tiles into the adjacent empty space.</li>
                <li>Only tiles directly above, below, left, or right of the empty space can move.</li>
                <li>Tiles cannot jump over other tiles.</li>
                <li>The game continues until all tiles are arranged in the correct order.</li>
            </ul>
            <br>

            <b>Winning:</b><br>
            <ul>
                <li>The player wins when all numbered tiles are placed in the correct sequence.</li>
                <li>The empty space must be in the final bottom-right position.</li>
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
