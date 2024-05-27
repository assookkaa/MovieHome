<?php
include 'check-login.php';
include 'dbcon.php';
$check = new Level();
$check->admin();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Add any additional styles if needed -->

    <!-- Print stylesheet -->
    <link rel="stylesheet" type="text/css" href="print.css" media="print">
</head>

<body>
    <style>
        .bookings {
            padding: 1rem;
            background-color: white;
            float: left;
            margin-left: 1rem;
            border-radius: 5px;

        }

        .bookingtable {
            padding: 4rem;
        }

        #salesTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;

        }

        #salesTable th,
        #salesTable td {
            color: black;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 18px;
        }

        #salesTable th {
            background-color: #4CAF50;
            color: #fff;
        }

        #salesTable tr {
            background-color: #f2f2f2;
        }

        body {
            font-size: 12pt;
            /* Default font size for printing */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12pt;
            /* Default font size for printing */
        }

        /* Responsive styles for printing */
        @media print {
            body {
                font-size: 10pt;
                /* Adjust font size for printing */
            }

            table {
                font-size: 10pt;
                /* Adjust font size for printing */
            }

            /* Add any other styles to optimize for printing */
        }

        .ulol {
            margin-left: 30rem;
            margin-right: 30rem;
            padding: 20px;
            border-radius: 8px;
            background-color: white;
            justify-content: space-around;
            display: flex;
        }

        .ulol a {
            color: black;
        }
    </style>
    <h1 style="text-align: center;">Welcome Admin</h1>
    <header>
        <nav>
            <ul class="ulol">
                <li><a href="staff.php">View Bookings</a></li>
                <li><a href="owner.php">Records</a></li>
                <li><a href="managemovie.php">View Movies</a></li>
                <li><a href="managerooms.php">View Rooms</a></li>
                <li><a href="logout.php">Logout</a></li>
                <!-- <li><a href="#"></a></li> -->
            </ul>
        </nav>
    </header>
    <!-- <header>
        <h1>Movie Home</h1>
        <h2>Welcome, Admin!</h2>
        <nav>
            <ul>
                <li><a href="staff.php" style="color:black">View Bookings</a></li>
                <li><a href="owner.php" style="color:black">Records</a></li>
                <li><a href="managerooms.php" style="color:black">View Rooms</a></li>
                <li><a href="managemovie.php" style="color:black">View Movies</a></li>
                <li><a href="logout.php" style="color:black">Logout</a></li>
            </ul>
        </nav>
    </header> -->
    
    <?php
    include 'adminstufhaha.php';
    $log = new Slayall;

    $logs = $log->getAllLogsCustomer();
    ?>

    <div class="bookingtable">
        <h3>
            <a href="admindashboard.php"><span style="background-color: whitesmoke; padding:1rem; margin:5px;">All Logs Of Customer </span></a>
            <a href="admindashstaff.php"><span style="background-color: whitesmoke; padding:1rem; margin:5px;">All Logs of Staff</span></a>
            <a href="adminaddstaff.php"><span style="background-color: whitesmoke; padding:1rem; margin:5px;">Add Staff</span></a>
        </h3>
        
        <label for="startDate">Start Date:</label>
<input type="date" id="startDate">

<label for="endDate">End Date:</label>
<input type="date" id="endDate">
        <button id="printButton">Print Report</button>
        <table id="salesTable">
            <h3>All Customer Logs</h3>
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Login Date and Time</th>
                    <th>Logout Date and Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $get) { ?>
                    <tr>
                        <td><?php echo $get['log_id']; ?></td>
                        <td><?php echo $get['role_name']; ?></td>
                        <td><?php echo $get['fname']. " " .$get['mname']. " ".$get['mname'];?></td>
                        <td><?php echo $get['address']; ?></td>
                        <td><?php echo $get['contact_num']; ?></td>
                        <td><?php echo $get['email']; ?></td>
                        <td><?php echo $get['login']; ?></td>
                        <td><?php echo $get['logout']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
        
        document.getElementById('printButton').addEventListener('click', function () {
            function filterTable() {
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        var table = document.getElementById('salesTable');
        var rows = table.getElementsByTagName('tr');

        for (var i = 1; i < rows.length; i++) {
            var rowDate = new Date(rows[i].cells[8].textContent); // Assuming login date is at index 8

            if (startDate && endDate) {
                if (rowDate < new Date(startDate) || rowDate > new Date(endDate)) {
                    rows[i].style.display = 'none';
                } else {
                    rows[i].style.display = '';
                }
            }
        }
    }

    // Attach the filterTable function to the change event of date inputs
    document.getElementById('startDate').addEventListener('change', filterTable);
    document.getElementById('endDate').addEventListener('change', filterTable);
        var table = document.getElementById('salesTable');
        var printContents = '<html><head><title>Logs Report</title>';
        printContents += '<style>';
        printContents += 'body { font-family: Arial, sans-serif; }';
        printContents += 'table { width: 100%; border-collapse: collapse; margin: 20px 0; }';
        printContents += 'th, td { border: 1px solid #dddddd; text-align: left; padding: 10px; }';
        printContents += 'th { background-color: #f2f2f2; }';
        printContents += '</style>';
        printContents += '</head><body>';
        printContents += table.outerHTML;
        printContents += '</body></html>';

        var originalContents = document.body.innerHTML;

        // Open a new window and set the content to the styled table
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(printContents);
        printWindow.document.close();

        // Focus on the new window and initiate the print
        printWindow.focus();
        printWindow.print();

        // Close the new window after printing
        printWindow.close();

        // Restore the original content of the document
        document.body.innerHTML = originalContents;
    });
    </script>


</body>

</html>