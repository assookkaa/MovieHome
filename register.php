<?php

require 'dbcon.php';
require 'log.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>
    <link rel="stylesheet" type="text/css" href="form.css">
</head>
<body>
    <div class="registration-container" >
        <h2>Registration</h2>
<?php

if(isset($_POST['register'])){
    if($_POST['password'] === $_POST['vpassword']){
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $address = $_POST['address']; // Corrected variable name
        $contact_num = $_POST['contact_num']; // Added missing variable
        $email = $_POST['email'];
        $password = hash('sha256', $_POST['password']);

        $reg = new log();
        $reg->register($fname, $mname, $lname, $address, $contact_num, $email, $password);
    } else {
        echo 'Password confirmation failed';
    }
} 

?>


        <form method="POST">
            <div class="form-group">
                <label for="username">First Name:</label>
                <input type="text" id="username" name="fname" required>
            </div>
            <div class="form-group">
                <label for="username">Middle Name:</label>
                <input type="text" id="username" name="mname">
            </div>
            <div class="form-group">
                <label for="username">Last Name:</label>
                <input type="text" id="username" name="lname" required>
            </div>
            <div class="form-group">
                <label for="username">Address:</label>
                <input type="text" id="username" name="address" required>
            </div>
            <div class="form-group">
                <label for="username">Contact Number:</label>
                <input type="text" id="username" name="contact_num" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password">Confirm Password:</label>
                <input type="password" id="password" name="vpassword" required>
            </div>
            <input type="submit" name="register" value="Register">
            
        </form>
        <br>
        <a href="login.php">
        <input type="submit" name="login" value="Log in">
        </a>
    </div>
</body>
</html>
