<?php
require_once('includes/config.php');

$type = $_POST['type'];
$value = $_POST['value'];

if ($type && $value) {
    // Query to get menu access for the selected user or role
    $accessQuery = "SELECT menu_id FROM tbl_user_menu_access WHERE $type = ?";
    $stmt = $con->prepare($accessQuery);
    $stmt->bind_param('s', $value);
    $stmt->execute();
    $result = $stmt->get_result();

    $access = [];
    while ($row = $result->fetch_assoc()) {
        $access[] = $row['menu_id'];
    }

    // Query to get all menus
    $menuQuery = "SELECT * FROM tbl_sidebar_menu";
    $menuResult = $con->query($menuQuery);

    // Display menu items with checkboxes
    while ($menu = $menuResult->fetch_assoc()) {
        $checked = in_array($menu['id'], $access) ? 'checked' : '';
        echo '<tr>';
        echo '<td><input class="form-check-input menu-checkbox" type="checkbox" value="' . $menu['id'] . '" name="menus[]" ' . $checked . '></td>';
        echo '<td>' . htmlspecialchars($menu['menu_name']) . '</td>';
        echo '</tr>';
    }
}
?>
