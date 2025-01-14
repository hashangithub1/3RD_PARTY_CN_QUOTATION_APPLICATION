<?php
session_start();
require_once('includes/config.php');

// Check if user is logged in
if (empty($_SESSION['id'])) {
    header('location:logout.php');
    exit;
}

// Function to grant access by username or role
function grantAccess($con, $identifier, $menus, $column) {
    $deleteQuery = "DELETE FROM tbl_user_menu_access WHERE $column = ?";
    $stmt = mysqli_prepare($con, $deleteQuery);
    mysqli_stmt_bind_param($stmt, 's', $identifier);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Insert new access for selected menus
    if (!empty($menus)) {
        $insertQuery = "INSERT INTO tbl_user_menu_access ($column, menu_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $insertQuery);
        foreach ($menus as $menu_id) {
            mysqli_stmt_bind_param($stmt, 'si', $identifier, $menu_id);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $role = $_POST['role'] ?? '';
    $menus = $_POST['menus'] ?? [];

    if (!empty($username)) {
        grantAccess($con, $username, $menus, 'username');
    } elseif (!empty($role)) {
        grantAccess($con, $role, $menus, 'role');
    } else {
        $_SESSION['error'] = "Please select a user or role.";
        header("Location: access_menu.php");
        exit;
    }

    $_SESSION['msg'] = "Access granted successfully!";
    header("Location: access_menu.php");
    exit;
}
?>
