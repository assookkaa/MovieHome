<?php
require 'dbcon.php';
require 'log.php';

session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = new log;
    $login->login($email, $password);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="form.css">
</head>

<body>
    <div class="login-container">
        <h2>Login to Movie Home</h2>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" name="login" value="Login"><br><br>
            <a href="register.php">
                <style>
                    .no-design {
                        background: none;
                        border: none;
                        color: inherit;                      
                        text-decoration: none;                       
                        cursor: pointer;                        
                        padding: 0;                    
                        font: inherit;                       
                    }
                </style>
                <button type="button" class="no-design">No Account?</button>
            </a>
        </form>
    </div>
</body>

</html>