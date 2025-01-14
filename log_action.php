<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = htmlspecialchars($_POST['action']); // Sanitize input
    $timestamp = date('Y-m-d H:i:s'); // Capture current timestamp
    
    // Append the action to the session log
    $_SESSION['user_log'][] = [
        'action' => $action,
        'timestamp' => $timestamp,
    ];
    
    echo "Action logged successfully.";
}
?>
