<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert register data</title>
</head>
<body>
       <?php 
            $conn=mysqli_connect("localhost","root","","tictactoe");
            if($conn===false){
                die("ERROR:could not connect.".mysqli_connect_error());
            }
            $usrname=trim($_POST['username']);
            $psswrd=trim($_POST['userpswd']);
            
            $usrname = preg_replace('/\s+/','',$usrname);

            $sql1="SELECT username, password FROM users WHERE BINARY username = ?";
            $stmt=mysqli_prepare($conn,$sql1);
            mysqli_stmt_bind_param($stmt,"s",$usrname);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            $row=mysqli_fetch_assoc($result);


            if($row && password_verify($psswrd, $row['password'])){
                $_SESSION['user']=$row['username'];
                $_SESSION['username']=$row['username'];
                header("Location:indexafterlogin.php");
                exit();
            }
            else{
                header("Location: login.php?error=wrong");
                exit();
            }    
        ?>
</body>
</html>
