<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
  <link rel='stylesheet' href='./css/login.css'>
</head>
  <div class="form">
    <div id="signup">
      <h1>Sign Up</h1>
      <form action="./index.php" method="post" >
        <div class="field-wrap">
          <label>First Name<span class="req">*</span></label>
          <input type="text" name="firstname" maxlength="20" placeholder="enter your first name">
          <span class = "error"><?php echo isset($first_nameErr) ? $first_nameErr : '';?></span>
        </div>
        <div class="field-wrap">
          <label>Last Name<span class="req">*</span></label>
          <input type="text" name="lastname" maxlength="20" placeholder="enter your last name">
          <span class = "error"><?php echo isset($last_nameErr) ? $last_nameErr : '';?></span>
        </div>
        <div class="field-wrap">
          <label>Email Address<span class="req">*</span></label>
          <input type="text" name="email" maxlength="30" placeholder="enter a email address">
          <span class = "error"><?php echo isset($emailErr) ? $emailErr : '';?></span>
        </div>
        <div class="field-wrap">
          <label>Password<span class="req">*</span></label>
          <input type="password" name="password" maxlength="30" placeholder="enter a password">
          <span class = "error"><?php echo isset($passwordErr) ? $passwordErr : '' ;?></span>
        </div>
          <button type="submit" class="button button-block" name="user_submit" value="register">Register</button>
      </form>
    </div>
  </div>
</body>
</html>
