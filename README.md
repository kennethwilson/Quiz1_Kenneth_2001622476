# Quiz1_Kenneth_2001622476-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2018 at 05:52 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz1_webapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `route_ID` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` int(11) NOT NULL,
  `source_location` varchar(100) NOT NULL,
  `target_location` varchar(100) NOT NULL,
  `driver_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`route_ID`, `date`, `time`, `source_location`, `target_location`, `driver_ID`) VALUES
(1, '2018-03-13', 11, 'fx', 'pik', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `username`, `password`) VALUES
(1, 'user1', 'pass1'),
(2, 'user2', 'pass2');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `user_ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `average_rating` float NOT NULL,
  `no_of_rating` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`user_ID`, `name`, `type`, `status`, `average_rating`, `no_of_rating`) VALUES
(1, 'Kenneth', 'driver', 'active', 4, 10),
(2, 'Wilson', 'passenger', 'active', 5, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`route_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `route_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


<?php
$connect = mysqli_connect("localhost","root","","quiz1_webapp");
?>

html{
  font-family: "Arial";
}
.header
{
  text-align: center;
  margin-bottom: 50px;
}
.contenthead
{
  height: 12%;
}
.contentheader{
  display: block;
  float: left;
  text-align: center;
  width: 25%;
  font-size: 20px;
  margin-bottom: 10 px;
}
.hr1{
  width: 100%;
}
hr {
    overflow: visible;
    height: 30px;
    border-style: solid;
    border-color: black;
    border-width: 1px 0 0 0;
    border-radius: 20px;
}
hr:before {
    display: block;
    content: "";
    height: 30px;
    margin-top: -31px;
    border-style: solid;
    border-color: black;
    border-width: 0 0 1px 0;
    border-radius: 20px;
}
table,td{
  color: black;
  border: 1px solid black;
  font-size: 15px;
}
td{
  padding: 5px;
}

<?php
session_start();
include("connect.php");
$username = $_SESSION["username"];
$sql2 = "SELECT user_ID FROM user WHERE username='$username'";
$sql3;
$result2 =  mysqli_query($connect, $sql2);
if(mysqli_num_rows($result2) > 0)
{
  while($row2 = $result2->fetch_assoc())
  {
    $id = $row2["user_ID"];
    echo("USER ID: ".$id.", ");
    $sql3 = "SELECT type from userinfo WHERE user_ID='$id'";
    $result3 = mysqli_query($connect, $sql3);
    if(mysqli_num_rows($result3) ==1 )
    {
      while($row3 = $result3->fetch_assoc())
      {
          echo("YOU ARE A ".$row3["type"]);
          $type = $row3["type"];
      }
    }
  }
}
$_SESSION["type"]=$type;
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css1.css">
</head>
<body>
  <div class="header">
  <img src="shareit.png" width="300px" height="180px">
</div>
<div class="contenthead">
  <div class="contentheader"><b> Available Offers </b></div>
  <div class="contentheader"><a href=""> Requested Routes</a></div>
  <div class="contentheader"><a href=""> My Routes Offered  </a></div>
  <div class="contentheader"><a href=""> My Routes Booked  </a></div>
  <div class="contentheader hr1"> <hr> </div>
</div>
<h3>Welcome back, <?php print_r($_SESSION["username"]);?> </h3>
<h4> Here are the available routes from today onwards:</h4>

<table>
<tr>
  <td colspan="7"><b><center>Available Routes </center></b></td>
</tr>
<tr>
  <td> <b>Date</b> </td>
  <td> <b>Time</b> </td>
  <td><b>Source Location</b> </td>
  <td><b>Target Location</b> </td>
  <td><b>Driver's Name</b> </td>
  <td><b>Driver's Average Rating</b> </td>
  <td><b>No. of Ratings Given</b> </td>
</tr>
<?php
$today = date('Y-m-d');
$sql = "SELECT routes.date,routes.time, routes.source_location,routes.target_location,
              userinfo.name,userinfo.average_rating,userinfo.no_of_rating
FROM routes
INNER JOIN userinfo on routes.driver_ID=userinfo.user_ID
WHERE routes.date>=$today";
$result = mysqli_query($connect, $sql);
if(mysqli_num_rows($result) > 0)
{
   while($row = $result->fetch_assoc()) {
     echo("<tr>");
     echo("<td>".$row["date"]."</td>");
     echo("<td>".$row["time"].":00"."</td>");
     echo("<td>".$row["source_location"]."</td>");
     echo("<td>".$row["target_location"]."</td>");
     echo("<td>".$row["name"]."</td>");
     echo("<td>".$row["average_rating"]."</td>");
     echo("<td>".$row["no_of_rating"]."</td>");
     echo("</tr>");
   }
}
?>
</table>
<?php if($_SESSION["type"]=="driver")
{
  echo("<form action='add_route.php' method=''post>");
  echo("ADD ROUTE");
  echo("<br>");
}?>


</body>
</html>

<html>
<head>
</head>
<body>
<form name="myForm" action="login.php" method="post">
<h1> Login </h1>
Username: <input type="text" name="username">
<br>
Password: <input type="password" name="pass">
<br>
<input type="submit" value="Login">
</form>
</body>
</html>

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

<html>
<head>
</head>
<body>
<form name="myForm" action="login.php" method="post">
<h1> Login </h1>
Username: <input type="text" name="username">
<br>
Password: <input type="password" name="pass">
<br>
<input type="submit" value="Login">
<br>
<font color="red"> Invalid username or password! Try Again </font>
</form>
</body>
</html>
