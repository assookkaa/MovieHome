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
            max-width: 1800px;
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

        .staffdash {
            padding: 1rem;
            background-color: whitesmoke;
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="date"] {
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
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
    <?php
    include 'reports.php';
    $report = new Report();
    $getSales = $report->getSalesReport();
    
    ?>
     <label for="startDate">Start Date:</label>
        <input type="date" id="startDate">

        <label for="endDate">End Date:</label>
        <input type="date" id="endDate">

        <div class="recent-staff">
            <h2>Recent Sales Report</h2>
            <div class="staff-info" id="recentStaffInfo">
                <!-- Recent staff information will be dynamically added here -->
            </div>
        </div>
        <div class="sales-report">
            <h3>Sales Report</h3>
            <table id="salesTable">
                <tr>
                    <th>Booking ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Payment Type</th>
                    <th>Total Amount of People</th>
                    <th>Additional People</th>
                    <th>Initial Cost</th>
                    <th>Additional Cost</th>
                    <th>Amount Paid</th>
                    <th>Total Amount</th>
                    <th>Change</th>
                    <th>Amount Sale</th>
                </tr>
                <?php foreach ($getSales as $salesReport) { ?>
                <tr>
                    <td><?php echo $salesReport['booking_id']; ?></td>
                    <td><?php echo $salesReport['fname']. " ".  $salesReport['mname']. " " .$salesReport['lname'];?></td>
                    <td><?php echo $salesReport['date']; ?></td>
                    <td><?php echo $salesReport['payment_type']; ?></td>
                    <td><?php echo $salesReport['quantity']; ?></td>
                    <td><?php echo $salesReport['additional_people']; ?></td>
                    <td>₱ <?php echo $salesReport['price']; ?>.00</td>
                    <td>₱ <?php echo $salesReport['additional_cost']; ?>.00</td>
                    <td>₱ <?php echo $salesReport['amount']; ?>.00</td>
                    <td>₱ <?php echo $salesReport['amount']; ?>.00</td>
                    <td>₱ <?php echo $salesReport['sukli']; ?>.00</td>
                    <td>₱ <?php echo $salesReport['total'];?>.00</td>
                  
                </tr>
                <?php } ?>
                <tfoot>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold; text-align: right;" >Total Sales: </td>
                    <td>₱ <?php echo $report->getTotalSales();?>.00</td>
                </tfoot>
            </table>
            
            <button id="printButton" onclick="printSalesReport()">Print Sales Report</button><br>
        </div>
    </div>
   
</body>
<script>
     function filterSalesReport() {
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;

            var table = document.getElementById('salesTable');
            var rows = table.getElementsByTagName('tr');

            for (var i = 1; i < rows.length; i++) {
                var rowDate = new Date(rows[i].cells[2].textContent); // Assuming date is at index 2

                if (startDate && endDate) {
                    if (rowDate < new Date(startDate) || rowDate > new Date(endDate)) {
                        rows[i].style.display = 'none';
                    } else {
                        rows[i].style.display = '';
                    }
                }
            }
        }

        // Attach the filterSalesReport function to the change event of date inputs
        document.getElementById('startDate').addEventListener('change', filterSalesReport);
        document.getElementById('endDate').addEventListener('change', filterSalesReport);
    function printSalesReport() {
        var table = document.getElementById("salesTable");
        var printContents = '<html><head><title>Sales Report</title>';
        printContents += '<style>';
        printContents += 'body { font-family: Arial, sans-serif; }';
        printContents += 'table { width: 100%; border-collapse: collapse; }';
        printContents += 'th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; }';
        printContents += 'th { background-color: #f2f2f2; }';
        printContents += 'tfoot td { font-weight: bold; text-align: right; }';
        printContents += '</style>';
        printContents += '</head><body>';
        printContents += table.outerHTML;
        printContents += '</body></html>';

        var originalContents = document.body.innerHTML;

        // Open a new window and set the content to the table with styles
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
    }
</script>

</html>