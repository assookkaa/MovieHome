<?php
include 'check-login.php';
include 'dbcon.php';
$check = new Level();
$check->manager();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
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

        h1 {
            margin: 0;
        }

        nav ul {
            list-style: none;
        }

        nav ul li {
            display: inline-block;
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 16px;
        }

        .owner-dashboard {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .staff-management h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input,
        button {
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #555;
        }

        .recent-staff {
            margin-top: 30px;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .recent-staff h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .staff-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .staff-info div {
            flex: 1;
            margin-right: 10px;
        }

        .staff-info div:last-child {
            margin-right: 0;
        }

        #salesTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #salesTable th,
        #salesTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #salesTable th {
            background-color: #4CAF50;
            color: #fff;
        }

        #salesTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Style for the Print button */
        button#printButton {
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }

        button#printButton:hover {
            background-color: #45a049;
        } .ulol {
            margin-left: 30rem;
            margin-right: 30rem;
            padding: 20px;
            border-radius: 8px;
            background-color: white;
            justify-content: space-around;
            display: flex;
        }

        .staffdash {
            padding: 1rem;
            background-color: whitesmoke;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
<h1 style="text-align: center;">Owner Dashboard</h1>
    <header>
        <nav>
            <ul class="ulol">
            <li><a href="staffinfo.php">Staff Management</a></li>
                <li><a href="staffarchive.php">Staff Archive</a></li>
                <li><a href="owner.php">View Report</a></li>
                <li><a href="managemovie.php">View Movies</a></li>
                <li><a href="managerooms.php">View Rooms</a></li>
                <li><a href="logout.php">Logout</a></li>
                <!-- <li><a href="#"></a></li> -->
            </ul>
        </nav>
    </header>
    <?php
    include 'ownerstaff.php';
    if (isset($_POST['register'])) {
        if ($_POST['password'] === $_POST['vpassword']) {
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $lname = $_POST['lname'];
            $address = $_POST['address']; // Corrected variable name
            $contact_num = $_POST['contact_num']; // Added missing variable
            $email = $_POST['email'];
            $password = hash('sha256', $_POST['password']);

            $reg = new Staff;
            $reg->hireStaff($fname, $mname, $lname, $address, $contact_num, $email, $password);
            
        } else {
            echo 'Password confirmation failed';
        }
    }
    ?>
    <div class="owner-dashboard">
        <div class="staff-management">
            <h2>Staff Management</h2>
        </div>
        <form method="POST">
            <label for="staffName">Staff Information:</label>
            <input type="text" id="staffName" name="fname" placeholder="First Name" required>
            <input type="text" id="staffName" name="mname" placeholder="Middle Name">
            <input type="text" id="staffName" name="lname" placeholder="Last Name" required>
            <input type="text" id="staffName" name="address" placeholder="Address" required>
            <input type="text" id="staffName" name="contact_num" placeholder="Contact Number" required>
            <input type="email" id="staffName" name="email" placeholder="Email" required>
            <input type="password" id="staffName" name="password" placeholder="Password" required>
            <input type="password" id="staffName" name="vpassword" placeholder="Verify Password" required>

            <!-- <label for="staffRole">Staff Role:</label>
                <input type="text" id="staffRole" name="staffRole" required> -->

            <button type="submit" name="register" type="button" onclick="addStaff()">Add Staff</button>
        </form>
        <a href="staffinfo.php">
            <button>Back</button>
         </a>
    </div>
</body>

</html>