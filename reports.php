<?php 

Class Report{

    private $db;

    public function __construct(){
        require 'dbcon.php';
        $this->db = $con;
    }


    public function getSalesReport(){
        $stmt = $this->db->prepare("SELECT sales.*, bookings.*, users.*, rooms.*, movies.*, staff.*
                                    FROM sales
                                    LEFT JOIN bookings ON sales.booking_id = bookings.booking_id
                                    LEFT JOIN users ON bookings.user_id = users.user_id
                                    LEFT JOIN bookedrooms ON bookings.booking_id = bookedrooms.booking_id
                                    LEFT JOIN rooms ON bookedrooms.room_id = rooms.room_id
                                    LEFT JOIN bookedmovies ON bookings.booking_id = bookedmovies.booking_id
                                    LEFT JOIN movies ON bookedmovies.movie_id = movies.movie_id
                                    LEFT JOIN staff ON bookings.staff_id = staff.staff_id");
        $stmt->execute();
        $res = $stmt->get_result();
    
        $salesReport = array();
    
        while ($row = $res->fetch_assoc()) {
            $salesReport[] = $row;
        }
    
        return $salesReport;
    }

    public function getTotalSales(){
        $stmt = $this->db->prepare("SELECT SUM(total) AS total_sum FROM sales");
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        return $row['total_sum'];
    } else {
       echo "failed";
    }
    }
}

?>