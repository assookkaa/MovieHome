
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
    
    include 'viewmov.php';
    $viewmov = new movie();
    $view = $viewmov->viewmovie();

    ?>
    <div class="movie-list">
        <?php foreach ($view as $movi) { ?>
            <div class="movie">
                <img src='pictures/movieposter/<?php echo $movi['movie_image'] ?>' style="width:800px;" alt="Movie 1">
                <h2>Title: <?php echo $movi['title']; ?></h2>
                <p style="padding: 7px;">
                    <span style="font-weight: bold;">Description: </span><span><?php echo $movi['description']; ?></span>
                </p>
                <p style="padding: 7px;">
                    <span style="font-weight: bold;">Genre: </span><?php echo $movi['genre']; ?>
                </p>
                <p style="padding: 7px;">
                    <span style="font-weight: bold;">Duration: </span><?php echo $movi['duration']; ?>
                </p>
                <p style="padding: 7px;">
                    <span style="font-weight: bold;">Price: ₱</span><?php echo $movi['price']; ?>
                </p>
                <?php if ($isCustomerLoggedIn) { ?>
                    <a href="rooms.php?movie=<?php echo $movi['movie_id']; ?>" class="btn">Reserve</a>
                <?php } else { ?>
                    <button onclick="showLoginPopup()">Reserve</button>
                <?php } ?>
            </div>

        <?php } ?>
        <!-- <div class="movie">
            <img src='pictures/untold.gif' style="width:800px;" alt="Movie 2">
            <h2>Untold</h2>
            <p>Genre: Suspense 18+</p>
            <a href="ticket.html?movie=untold" class="btn">Reserve Room</a>
        </div>
        <div class="movie">
            <img src='pictures/fastx.gif' style="width:800px;" alt="Movie 3">
            <h2>Fast and Furious X</h2>
            <p>Genre: Action 18+</p>
            <a href="ticket.html?movie=fastx" class="btn">Reserve Room</a>
        </div>
        <div class="movie">
            <img src='pictures/thenun.gif' style="width:800px;" alt="Movie 4">
            <h2>The Nun 2</h2>
            <p>Genre: Horror 18+</p>
            <a href="ticket.html?movie=thenun" class="btn">Reserve Room</a>
        </div> -->
        <!-- Add more movie entries as needed -->
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
        </script>

        <p>&copy; 2023 Movie Theatre. All rights reserved.</p>
    </footer>
</body>

</html>