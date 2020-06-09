<?php 
  include("includes/classes/Account.php");
  $account = new Account();
  include("includes/handlers/register-handler.php");
  include("includes/handlers/login-handler.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Spotify Clone!</title>
</head>
<body>
  <div id="inputContainer">
    <form action="register.php" id="loginForm" method="POST">
      <h2>Login to your account</h2>
      <p>
        <label for="loginUsername">Username</label>
        <input type="text" id="loginUsername" name="loginUsername" placeholder="e.g. bartSimpson" required>
      </p>
      <p>
        <label for="loginPassword">Password</label>
        <input type="password" id="loginPassword" name="loginPassword" placeholder="Your password"  required>
      </p>
      
      <button type="submit" name="loginButton">LOG IN</button>

    </form>

    <form action="register.php" id="registerForm" method="POST">
      <h2>Create your free account</h2>
      <p>
        <?php echo $account->getError("Your username must be between 5 and 25 characters"); ?>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="e.g. bartSimpson" required>
      </p>
      <p>
        <?php echo $account->getError("Your first name must be between 2 and 25 characters"); ?>
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="firstName" placeholder="e.g. Bart" required>
      </p>
      <p>
        <?php echo $account->getError("Your last name must be between 2 and 25 characters"); ?>
        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="lastName" placeholder="e.g. Simpson" required>
      </p>
      <p>
        <?php echo $account->getError("Your emails don't match"); ?>
        <?php echo $account->getError("Email is invalid"); ?>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="e.g. bart@gmail.com" required>
      </p>
      <p>
        <label for="email2">Confirm Email</label>
        <input type="email" id="email2" name="email2" placeholder="e.g. bart@gmail.com" required>
      </p>

      <p>
        <?php echo $account->getError("Your passwords don't match"); ?>
        <?php echo $account->getError("Your passwords can only contain numbers and letters"); ?>
        <?php echo $account->getError("Your password must be between 5 and 30 characters"); ?>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Your password" required>
      </p>
      <p>
        <label for="password2">Confirm Password</label>
        <input type="password" id="password2" name="password2" placeholder="Your password" required>
      </p>
      
      <button type="submit" name="registerButton">SIGN UP</button>

    </form>

  </div>
</body>
</html>