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
    <div class="header">
      <div class="top"></div>
      <div class="navbar">
        <input type="button" name="about" id="about" value="About" style="background-color:white;" />
        <input type="button" name="rules" id="rules" value="Rules of Games" onclick="window.location.href='signup.php'"/>
        <input type="button" name="score" id="score" value="Score card " onclick="window.location.href='signup.php'" />
      </div>
    </div>


    <div class="middle">
      <div class="home">
        <div id="logo">
          <img src="logo.jpeg" alt="tic tac toe" />
        </div>
        <div class="about">
          <h1>ABOUT</h1>
          <p>
            Nostalgic gaming online is a website brings the joy of classic games
            like Tic Tac Toe and more to your fingertips. Enjoy a nostalic
            experience with a mordern, user -friendly platform. Stay tuned for
            even more games to come! initially we have tic tac toe but many more
            to come soon...
          </p>
        </div>
      </div>
      <hr />
      <h1>Our Games:</h1>
      <div class="ourgame">
        <div class="heart" ><img src="heart.svg" alt="heart">
        </div>
        <div class="ttt">
          <div id="Img">
            <img src="tictactoe.png" alt="tic tac toe" />
          </div>
          <div class="content">
            <h3>Tic-Tac-Toe</h3>
            <p>
                Tic Tac toe is a classic strategy game for two players. Played on a
                3x3 grid, players take turns marking squares with "X" or "0". The
                first player to get three of their marks in a row(horizontally,
                vertically, or diagonally) wins! <br />
              </p>
              <div class="button">
                <button><a href="signup.php" style="color:white;">PLAY NOW</a></button>
                <button><a href="signup.php" style="color:white;">PAST SCORE</a></button>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="fotter"></div>
  </body>
</html>