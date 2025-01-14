<?php session_start();
$_SESSION['selected_company_name'] = "";
$_SESSION['selected_company_code'] = "";
$_SESSION['selected_product_name'] = "";
$_SESSION['selected_product_code'] = "";
$_SESSION['selected_channel_name'] = "";
$_SESSION['selected_channel_code'] = "";
$_SESSION['notification_handle'] = "";
$_SESSION['notification'] = "";

echo "<script type='text/javascript'> document.location = 'product-cover-motor.php'; </script>";
?>