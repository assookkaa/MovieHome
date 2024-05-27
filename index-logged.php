<?php
include 'check-login.php';
include 'dbcon.php';
$check = new Level();
$check->customer();


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Movie Theatre</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        #movies {
            max-width: 1800px;
            margin: 0 auto;
            display: flex;
            overflow-x: hidden;
            justify-content: space-between;
            transition: transform 0.5s ease-in-out;
            background-color: #f4f4f4;
        }

        .movie {
            flex: 0 0 auto;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            height: 75rem;
            overflow: hidden;
        }

        .movie h3 {
            font-size: 50px;
            background-color: #fff;
            margin: 0px;
            padding: 20px;
            border-radius: 0px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .movie p {
            padding: 30px;
            font-size: 20px;
            font-style: normal;
            font-weight: 400;
            background-color: whitesmoke;
        }

        .movie img {
            width: 100%;
            height: auto;
        }

        #movies-container {
            position: relative;
        }

        .prev,
        .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
            cursor: pointer;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }
    </style>
</head>

<body>
    <header>
        <img class="logo" src="/pictures/moviehome.jpg" width="300" height="100" alt="logo" style="border-radius: 300px;">
        <h1 style="font-family:Verdana, Geneva, Tahoma, sans-serif;font-size: 250%; ">Welcome to Movie Home Dumaguete: <br>
            <span style="font-size: 75%; border-width: 3px; border-style: solid; padding: 3px;">
                <?php
                if (isset($_SESSION['fname'])) {
                    echo $_SESSION['fname'];
                    echo " ";
                }
                if (isset($_SESSION['mname'])) {
                    echo $_SESSION['mname'];
                    echo " ";
                }
                if (isset($_SESSION['lname'])) {
                    echo $_SESSION['lname'];
                }
                ?>
            </span>
        </h1>
        <nav>
            <ul style="font-family: -webkit-body;font-size: 16;">
                <li><a href="index-logged.php">HOME</a></li>
                <li><a href="movies.php">MOVIES</a></li>
                <li><a href="rooms.php">ROOMS</a></li>
                <li><a href="customerpage.php">PROFILE</a></li>
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </nav>
    </header>

    <section id="hero">
        <h2 style="font-size: 36px;">Welcome to Movie Home Dumaguete</h2>
        <p style="font-size: 18PX;">High-quality Movie Family Entertainment Center in Dumaguete for you to enjoy the greatest movies</p><br><br>
        <a href="movies.php" class="btn">View Movies</a>
    </section>

    <h1 style="font-size: 48px; background-color: orange; padding: 10px">NOW SHOWING</h1>
    <section id="movies-container">
        <div id="movies">
            <?php
            include 'viewmov.php';
            $view = new movie();
            $movbanner = $view->viewmovie();

            // Shuffle the movies array to get a random order
            shuffle($movbanner);
            ?>

            <?php
            $counter = 0; // Initialize counter

            foreach ($movbanner as $mov) {
                if ($counter < 3) { // Display only three movies
            ?>
                    <div class="movie">
                        <img src='/pictures/movieposter/<?php echo $mov['movie_image']; ?>' alt="<?php echo $mov['title']; ?>">
                        <h3><?php echo $mov['title']; ?></h3>
                        <p><?php echo $mov['description']; ?></p>
                        <!-- <a href="movies.html" class="btn">View Movie</a> -->
                    </div>
            <?php
                    $counter++;
                } else {
                    break; // Break the loop after displaying three movies
                }
            }
            ?>
            <!-- Add more movie items as needed -->
        </div>
        <div>
            <a href="movies.php" class="btn" style="font-size: 2rem;">View More Movies</a>
        </div>

    </section>

    <!-- New "About Us" section -->
    <section id="about-us">
        <div class="about-content">
            <div class="about-text">
                <h1>About Us</h1>
                <p style="text-align: left;">
                    Welcome to Movie Home Dumaguete, where we are
                    dedicated to providing you with high-quality family entertainment. Our state-of-the-art theaters and a wide selection of movies
                    ensure an immersive and enjoyable experience for all movie enthusiasts.
                    <br>
                    <br>
                    <!-- Include a div within the text -->
                    <!-- <div class="additional-info"> -->
                    Explore our website to discover the latest movie releases, book tickets for your favorite films,
                    and enjoy a magical cinema experience with your loved ones.
                    <!-- </div> -->
                    <br>
                    <br>
                    Join us in creating memories and embracing the magic of cinema at Movie Home!
            </div>
            <div class="about-images">
                <img src="/pictures/aboutus/aboutus2.jpg" alt="aboutus1">
                <img src="/pictures/aboutus/aboutus4.jpg" alt="aboutus4">
                <img src="/pictures/aboutus/aboutus3.jpg" alt="aboutus2">
                <!-- Add more images as needed -->
            </div>
        </div>
    </section>


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



</body>

</html>