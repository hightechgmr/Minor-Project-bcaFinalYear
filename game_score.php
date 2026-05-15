<?php
session_start();
header('Content-Type: application/json');

function send_json($success, $message, $stats = null, $status_code = 200) {
    http_response_code($status_code);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'stats' => $stats
    ]);
    exit();
}

function clean_game_name($game_name) {
    $game_name = strtolower(trim($game_name ?? ''));
    $game_name = preg_replace('/[^a-z0-9_-]/', '', $game_name);
    return $game_name !== '' ? $game_name : 'tictactoe';
}

function clean_opponent($opponent) {
    return trim($opponent ?? '');
}

function fetch_stats($conn, $user, $opponent, $game_name) {
    $sql = "SELECT total_matches, won, lost FROM scorecard
            WHERE BINARY user_name = ? AND BINARY against = ? AND game_name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $user, $opponent, $game_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $total = isset($row['total_matches']) ? (int)$row['total_matches'] : 0;
    $won = isset($row['won']) ? (int)$row['won'] : 0;
    $lost = isset($row['lost']) ? (int)$row['lost'] : 0;

    return [
        'total_matches' => $total,
        'won' => $won,
        'lost' => $lost,
        'draws' => max(0, $total - $won - $lost)
    ];
}

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    send_json(false, 'Please login again.', null, 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_json(false, 'Invalid request method.', null, 405);
}

$conn = mysqli_connect('localhost', 'root', '', 'tictactoe');

if (!$conn) {
    send_json(false, 'Database connection failed.', null, 500);
}

$action = $_POST['action'] ?? 'save_score';
$game_name = clean_game_name($_POST['game_name'] ?? 'tictactoe');
$user = $_SESSION['user'];
$opponent = clean_opponent($_POST['against'] ?? '');

if ($opponent === '') {
    send_json(false, 'Please enter opponent name.', null, 422);
}

if ($action === 'get_stats') {
    send_json(true, 'Stats loaded.', fetch_stats($conn, $user, $opponent, $game_name));
}

$result = $_POST['result'] ?? '';
$allowed_results = ['win', 'loss', 'draw'];

if (!in_array($result, $allowed_results, true)) {
    send_json(false, 'Invalid game result.', null, 422);
}

$won = $result === 'win' ? 1 : 0;
$lost = $result === 'loss' ? 1 : 0;

// Draws are stored implicitly as total_matches - won - lost to keep the current table structure.
$check_sql = "SELECT `s.no` FROM scorecard
              WHERE BINARY user_name = ? AND BINARY against = ? AND game_name = ?";
$check_stmt = mysqli_prepare($conn, $check_sql);
mysqli_stmt_bind_param($check_stmt, 'sss', $user, $opponent, $game_name);
mysqli_stmt_execute($check_stmt);
$check_result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($check_result) > 0) {
    $update_sql = "UPDATE scorecard
                   SET total_matches = total_matches + 1,
                       won = won + ?,
                       lost = lost + ?
                   WHERE BINARY user_name = ? AND BINARY against = ? AND game_name = ?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, 'iisss', $won, $lost, $user, $opponent, $game_name);

    if (!mysqli_stmt_execute($update_stmt)) {
        send_json(false, 'Could not update score.', null, 500);
    }
} else {
    $insert_sql = "INSERT INTO scorecard
                   (game_name, user_name, total_matches, won, lost, against)
                   VALUES (?, ?, 1, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert_sql);
    mysqli_stmt_bind_param($insert_stmt, 'ssiis', $game_name, $user, $won, $lost, $opponent);

    if (!mysqli_stmt_execute($insert_stmt)) {
        send_json(false, 'Could not save score.', null, 500);
    }
}

send_json(true, 'Score updated.', fetch_stats($conn, $user, $opponent, $game_name));
?>
