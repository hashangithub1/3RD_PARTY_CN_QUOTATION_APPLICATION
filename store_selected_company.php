<?php session_start();
include_once('includes/config.php');
// Retrieve selected product code from POST request
if(isset($_POST['selectedCompany'])){
   $compcode = $_POST['selectedCompany'];

  
   
    $sql = "SELECT name FROM tbl_company_mt WHERE code = '$compcode'";
                    $result = $con->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $compname = $row['name'];
                    }
    $_SESSION['selected_company_code'] = $compcode;
    $_SESSION['selected_company_name'] = $compname;
    $_SESSION['notification_handle'] = "";
    $_SESSION['notification'] = "";
    echo $compcode;
} else {
    echo "Error: No company code received!";
}
?>
