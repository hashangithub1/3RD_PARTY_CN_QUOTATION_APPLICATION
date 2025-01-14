<?php
// Include your database connection file
include_once('includes/config.php');

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM tbl_agent_codes WHERE id = ?";
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: agent_code.php?message=Agent Code deleted successfully");
            exit();
        } else {
            header("Location: agent_code.php?message=Error deleting Agent Code");
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        header("Location: agent_code.php?message=Error preparing statement");
        exit();
    }
} else {
    header("Location: agent_code.php?message=Invalid code ID");
    exit();
}

// Close the database connection
mysqli_close($con);
?>