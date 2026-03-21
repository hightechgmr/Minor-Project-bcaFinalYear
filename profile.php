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
                <input type="button" id="ruleofgame" class="button" value="Rules of games" style="background-color:#F2E9E4;" onclick="window.location.href='rules.html'">
                <input type="button" id="scorecard" class="button" value="Score card" style="background-color:#F2E9E4;" onclick="window.location.href='scorecard.html'">
                <input type="button" id="log-sign" class="button" value="Login/Signup">
                <img src="images/profile.png" alt="profile" id="profile" onclick="window.location.href='scorecard.html'">
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
                <td><input type="text" id="usrnm"></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td><input type="text" id="Gender"></td>
            </tr>
            <tr>
                <td>Total Matches:</td>
                <td><input type="text" id="Totlmatch"></td>
            </tr>
            <tr>
                <td>Won:</td>
                <td><input type="text" id="won"></td>
            </tr>
            <tr>
                <td>Lost:</td>
                <td><input type="text" id="lost"></td>
            </tr>
        </table>
        <div id="rmv">
            <input type="button"  id="rmvacc" value="Log Out">
        </div>
            
    </content>
    <footer id="footer">
        <div></div>
    </footer>
</body>
</html>