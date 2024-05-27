<?php

class roommod
{


    private $db;

    public function __construct()
    {
        require 'dbcon.php';
        $this->db = $con;
    }

    public function editRoom($roomId, $roomnum, $roomcap, $roomimg) {
        $stmt = $this->db->prepare("UPDATE rooms SET room_number=?, room_capacity=?, room_image=? WHERE room_id=?");
        $stmt->bind_param("issi", $roomnum, $roomcap, $roomimg, $roomId);
        $stmt->execute();
        
    }

    public function deleteRoom($roomId){
        $stmt = $this->db->prepare("DELETE FROM rooms WHERE room_id = ?");
        $stmt->bind_param("i", $roomId);
        $stmt->execute();
    }

    public function addRoom( $roomnum, $roomcap, $roomimg){
        $stmt = $this->db->prepare("INSERT INTO rooms (room_number, room_capacity, room_image) VALUES (?,?,?)");
        $stmt->bind_param("iss",  $roomnum, $roomcap, $roomimg);
        $stmt->execute();
    }
}
