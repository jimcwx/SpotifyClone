<?php 

  include("includes/config.php");
  include("includes/classes/Account.php");
  include("includes/classes/Constants.php");
  $account = new Account($con);
  include("includes/handlers/register-handler.php");
  include("includes/handlers/login-handler.php");

  function getInputValue($name) {
    if (isset($_POST[$name])) {
      echo $_POST[$name];
    }
  }
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
        <?php echo $account->getError(Constants::$loginFailed); ?>
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
        <?php echo $account->getError(Constants::$usernameCharacters); ?>
        <?php echo $account->getError(Constants::$usernameTaken); ?>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="e.g. bartSimpson" value="<?php getInputValue("username") ?>" required>
      </p>
      <p>
        <?php echo $account->getError(Constants::$firstNameCharacters); ?>
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="firstName" placeholder="e.g. Bart" value="<?php getInputValue("firstName") ?>" required>
      </p>
      <p>
        <?php echo $account->getError(Constants::$lastNameCharacters); ?>
        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="lastName" placeholder="e.g. Simpson" value="<?php getInputValue("lastName") ?>" required>
      </p>
      <p>
        <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
        <?php echo $account->getError(Constants::$emailInvalid); ?>
        <?php echo $account->getError(Constants::$emailTaken); ?>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="e.g. bart@gmail.com" value="<?php getInputValue("email") ?>" required>
      </p>
      <p>
        <label for="email2">Confirm Email</label>
        <input type="email" id="email2" name="email2" placeholder="e.g. bart@gmail.com" value="<?php getInputValue("email2") ?>" required>
      </p>

      <p>
        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
        <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
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