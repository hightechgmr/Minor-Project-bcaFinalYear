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
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn,$query);

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