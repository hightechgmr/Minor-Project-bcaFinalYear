<?php
session_start();

// Support the existing app session key and the alternate key used in check.php.
if (!isset($_SESSION['user']) && isset($_SESSION['username'])) {
    $_SESSION['user'] = $_SESSION['username'];
}

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

function format_score_time($seconds) {
    $seconds = max(0, (int)$seconds);
    $minutes = floor($seconds / 60);
    $remainingSeconds = $seconds % 60;

    return sprintf('%02d:%02d', $minutes, $remainingSeconds);
}

$conn = mysqli_connect("localhost", "root", "", "tictactoe");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user = $_SESSION['user'];

$scoreSql = "SELECT * FROM scorecard WHERE user_name = ?";
$scoreStmt = mysqli_prepare($conn, $scoreSql);
mysqli_stmt_bind_param($scoreStmt, 's', $user);
mysqli_stmt_execute($scoreStmt);
$result = mysqli_stmt_get_result($scoreStmt);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$eightPuzzleSql = "
    SELECT user_name, moves, time_seconds
    FROM eight_puzzle_scorecard
    ORDER BY time_seconds ASC, moves ASC
    LIMIT 5
";
$eightPuzzleResult = mysqli_query($conn, $eightPuzzleSql);
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
        <a href="games_list.php">Our Games</a>
        <a href="rule.php">Game Rules</a>
        <a class="current-page">Scorecard</a>
      </nav>

      <a href="profile.php" class="profile-container">
          <img src="images/profile.png" alt="profile" id="profile">
      </a>
    </header>

    <main class="content">
        <div class="head">
            <div class="headings" style="color: black; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">ScoreCard:</div>
        </div>

        <section class="score-section" id="tictactoe">
            <div class="score-heading">Tic Tac Toe Scorecard</div>
            <div class="table-wrap">
                <table id="table" class="score-page-table">
                    <tr>
                        <th>S.No.</th>
                        <th>Game Name</th>
                        <th>Username</th>
                        <th>Opponent</th>
                        <th>Total Matches</th>
                        <th>Won</th>
                        <th>Lost</th>
                        <th>Draws</th>
                    </tr>

                    <?php
                    $sn = 1;

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $wonClass = ((int)$row['won'] > (int)$row['lost']) ? "win" : "";
                            $lostClass = ((int)$row['lost'] > (int)$row['won']) ? "loss" : "";
                            $draws = max(0, (int)$row['total_matches'] - (int)$row['won'] - (int)$row['lost']);

                            echo "<tr>
                                <td>" . $sn++ . "</td>
                                <td>" . htmlspecialchars($row['game_name']) . "</td>
                                <td>" . htmlspecialchars($row['user_name']) . "</td>
                                <td>" . htmlspecialchars($row['against']) . "</td>
                                <td>" . (int)$row['total_matches'] . "</td>
                                <td class='" . $wonClass . "'>" . (int)$row['won'] . "</td>
                                <td class='" . $lostClass . "'>" . (int)$row['lost'] . "</td>
                                <td>" . $draws . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No records found</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="buttonx-container ">
                <a class="buttonx" href="score.php">Go Back</a>
            </div>
        </section>

        <section class="score-section" id="8PuzzleProblem">
            <div class="score-heading">8 Puzzle Game Best 5 Solves</div>
            <div class="table-wrap">
                <table class="score-page-table">
                    <tr>
                        <th>S.No</th>
                        <th>Game Name</th>
                        <th>Username</th>
                        <th>Moves</th>
                        <th>Time</th>
                    </tr>

                    <?php
                    $puzzleSn = 1;

                    if ($eightPuzzleResult && mysqli_num_rows($eightPuzzleResult) > 0) {
                        while ($row = mysqli_fetch_assoc($eightPuzzleResult)) {
                            echo "<tr>
                                <td>" . $puzzleSn++ . "</td>
                                <td>8 Puzzle</td>
                                <td>" . htmlspecialchars($row['user_name']) . "</td>
                                <td>" . (int)$row['moves'] . "</td>
                                <td>" . format_score_time($row['time_seconds']) . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="buttonx-container ">
                <a class="buttonx" href="score.php">Go Back</a>
            </div>
        </section>
    </main>

    <div class="fotter"></div>
</body>
</html>

<?php mysqli_close($conn); ?>
