<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "tictactoe");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $game = $_POST['game_name'];
    $user = $_SESSION['user'];
    $won = (int)$_POST['won'];
    $lost = (int)$_POST['lost'];
    $against = $_POST['against'];

    // CHECK if record already exists for SAME opponent
    $checkQuery = "SELECT * FROM scorecard 
                   WHERE user_name='$user' AND against='$against' AND game_name='$game'";

    $check = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($check) > 0) {

        //UPDATE existing row
        $update = "UPDATE scorecard 
                   SET total_matches = total_matches + 1,
                       won = won + $won,
                       lost = lost + $lost
                   WHERE user_name='$user' 
                   AND against='$against'
                   AND game_name='$game'";

        mysqli_query($conn, $update);

    } else {

        // INSERT new row
        $insert = "INSERT INTO scorecard 
                   (game_name, user_name, total_matches, won, lost, against)
                   VALUES 
                   ('$game', '$user', 1, $won, $lost, '$against')";

        mysqli_query($conn, $insert);
    }

    echo "Score Updated";
}
?>
