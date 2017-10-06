<?php
// need to start session on each page
session_start();
// connect to database
require './db.php';

?>
<!-- render the page -->
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Music Ocean</title>
<link href="./css/board.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" id="boardTag" href="#">Music Ocean</a>
      </div>
      <ul class="nav navbar-nav">
          <li class="nav-item"><a class="nav-link" id="publicTag" href="#">
            <span class="glyphicon glyphicon-star"></span> PUBLIC MUSIC</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">

<?php

// TODO
/* Business Logic should not be in views !!! */
/* Business Logic should not be in views !!! */
/* Business Logic should not be in views !!! */

if( isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1) {
    print "<span class='glyphicon glyphicon-eye-open'></span> ALL BOARDS<span class='caret'>
    </span></a><ul class='dropdown-menu'>";
}
else {
    print "<span class='glyphicon glyphicon-headphones'></span> MY BOARDS <span class='caret'>
    </span></a><ul class='dropdown-menu'>";
}
/* If logged in as administrator, list all the existing boards in dropdown menu */
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
    $user_id = $_SESSION['user_id'];
    // user is admin
    if( $_SESSION['isadmin'] == 1 ) {
        // list all the boards
        $sql = "SELECT * FROM `soundboard`";
        $result = $mysqli->query($sql);
        while($row = $result->fetch_assoc()) {
            $board_id = $row["board_id"];
            $board_name = $row["board_name"];
            print "<li><a href='#' id='".$board_id."' onclick='postback(".$board_id.")'>
            <span class='glyphicon glyphicon-music'></span> ".$board_name."</a></li>";
        }
    }
    // user is not admin
    else {
      $sql = "SELECT * FROM `has_boards` WHERE `user_id` = $user_id";
      $result1 = $mysqli->query($sql);
      while($row = $result1->fetch_assoc()) {
          $board_id = $row["board_id"];
          $sql = "SELECT * FROM `soundboard` WHERE `board_id` = $board_id";
          $result2 = $mysqli->query($sql);
          $board = $result2->fetch_object();
          $board_name = $board->board_name;
          if($board_id == $_SESSION['current_board_id']) {
            print "<li><a href='#' id='".$board_id."' style='background-color:lightblue;'
                   onclick='postback(".$board_id.")'>
            <span class='glyphicon glyphicon-music'></span> ".$board_name."</a></li>";
          } else {
            print "<li><a href='#' id='".$board_id."' onclick='postback(".$board_id.")'>
            <span class='glyphicon glyphicon-music'></span> ".$board_name."</a></li>";
          }
      }
    }
}
if( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
  print "<li><a href='#' id='addBtn'><span class='glyphicon glyphicon-plus'></span> Add</a></li></ul></li>";
} else {
  print "<li><a href='./index.php' ><span class='glyphicon glyphicon-plus'></span> Add</a></li></ul></li>";
}
if( isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1) {
  if( isset($_SESSION['current_board_id']) && $_SESSION['current_board_id'] == 0) {
      print "<li><a href='#' onclick='SBC.addBoard()' id='editboardlink'><span class='glyphicon glyphicon-wrench'></span> EDIT BOARD</a></li>";
  } else {
      print "<li><a href='./editboard.php' id='editboardlink'><span class='glyphicon glyphicon-wrench'></span> EDIT BOARD</a></li>";
  }
  print "<li><a href='./log.php'><span class='glyphicon glyphicon-signal'></span> LOGS</a></li></ul>";
}
  else {

  if( isset($_SESSION['current_board_id']) && $_SESSION['current_board_id'] == 0) {
      print "<li><a href='#' onclick='SBC.addBoard()' id='editboardlink'><span class='glyphicon glyphicon-edit'></span> EDIT BOARD</a></li>";
  } else {
      print "<li><a href='./editboard.php' id='editboardlink'><span class='glyphicon glyphicon-edit'></span> EDIT BOARD</a></li>";
  }
}
  print "</ul><ul class='nav navbar-nav navbar-right'>";
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
  print "<li><a href='./logout.php'><span class='glyphicon glyphicon-log-out'></span> Log Out</a></li>";
} else {
  print "<li><a href='./index.php?sign=signup'><span class='glyphicon glyphicon-new-window'></span> Sign Up</a></li>";
  print "<li><a href='./index.php?sign=signin'><span class='glyphicon glyphicon-log-in'></span> Log In</a></li>";
}
print "</ul></div></nav>";

// if user logged in, render current board and hide other owned board
// if user logged in as admin, render all board
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
  $user_id = $_SESSION['user_id'];
  print "<section id='boardSection'>";

  if($_SESSION['isadmin'] == 1) {
      // user is admin
      $result = $mysqli->query("SELECT * FROM `users`");
      while($row = $result->fetch_assoc()) {
          $user_id = $row['user_id'];
          $sql = "SELECT * FROM `has_boards` WHERE `user_id` = $user_id";
          $result1 = $mysqli->query($sql);

          while($row1 = $result1->fetch_assoc()) {
              $board_id = $row1["board_id"];
              if($board_id == $_SESSION['current_board_id']) {
                print "<div class='board' id='".$board_id."' style='display:flex'>";
              } else {
                print "<div class='board' id='".$board_id."' style='display:none'>";
              }
              $sql = "SELECT * FROM `has_sounds` WHERE `board_id` = $board_id";
              // result2 is a board with mutiple sounds
              $result2 = $mysqli->query($sql);

              if($result2->num_rows == 0) {
                  print "<div style='max-width:800px;margin:auto;margin-top:200px;'>
                  <a href='./editboard.php' style='text-decoration:none;font-size:5rem;font-weight:bold'>
                  You Have No Sound Yet <span class='glyphicon glyphicon-upload'
                  style='font-size: 60px';></span></a></div>";
              }
              while($row2 = $result2->fetch_array()) {
                  $sound_id = $row2[1];
                  $sql = "SELECT * FROM `sounds` WHERE `sound_id`= $sound_id";
                  // result3 is one specific sound
                  $result3 = $mysqli->query($sql);
                  $sound = $result3->fetch_object();
                  print "<div class='container'><div class='wrapper'>";
                  print "<div class='sound'><div class = 'soundBtn'>";
                  print "<i class='material-icons'>play_circle_outline</i>";
                  print "<audio><source src='".$sound->sound."'></audio></div></div>";
                  print "<img src='".$sound->image."'alt='image'>";
                  print "</div><div class='padder'></div></div>";
              }
              print "</div>";
          }
          print "</div>";
      }
      print "</section>";
  }
  else {
    // user is not admin
    $sql = "SELECT * FROM `has_boards` WHERE `user_id` = $user_id";
    $result1 = $mysqli->query($sql);

    while($row1 = $result1->fetch_assoc()) {
        $board_id = $row1["board_id"];
        if($board_id == $_SESSION['current_board_id']) {
          print "<div class='board' id='".$board_id."' style='display:flex'>";
        } else {
          print "<div class='board' id='".$board_id."' style='display:none'>";
        }
        $sql = "SELECT * FROM `has_sounds` WHERE `board_id` = $board_id";
        // result2 is a board with mutiple sounds
        $result2 = $mysqli->query($sql);

        if($result2->num_rows == 0) {
            print "<div style='max-width:800px;margin:auto;margin-top:200px;'>
            <a href='./editboard.php' style='text-decoration:none;font-size:5rem;font-weight:bold'>
            You Have No Sound Yet <span class='glyphicon glyphicon-upload'
            style='font-size: 60px';></span></a></div>";
        }

        while($row2 = $result2->fetch_array()) {
            $sound_id = $row2[1];
            $sql = "SELECT * FROM `sounds` WHERE `sound_id`= $sound_id";
            // result3 is one specific sound
            $result3 = $mysqli->query($sql);
            $sound = $result3->fetch_object();

            print "<div class='container'><div class='wrapper'>";
            print "<div class='sound'><div class = 'soundBtn'>";
            print "<i class='material-icons'>play_circle_outline</i>";
            print "<audio><source src='".$sound->sound."'></audio></div></div>";
            print "<img src='".$sound->image."'alt='image'>";
            print "</div><div class='padder'></div></div>";
        }
        print "</div>";
    }
    print "</div>";
    print "</section>";
  }
}
  /* Print all public board for no logged in user*/
  print "<section id='publicboardSection'>";
  // if user logged in, hide public first and display if they click public board
  if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
    print "<div class='board' style='display:none'>";
  } else {
    print "<div class='board' style='display:flex'>";
  }
    $sql = "SELECT * FROM `soundboard` WHERE `public` = 1";
    $result1 = $mysqli->query($sql);
    while($row1 = $result1->fetch_assoc()) {
        $board_id = $row1["board_id"];
        $sql = "SELECT * FROM `has_sounds` WHERE `board_id` = $board_id";
        // result2 is a board with mutiple sounds
        $result2 = $mysqli->query($sql);
        while($row2 = $result2->fetch_array()) {
            $sound_id = $row2[1];
            $sql = "SELECT * FROM `sounds` WHERE `sound_id`= $sound_id";
            // result3 is one specific sound
            $result3 = $mysqli->query($sql);
            $sound = $result3->fetch_object();

            print "<div class='container'><div class='wrapper'>";
            print "<div class='sound'><div class = 'soundBtn'>";
            print "<i class='material-icons'>play_circle_outline</i>";
            print "<audio><source src='".$sound->sound."'></audio></div></div>";
            print "<img src='".$sound->image."'alt='image'>";
            print "</div><div class='padder'></div></div>";
          }
    }
    print "</div>";
    print "</section>";
?>

<?php
    include './views/addBoardModal.tpl';
    include './views/remindactiveModal.tpl';
    include './views/footer.tpl';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {

  <?php
    if( isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
      if( $_SESSION['active'] === 0) {
        $email = $_SESSION['email'];
        print "$('#remindActive').modal('show');";
        print "$('#remindActiveModalLabel').html('a verification email has been sent";
        print " to $email.<br><br> for your account security, Please verify your email<br><br>";
        print " by clicking the link on the email.<br><br> Thank you.');";
      }
    }
  ?>

  $("#addBtn").click(function () {
    SBC.addBoard();
  });
  $("#publicTag").click(function () {
    SBC.hideUserBoard();
  });
  $(".wrapper").mouseover(function() {
    $(this).find("i").css('visibility', 'visible');
  });
  $(".wrapper").mouseout(function() {
    $(this).find("i").css('visibility', 'hidden');
  });
});


var SBC = {};
SBC.hideUserBoard = function hideUserBoard() {
  $("#boardSection .board").each(function() {
      $(this).attr('style',"display:none");
  });
  $("#publicboardSection .board").each(function() {
      $(this).attr('style',"display:flex");
  });
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }
    return true;
}
function postback(boardID) {
    $.post("./check/board_change.php",
    {
        board_id: boardID
    },
    function(data, status){
      if(data == "ERROR") {
        alert("Error... can not swith board");
      } else {
        $(".dropdown-menu a").each(function() {
            if($(this).attr('id') == data) {
              $(this).attr('style',"background-color:lightblue");
            } else {
              $(this).attr('style',"background-color:transparent");
            }
        });
        $("#publicboardSection .board").each(function() {
            $(this).attr('style',"display:none");
        });
        $("#boardSection .board").each(function() {
            if($(this).attr('id') == data) {
              $(this).attr('style',"display:flex");
            } else {
              $(this).attr('style',"display:none");
            }
        });
      }
    });
}

SBC.addBoard = function addBoard(record) {
    $('#addModal').modal('show');
    $("#myModalLabel").html("Add Board");
    $("#actionBtn").attr('value','AddBoard');
}

var els = document.querySelectorAll('.soundBtn');
for(i = 0; i < els.length; i++) {
    els[i].addEventListener('click', function () {
    var icon = this.getElementsByTagName('i')[0];
    var sound = this.getElementsByTagName('audio')[0];
    if (sound.paused) {
        sound.play();
        icon.textContent = "pause_circle_outline";
      } else {
        sound.pause();
        icon.textContent = "play_circle_outline";
      }
      sound.onended = function() {
        icon.textContent = "play_circle_outline";
      }
    }, false);
  }
</script>
</body>
</html>
