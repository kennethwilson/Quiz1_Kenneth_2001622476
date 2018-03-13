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
