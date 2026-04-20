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

            $sql1="SELECT * FROM users where username='$usrname' and password='$psswrd'";
            $result=$conn->query($sql1);
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
