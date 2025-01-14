<?php
include_once('includes/config.php');

if (isset($_POST['id']) && isset($_POST['receipt_no']) && isset($_POST['description']) && 
    isset($_POST['total']) && isset($_POST['spent_amount']) && isset($_POST['available_amount'])) {
    // Assuming your database connection is $conn
    $id = $_POST['id'];
    $receipt_no = $_POST['receipt_no'];
    $description = $_POST['description'];
    $total = $_POST['total'];
    $spent_amount = $_POST['spent_amount'];
    $available_amount = $_POST['available_amount'];
    
    // Update query
    $sql = "UPDATE tbl_receipt SET 
                receipt_no = '$receipt_no', 
                description = '$description', 
                total = '$total', 
                spent_amount = '$spent_amount', 
                available_amount = '$available_amount' 
            WHERE id = '$id'";
    
    if (mysqli_query($con, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>