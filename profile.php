<?php
session_start();


if (!isset($_SESSION['user']) && isset($_SESSION['username'])) {
    $_SESSION['user'] = $_SESSION['username'];
}

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
$userQuery = "SELECT username, gender FROM users WHERE BINARY username = ?";
$userStmt = mysqli_prepare($conn, $userQuery);
mysqli_stmt_bind_param($userStmt, "s", $user);
mysqli_stmt_execute($userStmt);
$userResult = mysqli_stmt_get_result($userStmt);

if ($userResult && mysqli_num_rows($userResult) > 0) {
    $userData = mysqli_fetch_assoc($userResult);
    $username = $userData['username'];
    $gender = $userData['gender'];
    $_SESSION['user'] = $username;
    $_SESSION['username'] = $username;
    $user = $username;
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
WHERE BINARY user_name = ?
";

$scoreStmt = mysqli_prepare($conn, $scoreQuery);
mysqli_stmt_bind_param($scoreStmt, "s", $user);
mysqli_stmt_execute($scoreStmt);
$scoreResult = mysqli_stmt_get_result($scoreStmt);

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
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/responsive.css">
    <title>Profile</title>
</head>
<body>
    <header>
       <nav class="navigation">
        <a href="indexafterlogin.php">Home</a>
        <a href="games_list.php">Our Games</a>
        <a href="rule.php">Game Rules</a>
        <a href="score.php">Scorecard</a> 
      </nav>    
    </header>

    <content class="content-profile-page">
        <div class="head-profile-page">
            <div id="profilepic">
                <img src="images/profilemale.png" alt="profile pic" id="malepic">
            </div>
            <div class="headings">
                Profile 
            </div>
        </div>

        <table id="frm-table">
             <tr>
                <td>User Name:</td>
                <td><input type="text" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" style="text-transform: none;" readonly></td>
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
        
        <div id="div-logo">
             <img src="images/logo.jpeg" alt="logo" id="logo2">
         </div>
            
    </content>
    <footer class="fotter">
    </footer>
</body>
</html>
