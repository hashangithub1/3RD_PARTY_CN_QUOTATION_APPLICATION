<?php
include_once('includes/config.php');

// Fetch the menu items from the database
$query = "SELECT * FROM tbl_sidebar_menu ORDER BY parent_id, id";
$menuItems = $con->query($query);

// Organize menu items into a tree structure
$menuTree = [];
$itemsById = [];

while ($item = $menuItems->fetch_assoc()) {
    $item['children'] = [];
    $itemsById[$item['id']] = $item;
}

// Build the tree structure
foreach ($itemsById as $id => &$item) {
    if ($item['parent_id'] == NULL) {
        $menuTree[$id] = &$item;
    } else {
        if (isset($itemsById[$item['parent_id']])) {
            $itemsById[$item['parent_id']]['children'][$id] = &$item;
        }
    }
}

// Function to generate the menu HTML
function generateMenu($menuTree) {
    $html = '<ul class="nav">';
    foreach ($menuTree as $item) {
        if (!isset($item['menu_name'])) {
            continue; // Skip items that don't have a name
        }

        $hasChildren = !empty($item['children']);
        $html .= '<li class="nav-item">';
        $html .= '<a class="nav-link' . ($hasChildren ? ' collapse' : '') . '" href="' . ($hasChildren ? '#submenu-' . $item['id'] : $item['url']) . '" ' . ($hasChildren ? 'data-toggle="collapse"' : '') . '>';
        $html .= '<span class="menu-title">' . $item['menu_name'] . '</span>';
        $html .= $hasChildren ? '<i class="menu-arrow"></i>' : '';
        $html .= '</a>';
        if ($hasChildren) {
            $html .= '<div class="collapse" id="submenu-' . $item['id'] . '">';
            $html .= generateMenu($item['children']);
            $html .= '</div>';
        }
        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}

// Output the menu
echo generateMenu($menuTree);
?>
