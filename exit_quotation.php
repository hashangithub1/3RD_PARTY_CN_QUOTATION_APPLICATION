<?php
// Start session
session_start();

// Check if the request is a POST and has the required action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the incoming JSON
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action']) && $input['action'] === 'exit') {
        // Unset all session variables except the specified ones
        $allowed_keys = ['id', 'u_name', 'name', 'u_role', 'branch'];
        $_SESSION = array_intersect_key($_SESSION, array_flip($allowed_keys));

        // Respond with a success status
        http_response_code(200); // OK
        echo json_encode(['status' => 'success']);
        exit;
    }
}

// Respond with an error if the request is invalid
http_response_code(400); // Bad Request
echo json_encode(['status' => 'error']);
?>
