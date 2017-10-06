<?php
if($_FILES['file_sound']) {
    $file_sound_tmp = $_FILES['file_sound']['tmp_name'];
    $file_sound_name = $_FILES['file_sound']['name'];
    $file_sound_size = $_FILES['file_sound']['size'];
    $error = 0;
    $err_msg = '';

    // Dectect audio type user upload
    $allowedTypes = array(
      'application/octet-stream', 'audio/mpeg', 'audio/x-mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'audio/aiff',
      'audio/mpeg', 'audio/x-mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'audio/aiff',
      'audio/mid', 'audio/x-aiff', 'audio/x-mpequrl','audio/midi', 'audio/x-mid',
      'audio/x-midi','audio/wav','audio/x-wav','audio/xm','audio/x-aac','audio/basic',
      'audio/flac','audio/mp4','audio/x-matroska','audio/ogg','audio/s3m','audio/x-ms-wax',
      'audio/xm'
    );

    $finfo = new finfo(FILEINFO_MIME);
    $detectedType = $finfo->buffer(file_get_contents($file_sound_tmp ));
    $detectedType = explode(";", $detectedType);

    if(!in_array($detectedType[0], $allowedTypes)) {
        $error = 1;
        $err_msg = "please make sure you sumbit corret audio file";
    }
    if ($file_sound_size > 6000000) {
        $error = 1;
        $err_msg = "please make sure your audio file is less than 6MB";
    }
    if($error) {
        $_SESSION['error_message'] = $err_msg;
        header('location: ./error.php');
        exit;
    }
    $unique = uniqid("",false);
    $sound_ext = pathinfo($file_sound_name,PATHINFO_EXTENSION);
    $sound_destination_url = './uploads/sounds/'.$unique.'.'.$sound_ext;
    move_uploaded_file($file_sound_tmp, $sound_destination_url);
  }
