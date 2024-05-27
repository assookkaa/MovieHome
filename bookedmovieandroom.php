<?php
include 'check-login.php';
if (isset($_GET['movie_id']) && isset($_GET['room_id'])) {
    $movie = $_GET['movie_id'];
    $rooms = $_GET['room_id'];
    $bookingHandler->backrooms($bookingId, $movie, $rooms);
    $bookingHandler = new RoomsAndMovie();

    $bookingId = 19;   
}

class RoomsAndMovie
{
    private $db;

    public function __construct()
    {
        require 'dbcon.php';
        $this->db = $con;
    }

    public function backrooms($bookingId, $movie, $rooms)
    {
        // Prepare and execute the query for bookedmovies
        $stmtMovies = $this->db->prepare("INSERT INTO bookedmovies (booking_id, movie_id) VALUES (?, ?)");
        $stmtMovies->bind_param("ii", $bookingId, $movie);
        $stmtMoviesResult = $stmtMovies->execute();

        // Prepare and execute the query for bookedrooms
        $stmtRooms = $this->db->prepare("INSERT INTO bookedrooms (booking_id, room_id) VALUES (?, ?)");
        $stmtRooms->bind_param("ii", $bookingId, $rooms);
        $stmtRoomsResult = $stmtRooms->execute();

        // Check if both insert queries were successful
        if ($stmtMoviesResult && $stmtRoomsResult) {
            $this->db->close();
            header('Location: payment.php');
            exit; // Ensure that no code is executed after the redirect
        } else {
            // Handle errors gracefully (log, display a message, etc.)
            echo 'Error in database operations';
        }
    }
}
?>
