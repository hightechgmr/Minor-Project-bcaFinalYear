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
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $username = preg_replace('/\s+/','',$username);

           
            $sql1="SELECT count(*) FROM users WHERE BINARY username = ?";
            $stmt=mysqli_prepare($conn,$sql1);
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            $result=mysqli_stmt_get_result($stmt);
            while($row=mysqli_fetch_array($result)){
                $val= $row['count(*)'];
                if($val>=1){
                    echo'<script type="text/JavaScript">
                    alert("username taken");
                    window.history.back();
                    </script>';
                    exit();

                }else{
                    $sql="INSERT INTO users (username,gender,password) values (?, ?, ?)";
                    $insertStmt=mysqli_prepare($conn,$sql);
                    mysqli_stmt_bind_param($insertStmt,"sss",$username,$gender,$passwordHash);

                    if(mysqli_stmt_execute($insertStmt)){
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
