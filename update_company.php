<?php
require_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from the form
    $Id = $_POST['editId'];
    $Code = $_POST['editCode'];
    $Name = $_POST['editName'];
    $Desc = $_POST['editDescription'];

         $sql = "UPDATE tbl_company_mt SET code='$Code', name='$Name', description='$Desc' WHERE id=$Id";
         mysqli_query($con, $sql);

        // Display success message
        echo "<script>alert('Updated successfully!');</script>";
        echo "<script type='text/javascript'> document.location = 'companies-motor.php'; </script>";
    }
?>