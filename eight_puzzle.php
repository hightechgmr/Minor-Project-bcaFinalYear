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

$playerName = $_SESSION['user'];

function db_connection() {
    if (!function_exists('mysqli_connect')) {
        return false;
    }

    return @mysqli_connect("localhost", "root", "", "tictactoe");
}

function eight_puzzle_columns($conn) {
    $columns = [];
    $result = mysqli_query($conn, "SHOW COLUMNS FROM eight_puzzle_scorecard");

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }
    }

    return $columns;
}

function save_eight_puzzle_score($playerName, $moves, $timeSeconds) {
    $conn = db_connection();

    if (!$conn) {
        return ['success' => false, 'message' => 'Database connection failed.'];
    }

    $columns = eight_puzzle_columns($conn);
    $dateColumn = '';

    foreach (['played_at', 'created_at', 'date_time', 'game_datetime', 'date'] as $candidate) {
        if (in_array($candidate, $columns, true)) {
            $dateColumn = $candidate;
            break;
        }
    }

    if ($dateColumn !== '') {
        $sql = "INSERT INTO eight_puzzle_scorecard (user_name, moves, time_seconds, `$dateColumn`) VALUES (?, ?, ?, NOW())";
    } else {
        $sql = "INSERT INTO eight_puzzle_scorecard (user_name, moves, time_seconds) VALUES (?, ?, ?)";
    }

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        mysqli_close($conn);
        return ['success' => false, 'message' => 'Score could not be saved.'];
    }

    mysqli_stmt_bind_param($stmt, 'sii', $playerName, $moves, $timeSeconds);
    $success = mysqli_stmt_execute($stmt);
    mysqli_close($conn);

    return [
        'success' => $success,
        'message' => $success ? 'Score saved.' : 'Score could not be saved.'
    ];
}

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($requestMethod === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_score') {
        header('Content-Type: application/json');

        $moves = isset($_POST['moves']) ? (int)$_POST['moves'] : 0;
        $timeSeconds = isset($_POST['time_seconds']) ? (int)$_POST['time_seconds'] : 0;

        if ($moves <= 0 || $timeSeconds < 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid score details.'
            ]);
            exit();
        }

        $saveResult = save_eight_puzzle_score($playerName, $moves, $timeSeconds);
        echo json_encode([
            'success' => $saveResult['success'],
            'message' => $saveResult['message']
        ]);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/games.css">
    <title>8 Puzzle Game</title>
</head>
<body>
    <header>
        <nav class="navigation">
            <a href="indexafterlogin.php">Home</a>
            <a href="games_list.php">Our Games</a>
            <a href="rule.php">Game Rules</a>
            <a href="score.php">Scorecard</a>
        </nav>

        <a href="profile.php" class="profile-container">
            <img src="images/profile.png" alt="profile" id="profile">
        </a>
    </header>

    <main class="content">
        <div class="head">
            <div class="headings" style="color: black;">8 Puzzle Game</div>
        </div>

        <section class="game-wrapper">
            <div class="panel-scorecard">
                <h2>Game Info</h2>
                <table class="score-table">
                    <tr>
                        <td>Username</td>
                        <td id="playerName"><?php echo htmlspecialchars($playerName); ?></td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td id="timer">00:00</td>
                    </tr>
                    <tr>
                        <td>Moves</td>
                        <td id="moveCount">0</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td id="gameStatus">Click Start Game</td>
                    </tr>
                </table>

                <div class="game-actions">
                    <button type="button" class="action-button" id="startBtn">Start Game</button>
                    <button type="button" class="action-button" id="restartBtn">Restart</button>
                    <button type="button" class="action-button" id="shuffleBtn">Shuffle</button>
                </div>
            </div>

            <section class="panel">
                <div class="status-box" id="statusBox">
                    Arrange the tiles from 1 to 8
                </div>

                <div class="puzzle-board" id="puzzleBoard" aria-label="8 Puzzle board">
                    <?php for ($tile = 1; $tile <= 8; $tile++) { ?>
                        <button
                            type="button"
                            class="puzzle-tile"
                            data-tile="<?php echo $tile; ?>"
                            aria-label="Tile <?php echo $tile; ?>"
                        ><?php echo $tile; ?></button>
                    <?php } ?>
                </div>
            </section>
        </section>
    </main>

    <div class="win-message" id="winMessage" role="dialog" aria-modal="true" aria-labelledby="winTitle" hidden>
        <div class="win-card">
            <h2 id="winTitle">Congratulations!</h2>
            <p id="winSummary">You solved the puzzle.</p>
            <button type="button" class="action-button" id="closeWinBtn">Close</button>
        </div>
    </div>

    <footer class="fotter"></footer>

    <script>
        window.eightPuzzleConfig = {
            saveUrl: "eight_puzzle.php",
            playerName: <?php echo json_encode($playerName); ?>
        };
    </script>
    <script src="js/eight_puzzle.js"></script>
</body>
</html>
