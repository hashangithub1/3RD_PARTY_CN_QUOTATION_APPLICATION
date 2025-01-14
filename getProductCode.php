<?php
// getProductCode.php
include_once('includes/config.php');
// Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];

    // Fetch the product code from the database based on the selected product
    $sql = "SELECT prod_code FROM tbl_product WHERE id = $productId";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['code'];
    } else {
        echo 'Product code not found';
    }
}
?>
