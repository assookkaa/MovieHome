<?php

include 'check-login.php';
$check = new Level();
$check->staff();


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Movie Rooms</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Link to your external stylesheet -->

    <!-- <script>
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
    </script> -->
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
   
    <?php
     include 'navigation/staffnav.php';
    include 'moviebackrooms.php';

    $edit = new movieedit;

    if (isset($_GET['movie_id'])) {
        $movieId = $_GET['movie_id'];

        if (isset($_POST['Edit'])) {
            $title = $_POST['title'];
            $desc = $_POST['desc'];
            $genre = $_POST['genre'];
            $duration_hours = $_POST['duration_hours'];
            $price = $_POST['price'];

            $duration = sprintf('%02d:00:00', $duration_hours);

            if (isset($_FILES['movieimg']) && $_FILES['movieimg']['error'] == UPLOAD_ERR_OK) {
                $targetDir = "pictures/movieposter/";
                $uploadedFileName = basename($_FILES["movieimg"]["name"]);
                $targetFile = $targetDir . $uploadedFileName;

                if (move_uploaded_file($_FILES["movieimg"]["tmp_name"], $targetFile)) {
                    $movieimg = $uploadedFileName;

                    // Call the editMovie method with the updated information
                    $edit->editMovie($movieId, $title, $desc, $genre, $duration, $price, $movieimg);
                } else {
                    echo "Error uploading file.";
                }
            }
        }
    }
    ?>
    <style>
        .file-upload-container {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .custom-label {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            cursor: pointer;
            display: inline-block;
        }

        .custom-label:hover {
            background-color: #2980b9;
        }

        #movieimg {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }
    </style>
    <div class="room-container">
        <h1>Edit Movie</h1>
        <div class="ticket">
            <form method="POST" enctype="multipart/form-data">
                <div class="file-upload-container">
                    <label for="movieimg" class="custom-label">Select Movie Image</label>
                    <input type="file" name="movieimg" id="movieimg" accept="image/*" onchange="displayFileName()">
                </div>
                <span id="selectedFileName">No file chosen</span>

                <input type="text" name="title" placeholder="Title">
                <input type="text" name="desc" placeholder="Description">
                <input type="text" name="genre" placeholder="Genre">
                <input type="text" name="duration_hours" placeholder="Duration (hours)">
                <input type="text" name="price" placeholder="Price">

                <button type="submit" name="Edit" class="buy-button">Edit</button>
            </form>
        </div>
    </div>

    <script>
        function displayFileName() {
            var fileInput = document.getElementById('movieimg');
            var fileNameContainer = document.getElementById('selectedFileName');

            fileNameContainer.textContent = fileInput.files[0].name;
        }
    </script>
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