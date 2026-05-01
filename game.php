<?php
session_start();

if (isset($_SESSION['user'])) {
    $game_name = isset($_GET['game']) ? strtolower(trim($_GET['game'])) : 'tictactoe';
    $game_name = preg_replace('/[^a-z0-9_-]/', '', $game_name);

    if ($game_name === '') {
        $game_name = 'tictactoe';
    }

    $game_titles = [
        'tictactoe' => 'Tic-Tac-Toe'
    ];
    $game_title = $game_titles[$game_name] ?? ucwords(str_replace(['-', '_'], ' ', $game_name));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/game.css">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <title>Game</title>
</head>
<body>
    <header>
      <nav class="navigation">
        <a href="indexafterlogin.php">Home</a>
        <a href="rule.php" target="_blank">Game Rules</a>
        <a href="score.php">Scorecard</a> 
      </nav>

      <a href="profile.php" class="profile-container">
          <img src="images/profile.png" alt="profile" id="profile">
      </a>
    </header>

    <content>
        <div class="head">
            <div id="topic">
                <?php echo htmlspecialchars($game_title); ?>
            </div>
        </div>
        <div id="msg-container">
            <div id="msg"></div>
        </div>
        <div class="gamecontent" data-game-name="<?php echo htmlspecialchars($game_name); ?>">
            <div id="player1">
                <div id="play1_name"><?php echo htmlspecialchars($_SESSION['user']); ?></div>
                <table class="userDataTable">
                    <tr>
                        <td colspan="2">
                            Match Record
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Total Matches:
                        </td>
                        <td>
                            <input type="number" id="totalp1" name="totalp1" value="0" readonly>
                            <!--" value="<?php echo $total_matches; ?>" readonly>-->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Wins:
                        </td>
                        <td>
                            <input type="number" id="winp1" name="winp1" value="0" readonly>
                            <!--" value="<?php echo $won; ?>" readonly>-->                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Loss:
                        </td>
                        <td>
                            <input type="number" id="lostp1" name="winp1" value="0" readonly>
                            <!--" value="<?php echo $lost; ?>" readonly>-->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Draws:
                        </td>
                        <td>
                            <input type="number" id="drawp1" name="drawp1" value="0" readonly>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="game">
                <button class="box" id="box0"  onclick="boxclick('0');"></button>
                <button class="box" id="box1"  onclick="boxclick('1');"></button>
                <button class="box" id="box2"  onclick="boxclick('2');"></button>
                <button class="box" id="box3"  onclick="boxclick('3');"></button>
                <button class="box" id="box4"  onclick="boxclick('4');"></button>
                <button class="box" id="box5"  onclick="boxclick('5');"></button>
                <button class="box" id="box6"  onclick="boxclick('6');"></button>
                <button class="box" id="box7"  onclick="boxclick('7');"></button>
                <button class="box" id="box8"  onclick="boxclick('8');"></button>
            </div>

            <div id="player2">
                <div id="play2_name"> </div>
                <table class="userDataTable">
                    <tr>
                        <td colspan="2">
                            Match Record
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Total Matches:
                        </td>
                        <td>
                            <input type="number" id="totalp2" name="totalp2" value="0" readonly>
                            <!--" value="<?php echo $total_matches; ?>" readonly>-->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Wins:
                        </td>
                        <td>
                            <input type="number" id="winp2" name="winp1" value="0" readonly>
                            <!--" value="<?php echo $won; ?>" readonly>-->                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Loss:
                        </td>
                        <td>
                            <input type="number" id="lostp2" name="winp2" value="0" readonly>
                            <!--" value="<?php echo $lost; ?>" readonly>-->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Draws:
                        </td>
                        <td>
                            <input type="number" id="drawp2" name="drawp2" value="0" readonly>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="restart">
            <input type="submit" name="button" class="restat" value="Restart Game" onclick="reset();">
        </div> 
  
    </content>

    <footer class="fotter" style="max-height: 2vh;">

    </footer>
    <script src="js/game.js?ver=5.0"></script>
</body>
</html>
<?php } else {
  header("Location: login.php");
} ?>
