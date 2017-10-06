<?php
/* Get the file path of this sound */
$sql = "SELECT * FROM `sounds` WHERE sound_id= ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_sound_id);
$stmt->execute();
$result2 = $stmt->get_result();
$stmt->close();

while($row2 = $result2->fetch_assoc()) {
    $sound = $row2['sound'];
    $image = $row2['image'];
}

/* Delete sound and image on file system */
if(!(unlink($sound) && unlink($image))) {
    $_SESSION['error_message'] = "Fatal Error!! can not delete the file";
    header("location: error.php");
    exit;
}
/*  Delete the sound on both table */
$sql = "DELETE FROM `has_sounds` WHERE sound_id= ? AND board_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ii", $_sound_id, $_board_id);
$stmt->execute();
$stmt->close();
$sql = "DELETE FROM `sounds` WHERE sound_id= ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $_sound_id);
$stmt->execute();
$stmt->close();
