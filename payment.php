<?php

include 'check-login.php';
$check = new Level();
$check->customer();


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <style>
        /* Add your inline styles here */
        body,
        h1,
        h2,
        p {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        header {
            background-color: orange;
            padding: 20px 0;
            text-align: center;
        }

        h1 {
            font-size: 28px;
            color: #333;
        }

        nav {
            display: inline-block;
            margin-top: 20px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav li {
            display: inline-block;
            margin-right: 20px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
        }

        #payment {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .add-on {
            margin-bottom: 10px;
        }

        .add-on img {
            max-width: 100%;
            height: auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
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
    <script>
        // Your JavaScript code remains unchanged
        function updateTotal(selectedDate) {
            var basePrice = 300.00;
            var foodTotal = 0.00;
            var selectedFoods = [];

            if (document.getElementById("popcorn").checked) {
                selectedFoods.push("Popcorn");
                foodTotal += 5.00;
            }

            if (document.getElementById("soda").checked) {
                selectedFoods.push("Soda");
                foodTotal += 3.00;
            }

            var selectedFoodsList = document.getElementById("selected_foods");
            selectedFoodsList.innerHTML = "";
            selectedFoods.forEach(function(food) {
                var listItem = document.createElement("li");
                listItem.textContent = food;
                selectedFoodsList.appendChild(listItem);
            });

            var totalCost = basePrice + foodTotal;
            document.getElementById("total_cost").innerHTML = totalCost.toFixed(2);
        }

        function showPaymentImage() {
            var paymentMethod = document.getElementById("payment_method").value;

            // Hide all payment images
            document.getElementById("gcashImage").style.display = "none";
            document.getElementById("mayaImage").style.display = "none";



            // Show image based on selected payment method
            if (paymentMethod === "gcash") {
                document.getElementById("gcashImage").style.display = "block";
            } else if (paymentMethod === "maya") {
                document.getElementById("mayaImage").style.display = "block";
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>Movie Theatre</h1>
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
        <h2>Reservation Details</h2>
        <div>
            <?php if ($details) { ?>
                <p><strong>Name:</strong> <?php
                                            echo $_SESSION['fname'] . " " . $_SESSION['mname'] . " " . $_SESSION['lname']; ?></p>

                <p><strong>Movie Selected:</strong> <?php echo $details['title']; ?></p>
                <p><strong>Room Number:</strong> <?php echo $details['room_number']; ?></p>
                <p><strong>Date:</strong> <?php echo $details['booking_date']; ?></p>
                <p><strong>Showtime:</strong> <?php echo $details['booking_start']; ?></p>
                <p><strong>End time:</strong> <?php echo $details['booking_end']; ?></p>
                <p><strong>--------------------------------------</strong></p>
                <h2>Cost Details</h2>
                <p><strong>Initial Cost for 1 or 2 people: </strong>₱ <?php echo $details['price']; ?></p>
                <p><strong>Total Number of People:</strong> <?php echo $details['quantity']; ?></p>

                <?php
                $costPerson = 70;
                $additionalPeople = max(0, $details['quantity'] - 2);
                $additionalPeopleCost = $additionalPeople * $costPerson;
                ?>
                <?php if ($additionalPeople > 0) { ?>
                    <p><strong>Cost Per Person:</strong> ₱ <?php echo $costPerson?></p>
                    <p><strong>Additional Number of People:</strong> <?php echo $additionalPeople; ?></p>
                    <p><strong>Additional People Cost:</strong> ₱ <?php echo $additionalPeopleCost; ?></p>
                <?php } else{?>
                    <p><strong>Additional People Cost:</strong> ₱ <?php echo $additionalPeopleCost; ?></p>
                    <p><strong>Additional Number of People:</strong> <?php echo $additionalPeople; ?></p>
                    <?php } ?>
                <?php
                // Calculate total cost
                $totalCost = $details['price'] + $additionalPeopleCost;
                ?>

                <p><strong>Total Cost: </strong> ₱ <?php echo $totalCost; ?></p>

            <?php }else { ?>
                <p>No reservation details found.</p>
                <?php } ?>

            <?php
            include 'staffbooks.php';
            $payment = new CustomerBooking;

            if (isset($_POST['pay'])) {
                if (isset($_GET['booking'])) {
                    $bookingId = $_GET['booking'];
                    $amount = ($_POST['cashAmount']);
                    $userid = $_SESSION['user_id'];
                    $details = $receipt->receipt($userid, $bookingId);
                    $amountToPay = $details['total_cost'];
                    $quantity = $details['quantity'];
                    
                   
                    if ($amount < $amountToPay) {
                        echo "Insufficient funds. Please provide the correct amount fool.";
                    } else {
                        $paymentType = $_POST['payment_method'];
                        $change = $amount - $amountToPay;
                        $total = $amount - $change;
                        $addtionalPeps =  $additionalPeople;
                        $addtionalCost = $additionalPeopleCost;
                        $costperperson = $costPerson;

                        $success = $payment->payment($bookingId, $paymentType,$addtionalPeps,$addtionalCost, $amount, $change, $total);

                        if ($success) {
                            echo '<script>alert("Payment successful! Your reservation is now Pending");window.location.href = "customerpage.php";</script>';
                        } else {
                            echo "Payment failed.";
                        }
                    }
                }
            }
            ?>

            <form id="paymentForm" method="post">
                <label for="payment_method">Select Payment Method:</label>
                <select id="payment_method" name="payment_method" required onchange="showPaymentImage()">
                    <option value="gcash">GCash</option>
                    <option value="maya">Maya</option>
                    <option value="cash">Pay with Cash</option>
                </select>

                <div id="paymentImage">
                    <!-- Placeholder for payment method image -->
                    <img style="width: 200px;" id="gcashImage" src="pictures/qrcodes/gcash.jpeg" alt="GCash QR Code">

                    <img style="width: 200px;" id="mayaImage" src="pictures/qrcodes/maya.png" alt="Maya QR Code">

                </div>

                <label for="cashAmount">Enter Cash Amount:</label>
                <input type="text" id="cashAmount" name="cashAmount" placeholder="Enter amount">


                <button type="submit" name="pay">Submit Payment</button>
            </form>
        </div>
    </section>
</body>

</html>