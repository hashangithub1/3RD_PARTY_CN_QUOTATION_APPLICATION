<?php
include_once('includes/config.php');


$userID   = $_SESSION['id'];
$username = $_SESSION['u_name'];
// Fetch the user's role from tbl_staff
$roleQuery = "SELECT role FROM tbl_staff WHERE id = ?";
$stmtRole = $con->prepare($roleQuery);
$stmtRole->bind_param('i', $userID);
$stmtRole->execute();
$resultRole = $stmtRole->get_result();
$userRoleRow = $resultRole->fetch_assoc();
$userRole = $userRoleRow['role'];

// Fetch the menu items from the database
$query = "SELECT * FROM tbl_sidebar_menu ORDER BY parent_id, id";
$menuItems = $con->query($query);

// Fetch role-based access from tbl_user_menu_access
$roleAccessQuery = "SELECT menu_id FROM tbl_user_menu_access WHERE role = ?";
$stmtRoleAccess = $con->prepare($roleAccessQuery);
$stmtRoleAccess->bind_param('i', $userRole);
$stmtRoleAccess->execute();
$resultRoleAccess = $stmtRoleAccess->get_result();

// Fetch username-specific access from tbl_user_menu_access
$usernameAccessQuery = "SELECT menu_id FROM tbl_user_menu_access WHERE username = ?";
$stmtUsernameAccess = $con->prepare($usernameAccessQuery);
$stmtUsernameAccess->bind_param('s', $username);
$stmtUsernameAccess->execute();
$resultUsernameAccess = $stmtUsernameAccess->get_result();

// Store the accessed menu IDs in arrays
$roleAccess = [];
while ($rowRoleAccess = $resultRoleAccess->fetch_assoc()) {
    $roleAccess[] = $rowRoleAccess['menu_id'];
}

$usernameAccess = [];
while ($rowUsernameAccess = $resultUsernameAccess->fetch_assoc()) {
    $usernameAccess[] = $rowUsernameAccess['menu_id'];
}

// Organize menu items into a tree structure
$menuTree = [];
$itemsById = [];

while ($item = $menuItems->fetch_assoc()) {
    $item['children'] = [];
    $item['access_granted'] = in_array($item['id'], $roleAccess) || in_array($item['id'], $usernameAccess); // Check if the user has access
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

// Function to generate the menu HTML with access control
function generateMenu($menuTree) {
    $html = '<ul class="custom-nav">';
    foreach ($menuTree as $item) {
        if (!isset($item['menu_name'])) {
            continue; // Skip items that don't have a name
        }

        $hasChildren = !empty($item['children']);
        $uniqueId = 'custom-submenu-' . $item['id'];
        $html .= '<li class="custom-nav-item">';

        // Mark the menu as accessible or not based on the user's access
        $isAccessible = $item['access_granted'] ? ' accessible' : ' not-accessible';

        $html .= '<a class="custom-nav-link' . ($hasChildren ? ' custom-collapse-toggle' : '') . $isAccessible . '" href="../' . ($hasChildren ? '#' . $uniqueId : $item['url']) . '" ' . ($hasChildren ? 'aria-expanded="false"' : '') . '>';
        $html .= '<span class="custom-menu-title">' . $item['menu_name'] . '</span>';
        $html .= '<span class="menu-id" style="display:none;">' . $item['id'] . '</span>';
        $html .= $hasChildren ? '<i class="custom-menu-arrow">▶</i>' : '';
        $html .= '</a>';

        if ($hasChildren) {
            $html .= '<div class="custom-collapse" id="' . $uniqueId . '">';
            $html .= generateMenu($item['children']);
            $html .= '</div>';
        }

        $html .= '</li>';
    }
    $html .= '</ul>';
    return $html;
}

?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
    <?php echo generateMenu($menuTree); ?>
    </ul>
</nav>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuLinks = document.querySelectorAll('.custom-nav-link');

    menuLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            // Remove active class from all links
            menuLinks.forEach(link => link.classList.remove('active'));

            // Add active class to the clicked link
            this.classList.add('active');

            // Toggle submenu for parent links
            if (this.classList.contains('custom-collapse-toggle')) {
                e.preventDefault(); // Prevent the default action

                const collapseElement = this.nextElementSibling;
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                // Toggle the "aria-expanded" attribute
                this.setAttribute('aria-expanded', !isExpanded);

                // Show or hide the submenu
                if (collapseElement) {
                    collapseElement.style.display = isExpanded ? 'none' : 'block';
                }

                // Rotate the arrow
                const arrowIcon = this.querySelector('.custom-menu-arrow');
                if (arrowIcon) {
                    arrowIcon.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(90deg)';
                }
            }
        });
    });
});
</script>

<style>
 /* Custom Sidebar Styling */
.sidebar {
  background: #1e1e1e;
}

.custom-sidebar {
    width: 250px;
    background-color: #5D6771;
    color: white;
    padding: 15px;
}

.custom-nav {
    list-style: none;
    padding-left: 0;
}

.custom-nav-item {
    margin-bottom: 10px;
}

.custom-nav-link {
    color: white;
    text-decoration: none;
    padding: 3px 7px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #34495e;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.custom-nav-link:hover {
    background-color: #81bd43;
    color: white;
}

.custom-nav-link.active {
    background-color: #81bd43;
    color: white;
}

.custom-menu-arrow {
    transition: transform 0.3s ease;
    font-size: 12px;
}

.custom-collapse {
    display: none;
    background-color: #34495e;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    padding-left: 20px;
    margin: 5px;
}

.custom-collapse-toggle[aria-expanded="true"] + .custom-collapse {
    display: block;
}

.custom-nav-link[aria-expanded="true"] .custom-menu-arrow {
    transform: rotate(90deg);
}


.not-accessible {
    color: red; /* Non-accessible menu items will appear red */
    pointer-events: none; /* Optional: disable clicking */
    display : none;
}

</style>