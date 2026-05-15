<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Our Games</title>
     <link rel="stylesheet" href="css/index.css">
     <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
     <header>
      <nav class="navigation">
        <a href="indexafterlogin.php">Home</a>
        <a class="current-page">Our Games</a>
        <a href="rule.php">Game Rules</a>
        <a href="score.php">Scorecard</a> 
      </nav>

      <a href="profile.php" class="profile-container">
          <img src="images/profile.png" alt="profile" id="profile">
      </a>
    </header>

    <h1 class="headings" style="color: black;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Our Games:</h1>
     <div class="ourgames" id="tictactoe">

          <h3 class="headings2">Tic-Tac-Toe</h3>

          <div class="game-content-ourgames">
               <div class="content-ourgames">          
                    <div class="game-img">
                         <img src="images/tictactoe.png" alt="tic tac toe" />
                    </div>
                    <p>
                         Tic Tac toe is a classic strategy game for two players. Played on a 3x3 grid, players take turns marking squares with "X" or "0". The first player to get three of their marks in a row(horizontally, vertically, or diagonally) wins! <br>
                         </p>
               </div> 
          </div>

          <div class="buttons">
               <a href="tictactoe.php" class="button">
                    PLAY NOW
               </a>
               <a href="scorecard_page.php#tictactoe" class="button">
                    PAST SCORES
               </a>
          </div>
     </div>

     <div class="ourgames" id="8PuzzleProblem">

          <h3 class="headings2">8-Puzzle Problem</h3>
          
          <div class="game-content-ourgames">
               <div class="content-ourgames">
                    <div class="game-img">
                         <img src="images/8puzzleProblem.gif" alt="tic tac toe" />
                    </div>
                    <p>
                         The 8-puzzle problem is a classic  sliding puzzle consisting of a 3x3 grid with eight numbered tiles (1-8) and one blank space. The goal is to reach a target configuration from a random initial state by sliding tiles into the blank space.<br>
                    </p>
               </div> 
          </div>

         <div class="buttons">
               <a href="eight_puzzle.php" class="button">
                    PLAY NOW
               </a>
               <a href="scorecard_page.php#8PuzzleProblem" class="button">
                    PAST SCORES
               </a>
          </div>

     </div>

     <div class="fotter">
     </div>
</body>
</html>
