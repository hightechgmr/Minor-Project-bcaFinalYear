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
$winningLines = [
    [0, 1, 2], [3, 4, 5], [6, 7, 8],
    [0, 3, 6], [1, 4, 7], [2, 5, 8],
    [0, 4, 8], [2, 4, 6]
];

function default_game_state($mode = null) {
    return [
        'mode' => $mode,
        'player2_name' => $mode === 'two_player' ? 'Player 2' : '',
        'board' => array_fill(0, 9, ''),
        'turn' => 'X',
        'status' => $mode ? 'playing' : 'choose',
        'message' => $mode ? 'Current turn: X' : 'Choose a game mode',
        'winner' => ''
    ];
}

function check_winner($board, $winningLines) {
    foreach ($winningLines as $line) {
        [$a, $b, $c] = $line;
        if ($board[$a] !== '' && $board[$a] === $board[$b] && $board[$b] === $board[$c]) {
            return $board[$a];
        }
    }

    return in_array('', $board, true) ? '' : 'draw';
}

function find_best_move($board, $symbol, $winningLines) {
    for ($i = 0; $i < 9; $i++) {
        if ($board[$i] === '') {
            $testBoard = $board;
            $testBoard[$i] = $symbol;

            if (check_winner($testBoard, $winningLines) === $symbol) {
                return $i;
            }
        }
    }

    return -1;
}

function get_computer_move($board, $winningLines) {
    // Medium AI: win first, block second, then prefer center/corners before random.
    $winMove = find_best_move($board, 'O', $winningLines);
    if ($winMove !== -1) {
        return $winMove;
    }

    $blockMove = find_best_move($board, 'X', $winningLines);
    if ($blockMove !== -1) {
        return $blockMove;
    }

    $preferredMoves = [4, 0, 2, 6, 8];
    foreach ($preferredMoves as $move) {
        if ($board[$move] === '') {
            return $move;
        }
    }

    $availableMoves = [];
    for ($i = 0; $i < 9; $i++) {
        if ($board[$i] === '') {
            $availableMoves[] = $i;
        }
    }

    return $availableMoves ? $availableMoves[array_rand($availableMoves)] : -1;
}

function fetch_score($playerName, $opponentName) {
    $stats = ['total_matches' => 0, 'won' => 0, 'lost' => 0, 'draws' => 0];
    $conn = @mysqli_connect("localhost", "root", "", "tictactoe");

    if (!$conn) {
        return $stats;
    }

    $sql = "SELECT total_matches, won, lost FROM scorecard WHERE user_name = ? AND against = ? AND game_name = 'tictactoe'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $playerName, $opponentName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $stats['total_matches'] = (int)$row['total_matches'];
        $stats['won'] = (int)$row['won'];
        $stats['lost'] = (int)$row['lost'];
        $stats['draws'] = max(0, $stats['total_matches'] - $stats['won'] - $stats['lost']);
    }

    mysqli_close($conn);
    return $stats;
}

function save_score($playerName, $opponentName, $result) {
    $conn = @mysqli_connect("localhost", "root", "", "tictactoe");

    if (!$conn) {
        return;
    }

    $won = $result === 'win' ? 1 : 0;
    $lost = $result === 'loss' ? 1 : 0;

    $checkSql = "SELECT `s.no` FROM scorecard WHERE user_name = ? AND against = ? AND game_name = 'tictactoe'";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, 'ss', $playerName, $opponentName);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($checkResult) > 0) {
        $updateSql = "UPDATE scorecard SET total_matches = total_matches + 1, won = won + ?, lost = lost + ? WHERE user_name = ? AND against = ? AND game_name = 'tictactoe'";
        $updateStmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, 'iiss', $won, $lost, $playerName, $opponentName);
        mysqli_stmt_execute($updateStmt);
    } else {
        $insertSql = "INSERT INTO scorecard (game_name, user_name, total_matches, won, lost, against) VALUES ('tictactoe', ?, 1, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertSql);
        mysqli_stmt_bind_param($insertStmt, 'siis', $playerName, $won, $lost, $opponentName);
        mysqli_stmt_execute($insertStmt);
    }

    mysqli_close($conn);
}

function finish_game(&$game, $winner, $playerName) {
    $game['status'] = 'finished';
    $game['winner'] = $winner;
    $opponentName = $game['mode'] === 'computer' ? 'Computer' : $game['player2_name'];

    if ($winner === 'draw') {
        $game['message'] = "It's a draw!";
        save_score($playerName, $opponentName, 'draw');
    } elseif ($winner === 'X') {
        $game['message'] = $playerName . " wins!";
        save_score($playerName, $opponentName, 'win');
    } else {
        $game['message'] = $opponentName . " wins!";
        save_score($playerName, $opponentName, 'loss');
    }
}

if (!isset($_SESSION['tictactoe_game'])) {
    $_SESSION['tictactoe_game'] = default_game_state();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $game = $_SESSION['tictactoe_game'];

    if ($action === 'choose_mode') {
        $mode = $_POST['mode'] ?? '';
        $nextGame = default_game_state(in_array($mode, ['computer', 'two_player'], true) ? $mode : null);

        if ($nextGame['mode'] === 'two_player') {
            $player2Name = trim($_POST['player2_name'] ?? '');
            $nextGame['player2_name'] = $player2Name !== '' ? $player2Name : 'Player 2';
        }

        $_SESSION['tictactoe_game'] = $nextGame;
    } elseif ($action === 'new_game' && !empty($game['mode'])) {
        $nextGame = default_game_state($game['mode']);
        $nextGame['player2_name'] = $game['player2_name'];
        $_SESSION['tictactoe_game'] = $nextGame;
    } elseif ($action === 'change_mode') {
        $_SESSION['tictactoe_game'] = default_game_state();
    } elseif ($action === 'cell' && $game['status'] === 'playing') {
        $cell = isset($_POST['cell']) ? (int)$_POST['cell'] : -1;

        if ($cell >= 0 && $cell <= 8 && $game['board'][$cell] === '') {
            $game['board'][$cell] = $game['turn'];
            $winner = check_winner($game['board'], $winningLines);

            if ($winner !== '') {
                finish_game($game, $winner, $playerName);
            } elseif ($game['mode'] === 'computer') {
                // Let the page render the user's X first; JavaScript submits the delayed computer move.
                $game['turn'] = 'O';
                $game['message'] = 'Current turn: O';
            } else {
                $game['turn'] = $game['turn'] === 'X' ? 'O' : 'X';
                $game['message'] = 'Current turn: ' . $game['turn'];
            }
        }

        $_SESSION['tictactoe_game'] = $game;
    } elseif ($action === 'computer_move' && $game['status'] === 'playing' && $game['mode'] === 'computer' && $game['turn'] === 'O') {
        $computerMove = get_computer_move($game['board'], $winningLines);

        if ($computerMove !== -1) {
            $game['board'][$computerMove] = 'O';
        }

        $winner = check_winner($game['board'], $winningLines);
        if ($winner !== '') {
            finish_game($game, $winner, $playerName);
        } else {
            $game['turn'] = 'X';
            $game['message'] = 'Current turn: X';
        }

        $_SESSION['tictactoe_game'] = $game;
    }

    header("Location: tictactoe.php");
    exit();
}

$game = $_SESSION['tictactoe_game'];
$opponentName = $game['mode'] === 'computer' ? 'Computer' : ($game['player2_name'] ?: 'Player 2');
$score = $game['mode'] ? fetch_score($playerName, $opponentName) : ['total_matches' => 0, 'won' => 0, 'lost' => 0, 'draws' => 0];
$computerThinking = $game['mode'] === 'computer' && $game['status'] === 'playing' && $game['turn'] === 'O';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <title>Tic Tac Toe</title>
    <style>
        .game-wrapper {
            width: 90%;
            max-width: 1100px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 2rem;
            align-items: start;
        }

        .panel {
            background: #9A8C98;
            border: 0.25rem solid #333c78;
            box-shadow: 0.45rem 0.45rem 0.45rem #000000;
            padding: 1.5rem;
        }

        .mode-actions, .game-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 1rem;
        }

        .mode-button, .action-button, .cell {
            cursor: pointer;
            font-weight: bold;
        }

        .mode-button, .action-button {
            background: #4A4E69;
            color: #ffffff;
            border: 0.125rem solid #ffffff;
            border-radius: 0.75rem;
            padding: 0.8rem 1rem;
            font-size: 1rem;
        }

        .mode-button:hover, .action-button:hover {
            background: #22223B;
        }

        .status-box {
            text-align: center;
            font-size: 1.7rem;
            font-weight: bold;
            color: #173b16;
            margin-bottom: 1rem;
        }

        .board {
            width: min(86vw, 27rem);
            aspect-ratio: 1 / 1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.6rem;
            margin: 0 auto;
        }

        .board form {
            display: block;
            min-width: 0;
            min-height: 0;
        }

        .cell {
            width: 100%;
            height: 100%;
            min-width: 0;
            background: #4A4E69;
            color: aqua;
            border: 0.25rem solid #e0dbdb;
            border-radius: 1rem;
            font-size: clamp(3rem, 11vw, 5rem);
            line-height: 1;
        }

        .cell:hover:not(:disabled) {
            border-color: #22223B;
            background: #3e425c;
        }

        .cell:disabled {
            cursor: default;
            opacity: 0.95;
        }

        .scorecard h2, .mode-card h2 {
            color: #ffffff;
            text-align: center;
            margin-bottom: 1rem;
        }

        .score-table {
            width: 100%;
            border-collapse: collapse;
            background: #F2E9E4;
        }

        .score-table td {
            border: 0.0625rem solid #4A4E69;
            padding: 0.8rem;
            font-size: 1rem;
        }

        .score-table td:first-child {
            font-weight: bold;
        }

        @media (max-width: 850px) {
            .game-wrapper {
                grid-template-columns: 1fr;
            }

            #topic {
                font-size: 3rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navigation">
            <a href="indexafterlogin.php">Home</a>
            <a href="rule.php">Game Rules</a>
            <a href="score.php">Scorecard</a>
        </nav>

        <a href="profile.php" class="profile-container">
            <img src="images/profile.png" alt="profile" id="profile">
        </a>
    </header>

    <main class="content">
        <div class="head">
            <div id="topic">Tic Tac Toe</div>
        </div>

        <?php if (!$game['mode']) { ?>
            <section class="panel mode-card" style="width: min(90%, 45rem); margin: 0 auto 2rem;">
                <h2>Select Game Mode</h2>
                <div class="mode-actions">
                    <form method="post">
                        <input type="hidden" name="action" value="choose_mode">
                        <input type="hidden" name="mode" value="computer">
                        <button type="submit" class="mode-button">Player 1 - Play with Computer</button>
                    </form>

                    <form method="post" id="twoPlayerForm">
                        <input type="hidden" name="action" value="choose_mode">
                        <input type="hidden" name="mode" value="two_player">
                        <input type="hidden" name="player2_name" id="player2NameInput" value="">
                        <button type="submit" class="mode-button">Player 2 - Two Player Mode</button>
                    </form>
                </div>
            </section>
        <?php } else { ?>
            <section class="game-wrapper">
                <aside class="panel scorecard">
                    <h2>Scorecard</h2>
                    <table class="score-table">
                        <tr>
                            <td>Player Name</td>
                            <td><?php echo htmlspecialchars($playerName); ?></td>
                        </tr>
                        <tr>
                            <td>Opponent Name</td>
                            <td><?php echo htmlspecialchars($opponentName); ?></td>
                        </tr>
                        <tr>
                            <td>Wins</td>
                            <td><?php echo (int)$score['won']; ?></td>
                        </tr>
                        <tr>
                            <td>Loss</td>
                            <td><?php echo (int)$score['lost']; ?></td>
                        </tr>
                        <tr>
                            <td>Draws</td>
                            <td><?php echo (int)$score['draws']; ?></td>
                        </tr>
                    </table>

                    <div class="game-actions">
                        <form method="post">
                            <input type="hidden" name="action" value="new_game">
                            <button type="submit" class="action-button">New Game</button>
                        </form>
                        <form method="post">
                            <input type="hidden" name="action" value="change_mode">
                            <button type="submit" class="action-button">Change Mode</button>
                        </form>
                    </div>
                </aside>

                <section class="panel">
                    <div class="status-box">
                        <?php echo htmlspecialchars($game['message']); ?>
                    </div>

                    <div class="board" aria-label="Tic Tac Toe board" data-computer-thinking="<?php echo $computerThinking ? 'true' : 'false'; ?>">
                        <?php foreach ($game['board'] as $index => $value) { ?>
                            <form method="post">
                                <input type="hidden" name="action" value="cell">
                                <input type="hidden" name="cell" value="<?php echo $index; ?>">
                                <button
                                    type="submit"
                                    class="cell"
                                    aria-label="Cell <?php echo $index + 1; ?>"
                                    <?php echo ($value !== '' || $game['status'] !== 'playing' || $computerThinking) ? 'disabled' : ''; ?>
                                ><?php echo htmlspecialchars($value); ?></button>
                            </form>
                        <?php } ?>
                    </div>

                    <?php if ($computerThinking) { ?>
                        <form method="post" id="computerMoveForm">
                            <input type="hidden" name="action" value="computer_move">
                        </form>
                    <?php } ?>
                </section>
            </section>
        <?php } ?>
    </main>

    <footer class="fotter"></footer>
    <script>
        const twoPlayerForm = document.getElementById("twoPlayerForm");
        const player2NameInput = document.getElementById("player2NameInput");

        if (twoPlayerForm && player2NameInput) {
            twoPlayerForm.addEventListener("submit", function (event) {
                let player2Name = "";

                while (!player2Name.trim()) {
                    player2Name = prompt("Enter Player 2 name:");

                    if (player2Name === null) {
                        event.preventDefault();
                        return;
                    }

                    if (!player2Name.trim()) {
                        alert("Please enter Player 2 name.");
                    }
                }

                player2NameInput.value = player2Name.trim();
            });
        }

        const computerMoveForm = document.getElementById("computerMoveForm");
        const board = document.querySelector(".board");

        // Computer mode delay: show the user's move immediately, pause for 1 second, then let O play.
        if (computerMoveForm && board?.dataset.computerThinking === "true") {
            document.querySelectorAll(".cell").forEach(function (cell) {
                cell.disabled = true;
            });

            setTimeout(function () {
                computerMoveForm.submit();
            }, 1000);
        }
    </script>
</body>
</html>
