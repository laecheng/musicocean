<?php
/* The Business Logic layer for this app
	 handle CRUD sounds, reset password
	 manipulate database */
session_start();
require './check/request_type_check.php';
require './db.php';

$action = $_POST['action'];
// update password
if ($action === "resetpassword") {

		$email = $_SESSION['reset_email'];
		$hash = $_SESSION['reset_hash'];
		$new_password = $_POST['newpassword'];
		$confirm_password = $_POST['confirmpassword'];
		$new_password = trim($new_password);
    $new_password = stripslashes($new_password);
    $new_password = htmlspecialchars($new_password);
		$confirm_password = trim($confirm_password);
		$confirm_password = stripslashes($confirm_password);
		$confirm_password = htmlspecialchars($confirm_password);
		$newpasswordError = $confirmpasswordError = "";

		if (!preg_match('/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/', $new_password)) {
	    $newpasswordError = "password must be at least 8 characters with upper, lower letter, digit";
			include './views/password_reset.tpl';
			exit;
		} else if ($new_password !== $confirm_password) {
			$confirmpasswordError = "passwords you entered does not match";
			include './views/password_reset.tpl';
			exit;
		} else {
			// reset password using the email and hash in SESSION
			$options = [
					'cost' => 12
			];
			$new_password = password_hash($new_password, PASSWORD_BCRYPT, $options);

			$stmt = $mysqli->prepare("UPDATE `users` SET `password` = ? WHERE email = ? AND password = ?");
			$stmt->bind_param('sss', $new_password, $email, $hash);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();

			// unset the session for email and hash
			unset($_SESSION['reset_email']);
			unset($_SESSION['reset_hash']);

			//redirect
			include './views/password_reset_success.tpl';
			exit;
		}
}

require './check/sessioncheck.php';
require './log/log_access_sound.php';
/* Delete current board of this user */
if ($action === "DeleteBoard") {
	$_board_id = $_POST['board_id'];
	$user_id = $_SESSION['user_id'];

	/* Do a bunch of check before deleting !!!! */
	if(!$_SESSION['isadmin']) {
			require './check/board_match_check.php';
	}

	// Delete all the sounds in this board
	$sql = "SELECT * FROM `has_sounds` WHERE `board_id` = $_board_id";
	$result = $mysqli->query($sql);
	while($row = $result->fetch_array()) {
			$_sound_id = $row[1];
			require './delete_sound.php';
	}

	// Delete this board itself
	$mysqli->query("DELETE FROM `soundboard` WHERE `board_id` = $_board_id");
	if($_SESSION['isadmin']) {
		$mysqli->query("DELETE FROM `has_boards` WHERE `board_id` = $_board_id");
	} else {
		$mysqli->query("DELETE FROM `has_boards` WHERE `board_id` = $_board_id AND `user_id` = $user_id");
	}

	if($_SESSION['isadmin']) {
		// fecth any board for the admin to display
		$result = $mysqli->query("SELECT * FROM `soundboard`");
		while($row = $result->fetch_assoc()) {
				$board_id = $row["board_id"];
				break;
		}
		// if no board, set current board to 0
		if( $result->num_rows == 0) {
			$board_id = 0;
		}
	} else {
		// fecth the avalible board for the user
		$sql = "SELECT * FROM `has_boards` WHERE `user_id` = $user_id";
		$result = $mysqli->query($sql);
		while($row = $result->fetch_assoc()) {
				$board_id = $row["board_id"];
				break;
		}
		if( $result->num_rows == 0) {
			$board_id = 0;
		}
	}
	$_SESSION['current_board_id'] = $board_id;
	header('location: ./soundboard.php');
	exit;
}

/* Add one board for the user */
if ($action == "AddBoard") {
	$user_id = $_SESSION['user_id'];
	$board_name = $_POST['board_name'];
	$public = ($_POST['auth'] == 'public') ? 1 : 0;

	require './check/add_board_check.php';

	// create a new board in table soundboard
	$sql = "INSERT INTO `soundboard` (`board_name`, `public`) VALUES (?,?)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('si', $board_name, $public);
	if($stmt->execute() === true) {
		// get new generated id of this board
		$board_id = $mysqli->insert_id;
	}
	$stmt->close();
	$_SESSION['current_board_id'] = $board_id;

	// update tables has_boards for this user
	$sql = "INSERT INTO `has_boards` (`board_id`, `user_id`)
	        VALUES ('$board_id', '$user_id')";
	$mysqli->query($sql);

	header('Location: ./soundboard.php');
	exit;
}

else if ($action == "Delete") {
		$_sound_id = $_POST['sound_id'];
		$_board_id = $_POST['board_id'];
		$user_id = $_SESSION['user_id'];
		/* Do a bunch of check before deleting !!!! */
		/* Check if user is trying to modify other board */

		if(!$_SESSION['isadmin']) {
				require './check/sound_board_match_check.php';
		}
		$_SESSION['current_board_id'] = $_board_id;

		require './delete_sound.php';
		// redirect
		header('Location: ./editboard.php');
		exit;
}

/* Update the sound and image on the current board */
else if ($action == "Update") {
			$_sound_id = $_POST['sound_id'];
			$_board_id = $_POST['board_id'];
			$_sound_name = $_POST['sound_name'];
			$user_id = $_SESSION['user_id'];

			require './check/sound_board_match_check.php';

			require './check/add_edit_check.php';

			$_SESSION['current_board_id'] = $_board_id;

			if(!empty($_sound_name)) {
				$sql = "UPDATE `sounds` SET  `name` = ?
																WHERE `sound_id` = ?";
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('si', $_sound_name, $_sound_id);
				$stmt->execute();
				$stmt->close();
			}
			// if file is chosen, upload and update
			if($_FILES['file_image']['size'] != 0) {
					require './upload_image.php';
					/* Replace the image and sound in file system */
					$sql = "SELECT * FROM `sounds` WHERE sound_id= ?";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param("i", $_sound_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$stmt->close();
					while($row = $result->fetch_assoc()) {
							$image = $row['image'];
					}
					if(!unlink($image)) {
						$_SESSION['error_message'] = "Err, can not delete the sound";
						header("location: ./error.php");
						exit;
					}
					// update the new audio path in database
					$sql = "UPDATE `sounds` SET  `image` = ?
																	WHERE `sound_id` = ?";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('si', $image_destination_url, $_sound_id);
					$stmt->execute();
					$stmt->close();
			}

			if($_FILES['file_sound']['size'] != 0) {
					require './upload_sound.php';
					// delete the audio file in uploads directory
					$sql = "SELECT * FROM `sounds` WHERE sound_id= ?";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param("i", $_sound_id);
					$stmt->execute();
					$result = $stmt->get_result();
					$stmt->close();
					while($row = $result->fetch_assoc()) {
							$sound = $row['sound'];
					}
					if(!unlink($sound)) {
						$_SESSION['error_message'] = "Err, can not delete the sound";
						header("location: ./error.php");
						exit;
					}
					// update the new audio path in database
					$sql = "UPDATE `sounds` SET `sound` = ?
																	WHERE `sound_id` = ?";
					$stmt = $mysqli->prepare($sql);
					$stmt->bind_param('si', $sound_destination_url, $_sound_id);
					$stmt->execute();
					$stmt->close();
			}
			// redirect
			header('Location: ./editboard.php');
			exit;
}

/* Add sound to the current board */
else if ($action == "Add") {

		$_board_id = $_POST['board_id'];
		$user_id = $_SESSION['user_id'];

		if($_FILES['file_image']['size'] == 0) {
			$_SESSION['error_message'] = "You must choose a image file";
			header("location: ./error.php");
			exit;
		}
		if($_FILES['file_sound']['size'] == 0) {
			$_SESSION['error_message'] = "You must choose a audio file";
			header("location: ./error.php");
			exit;
		}
		/* Check if user is adding sound to its own board */
		if(!$_SESSION['isadmin']) {
			$sql = "SELECT `board_id` FROM `has_boards` WHERE `user_id` = $user_id";
			$result = $mysqli->query($sql);
			$boardMatch = false;
			while($row = $result->fetch_assoc()) {
					$board_id = $row['board_id'];
					if($board_id === $_board_id) {
						$boardMatch = true;
					}
			}
			if(!$boardMatch) {
					$_SESSION['error_message'] = "your request does not match the record";
					header("location: ./error.php");
					exit;
			}
		}
		// now user on board current_board_id
		$_SESSION['current_board_id'] = $_board_id;
		/* get user input data and do validate and sanitize*/
		$_sound_name = $_POST['sound_name'];

		require './check/add_edit_check.php';

		/* Upload the sound and image to system directory */
		require './upload_image.php';
		require './upload_sound.php';

		/* Now we can add this sound to table sounds */
		$image_path = $image_destination_url;
		$sound_path = $sound_destination_url;

		$sql = "INSERT INTO `sounds` (name, image, sound) VALUES (?,?,?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('sss', $_sound_name, $image_path, $sound_path);
		if($stmt->execute() === true) {
			 $sound_id = $mysqli->insert_id;
		}
		$stmt->close();

		/*  Add board_id and sound_id to has_sounds */
		$sql = "INSERT INTO `has_sounds` (`board_id`, `sound_id`)
		        VALUES ('$_board_id', '$sound_id')";
		$mysqli->query($sql);
		// redirect
		header('Location: ./editboard.php');
		exit;
	}
