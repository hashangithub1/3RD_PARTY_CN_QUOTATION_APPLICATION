<?php
require_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from the form
    $branchId = $_POST['editBranchId'];
    $branchCode = $_POST['editBranchCode'];
    $bank_code = $_POST['editBankCode'];
    $branchName = $_POST['editBranchName'];
    $Bank_name = $_POST['editBankName'];
    $AC_no = $_POST['editAcNo'];

    if (empty($branchCode) || empty($branchName)) {
        echo "<script>alert('Please fill in all fields.');</script>";
        echo "<script type='text/javascript'> document.location = 'branch.php'; </script>";

    } else {
         $sql = "UPDATE tbl_branch SET b_name='$branchName', b_code='$branchCode', bank_code='$bank_code', bank_name='$Bank_name', bank_acc_no='$AC_no' WHERE id=$branchId";
         mysqli_query($con, $sql);

        // Display success message
        echo "<script>alert('Branch updated successfully!');</script>";
        echo "<script type='text/javascript'> document.location = 'branch.php'; </script>";
    }
}
?>
