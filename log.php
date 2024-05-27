<?php
class log
{

    private $db;
    public function __construct()
    {
        require 'dbcon.php';
        $this->db= $con;
    }



    public function register($fname, $mname, $lname, $address, $contact_num, $email, $password){
        $password = hash("sha256", $password);
    
        // Check if email already exists
        $checkStmt = $this->db->prepare('SELECT email FROM users WHERE email = ?');
        $checkStmt->bind_param('s', $email);
        $checkStmt->execute();
        $checkStmt->store_result();
    
        if($checkStmt->num_rows > 0){
            echo 'Email already exists, please use a different email.';
            return; 
        }
    
        // Check if contact number already exists
        $checkStm = $this->db->prepare('SELECT contact_num FROM users WHERE contact_num = ?');
        $checkStm->bind_param('s', $contact_num);
        $checkStm->execute();
        $checkStm->store_result();
    
        if($checkStm->num_rows > 0){
            echo 'Contact number already exists, please use a different contact number.';
            return; 
        }
    
        // Get role_id based on role_name
        $roleStmt = $this->db->prepare('SELECT role_id FROM roles WHERE role_name = "customer"');
        $roleStmt->execute();
        $roleRes = $roleStmt->get_result();
    
        if ($roleRes->num_rows === 1) {
            $roleRow = $roleRes->fetch_assoc();
            $role_id = $roleRow['role_id'];
    
            $stmt = $this->db->prepare('INSERT INTO users (fname, mname, lname, address, contact_num, email, password, role_id) VALUES (?,?,?,?,?,?,?,?)');
            $stmt->bind_param('ssssissi', $fname, $mname, $lname, $address, $contact_num, $email, $password, $role_id);
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
    

   public function login($email, $password){
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $stmt = $this->db->prepare('SELECT users.*, roles.role_name as roles_role_name from users INNER JOIN roles ON roles.role_id = users.role_id WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        $fetch = $result->fetch_assoc();

        if(hash('sha256', ($password) === $fetch['password'])){
            $_SESSION['user_id'] = $fetch['user_id'];
            $_SESSION['fname'] = $fetch['fname'];
            $_SESSION['mname'] = $fetch['mname'];
            $_SESSION['lname'] = $fetch['lname'];
            $_SESSION['roles_role_name'] = $fetch['roles_role_name'];

            $updateStmt = $this->db->prepare('UPDATE users SET login = CURRENT_TIMESTAMP WHERE user_id = ?');
            $updateStmt->bind_param('i', $_SESSION['user_id']);
            $updateStmt->execute();

            $logStmt = $this->db->prepare('INSERT INTO logs (user_id, login) VALUES (?, CURRENT_TIMESTAMP)');
            $logStmt->bind_param('i', $_SESSION['user_id']);
            $logStmt->execute();

            switch ($fetch['role_id']) {
                case 1:
                    $_SESSION['roles'] = 'customer';
                    header("location: index-logged.php");
                    break;
            }
            exit(); 
        } else {
            echo 'Invalid username or password';
        }
    } else {
        echo 'Invalid username or password';
    }
}

    public function staffLogin($email , $password){
        $stmt = $this->db->prepare('SELECT staff.*, roles.role_name as roles_role_name from staff INNER JOIN roles ON roles.role_id = staff.role_id WHERE staff_email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $fetch = $result->fetch_assoc();
    
            if(hash('sha256', ($password) === $fetch['staff_password'])){
                $_SESSION['staff_id'] = $fetch['staff_id'];
                $_SESSION['staff_fname'] = $fetch['staff_fname'];
                $_SESSION['staff_mname'] = $fetch['staff_mname'];
                $_SESSION['staff_lname'] = $fetch['staff_lname'];
                $_SESSION['roles_role_name'] = $fetch['roles_role_name'];

                $updateStmt = $this->db->prepare('UPDATE staff SET staff_login = CURRENT_TIMESTAMP WHERE staff_id = ?');
                $updateStmt->bind_param('i', $_SESSION['staff_id']);
                $updateStmt->execute();
    
                $logStmt = $this->db->prepare('INSERT INTO logs (staff_id, login) VALUES (?, CURRENT_TIMESTAMP)');
                $logStmt->bind_param('i', $_SESSION['staff_id']);
                $logStmt->execute();
                
                switch ($fetch['role_id']) {
                    case 2:
                        $_SESSION['roles'] = 'staff';
                        header("location: staff.php");
                        break;
                    case 3:
                        $_SESSION['roles'] = 'manager';
                        header("location: owner.php");
                        break;
                    case 4:
                        $_SESSION['roles'] = 'admin';
                        header("location: admindashboard.php");
                        break;
                }
                exit(); 
            } else {
                echo 'Invalid username or password';
            }
        } else {
            echo 'Invalid username or password';
        }
    }
}

?>