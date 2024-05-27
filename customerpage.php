<?php

include 'check-login.php';
$check = new Level();
$check->customer();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Movie List</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <header>
       <?php include 'navigation/customersession.php'?>
    </header>
    <style>
        .around {
            padding: 2rem;
            background-color: white;
            margin: 2rem;
            border-radius: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .around h2 {
            color: #333;
            font-size: 2rem;
        }

        .flexin {
            display: flex;
            justify-content: center;
        }

        .tablin {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            /* Add a border-radius for softer edges */
            overflow: hidden;
            /* Ensure rounded corners are displayed */
        }

        .tablin th,
        .tablin td {
            border: 1px solid #ddd;
            padding: 1rem;
            /* Increase padding for a more spacious look */
            text-align: center;
            font-size: 1rem;
        }

        .tablin th {
            color: white;
            background-color: #333;
        }
    </style>
    <div class="flexin">
        <?php
        include 'book.php';
        include 'viewmov.php';
        $book = new Book;
        if (isset($_SESSION['user_id'])) {
            $userid = $_SESSION['user_id'];
            $getPaidBookings = $book->getAllBookingsPaid($userid);
            $getBookings = $book->getAllBookings($userid);


            if (isset($_POST['cancel'])) {
                $bookingId = $_POST['bookingId'];
                $userid = $_SESSION['user_id'];
                $cancel = $book->CanecelBook($userid, $bookingId);
            }

            if (!empty($getBookings)) {
        ?>
        
                <div class="around">
                    <table class="tablin">
                        <h2>Unpaid Booking</h2>
                        <tr>

                            <th>Movie</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($getBookings as $booking) : ?>
                            <tr>
                                <td><?php echo $booking['movie_title'] ?></td>
                                <td><?php echo $booking['room_number'] ?></td>
                                <td><?php echo $booking['booking_date'] ?></td>
                                <td><?php echo $booking['booking_start'] ?> - <?php echo $booking['booking_end'] ?></td>
                                <td><?php echo $booking['total_cost'] ?></td>
                                <td><?php echo $booking['status'] ?></td>
                                <td>
                                        <a href="payment.php?booking=<?php echo $booking['booking_id'] ?>">
                                            <button style="margin-right: 10px;">Pay</button></a>
                                <form method="POST">
                                            <input type="hidden" name="bookingId" value="<?php echo $booking['booking_id']; ?>">
                                            <button type="submit" name="cancel">Cancel</button>
                                </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php } 
            if (!empty($getPaidBookings)) {
            ?>
                <div class="around">
                    <table id="salesTable">
                        <h2>Paid Booking</h2>
                        <tr>

                            <th>Movie</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                        <?php foreach ($getPaidBookings as $pbooking) : ?>
                            <tr>
                                <td><?php echo $pbooking['movie_title'] ?></td>
                                <td><?php echo $pbooking['room_number'] ?></td>
                                <td><?php echo $pbooking['booking_date'] ?></td>
                                <td><?php echo $pbooking['booking_start'] ?> - <?php echo $pbooking['booking_end'] ?></td>
                                <td><?php echo $pbooking['status'] . " ". "and Pending" ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
        <?php } 
        }
        ?>

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
        <script>
            function showLoginPopup() {
                alert('Please log in first.');
                window.location.href = 'login.php';

            }

            function showSelectMoviePopup() {
                alert('Please select a movie first.');
                window.location.href = 'movies.php';
            }
        </script>

        <p>&copy; 2023 Movie Theatre. All rights reserved.</p>
    </footer>
</body>

</html>