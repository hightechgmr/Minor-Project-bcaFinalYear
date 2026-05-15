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

  
    $query = "SELECT * FROM users WHERE BINARY username = ? AND BINARY password = ?";
    $stmt = mysqli_prepare($conn,$query);
    mysqli_stmt_bind_param($stmt,"ss",$username,$password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1)
    {
        $_SESSION['username'] = $username;
        header("Location: indexafterlogin.php");
        exit();
    }
    else
    {
        echo "Invalid Username or Password";
    }
}
?>