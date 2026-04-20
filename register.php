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
            
            $username=trim($_POST['username']);
            $gender=$_POST['gender'];
            $password=trim($_POST['userpswd']);

            $username = preg_replace('/\s+/','',$username);

            $sql1="SELECT count(*) FROM users where username='$username'";
            $result=$conn->query($sql1);
            while($row=mysqli_fetch_array($result)){
                $val= $row['count(*)'];
                if($val>=1){
                    echo'<script type="text/JavaScript">
                    alert("username taken");
                    </script>';
                    
                }else{
                    $sql="INSERT INTO users (username,gender,password) values ('$username','$gender','$password')";
                    if(mysqli_query($conn,$sql)){
                        header("location:login.php"); 
                    }else{
                        echo"error.".mysqli_error($conn); 
                    }
                }
                    
                
            }
            
            
            
            mysqli_close($conn);
        ?>
</body>
</html>