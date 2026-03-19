<?php
session_start();

if(isset($_POST['submit']))
{
    $_SESSION['opponent_name'] = $_POST['opponent_name'];
    header("Location: game.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Opponent Name</title>
    <link rel="stylesheet" href="css/all.css">
</head>

<body>

<h2>Enter Opponent Name</h2>

<form method="post" action="">
    
    <label>Opponent Name:</label><br><br>
    
    <input type="text" name="opponent_name" required><br><br>
    
    <button type="submit" name="submit">Start Game</button>

</form>

</body>
</html>