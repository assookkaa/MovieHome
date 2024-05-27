<?php

include 'check-login.php';
$check = new Level();
$check->customer();


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Movie Rooms</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to your external stylesheet -->

    <script>
        function validateReservationTime() {
            var selectedTime = document.getElementById("time").value;
            var parsedSelectedTime = new Date("1970-01-01T" + selectedTime + ":00");
            var allowedStartTime = new Date("1970-01-01T09:00:00");
            var allowedEndTime = new Date("1970-01-01T21:00:00");

            if (parsedSelectedTime >= allowedStartTime && parsedSelectedTime <= allowedEndTime) {
                // window.location.href = "payment.php";
            } else {
                alert("Room reservations are only allowed from 9:00 AM to 9:00 PM.");
            }
        }

        function updatePrice() {
            var persons = document.getElementById("persons").value;
            var basePrice = 300.00;

            // Adjust the price based on the number of persons
            if (persons == 1) {
                basePrice = 250.00; // Adjust the price for 1 person
            }

            // Update the price display
            document.getElementById("price").innerHTML = "Price: " + basePrice.toFixed(2);
        }
    </script>
    <style>
        /* Add your CSS styles here for the two-column layout */
        .room-container {
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .ticket {
            width: 48%;
            margin: auto;
            box-sizing: border-box;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <header>
        <img class="logo" src="/pictures/moviehome.jpg" width="300" height="100" alt="logo" style="border-radius: 300px;">
        <h1 style="font-family:Verdana, Geneva, Tahoma, sans-serif;font-size: 400%;">Movie Home
        </h1>
        <nav>
            <ul style="font-family: -webkit-body;font-size: 16;">
                <li><a href="index-logged.php">HOME</a></li>
                <li><a href="movies.php">MOVIES</a></li>
                <li><a href="rooms.php">ROOMS</a></li>
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </nav>
    </header>

    <br>
    <?php
    include 'book.php';
    include 'viewmov.php';

    if (isset($_GET['movie']) && isset($_GET['room'])) {
        $book = new Book;
        // $movie = $_GET['movie'];
        // $rooms = $_GET['room'];

        if (isset($_POST['Reserve'])) {
            $userid = $_SESSION['user_id'];
            $date = $_POST['date'];
            $start = $_POST['time'];

            $movie = new movie;
            $movieid = $_GET['movie'];
            $selectedMovie = $movie->selectedmovie($movieid);

            if ($selectedMovie) {
                $price = $selectedMovie['price'];
                $duration = $selectedMovie['duration'];

                // Calculate end time based on start time and movie duration
                $movieDuration = strtotime($duration) / 60;
                // Calculate the end time by adding movie duration + 30 minutes to the start time
                $endTime = date('H:i', strtotime($start) + ($movieDuration + 30) * 60);

                $quantity = $_POST['persons'];
                $additionalPersons = max(0, $quantity - 2);
                $totalCost = $price + ($additionalPersons * 70);

                $status = "Unpaid";

                $roomId = $_GET['room'];
                switch (true) {
                    case !$book->isRoomAvailable($roomId, $date, $start, $endTime):
                        echo "Room is not available for the selected time";
                        break;
                    case $bookingId = $book->book($userid, $date, $start, $endTime, $quantity, $totalCost, $status):
                        $movie = $_GET['movie'];
                        $rooms = $_GET['room'];
                        $bookroom = $book->bookedrooms($bookingId, $rooms);
                        $bookmovie = $book->bookedmovie($bookingId, $movie);
                        echo '<script>alert("Room successfully booked!");</script>';
                        header('location: customerpage.php');
                    break;
                    default:
                        echo "Booking failed";
                }
            } else {
                echo "Selected movie not found";
            }
        } else {
            echo "Select date and time";
        }
    }
    ?>
    <div class="room-container">
        <div class="ticket">
            <form method="POST">
                <h3>Room Number: <?php
                                    $room = new Room;
                                    $roomId = $_GET['room'];
                                    $selectedRoom = $room->selectedroom($roomId);

                                    if ($selectedRoom) {
                                        echo  $selectedRoom['room_number'];
                                    }
                                    ?>
                </h3>
                <h3>Movie Selected: <?php
                                    $movie = new movie;
                                    $movieid = $_GET['movie'];
                                    $selectedMovie = $movie->selectedmovie($movieid);

                                    if ($selectedMovie) {
                                        echo  $selectedMovie['title'];
                                    }
                                    ?>
                </h3>
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Select Showtime:</label>
                <input type="time" id="time" name="time" required onchange="validateReservationTime()">

                <label for="persons">Number of Persons:</label>
                <input id="persons" name="persons" onchange="updatePrice()">
                </input>
            
                <button type="submit" name="Reserve" class="buy-button" onclick="validateReservationTime()">Reserve Room</button>
        </div>

        <footer>
            <div class="footer-content">
                <img class="logo" src="/pictures/moviehome.jpg" width="300" height="100" alt="logo" ; style="border-radius: 300px;"><br>

                <div class="social-media">
                    <div>
                        <i class="fa fa-map-marker"></i>
                        <span>Dumaguete City</span> Negros Oriental
                    </div>
                    <br>
                    <div>
                        <i class="fa fa-phone"></i>
                        +639956621612
                    </div>
                    <br>
                    <div>
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:moviehome@gmail.com">moviehome@gmail.com</a>
                    </div>
                </div>
                <br>

                <div class="footer-right">
                    <p class="footer-company-about">
                        <span> </span>
                        "Escape reality. Embrace the magic. Movie Home Theatre where every moment is a blockbuster waiting to happen!
                    </p>
                    <div class="footer-icons">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-google"></i></a>
                    </div>
                </div>
            </div>

            <p>&copy; 2023 Movie Theatre. All rights reserved.</p>
        </footer>

        </footer>

</body>

</html>