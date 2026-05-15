<?php session_start();
if(isset($_SESSION['user'])){?>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashbord</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
<!--The header section-->
  <header>
    <nav class="navigation">
      <a class="current-page">Home</a>
      <a href="games_list.php">Our Games</a>
      <a href="rule.php">Game Rules</a>
      <a href="score.php">Scorecard</a> 
    </nav>

    <a href="profile.php" class="profile-container">
      <img src="images/profile.png" alt="profile" id="profile">
    </a>
  </header>

<!--The About section-->
  <div class="middle">
    <div class="home">
      <div id="logo">
        <h1 class="headings">About Us</h1>
        <img src="images/logo.jpeg"/>
      </div>

      <div class="about">
        <p style="color: #111111;">
          Nostalgic gaming online is a website brings the joy of classic games
          like Tic Tac Toe and more to your fingertips. Enjoy a nostalic
          experience with a mordern, user -friendly platform. Stay tuned for
          even more games to come! initially we have tic tac toe, 8 puzzle problem but many more
          to come soon...
        </p>
      </div>
    </div>
    <hr/>
  </div>

<!--The Bottom section-->

  <div class="bottom">
    <h1 class="headings">Checkout Our Games</h1>
    
    <a class="game-card-link" href="games_list.php#tictactoe">
      <div class="game-card">
        <img src="images/tictactoe.png">
        <section>
          <h1>TicTacToe</h1>
          <p>
            <ul>
              <li>
                A classic strategy game for two players played on a 3x3 grid
              </li>
            </ul>
          </p>
        </section>
      </div>
    </a>

    <a class="game-card-link" href="games_list.php#8PuzzleProblem">
      <div class="game-card">
        <img src="images/8puzzleProblem.gif">
        <section>
          <h1>8-Puzzle Problem</h1>
          <p>
            <ul>
              <li>
                A classic sliding puzzle consisting of a 3x3 grid with eight numbered tiles (1-8) and one blank space
              </li>
            </ul>
          </p>
        </section>
      </div>
    </a>
  
  </div>
  
  
  <div class="fotter">
  </div>
</body>
</html>

<?php } else { 
  header("Location: login.php");
} ?>