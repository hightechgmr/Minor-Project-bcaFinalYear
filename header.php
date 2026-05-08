<?php session_start(); ?>
      <nav class="navigation">
        <a class="current-page">Home</a>
        <a href="games_list.php">Our Games</a>
        <a href="rule.php">Game Rules</a>
        <a href="score.php">Scorecard</a> 
      </nav>

     <?php if(isset($_SESSION['user'])):?>
      <a href="profile.php" class="profile-container">
          <img src="images/profile.png" alt="profile" id="profile">
      </a>

      <?php else: ?>
     <nav>
        <a href="login.php">Login/SingnUp</a>
      </nav>
      <?php endif; ?>
    