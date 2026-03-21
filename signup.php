<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Sign up</title>
</head>
<body>
        <div class="content2">
            <div id="pic">
                <img src="images/play.png" alt="tic tac toe">
            </div>
            
            <div id="form">
                <form action="register.php" method="post" id="signup" name="signup">
                    <h1 class="headings">Sign Up</h1>
                    <table>
                        <tr>
                            <td>
                                <label style="font-weight: bolder;">UserName: </label>
                            </td>
                            <td>
                                <input type="text" name="username" id="username"  required>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td>
                                <label style="font-weight: bolder;">Gender: </label>
                            </td>
                            <td>
                                <input type = "radio" name = "gender" value = "M">
			                    <label for = "M"> Male </label>
			                    <input type = "radio" name = "gender" value = "F">
			                    <label for = "F"> Female </label>
			                    <input type = "radio" name = "gender" value = "O">
			                    <label for = "O"> Others </label>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td>
                                <label style="font-weight: bolder;">Password: </label>
                            </td>
                            <td>
                                <input type="password" name="userpswd" id="userpswd" maxlength=8 placeholder="" required>
                            </td>
                        </tr>
                        <br>
                        <tr>
                            <td colspan="2" style="padding: 1rem;">
                               <input type="submit" name="lin" id="lin" value="SignUp">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>OR</h4>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                already have an account?
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 0.01rem;">
                                <a href="login.php" class="buttons">Login</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
</body>
</html>