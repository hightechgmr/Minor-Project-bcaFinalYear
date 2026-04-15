<?php
session_start();

// CHECK LOGIN
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    die("User not logged in. Please login first.");
}

// DB CONNECTION
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
<html>
<head>
    <title>Scorecard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: white;
            text-align: center;
        }

        h2 {
            margin-top: 20px;
        }

        .container {
            width: 90%;
            margin: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background: #1e293b;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #38bdf8;
            color: black;
            padding: 12px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #334155;
        }

        tr:hover {
            background: #334155;
        }

        .win {
            color: #22c55e;
            font-weight: bold;
        }

        .loss {
            color: #ef4444;
            font-weight: bold;
        }

        .btn {
            margin-top: 20px;
            padding: 10px 20px;
            background: #22c55e;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background: #16a34a;
        }
    </style>
</head>

<body>

<h2>Welcome <?php echo $user; ?> - Your Scorecard</h2>

<div class="container">

<table>
    <tr>
        <th>S.No</th>
        <th>Game</th>
        <th>User</th>
        <th>Total Matches</th>
        <th>Won</th>
        <th>Lost</th>
        <th>Against</th>
    </tr>

<?php
$sn = 1;

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {

        $wonClass = ($row['won'] > $row['lost']) ? "win" : "";
        $lostClass = ($row['lost'] > $row['won']) ? "loss" : "";

        echo "<tr>
            <td>".$sn++."</td>
            <td>".$row['game_name']."</td>
            <td>".$row['user_name']."</td>
            <td>".$row['total_matches']."</td>
            <td class='$wonClass'>".$row['won']."</td>
            <td class='$lostClass'>".$row['lost']."</td>
            <td>".$row['against']."</td>
        </tr>";
    }

} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}
?>

</table>

<!-- BUTTONS -->
<br>
<button class="btn" onclick="window.location.href='game.php'">Play Again</button>
<button class="btn" onclick="window.location.href='index.php'">Home</button>

</div>

</body>
</html>
