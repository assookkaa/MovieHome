<?php
class Book
{
    private $db;

    public function __construct()
    {
        require 'dbcon.php';
        $this->db = $con;
    }

    public function book($userid, $date, $start, $end, $quantity, $cost, $status){

            $stmt = $this->db->prepare("INSERT INTO bookings (user_id, booking_date, booking_start, booking_end, quantity, total_cost, status) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("isssiis", $userid, $date, $start, $end, $quantity, $cost, $status);
            $stmt->execute();

            $bookingId = $stmt->insert_id;
            return $bookingId;
       
    }
    public function getAllBookings($userid){

        $stmt = $this->db->prepare("SELECT bookings.*, users.*, movies.title AS movie_title, rooms.room_number AS room_number
                                    FROM bookings 
                                    LEFT JOIN users ON bookings.user_id = users.user_id
                                    LEFT JOIN bookedmovies ON bookings.booking_id = bookedmovies.booking_id
                                    LEFT JOIN movies ON bookedmovies.movie_id = movies.movie_id
                                    LEFT JOIN bookedrooms ON bookings.booking_id = bookedrooms.booking_id
                                    LEFT JOIN rooms ON bookedrooms.room_id = rooms.room_id
                                    WHERE bookings.user_id = ?  AND bookings.status = 'Unpaid' ");
          $stmt->bind_param("s", $userid);    
          $stmt->execute();

          $res = $stmt->get_result();
          
          $bookings = array();
      
          while ($row = $res->fetch_assoc()) {
              $bookings[] = $row;
          }
      
          return $bookings;
      }
      public function getAllBookingsPaid($userid){

        $stmt = $this->db->prepare("SELECT bookings.*, users.*, movies.title AS movie_title, rooms.room_number AS room_number
                                    FROM bookings 
                                    LEFT JOIN users ON bookings.user_id = users.user_id
                                    LEFT JOIN bookedmovies ON bookings.booking_id = bookedmovies.booking_id
                                    LEFT JOIN movies ON bookedmovies.movie_id = movies.movie_id
                                    LEFT JOIN bookedrooms ON bookings.booking_id = bookedrooms.booking_id
                                    LEFT JOIN rooms ON bookedrooms.room_id = rooms.room_id
                                    WHERE bookings.user_id = ?  AND bookings.status = 'Paid' ");
          $stmt->bind_param("s", $userid);    
          $stmt->execute();

          $res = $stmt->get_result();
          
          $bookings = array();
      
          while ($row = $res->fetch_assoc()) {
              $bookings[] = $row;
          }
      
          return $bookings;
      }
      public function CanecelBook($userid, $bookingId) {
        try {
            $stmt = $this->db->prepare("UPDATE bookings SET status = 'Cancelled' WHERE user_id = ? AND booking_id = ?");
            $stmt->bind_param("ss", $userid, $bookingId);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            // Handle the exception, log it, or display an error message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function bookedmovie($bookingId, $movie){

        
            $stmtMovies = $this->db->prepare("INSERT INTO bookedmovies (booking_id, movie_id) VALUES (?, ?)");
            $stmtMovies->bind_param("ii", $bookingId, $movie);
            $stmtMovies->execute();
           
           
    }
    
    public function bookedrooms($bookingId, $rooms){
           
            $stmtRooms = $this->db->prepare("INSERT INTO bookedrooms (booking_id, room_id) VALUES (?, ?)");
            $stmtRooms->bind_param("ii", $bookingId, $rooms);
            $stmtRooms->execute();
          
        }

    public function isRoomAvailable($roomId, $date, $start, $end)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count
                                        FROM bookings b
                                        INNER JOIN bookedrooms br ON b.booking_id = br.booking_id
                                        WHERE (b.status='Paid' OR b.status='Confirmed') AND br.room_id = ? 
                                            AND b.booking_date = ? 
                                            AND NOT (b.booking_end <= ? OR b.booking_start >= ?)");

        $stmt->bind_param("isss", $roomId, $date, $start, $end);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];

        return $count === 0; // Room is available if count is zero
    }


   public function receipt($userid, $bookingId){
    $stmt = $this->db->prepare("SELECT bookings.*, movies.*, rooms.*
                                FROM bookings
                                LEFT JOIN bookedmovies ON bookings.booking_id = bookedmovies.booking_id
                                LEFT JOIN movies ON bookedmovies.movie_id = movies.movie_id
                                LEFT JOIN bookedrooms ON bookings.booking_id = bookedrooms.booking_id
                                LEFT JOIN rooms ON bookedrooms.room_id = rooms.room_id
                                WHERE bookings.user_id = ? AND bookings.booking_id = ?");
    $stmt->bind_param("ii", $userid, $bookingId);
    $stmt->execute();

    $res = $stmt->get_result();
    
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        return $row;
    } else {
        return false;
    }
}
    public function getRoomBookingsWithTime($roomId)
    {
        $stmt = $this->db->prepare("SELECT b.*, r.room_number, bm.movie_id, m.title AS movie_title
                                    FROM bookings b
                                    LEFT JOIN bookedrooms br ON b.booking_id = br.booking_id
                                    LEFT JOIN rooms r ON br.room_id = r.room_id
                                    LEFT JOIN bookedmovies bm ON b.booking_id = bm.booking_id
                                    LEFT JOIN movies m ON bm.movie_id = m.movie_id
                                    WHERE r.room_id = ? AND b.status = 'Confirmed'
                                    ORDER BY b.booking_start");

        $stmt->bind_param("i", $roomId);
        $stmt->execute();

        $result = $stmt->get_result();

        $roomBookings = array();

        while ($row = $result->fetch_assoc()) {
            $roomBookings[] = $row;
        }

        return $roomBookings;
    }
}

?>
 