<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Super Basic CRUD!</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style>
<?php
require '/css/nav.css';
?>
</style>

</head>
<body>

<?php
require 'nav.tpl';
?>


<div class="container">

<?php
  // USE THE QUERY RESULT
  print "<table class='table'>";
  print "<tr><th>Sound</th><th>Image Path</th><th>Sound Path</th><th></th></tr>";

  if (mysqli_num_rows($result) > 0) {
    while($row = $result->fetch_assoc()) {
    print "<tr>";
    print "<td>". $row['sound_name'] . "</td>" ;
    print "<td>". $row['image_path'] . "</td>" ;
    print "<td>". $row['sound_path'] . "</td>" ;

    print "<td><div class='row'>";

    // clean the data before sending back to user using htmlspecialchars
    print "<div class='col-sm-6'><form action='edit.php' method='POST' class='form-horizontal'><input type='hidden' name='sound_id' value='".htmlspecialchars($row['sound_id'])."'><input type='hidden' name='display' value='display'>
    <div class='form-group'><button type='submit' name='action' value='Update' class='btn btn-default'>
  <span class='glyphicon glyphicon-pencil'></span></button></div></form></div>";

    print "<div class='col-sm-6'><form action='delete.php' method='POST' class='form-horizontal'><input type='hidden' name='sound_id' value='".htmlspecialchars($row['sound_id'])."'><div class='form-group'><button type='submit' class='btn btn-default' name='action' value=delete'>
  <span class='glyphicon glyphicon-trash'></span></button></div></form></div>";

      print "</div></td></tr>\n";

    }
  } else {
    print "<tr><td colspan='4'>No Rows</td></tr>";
  }
  print "</table>"
?>
</table>
<form action="edit.php" method="POST">
	<input type="submit" name="action" value="Add" class="btn btn-lg btn-primary">
</form>

</body>
</html>
