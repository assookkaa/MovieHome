<?php
Class Staff{

    private $db;

        public function __construct()
        {
            require 'dbcon.php';
            $this->db = $con;
        }


        public function hireStaff($fname, $mname, $lname, $address, $contact_num, $email, $password){
            $password = hash("sha256", $password);
        
            // Check if email already exists
            $checkStmt = $this->db->prepare('SELECT staff_email FROM staff WHERE staff_email = ?');
            $checkStmt->bind_param('s', $email);
            $checkStmt->execute();
            $checkStmt->store_result();
        
            if($checkStmt->num_rows > 0){
                echo 'Email already exists, please use a different email.';
                return; 
            }
        
            // Check if contact number already exists
            $checkStm = $this->db->prepare('SELECT staff_contact_num FROM staff WHERE staff_contact_num = ?');
            $checkStm->bind_param('s', $contact_num);
            $checkStm->execute();
            $checkStm->store_result();
        
            if($checkStm->num_rows > 0){
                echo 'Contact number already exists, please use a different contact number.';
                return; 
            }
    
            $roleStmt = $this->db->prepare('SELECT role_id FROM roles WHERE role_name = "Staff"');
            $roleStmt->execute();
            $roleRes = $roleStmt->get_result();
        
            if ($roleRes->num_rows === 1) {
                $roleRow = $roleRes->fetch_assoc();
                $role_id = $roleRow['role_id'];
                $status = "Active";
                $stmt = $this->db->prepare('INSERT INTO staff (staff_fname, staff_mname, staff_lname, staff_address, staff_contact_num, staff_email, staff_password, role_id, status) VALUES (?,?,?,?,?,?,?,?,?)');
                $stmt->bind_param('ssssissis', $fname, $mname, $lname, $address, $contact_num, $email, $password, $role_id, $status);
                $registered = $stmt->execute();
        
                if($registered){
                    echo 'Successfully registered';
                } else {
                    echo 'Registration failed';
                }
            } else {
                echo 'Role not found';
            }
        }

        public function adminAddStaff($fname, $mname, $lname, $address, $contact_num, $email, $password, $roleName) {
            $password = hash("sha256", $password);
        
            // Check if email already exists
            $checkStmt = $this->db->prepare('SELECT staff_email FROM staff WHERE staff_email = ?');
            $checkStmt->bind_param('s', $email);
            $checkStmt->execute();
            $checkStmt->store_result();
        
            if ($checkStmt->num_rows > 0) {
                echo 'Email already exists, please use a different email.';
                return;
            }
        
            // Check if contact number already exists
            $checkStm = $this->db->prepare('SELECT staff_contact_num FROM staff WHERE staff_contact_num = ?');
            $checkStm->bind_param('s', $contact_num);
            $checkStm->execute();
            $checkStm->store_result();
        
            if ($checkStm->num_rows > 0) {
                echo 'Contact number already exists, please use a different contact number.';
                return;
            }
        
            // Get role_id based on role_name
            $roleStmt = $this->db->prepare('SELECT role_id FROM roles WHERE role_name = ?');
            $roleStmt->bind_param('s', $roleName);
            $roleStmt->execute();
            $roleRes = $roleStmt->get_result();
        
            if ($roleRes->num_rows === 1) {
                $roleRow = $roleRes->fetch_assoc();
                $role_id = $roleRow['role_id'];
                $status = "Active";
                $stmt = $this->db->prepare('INSERT INTO staff (staff_fname, staff_mname, staff_lname, staff_address, staff_contact_num, staff_email, staff_password, role_id, status) VALUES (?,?,?,?,?,?,?,?,?)');
                $stmt->bind_param('ssssissis', $fname, $mname, $lname, $address, $contact_num, $email, $password, $role_id, $status);
                $registered = $stmt->execute();
        
                if ($registered) {
                    echo 'Successfully registered';
                } else {
                    echo 'Registration failed';
                }
            } else {
                echo 'Role not found';
            }
        }
        // public function getStaff(){
        //     $stmt = $this->db->prepare("SELECT staff.*, roles.role_name AS role_name FROM staff INNER JOIN roles ON staff.role_id = roles.role_id WHERE roles.role_name = 'Staff'");
        //     $stmt->execute();
        //     $res = $stmt->get_result();
              
        //       $bookings = array();
          
        //       while ($row = $res->fetch_assoc()) {
        //           $bookings[] = $row;
        //       }
          
        //       return $bookings;
            
        // }
        public function deleteStaff($staffId)
        {
            $stmt = $this->db->prepare("UPDATE staff SET status = 'Inactive' WHERE staff_id = ?");
            $stmt->bind_param("i", $staffId);
            $stmt->execute();
        }
        public function getstaffstatus($status){
            $stmt = $this->db->prepare("SELECT staff.*, roles.role_name AS role_name FROM staff INNER JOIN roles ON staff.role_id = roles.role_id WHERE staff.status= ? AND roles.role_name = 'Staff'");
            $stmt->bind_param("s",$status);
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