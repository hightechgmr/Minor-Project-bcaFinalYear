<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signup.css">
    <title>Sign up</title>
</head>
<body>
        <div class="content">
        <div id="pic"><img src="play.png" alt="tic tac toe"></div>
        <div id="form">
           <form action="register.php" method="post" id="signup" name="signup">
                <h1>Sign Up</h1>
                <table>
                    <tr>
                        <td><label><b>User Name:</b></label>
                        </td>
                        <td><input type="text" name="username" id="username"  required>
                        </td>
                    </tr><br>
                    <tr>
                        <td><label><b>Gender:</b></label>
                        </td>
                        <td><input type="text" name="gender" id="gender" placeholder="M or F or O" maxlength=1 required>
                        </td>
                    </tr><br>
                    <tr>
                        <td><label><b>Password:</b></label></td>
                        <td><input type="password" name="userpswd" id="userpswd" maxlength=8 placeholder="" required></td>
                    </tr><br>
                </table>
                <input type="submit" name="lin" id="lin" value="       Sign up       "><br><br>
                <div id="msghere"></div>
                <h4>OR</h4>
                <p>Already have a account ??</p><br>
                <input type="button" name="sup" id="sup" value="login" onclick="window.location.href='login.php'">
            </form>
        </div>
        </div>
</body>
</html>