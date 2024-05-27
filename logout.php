<?php
session_start();
require 'dbcon.php'; 

if (isset($_SESSION['user_id'])) {
    
    $updateStmt = $con->prepare('UPDATE users SET logout = CURRENT_TIMESTAMP WHERE user_id = ?');
    $updateStmt->bind_param('i', $_SESSION['user_id']);
    $updateStmt->execute();

    $selectLatestLogIdStmt = $con->prepare('SELECT log_id FROM logs WHERE user_id = ? ORDER BY log_id DESC LIMIT 1');
    $selectLatestLogIdStmt->bind_param('i', $_SESSION['user_id']);
    $selectLatestLogIdStmt->execute();
    $result = $selectLatestLogIdStmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $latestLogId = $row['log_id'];
    } 

    $updateStmt = $con->prepare('UPDATE logs SET logout = CURRENT_TIMESTAMP WHERE user_id = ? AND log_id = ?');
    $updateStmt->bind_param('ii', $_SESSION['user_id'], $latestLogId); 
    $updateStmt->execute();
    
}
if (isset($_SESSION['staff_id'])) {
    
    $updateStmt = $con->prepare('UPDATE staff SET staff_logout = CURRENT_TIMESTAMP WHERE staff_id = ?');
    $updateStmt->bind_param('i', $_SESSION['staff_id']);
    $updateStmt->execute();

    $selectLatestLogIdStmt = $con->prepare('SELECT log_id FROM logs WHERE staff_id = ? ORDER BY log_id DESC LIMIT 1');
    $selectLatestLogIdStmt->bind_param('i', $_SESSION['staff_id']);
    $selectLatestLogIdStmt->execute();
    $result = $selectLatestLogIdStmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $latestLogId = $row['log_id'];
    } 

    $updateStmt = $con->prepare('UPDATE logs SET logout = CURRENT_TIMESTAMP WHERE staff_id = ? AND log_id = ?');
    $updateStmt->bind_param('ii', $_SESSION['staff_id'], $latestLogId); 
    $updateStmt->execute();
    
}
session_destroy();
header ("location: login.php");


?>