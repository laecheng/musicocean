<?php
    // Register user to database
    $options = [
        'cost' => 12
    ];
    $password = password_hash($password, PASSWORD_BCRYPT, $options);

    /* create a new user using parameterized query */
    $sql = "INSERT INTO users (last_name, first_name, email, password, admin, active)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $admin = 0;
    $active = 0;
    $stmt->bind_param("ssssii", $last_name, $first_name, $email, $password, $admin, $active);
    $stmt->execute();
    $user_id = $mysqli->insert_id;
    $stmt->close();

    // Send registration confirmation link (verify.php)
    $to = $email;
    $subject = 'Account Verification ( www.qooqles.com)';
    $message_body = '
    Hello '.$first_name.',

    Thank you for signing up!

    Please click this link to activate your account:

    http://localhost/myboard/verify.php?email='.$email.'&hash='.$password;

    require './sendmail.php';

    /* create a default sound board for user */
    $default = $first_name." default";
    $sql = "INSERT INTO `soundboard` (`board_id`, `board_name`, `public`)
            VALUES (NULL, '$default', '0')";
    // get new board id for user
    if($mysqli->query($sql) === true) {
        $board_id = $mysqli->insert_id;
    }

    // update has_boards for user
    $sql = "INSERT INTO `has_boards` (`board_id`, `user_id`)
            VALUES ('$board_id', '$user_id')";
    $mysqli->query($sql);

    // update log
    $sql = "INSERT INTO logs VALUES ('$user_id', '0', '0', '1', '0', '1', '0')";
    $mysqli->query($sql);

    // store user info to session
    $_SESSION['logged_in'] = true;
    $_SESSION['active'] = 0;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['email'] = $email;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    // current board user is on
    $_SESSION['current_board_id'] = $board_id;
    if($admin == 1) {
      $_SESSION['isadmin'] = 1;
    } else {
      $_SESSION['isadmin'] = 0;
    }
    // redirect to the main page for the app
    header("location: ./soundboard.php");
