<?php session_start();
if(isset($_SESSION['user'])){?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <title>scorecard</title>
</head>
<body>
    <header>
      <nav class="navigation">
        <a href="index.php">Home</a>
        <a href="rule.php">Game Rules</a>
        <a class="current-page">Scorecard</a>
      </nav>

      <a href="profile.php" class="profile-container">
          <img src="images/profile.png" alt="profile" id="profile">
      </a>
    </header>

    <content class="content">
        <div class="head">
            <div class="headings" style="color: black;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">ScoreCard:</div>
        </div>

        <table id="table">
            <tr>
                <th>S.No.</th>
                <th>Game Name</th>
                <th>Username</th>
                <th>Total Matches</th>
                <th>Won</th>
                <th>Lost</th>
                <th>Opponent</th>
            </tr>

            <?php
                $conn = mysqli_connect("localhost", "root", "", "tictactoe");

                $query = "SELECT * FROM scorecard";
                $result = mysqli_query($conn, $query);

                $i = 1;
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr class='gentable'>
                    <td>".$i++."</td>
                    <td>".$row['game_name']."</td>
                    <td>".$row['user_name']."</td>
                    <td>".$row['total_matches']."</td>
                    <td>".$row['won']."</td>
                    <td>".$row['lost']."</td>
                    <td>".$row['against']."</td>
                    </tr>";
                }
            ?>
        </table> 
    </content>

    
    <footer class="fotter">
    </footer>
</body>
</html>
<?php } else { 
  header("Location: login.php");
} ?>
