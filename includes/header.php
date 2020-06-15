<?php
  include('includes/config.php');

  //session_destroy();
  if (isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
  } else {
    header('Location: register.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style.css">
  <title>Welcome to Spotify Clone</title>
</head>
<body>
  <div id="mainContainer">

    <div id="topContainer">


      <?php include("includes/navBarContainer.php"); ?>

      <div id="mainViewContainer">
        <div id="mainContent">