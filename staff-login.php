<?php
require 'dbcon.php';
require 'log.php';

session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = new log;
    $login->staffLogin($email, $password);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: orange;
            color: black;
            padding: 10px 0;
            text-align: center;
        }

        header h1 {
            font-family: 'Verdana', Geneva, Tahoma, sans-serif;
            font-size: 2em;
        }

        nav ul {
            list-style: none;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 50px auto;
        }

        form label {
            display: block;
            margin-bottom: 8px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        form button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Movie Home</h1>
        <h2>Staff log-in</h2>
        <!-- <nav>
            <ul>
                <li><a href="index.html" style="color:black">HOME</a></li>
                <li><a href="movies.html" style="color:black">MOVIES</a></li>
                <li><a href="ticket.html" style="color:black">ROOMS</a></li>
                <li><a href="login.html" style="color:black">LOGIN</a></li>
                <li><a href="register.html" style="color:black">REGISTER</a></li>
                <li><a href="staff.html" style="color:black">STAFF</a></li>
            </ul>
        </nav> -->
    </header>
    
    <form id="staffLoginForm" method="POST">
        <label for="username">email:</label>
        <input type="text" id="username" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" name="login">Login</button>
    </form>
</body>

</html>
