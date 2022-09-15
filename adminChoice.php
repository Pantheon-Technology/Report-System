<!DOCTYPE html>
<html>

<head>
  <title>Time Sheet Prototype</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>

<body class="w3-black">
<?php
session_start();
 
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["adminLoggedin"]) || $_SESSION["adminLoggedin"] !== true){
     header("location: adminLogIn.php");
     exit;
 }
 ?>
  <h2 class="w3-text-light-grey">Time Sheet Prototype</h2>
  <div class="w3-padding-large" id="main">
  <div class="w3-row w3-center w3-padding-16 w3-section w3-light-grey">
    <a href = "viewTimesheets.php">View Timesheets</a>
  </div>
  <div class="w3-row w3-center w3-padding-16 w3-section w3-light-grey">
    <a href = "logOut.php">Log Out</a>
  </div>
  </div>
</body>

</html>