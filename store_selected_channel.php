<?php session_start();
include_once('includes/config.php');
// Retrieve selected product code from POST request
if(isset($_POST['selectedChannel'])){
   $chnlcode = $_POST['selectedChannel'];

  
   
    $sql = "SELECT name FROM tbl_business_channel_mt WHERE code = '$chnlcode'";
                    $result = $con->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $chnlname = $row['name'];
                    }
    $_SESSION['selected_channel_code'] = $chnlcode;
    $_SESSION['selected_channel_name'] = $chnlname;
    $_SESSION['notification_handle'] = "";
    $_SESSION['notification'] = "";
    $_SESSION['companyname_form'] = "";
    $_SESSION['companycode_form'] = "";
    $_SESSION['selected_product_code'] = "";
    $_SESSION['selected_company_name'] = "";
    
    echo $chnlcode;
} else {
    echo "Error: No company code received!";
}
?>
