<?php
require_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from the form
    $productId = $_POST['editProductId'];
    $productCode = $_POST['editProductCode'];
    $productName = $_POST['editProductName'];
    $productPremium = $_POST['editProductPremium'];

    if (empty($productCode) || empty($productName) || empty($productPremium)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        echo "<script type='text/javascript'> document.location = 'products.php'; </script>";


    } else {
         $sql = "UPDATE tbl_product SET prod_code='$productCode', name='$productName', value='$productPremium' WHERE id=$productId";
         mysqli_query($con, $sql);

        // Display success message
        echo "<script>alert('Product updated successfully!');</script>";
        echo "<script type='text/javascript'> document.location = 'products.php'; </script>";
    }
}
?>