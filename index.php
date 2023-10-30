<?php
    session_start();

    if ($_GET['page'] === 'login' || $_GET['page'] === 'signup') {
        $_SESSION['currUser'] = null;
    }

    if (!isset($_SESSION['currUser']) && $_GET['page'] !== 'login' && $_GET['page'] !== 'signup') {
        header("Location: index.php?page=login");
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="description" content="Your website description goes here.">
    
    <title> popcorn! | log-in </title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">


    <!-- Import jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- External Javascript -->
    <script src="main.js"></script>

    <!-- External Stylesheets -->
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="animations.css">

</head>
<body onload = 'onload()'>
    <!-- Header -->
    <div id = 'header'></div>



    <!-- Login Page -->
    <div id="loginPage"></div>

    <!-- Sign Up Page -->
    <div id="signupPage"></div>

    <!-- Create Account Page -->
    <div id="createAccountPage"></div>

    <!-- Feed Page -->
    <div id="feedPage"></div>

    <!-- Search Page -->
    <div id="searchPage"></div>


    <!-- Notification Page -->
    <div id="notificationsPage"></div>

    <!-- Account Page -->
    <div id="userProfilePage"></div>

    <!-- Footer -->
    <div id="footer"></div>
</body>

</html>