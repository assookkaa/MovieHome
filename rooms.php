
<?php
session_start();
$isCustomerLoggedIn = isset($_SESSION['user_id']) && $_SESSION['roles'] === 'customer';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Movie List</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

    <?php
   
           include 'navigation/customersession.php';
       
    include 'book.php';
    include 'viewmov.php';
    $viewroom = new Room();
    $book = new Book;
    $view = $viewroom->viewroom();

    ?>
    <div class="movie-list">
        <?php foreach ($view as $room) { ?>
            <div class="movie">
                <img src='pictures/rooms/<?php echo $room['room_image'] ?>' style="width:800px;" alt="Room Image">
                <h2>Title: <?php echo $room['room_number']; ?></h2>
                <p style="padding: 7px;">
                    <span style="font-weight: bold;">Capacity: </span><span><?php echo $room['room_capacity']; ?></span>
                </p>

                <?php
                $roomId = $room['room_number'];
                $roomBookings = $book->getRoomBookingsWithTime($roomId);
                ?>
                <h4>Unvailable Time</h4>
                <?php foreach ($roomBookings as $booking) { ?>

                    <li>
                        <?php echo $booking['booking_start'] . ' - '; ?>
                        <?php echo $booking['booking_end'] . ' | '; ?>
                    </li>';


                <?php } ?>

                <?php if ($isCustomerLoggedIn) { ?>
                    <?php if (isset($_GET['movie']) && !empty($_GET['movie'])) { ?>
                        <a href="ticket.php?movie=<?php echo $_GET['movie']; ?>&room=<?php echo $room['room_id']; ?>" class="btn">Reserve</a>
                    <?php } else { ?>
                        <button onclick="showSelectMoviePopup()">Select Movie First</button>
                    <?php } ?>
                <?php } else { ?>
                    <button onclick="showLoginPopup()">Reserve</button>
                <?php } ?>
            </div>
        <?php } ?>
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