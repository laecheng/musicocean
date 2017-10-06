<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <link rel='stylesheet' href='/myboard/css/login.css'>
</head>
<body>
  <div class="form">
    <h1>Reset Password</h1>
      <form action=<?= $_SERVER['PHP_SELF'] ?> method="post">
        <div class="field-wrap">
          <label>Your email address<span class="req">*</span></label>
          <input type="text" name="email" maxlength="25" placeholder="youemail@example.com">
          <span class = "error"><?php echo $emailErr;?></span>
        </div>
        <button type="submit" class="button button-block">send reset link</butoon>
      </form>
    </div>
  </div>
</body>
</html>
