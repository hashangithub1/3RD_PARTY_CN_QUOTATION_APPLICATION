<?php
include_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $ag_code = $_POST['ag_code'];
    $ag_desc = $_POST['ag_desc'];
    $status = $_POST['status'];

    $stmt2 = $con->prepare("UPDATE tbl_agent_codes SET agent_code = ?, ag_desc = ?, status = ? WHERE id = ?");
    $stmt2->bind_param("ssii", $ag_code, $ag_desc, $status, $id);

    if ($stmt2->execute()) {
        echo 'success';
    } else {
        echo 'error: ' . $stmt2->error;
    }

    $stmt2->close();
    $con->close();
} else {
    echo 'invalid_request';
}
?>