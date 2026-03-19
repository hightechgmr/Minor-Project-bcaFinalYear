<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signup.css">
    <title>Login</title>
</head>
<body>
        <div class="content">
        <div id="pic"><img src="play.png" alt="tic tac toe"></div>
        <div id="form">
           <form action="log.php" method="post" id="signup" name="signup">
                <h1>Log in</h1>
                <table>
                    <tr>
                        <td><label><b>User Name:</b></label>
                        </td>
                        <td><input type="text" name="username" id="username"  required>
                        </td>
                    </tr><br>
                    <tr>
                        <td><label><b>Password:</b></label></td>
                        <td><input type="password" name="userpswd" id="userpswd" placeholder="" required></td>
                    </tr><br>
                </table>
                <input type="submit" name="lin" id="lin" value="       login       "><br><br>
                <h4>OR</h4>
                <p>don't have a account ??</p><br>
                <input type="button" name="sup" id="sup" value="Sign up" onclick="window.location.href='signup.php'">
            </form>
        </div>
        </div>
</body>
</html>