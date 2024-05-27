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
            background-color: #333;
            color: #fff;
            border: none;
            padding: 1rem 5rem;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin: 0;
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
        }
        .h2O{
            display: flex; 
            justify-content:space-between;
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
    <div class="owner-dashboard">

        <div class="staff-management">
            <h2 class="h2O";>Staff Management
                <a href="staffregistration.php">
                    <button type="button">Hire Staff</button>
                </a>
                <a href="staffdelete.php">
                    <button type="button">Fire Staff</button>
                </a>
                
            </h2>
            <?php
            include 'ownerstaff.php';
            $get = new Staff;
            if($status = "Active"){
                $getStaff = $get->getstaffstatus($status);
            }
            ?>

            <h3 class="bookings">Staff information</h3>

            <div class="bookingtable">
                <table id="salesTable">
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th>Last Logout</th>
                    </tr>
                    <?php foreach ($getStaff as $staff) { ?>
                        <tr>
                        <td><?php echo $staff['staff_fname'] . " " . $staff['staff_mname'] . " " . $staff['staff_lname']; ?></td>
                            <td><?php echo $staff['staff_address']; ?></td>
                            <td><?php echo $staff['staff_contact_num']; ?></td>
                            <td><?php echo $staff['role_name']; ?></td>
                            <td><?php echo $staff['status']; ?></td>
                            <td><?php echo $staff['staff_login']; ?></td>
                            <td><?php echo $staff['staff_logout']; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

        </div>
    </div>
</body>

</html>