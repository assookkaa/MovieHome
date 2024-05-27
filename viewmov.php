<?php

Class movie{


    private $db;
    public function __construct()
    {
        require 'dbcon.php';
        $this->db= $con;
    }

    public function viewmovie(){
        
        $stm= $this->db->prepare("SELECT * FROM movies");
        $stm->execute();
        $res= $stm->get_result();

        $products = array(); // Initialize an empty array to store fetched rows
        while ($row = $res->fetch_assoc()) {
            $products[] = $row; // Append each row to the array
        }
        return $products; 

    }
    public function selectedmovie($movieid){
        $stm = $this->db->prepare("SELECT * FROM movies WHERE movie_id = ?");
        $stm->bind_param("i", $movieid);
        $stm->execute();
        $res = $stm->get_result();
    
        
        return $res->fetch_assoc();
    }


}

Class Room{
    private $db;
    public function __construct()
    {
        require 'dbcon.php';
        $this->db= $con;
    }

    public function viewroom(){
        
        $stm= $this->db->prepare("SELECT * FROM rooms");
        $stm->execute();
        $res= $stm->get_result();

        $rooms = array(); 
        while ($row = $res->fetch_assoc()) {
            $rooms[] = $row; 
        }
        return $rooms; 

    }
    public function selectedroom($roomid){
        
        $stm= $this->db->prepare("SELECT room_number FROM rooms WHERE room_id = ?");
        $stm->bind_param("i", $roomid);
        $stm->execute();
        $res = $stm->get_result();
    
        
        return $res->fetch_assoc();

    }


    // public function isRoomAvailable($roomId, $startTime, $endTime)
    // {

    //     $query = "SELECT COUNT(*) AS count FROM bookedrooms br
    //               INNER JOIN bookings b ON br.booking_id = b.booking_id
    //               WHERE br.room_id = ? AND (
    //                     (b.booking_start <= ? AND b.booking_end >= ?) OR
    //                     (b.booking_start <= ? AND b.booking_end >= ?) OR
    //                     (b.booking_start >= ? AND b.booking_end <= ?)
    //               )";
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bind_param('isiiiii', $roomId, $startTime, $endTime, $startTime, $endTime, $startTime, $endTime);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    //     $row = $result->fetch_assoc();
    //     $count = $row['count'];

    //     return $count == 0;
    // }

}

?>