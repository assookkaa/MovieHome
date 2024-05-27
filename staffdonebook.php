<?php
include 'check-login.php';
include 'dbcon.php';
$check = new Level();
$check->staff();



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> 
    <!-- <style>
        body,
        h1,
        h2,
        p,
        ul,
        li {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: whitesmoke;
        }

        header {
            background-color: orange;
            color: black;
            text-align: center;
            padding: 1rem;

        }

        header h1 {
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

        .movie-list,
        .room-management {
            background-color: #fff;
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(230, 201, 14, 0.1);
        }

        .movie-list h2,
        .room-management h2 {
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
        select,
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

        #schedule {
            background-color: #fff;
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #time-slots {
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }

        #time-slots label,
        #time-slots select {
            margin-bottom: 15px;
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
           
            margin-bottom: 1.5rem;
        }
    </style> -->
</head>

<body>

    <div>
        <style>
            .bookings {
                padding: 1rem;
                background-color: white;
                float: left;
                margin-left: 1rem;
                border-radius: 5px;

            }

            .bookingtable {
                padding: 1rem;
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
                font-size: 18px;
            }

            #salesTable th {
                background-color: #4CAF50;
                color: #fff;
            }

            #salesTable tr {
                background-color: #f2f2f2;
            }
        </style>
        <?php
        include 'navigation/staffnav.php';
        include 'staffbooks.php';
        $books = new CustomerBooking;
     
        if ($status = 'Done') {
            $done = $books->getAllBookings($status);
        }

        if (isset($_POST['Confirm'])) {
            $bookingId = $_POST['bookingId'];
            $staffId = $_SESSION['staff_id'];
            $confirmed = $books->confirmBooking($staffId,$bookingId);
            

            if ($confirmed) {
                echo "Booking confirmed successfully!";
            }
        }
        ?>
        <style>
            .bookings h3 :hover{ 
                background-color: grey;
            }
        </style>
        <a href="staff.php">
        <h3 class="bookings">Bookings to approve</h3>
        </a>
        <a href="staffconfirmed.php">
        <h3 class="bookings">Confirmed Bookings</h3>
        </a>
        <a href="staffdonebook.php">
        <h3 class="bookings">Done Bookings</h3>
        </a>
        <a href="staffbookcancel.php">
        <h3 class="bookings">Cancelled Bookings</h3>
        </a>
        <div class="bookingtable">
            <table id="salesTable">
                <tr>
                    <th>Staff that confirmed its done</th>
                    <th>Name</th>
                    <th>Movie</th>
                    <th>Room</th>
                    <th>Time</th>
                    <th>Amount</th>
                    <th>Status</th>
                    

                </tr>
                <?php foreach ($done as $book) { ?>
                    <tr>
                    <td><?php echo $book['staff_fname'] . " ". $book['staff_mname'] . " ". $book['staff_lname'];?></td>
                        <td><?php echo $book['fname'] . " " . $book['mname'] . " " . $book['lname']; ?></td>
                        <td><?php echo $book['movie_title']; ?></td>
                        <td><?php echo $book['room_number']; ?></td>
                        <td><?php echo $book['booking_start'] . ' - ' . $book['booking_end']; ?></td>
                        <td><?php echo $book['total_cost']; ?></td>
                        <td><?php echo $status; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

</body>

</html>