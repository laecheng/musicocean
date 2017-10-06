<?php
// need to start session on each page
session_start();
// connect to database
require './db.php';
// check if logged in, annymous user redirect to log in page
require './check/sessioncheck.php';
// check if user is admin
if(!$_SESSION['isadmin']) {
  $_SESSION['error_message'] = "Access Forbiden";
  header('location: ./error.php');
}
?>
<!-- render the page -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Super Basic CRUD!</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<style>
tbody tr th{
  background-color: rgb(192,77,249);

}
tbody > tr:nth-child(2n) {
  background-color: #EEEEEE;
}
tbody > tr:nth-child(2n+1) {
  background-color: #BBBBBB;
}
</style>
</head>
<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" id="boardTag" href="#">Super Board NinJa</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="nav-item"><a class="nav-link" id="publicTag" href="./soundboard.php">
        <span class="glyphicon glyphicon-circle-arrow-left"></span> BACK TO MAIN</a></li>
      </ul>
      <ul class='nav navbar-nav navbar-right'>
        <li><a href='./logout.php'><span class='glyphicon glyphicon-log-out'></span> Log Out</a></li>
      </ul>
    </div>
  </nav>

<div class="container">
<table class='table'>
<tr>
  <th>No.</th>
  <th>user_id</th>
  <th>board_access</th>
  <th>sound_access</th>
  <th>login_attempts</th>
  <th>login_fails</th>
  <th>login_success</th>
  <th>log_outs</th>
</tr>
<?php
    $result = $mysqli->query("SELECT * FROM `logs`");
    $row_count = 0;
    while($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
        $board_access = $row['board_access'];
        $sound_access = $row['sound_access'];
        $login_attempts = $row['login_attempts'];
        $login_fails = $row['login_fails'];
        $login_success = $row['login_success'];
        $log_outs = $row['logouts'];
        $row_count++;

        print "<tr>";
        print "<td>". $row_count . "</td>";
        print "<td>". $user_id . "</td>" ;
        print "<td>". $board_access . "</td>" ;
        print "<td>". $sound_access . "</td>" ;
        print "<td>". $login_attempts ."</td>" ;
        print "<td>". $login_fails ."</td>" ;
        print "<td>". $login_success ."</td>" ;
        print "<td>". $log_outs ."</td>" ;
        print "</tr>";
    }
    print "</table>";
?>
</div>
</body>
</html>
