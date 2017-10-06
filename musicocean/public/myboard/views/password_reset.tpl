<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <link rel='stylesheet' href='./css/login.css'>
</head>

<body>
  <div class="form">
    <h1>Reset Password</h1>
      <form action="./action.php" method="post">
        <div class="field-wrap">
          <label>Enter a new password<span class="req">*</span></label>
          <input type="password" name="newpassword" maxlength="30" placeholder="password">
          <span class = "error"><?php echo $newpasswordError;?></span>
        </div>
        <div class="field-wrap">
          <label>Comfirm your password<span class="req">*</span></label>
          <input type="password" name="confirmpassword"  maxlength="30" placeholder="password">
          <span class = "error"><?php echo $confirmpasswordError;?></span>
        </div>
        <button type="submit" class="button button-block">reset</butoon>
        <input type="hidden" name="action" value="resetpassword">
    </div>
</body>
</html>
