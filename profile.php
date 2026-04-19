<?php
session_start();


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "tictactoe");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Logged-in user
$user = $_SESSION['user'];


//  USER DATA 
$userQuery = "SELECT username, gender FROM users WHERE username='$user'";
$userResult = mysqli_query($conn, $userQuery);

if ($userResult && mysqli_num_rows($userResult) > 0) {
    $userData = mysqli_fetch_assoc($userResult);
    $username = $userData['username'];
    $gender = $userData['gender'];
} else {
    $username = "Not Found";
    $gender = "Not Found";
}


//SCORE DATA
$scoreQuery = "
SELECT 
    COALESCE(SUM(total_matches),0) AS total_matches,
    COALESCE(SUM(won),0) AS won,
    COALESCE(SUM(lost),0) AS lost
FROM scorecard 
WHERE user_name='$user'
";

$scoreResult = mysqli_query($conn, $scoreQuery);

if ($scoreResult) {
    $scoreData = mysqli_fetch_assoc($scoreResult);

    $total_matches = $scoreData['total_matches'];
    $won = $scoreData['won'];
    $lost = $scoreData['lost'];
} else {
    $total_matches = 0;
    $won = 0;
    $lost = 0;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <title>Profile</title>
</head>
<body>
    <header>
        <div class="border"></div>
        <div class="navbar">
            <div class="buttons">
                <input type="button" id="about" class="button" value="About">
                <input type="button" id="ruleofgame" class="button" value="Rules of games" style="background-color:#F2E9E4;" onclick="window.location.href='rule.php'">
                <input type="button" id="scorecard" class="button" value="Score card" style="background-color:#F2E9E4;" onclick="window.location.href='score.php'">
                <input type="button" id="log-sign" class="button" value="Login/Signup">
                <img src="images/profile.png" alt="profile" id="profile" onclick="window.location.href='score.php'">
            </div>
        </div>
    </header>
    <content>
        <div class="head">
            <div id="div-logo"><img src="images/logo.jpeg" alt="logo" id="logo"></div>
            <div id="topic">Profile:</div>
            <div id="profilepic"><img src="images/profilemale.png" alt="profile pic" id="malepic"></div>
        </div>
        <table id="frm-table">
            <tr>
                <td>User Name:</td>
                <td><input type="text" value="<?php echo $username; ?>" readonly></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td><input type="text" value="<?php echo $gender; ?>" readonly></td>
            </tr>
            <tr>
                <td>Total Matches:</td>
                <td><input type="text" value="<?php echo $total_matches; ?>" readonly></td>
            </tr>
            <tr>
                <td>Won:</td>
                <td><input type="text" value="<?php echo $won; ?>" readonly></td>
            </tr>
            <tr>
                <td>Lost:</td>
                <td><input type="text" value="<?php echo $lost; ?>" readonly></td>
            </tr>
        </table>
        <div id="rmv">
           <button id="rmvacc" onclick="window.location.href='logout.php'">
              Log Out
           </button>
</div>
            
    </content>
    <footer id="footer">
        <div></div>
    </footer>
</body>
</html>
