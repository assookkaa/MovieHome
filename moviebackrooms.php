<?php

class movieedit
{


    private $db;

    public function __construct()
    {
        require 'dbcon.php';
        $this->db = $con;
    }

    public function editMovie($movieId, $title, $desc, $genre, $duration, $price, $movieimg)
    {
        $stmt = $this->db->prepare("UPDATE movies SET title=?, description=?, genre=?, price=?, duration=?, movie_image=? WHERE movie_id=?");
        $stmt->bind_param('ssssisi', $title, $desc, $genre, $price, $duration, $movieimg, $movieId);
        $stmt->execute();
    }

    public function deleteMovie($movieId)
    {
        $stmt = $this->db->prepare("DELETE FROM movies WHERE movie_id = ?");
        $stmt->bind_param("i", $movieId);
        $stmt->execute();
    }

    public function addMovie($title, $desc, $genre, $duration, $price, $movieimg)
    {
        $stmt = $this->db->prepare("INSERT INTO movies (title, description, genre, duration, price, movie_image) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssis", $title, $desc, $genre, $duration, $price, $movieimg);
        $stmt->execute();
    }
}
