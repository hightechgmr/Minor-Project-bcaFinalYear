<?php
session_start();

// CHECK LOGIN
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// DATABASE CONNECTION
$conn = mysqli_connect("localhost", "root", "", "tictactoe");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user = $_SESSION['user'];

// FETCH ONLY LOGGED-IN USER DATA
$sql = "SELECT * FROM scorecard WHERE user_name='$user'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>


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
        <a href="indexafterlogin.php">Home</a>
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
                <th>Draws</th>
                <th>Opponent</th>
            </tr>

            <?php
$sn = 1;

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {

        $wonClass = ($row['won'] > $row['lost']) ? "win" : "";
        $lostClass = ($row['lost'] > $row['won']) ? "loss" : "";
        $draws = max(0, (int)$row['total_matches'] - (int)$row['won'] - (int)$row['lost']);

        echo "<tr>
            <td>".$sn++."</td>
            <td>".$row['game_name']."</td>
            <td>".$row['user_name']."</td>
            <td>".$row['total_matches']."</td>
            <td class='$wonClass'>".$row['won']."</td>
            <td class='$lostClass'>".$row['lost']."</td>
            <td>".$draws."</td>
            <td>".$row['against']."</td>
        </tr>";
    }

} else {
    echo "<tr><td colspan='8'>No records found</td></tr>";
}
?>
        </table> 
    </content>

</body>
</html>

