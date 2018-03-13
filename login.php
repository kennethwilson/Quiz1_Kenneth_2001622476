<?php
session_start();
include("connect.php");
$_SESSION["username"] =
$username = $_POST['username'];
$pass = $_POST['pass'];
$_SESSION["username"] =$username;
$sql = "SELECT username, password FROM user where username='$username' AND password='$pass'";
$result = mysqli_query($connect, $sql);
if(mysqli_num_rows($result) > 0)
{
  header("Location: home.php");
}
else {
  header("Location: login_error.php");
}
?>
