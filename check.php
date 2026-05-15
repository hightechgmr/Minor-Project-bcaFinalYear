<?php
session_start();

/* Database connection */
$host = "localhost";
$user = "root";
$password = "";
$dbname = "tictactoe";

$conn = mysqli_connect($host,$user,$password,$dbname);

if(!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

/* Check login */
if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

  
    $query = "SELECT username, password FROM users WHERE BINARY username = ?";
    $stmt = mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"s",$username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if($row && password_verify($password, $row['password']))
    {
        $_SESSION['user'] = $row['username'];
        $_SESSION['username'] = $row['username'];
        header("Location: indexafterlogin.php");
        exit();
    }
    else
    {
        echo "Invalid Username or Password";
    }
}
?>
