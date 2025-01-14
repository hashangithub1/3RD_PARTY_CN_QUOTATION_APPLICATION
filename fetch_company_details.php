<?php
require_once('includes/config.php');

if (isset($_POST['id'])) {
    $productId = $_POST['id'];

    // Fetch data for the selected product
    $query = "SELECT * FROM tbl_company_mt WHERE id = $productId";
    $result = mysqli_query($con, $query);
    $company = mysqli_fetch_assoc($result);

    // Send JSON response with product details
    echo json_encode($company);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>
