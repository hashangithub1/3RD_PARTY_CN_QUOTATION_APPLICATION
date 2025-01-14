<?php 
include_once('config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($data['coverNoteNumber'], $data['policyNumber'], $data['status'])) {
        $coverNoteNumber = $con->real_escape_string($data['coverNoteNumber']);
        $policyNumber = $con->real_escape_string($data['policyNumber']);
        $status = $con->real_escape_string($data['status']);

        // Insert into database
        $sql = "INSERT INTO tbl_policy_updates (coverNoteNumber, policyNumber, status) 
                VALUES ('$coverNoteNumber', '$policyNumber', '$status')";

        if ($con->query($sql) === TRUE) {
            $response = array("message" => "Record successfully inserted");
            http_response_code(201); // Created
        } else {
            $response = array("error" => "Error: " . $sql . "<br>" . $con->error);
            http_response_code(500); // Internal Server Error
        }
    } else {
        $response = array("error" => "Invalid input data");
        http_response_code(400); // Bad Request
    }
    
    echo json_encode($response);
}

$con->close();
?>
