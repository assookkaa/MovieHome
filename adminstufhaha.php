<?php

class Slayall
{
  private $db;

  public function __construct()
  {
    require 'dbcon.php';
    $this->db = $con;
  }

  public function getAllLogsCustomer()
  {
    $stmt = $this->db->prepare("SELECT logs.*, users.*, roles.* FROM logs 
                                  LEFT JOIN users ON logs.user_id = users.user_id
                                  LEFT JOIN roles ON users.role_id = roles.role_id
                                  WHERE roles.role_name= 'Customer'
                                  ORDER BY logs.log_id DESC");
    $stmt->execute();

    $res = $stmt->get_result();

    $logs = array();

    while ($row = $res->fetch_assoc()) {
      $logs[] = $row;
    }

    return $logs;
  }
  public function getAllLogsStaff()
  {
      $stmt = $this->db->prepare("SELECT logs.*, staff.*, roles.* FROM logs 
                                    LEFT JOIN staff ON staff.role_id = staff.role_id
                                    LEFT JOIN roles ON staff.role_id = roles.role_id
                                    ORDER BY logs.log_id DESC");
      
      $stmt->execute();
  
      $res = $stmt->get_result();
  
      $logs = array();
  
      while ($row = $res->fetch_assoc()) {
          $logs[] = $row;
      }
  
      return $logs;
  }

}
