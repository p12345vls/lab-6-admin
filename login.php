<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>
        Login Page
        </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="main.css" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <body>
        
        <h2>Login Form</h2>
       
        <form method="post" action="loginProcess.php">

            <div class="imgcontainer">
                <img src="img.png" alt="Avatar" class="avatar">
            </div>

            <div class="container">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <div class="bottom">
                <button type="submit" class = 'btn btn-primary' name="submitForm" value="Login!" />Login</button>
                </div>
            </div>
            <?php
            if ($_SESSION['incorrect']) {
                echo "<p class 'lead' id = 'error' style='color:red;'>";
                echo "<strong>Incorrect Username or Password</strong></p>";
            }
            ?>
    </body>
</html>
