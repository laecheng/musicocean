<?php
// need to start session on each page
session_start();
// check if this is a valid user or logged in
require './check/sessioncheck.php';
// connect to database
require './db.php';
// user editing board, update log
require './log/log_access_board.php';
?>
<!-- render the page -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Music Ocean</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
img {
  height: 45px;
}
footer{
  text-align: center;
  margin-top: 550px;
  padding: 3px;
  color: #fff;
  background-color: #333
}
</style>
</head>
<body>

  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Music Ocean</a>
      </div>
      <ul class="nav navbar-nav">
<?php
    $board_id = $_SESSION['current_board_id'];
    $sql = "SELECT * FROM `soundboard` WHERE `board_id` = $board_id";
    $result = $mysqli->query($sql);
    $board = $result->fetch_object();
    print "<li><a href='#'><span class='glyphicon glyphicon-th-list'>
    </span> BOARD: $board->board_name</a></li>";
?>
      <li><a href="./soundboard.php">
        <span class="glyphicon glyphicon-home"></span> HOME</a></li>
      <li><a id="delLink" href="#">
        <span class="glyphicon glyphicon-remove-circle"></span> REMOVE BOARD</a></li></ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="./logout.php">
        <span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
    </ul>
    </div>
  </nav>
<div class="container">
<table class='table'>
<tr>
  <th>No.</th>
  <th>My Sound</th>
  <th>My Image</th>
  <th></th>
</tr>

<?php
// fetching existing boards data for user, user may have multiple boards
    $board_id = $_SESSION['current_board_id'];
    $sql = "SELECT * FROM `has_sounds` WHERE `board_id` = $board_id";
    // result2 is a board with mutiple sounds
    $result2 = $mysqli->query($sql);
    $count = 0;
    while($row2 = $result2->fetch_array()) {
        $count++;
        $sound_id = $row2[1];
        $sql = "SELECT * FROM `sounds` WHERE `sound_id`= $sound_id";
        // result3 is one specific sound
        $result3 = $mysqli->query($sql);
        $sound = $result3->fetch_object();

        print "<tr>";
        print "<td>". $count . "</td>" ;
        print "<td>". $sound->name . "</td>" ;
        print "<td><img src='".$sound->image."'></td>" ;
        print "<td><div class='row'>";
        print "<div class='col-sm-8'></div>";
        print "<div class='col-sm-2'><button type='button' class='btn btn-default'
              onclick='SBC.editRecord(".json_encode($sound).")'>
              <span class='glyphicon glyphicon-pencil'></span></button></div>";

        print "<div class='col-sm-2'><button type='button' class='btn btn-default'
               onclick='SBC.confirmDelete(".json_encode($sound).");'>
               <span class='glyphicon glyphicon-trash'></span></button></div>";

        print "</div></td></tr>\n";
      }
    print "</table>";

    include './views/addSoundModal.tpl';
    include './views/deleteComfirmModal.tpl';
    include './views/editSoundBoardButtons.tpl';
    include './views/footer.tpl';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function () {

		$("#addBtn").click(function () {
		   SBC.editRecord();
		})
    $("#delLink").click(function() {
      $("#delBtn").click();
    })
    $("#delBtn").click(function () {
       SBC.confirmDelete();
    })
	});

  var SBC = {};

  SBC.confirmDelete = function confirmDelete(record) {
    if(!record) {
      // Delete entire board
      $("#myModalLabel2").html("Are you sure you want to DELETE this board ?");
      $('#deleteModal').modal('show');
      $('#delBtnAction').attr('value', 'DeleteBoard');
      $("#deleteConfirm_board_id").attr('value',<?php echo $_SESSION['current_board_id'] ?>);
    } else {
      // Delete selected sound
      $("#myModalLabel2").html("Comfire to Delete this sound");
      $("#deleteConfirm_sound_id").attr('value', record.sound_id);
      $("#deleteConfirm_board_id").attr('value',<?php echo $_SESSION['current_board_id'] ?>);
      $('#deleteModal').modal('show');
    }
  }

  SBC.editRecord = function editRecord(record) {
    $('#addModal').modal('show');

  if (!record) {
  // no data so it is a straight add
    $("#myModalLabel").html("Add Record");
    $("#actionBtn").attr('value','Add');
    $("#actionBtn").html('Add');
    $("#board_id").attr('value', <?php echo $board_id ?>);
    $("#file_image").prop('required', true);
    $("#file_sound").prop('required', true);
  } else {
    //data passed so it is an edit

    $("#myModalLabel").html("Edit Record");
    $("#sound_name").attr('value',record.name);
    $("#sound_id").attr('value', record.sound_id);
    $("#board_id").attr('value',<?php echo $board_id ?>);
    $("#actionBtn").attr('value','Update');
    $("#actionBtn").html('Update');
   }
}
</script>
</body>
</html>
