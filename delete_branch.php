<?php
session_start();
require_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Perform the deletion query
        $delete_query = mysqli_query($con, "DELETE FROM tbl_branch WHERE id = $id");

        if ($delete_query) {
            // Deletion successful
            echo json_encode(['success' => true]);
        } else {
            // Deletion failed
            echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
        }
    } else {
        // ID parameter not set
        echo json_encode(['success' => false, 'error' => 'ID parameter not set']);
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
?>