<?php
    Class CustomerBooking{

        private $db;

        public function __construct()
        {
            require 'dbcon.php';
            $this->db = $con;
        }
    
        
        public function getAllBookingsToConfirm($status){
            $stmt = $this->db->prepare("SELECT bookings.*, users.*, staff.*, movies.title AS movie_title, rooms.room_number AS room_number
                                        FROM bookings 
                                        LEFT JOIN users ON bookings.user_id = users.user_id
                                        LEFT JOIN bookedmovies ON bookings.booking_id = bookedmovies.booking_id
                                        LEFT JOIN movies ON bookedmovies.movie_id = movies.movie_id
                                        LEFT JOIN bookedrooms ON bookings.booking_id = bookedrooms.booking_id
                                        LEFT JOIN rooms ON bookedrooms.room_id = rooms.room_id
                                        LEFT JOIN staff ON bookings.staff_id = staff.staff_id
                                        WHERE bookings.status = ? ");
            $stmt->bind_param("s", $status);    
            $stmt->execute();
        
            $res = $stmt->get_result();
            
            $bookings = array();
            
            while ($row = $res->fetch_assoc()) {
                $bookings[] = $row;
            }
            
            return $bookings;
        }
        public function getAllBookings($status){
            $stmt = $this->db->prepare("SELECT bookings.*, users.*, staff.*, movies.title AS movie_title, rooms.room_number AS room_number
                                        FROM bookings 
                                        LEFT JOIN users ON bookings.user_id = users.user_id
                                        LEFT JOIN bookedmovies ON bookings.booking_id = bookedmovies.booking_id
                                        LEFT JOIN movies ON bookedmovies.movie_id = movies.movie_id
                                        LEFT JOIN bookedrooms ON bookings.booking_id = bookedrooms.booking_id
                                        LEFT JOIN rooms ON bookedrooms.room_id = rooms.room_id
                                        LEFT JOIN staff ON bookings.staff_id = staff.staff_id
                                        WHERE bookings.status = ? 
                                        ORDER BY bookings.booking_id DESC");
            $stmt->bind_param("s", $status);    
            $stmt->execute();
        
            $res = $stmt->get_result();
            
            $bookings = array();
            
            while ($row = $res->fetch_assoc()) {
                $bookings[] = $row;
            }
            
            return $bookings;
        }
        public function confirmBooking($bookingId, $staffId) {
            $stmt = $this->db->prepare("UPDATE bookings SET status = 'Confirmed', staff_id = ? WHERE booking_id = ?");
            
            // If $staffId is null, use 's' for NULL parameter binding, otherwise use 'i' for integer
            $paramType = is_null($staffId) ? 's' : 'i';
            
            $stmt->bind_param($paramType . "i", $staffId, $bookingId);
            $stmt->execute();
            
            return $stmt->affected_rows > 0;
        }
        public function DoneWatching($staffId, $bookingId){
            $stmt = $this->db->prepare("UPDATE bookings SET status = 'Done', staff_id = ? WHERE booking_id =?");
            $stmt->bind_param("ii",$staffId, $bookingId);
            $stmt->execute();
            return $stmt->affected_rows > 0;
            
        }

        

        public function payment($bookingId, $paymentType,$addtionalPeps, $addtionalCost, $amount, $change, $total){
            $stmt = $this->db->prepare("UPDATE bookings SET status = 'Paid' WHERE booking_id =?");
            $stmt->bind_param("i", $bookingId);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
               
                $stmt2 = $this->db->prepare("INSERT INTO sales (booking_id, date, payment_type,additional_people,additional_cost, amount, sukli, total) VALUES (?, CURRENT_TIMESTAMP, ?, ?,?,?,?,?)");
        
                $stmt2->bind_param("isiiiii", $bookingId, $paymentType,$addtionalPeps, $addtionalCost, $amount, $change, $total);
                $stmt2->execute();
        
                return $stmt2->affected_rows > 0;
            }
        
            return false;
        
        }

        public function getCustomer(){
            $stmt = $this->db->prepare("SELECT users.*, roles.role_name AS role_name FROM users INNER JOIN roles ON users.role_id = roles.role_id WHERE roles.role_name = 'Customer'");
            $stmt->execute();
            $res = $stmt->get_result();
              
              $bookings = array();
          
              while ($row = $res->fetch_assoc()) {
                  $bookings[] = $row;
              }
          
              return $bookings;
            
        }
       

    }
?>