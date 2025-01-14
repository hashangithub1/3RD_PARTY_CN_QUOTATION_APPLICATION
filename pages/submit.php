<?php session_start();
include_once('includes/config.php');
if (strlen($_SESSION['id']==0)) {
  header('location:logout.php');
  } else{
    
?>
<?php
// Assuming you have a database connection
require_once('includes/config.php');

    $userid = $_SESSION['id'];
    $query = mysqli_query($con, "select * from tbl_staff where id='$userid'");
    
    // Assuming you have only one result for the user
    $username = mysqli_fetch_array($query);


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $old_nic = $_POST["old_nic"];
    $new_nic = $_POST["new_nic"];
    $address_01 = $_POST["address_01"];
    $address_02 = $_POST["address_02"];
    $city = $_POST["city"];
    $product = $_POST["product"];
    $cover_note_number = $_POST["cover_note_number"];
    $make_model = $_POST["make_model"];
    $usage_type = $_POST["usage_type"];
    $registered_owner = $_POST["registered_owner"];
    $registration_number = $_POST["registration_number"];
    $engine_number = $_POST["engine_number"];
    $chassis_number = $_POST["chassis_number"];
    $engine_capacity = $_POST["engine_capacity"];
    $branch_added = $_SESSION['branch'];
    $user_added = $username['username'];
    // Insert data into the database
    $sql = "INSERT INTO tbl_insurance (name, old_nic, new_nic, address_01, address_02, city, product, cover_note_number, make_model, usage_type, registered_owner, registration_number, engine_number, chassis_number, engine_capacity, branch_added, user_added)
            VALUES ('$name', '$old_nic', '$new_nic', '$address_01', '$address_02', '$city', '$product', '$cover_note_number', '$make_model', '$usage_type', '$registered_owner', '$registration_number', '$engine_number', '$chassis_number', '$engine_capacity', '$branch_added', '$user_added')";

    if ($con->query($sql) === TRUE) {
        // Redirect back to the form with a success message as a query parameter
        header("Location: manage_thirdparty.php?success=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>
<?php } ?>