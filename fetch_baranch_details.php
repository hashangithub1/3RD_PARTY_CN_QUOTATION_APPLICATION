<?php
require_once('includes/config.php');

if (isset($_POST['id'])) {
    $branchtId = $_POST['id'];

    // Fetch data for the selected branch
    $query = "SELECT * FROM tbl_branch WHERE id = $branchtId";
    $result = mysqli_query($con, $query);
    $branch = mysqli_fetch_assoc($result);

    // Send JSON response with branch details
    echo json_encode($branch);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
