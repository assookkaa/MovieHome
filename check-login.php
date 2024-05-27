<?php
class Level
{

    private $db;
    public function __construct()
    {
        require 'dbcon.php';
        $this->db= $con;
    }

    public function customer()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || ($_SESSION['roles'] !== 'customer' )) {
            echo 'error';
            exit();
        }
    }
    
    public function staff()
    {
        session_start();
        if (!isset($_SESSION['staff_id']) || ($_SESSION['roles'] !== 'staff' && $_SESSION['roles'] !== 'manager'  && $_SESSION['roles'] !== 'admin')) {
            echo 'You have no access';
            exit();
        }
    }
    public function manager()
    {
        session_start();
        if (!isset($_SESSION['staff_id']) || ($_SESSION['roles'] !== 'manager'  && $_SESSION['roles'] !== 'admin')) {
            echo 'You have no access';
            exit();
        }
    }
    public function admin()
    {
        session_start();
        if (!isset($_SESSION['staff_id']) || ($_SESSION['roles'] !== 'admin')) {
            echo 'You have no access';
            exit();
        }
    }
}
?>