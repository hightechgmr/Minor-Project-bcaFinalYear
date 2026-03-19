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
            $usrname=$_REQUEST['username'];
            $psswrd=$_REQUEST['userpswd'];


            $sql1="SELECT * FROM users where username='$usrname' and password='$psswrd'";
            $result=$conn->query($sql1);
            $val= $result->num_rows;

            while($row=mysqli_fetch_array($result)){
                
                $data=$result->fetch_assoc();
                if($val==1){
                    $sql="INSERT INTO login_status (username,password) values ('$usrname','$psswrd')";
                    if(mysqli_query($conn,$sql)){
                        $_SESSION['user']=$usrname;
                        header("Location:indexafterlogin.php");
                    }else{
                        echo("error.".mysqli_error($conn)); 
                    }
                }
                else{
                    echo'<script type="text/JavaScript">
                    alert("Invalid username or password");
                    </script>';
                }
            }      
        ?>
</body>
</html>