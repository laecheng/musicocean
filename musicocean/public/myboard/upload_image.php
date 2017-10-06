<?php
if($_FILES['file_image']) {
    $file_image_tmp = $_FILES['file_image']['tmp_name'];
    $file_image_size = $_FILES['file_image']['size'];
    $error = 0;
    $err_msg = '';
    // Dectect image type user upload
    $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
    $detectedType = exif_imagetype($file_image_tmp);

    echo "before compression: " . filesize($file_image_tmp). "<br>";
    if(!in_array($detectedType, $allowedTypes)) {
        $error = 1;
        $err_msg = "please make sure you sumbit a jpg, png, or gif";
    }
    if ($file_image_size > 1000000) {
        $error = 1;
        $err_msg = "please make sure your image is less than 1MB";
    }
    if($error) {
        $_SESSION['error_message'] = $err_msg;
        header('location: ./error.php');
        exit;
    }
    // upload and compress
    if ($detectedType == IMAGETYPE_PNG) {
      $image = imagecreatefrompng($file_image_tmp);
    } else if ($detectedType == IMAGETYPE_JPEG) {
      $image = imagecreatefromjpeg($file_image_tmp);
    } else if ($detectedType == IMAGETYPE_GIF) {
      $image = imagecreatefromgif($file_image_tmp);
    }
    $unique = uniqid("",false);
    $image_destination_url = "./uploads/images/".$unique.".jpg";
    imagejpeg($image, $image_destination_url, 60);
  }
