<?php session_start();
include_once('includes/config.php');
// Retrieve selected product code from POST request
if(isset($_POST['selectedProduct'])){
    $pc = $_POST['selectedProduct'];

  
   
    $sql = "SELECT product_des, product_code FROM tbl_product_mt WHERE product_calss = '$pc'";
                    $result = $con->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $prodname = $row['product_des'];
                        $prodcode = $row['product_code'];
                    }
    $_SESSION['selected_product_class'] = $pc;
    $_SESSION['selected_product_code'] = $prodcode;
    $_SESSION['selected_product_name'] = $prodname;
    $_SESSION['notification_handle'] = "";
    $_SESSION['notification'] = "";
    echo $pc;
} else {
    echo "Error: No product code received!";
}
?>
