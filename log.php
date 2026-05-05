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

            // BINARY makes username and password checks case-sensitive.
            $sql1="SELECT * FROM users WHERE BINARY username = ? AND BINARY password = ?";
            $stmt=mysqli_prepare($conn,$sql1);
            mysqli_stmt_bind_param($stmt,"ss",$usrname,$psswrd);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            $val= $result->num_rows;


            if($val==1){
            $row=mysqli_fetch_array($result);   
                    $sql="INSERT INTO login_status (username,password) values ('$usrname','$psswrd')";
                    if(mysqli_query($conn,$sql)){
                        $_SESSION['user']=$usrname;
                        header("Location:indexafterlogin.php");
                        exit();
                    }else{
                        echo("error.".mysqli_error($conn)); 
                    }
            }
            else{
                header("Location: login.php?error=wrong");
                exit();
            }    
        ?>
</body>
</html>
