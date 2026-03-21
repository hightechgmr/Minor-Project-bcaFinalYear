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
        <div class="border"></div>
        <div class="navbar">
            <div class="buttons">
                <input type="button" id="about" class="button" value="About" onclick="window.location.href='indexafterlogin.php'">
                <input type="button" id="ruleofgame" class="button" value="Rules of games" style="background-color:#F2E9E4;" onclick="window.location.href='rule.php'">
                <input type="button" id="scorecard" class="button" value="Score card" onclick="window.location.href='score.php'">
                <input type="button" id="log-sign" class="button" value="Login/Signup" onclick="window.location.href='signup.php'">
                <img src="images/profile.png" alt="profile" id="profile" onclick="window.location.href='Profile.php'">
            </div>
        </div>
    </header>
    <content>
        <div class="head">
            <div id="div-logo"><img src="images/logo.jpeg" alt="logo" id="logo"></div>
            <div id="topic">Score Card:</div>
        </div>
        <table id="table">
            <tr>
                <th>S.No.</th>
                <th>Game_name</th>
                <th>User_Name</th>
                <th>Total Matches</th>
                <th>won</th>
                <th>Lost</th>
                <th>Against</th>
            </tr>
            <tr></tr>
        </table> 
    </content>
    <footer id="footer">
        <div></div>
    </footer>
</body>
</html>
<?php } else { 
  header("Location: login.php");
} ?>