<?php
include_once('includes/config.php');
// Fetch branches based on the provided username
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $sql = "SELECT DISTINCT branch_code FROM tbl_access WHERE username = '$username'";
    $result = $con->query($sql);

    $branches = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $branches[] = $row['branch_code'];
        }
    }

    echo json_encode($branches);
}

$con->close();
?>
