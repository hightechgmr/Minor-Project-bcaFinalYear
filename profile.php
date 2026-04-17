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
      <nav class="navigation">
        <a href="indexafterlogin.php">Home</a>
        <a href="rule.php">Game Rules</a>
        <a href="score.php">Scorecard</a> 
      </nav>    
    </header>

    <content>
        <div class="head">
            <div id="div-logo">
                <img src="images/logo.jpeg" alt="logo" id="logo">
            </div>
            <div id="topic">Profile:</div>
            <div id="profilepic">
                <img src="images/profilemale.png" alt="profile pic" id="malepic">
            </div>
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
            <input type="button" id="rmvacc" value="logout">
        </div>
            
    </content>

    <footer class="fotter">
    </footer>

</body>
</html>