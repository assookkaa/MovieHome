<?php

include 'check-login.php';
$check = new Level();
$check->customer();


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: orange;
            color: black;
            padding: 1em;
            text-align: center;
        }

        nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    /* background-color: #333; */
    display: flex;
    justify-content: center; /* Center the navigation items horizontally */
    align-items: center; /* Center the navigation items vertically */
    }

    nav li {
        float:right;
    }

nav li a {
    display: block;
    color: black;
    text-align: center; /* Center the text within the navigation items */
    padding: 14px 16px;
    text-decoration: none;
}


        section {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        p {
            color: #555;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Movie Theatre</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="movies.html">Movies</a></li>
                <!-- Add other navigation links as needed -->
            </ul>
        </nav>
    </header>
    <?php 
include 'book.php';

if (isset($_GET['booking'])) {
    $bookingId = $_GET['booking'];
    $userid = $_SESSION['user_id'];
    $receipt = new Book;

    $details = $receipt->receipt($userid, $bookingId);
}

?>
    <section id="receipt">
        <h2 style="color: #333; text-align: center;">Payment Receipt</h2>
        <div>
            <p><strong>Movie:</strong> <span id="selected_movie">Fast X</span></p>
            <p><strong>Date:</strong> <span id="selected_date">Select Day</span></p>
            <p><strong>Showtime:</strong> 9:00 PM</p>
            <p><strong>Room:</strong> Room 1</p>
            <p><strong>Price:</strong> 300.00</p>

            <p><strong>Selected Foods:</strong></p>
            <ul id="selected_foods">
                <!-- Food items will be dynamically added here -->
            </ul>

            <!-- Display the total cost -->
            <p><strong>Total Cost:</strong> <span id="total_cost">300.00</span></p>

            <!-- Display payment details -->
            <p><strong>Payment Method:</strong> GCash</p>
            <p><strong>Phone Number:</strong> 123-456-7890</p>

            <p style="text-align: center;">Thank you for your reservation!</p>
        </div>
    </section>
</body>

</html>
