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
        <input type="password" id="loginPassword" name="loginPassword"  required>
      </p>
      
      <button type="submit" name="loginButton">LOG IN</button>

    </form>
  </div>
</body>
</html>