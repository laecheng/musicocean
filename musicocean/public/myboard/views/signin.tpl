<!DOCTYPE html>
<html>
<head>
  <title>Sign-Up/Login Form</title>
  <link rel='stylesheet' href='./css/login.css'>
</head>

<body>
  <div class="form">

    <div id="signin">
    <h1>Welcome To MusicOcean&trade;, a place to discover music</h1>
      <form action="./index.php" method="post">
        <div class="field-wrap">
          <label>Email<span class="req">*</span></label>
          <input type="text" name="email" maxlength="25" placeholder="your email address">
          <span class = "error"><?php echo $emailErr;?></span>
        </div>
        <div class="field-wrap">
          <label>Password<span class="req">*</span></label>
          <input type="password" name="password"  maxlength="30" placeholder="your password">
          <span class = "error"><?php echo $passwordErr;?></span>
        </div>
        <div class="forgot"><a href="./forgetpassword.php">Forgot Password?</a></div>
        <button type="submit" class="button button-block" name="user_submit" value="signin">sign in</butoon>
      </form>
      <form action="./index.php" method="post">
        <button type="submit" class="button button-block" name="user_submit" value="signup">sign up</butoon>
      </form>
    </div>
  </div>
</body>
</html>
