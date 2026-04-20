<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
        <div class="content">
            <div id="pic">
                <img src="images/play.png" alt="tic tac toe">
            </div>

            <div id="form">
                <form action="log.php" method="post" id="signup" name="signup">
                    <h1 class="headings">Log in</h1>
                    <table>
                        <tr>
                            <td>
                                <label style="font-weight: bolder;">UserName: </label>
                            </td>
                            <td>
                                <input type="text" name="username" id="username" placeholder="username" required>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td>
                                <label style="font-weight: bolder;">Password: </label>
                            </td>
                            <td>
                                <input type="password" name="userpswd" id="userpswd" placeholder="password" required>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td colspan="2" style="padding: 1rem;">
                               <input type="submit" name="lin" id="lin" value="Login">
                                <?php
                                      if (isset($_GET['error']) && $_GET['error'] == "wrong") {
                                       echo "<p style='color:red; margin-top:10px;'>Wrong username or password</p>";
                                       }
                             ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>OR</h4>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                don't have an account?
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 0.01rem;">
                                <a href="signup.php" class="buttons">SignUp</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
</body>
</html>
