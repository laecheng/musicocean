<?php
// use parameterized query to prevent SQL injection!!!
$stmt = $mysqli->prepare("SELECT * FROM users WHERE email= ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// If no such email exists in database, go to error page
if ( $result->num_rows == 0 ) {
    $emailErr = "user with this email does not exist";
    require './views/signin.tpl';
    exit;
}
  else { // user exist
      // store user info to session
      $user = $result->fetch_assoc();
      $_SESSION['isadmin'] = ($user['admin'] == 1) ? 1 : 0;
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['first_name'] = $user['first_name'];
      $_SESSION['last_name'] = $user['last_name'];
      $_SESSION['active'] = $user['active'];
      $user_id = $_SESSION['user_id'];

      // fecth the first board for the user
      $sql = "SELECT * FROM `has_boards` WHERE `user_id` = $user_id";
      $result = $mysqli->query($sql);
      while($row = $result->fetch_assoc()) {
          $board_id = $row["board_id"];
          break;
      }

      if($result->num_rows == 0) {
          $_SESSION['current_board_id'] = 0;
      } else {
          $_SESSION['current_board_id'] = $board_id;
      }
      if (password_verify($password, $user['password']) ) {
          // this tell us user is actually logged in
          $_SESSION['logged_in'] = true;
          // update log
          require './log/log_login_success.php';
          // redirect to the main page for the app
          header("location: ./soundboard.php");
      }
      else {
          require './log/log_login_fail.php';
          $passwordErr = "wrong password, try again";
          include './views/signin.tpl';
      }
}
