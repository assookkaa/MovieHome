<?php
require 'dbcon.php';
require 'log.php';

session_start();

if(isset($_POST['login'])){
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
    <div class="login">
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
            <input type="submit" name="login" value="Login">
        </form>
    </div>
</body>

</html>