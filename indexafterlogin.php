<?php session_start();
if(isset($_SESSION['user'])){?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashbord</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v4.0.8/css/line.css"
    />
  </head>

  <body>
    <header>
      <nav class="navigation">
        <a class="current-page">Home</a>
        <a href="rule.php">Game Rules</a>
        <a href="score.php">Scorecard</a> 
      </nav>

      <a href="profile.php" class="profile-container">
          <img src="images/profile.png" alt="profile" id="profile">
      </a>
    </header>

    
    <div class="middle">
      <h1 class="headings" style="padding: 2rem 0rem 0rem 0rem">ABOUT</h1>
      <div class="home">
        <div id="logo">
          <img src="images/logo.jpeg" alt="tic tac toe" />
        </div>

        <div class="about">
          <p>
            Nostalgic gaming online is a website brings the joy of classic games
            like Tic Tac Toe and more to your fingertips. Enjoy a nostalic
            experience with a mordern, user -friendly platform. Stay tuned for
            even more games to come! initially we have tic tac toe but many more
            to come soon...
          </p>
        </div>
      </div>
      <hr/>

      <h1 class="headings" style="justify-self: center;">Our Games</h1>
      <div class="ourgames">
        <div class="tictactoe-main-content">
          <div class="tictactoe">
            <div id="Img">
              <img src="images/tictactoe.png" alt="tic tac toe" />
            </div>
          
            <div class="content">
              <h3 class="headings">Tic-Tac-Toe</h3>
              <p>
                Tic Tac toe is a classic strategy game for two players. Played on a
                3x3 grid, players take turns marking squares with "X" or "0". The
                first player to get three of their marks in a row(horizontally,
                vertically, or diagonally) wins! <br />
              </p>
            </div> 
          </div>

          <div class="buttons">
            <a href="tictactoe.php" class="button">
              PLAY NOW
            </a>
            <a href="score.php" class="button">
              PAST SCORES
            </a>
            </button>
          </div>
        </div>
      </div>
    </div>


    <div class="fotter">

    </div>
  </body>
</html>
<?php } else { 
  header("Location: login.php");
} ?>
