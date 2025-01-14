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

// Function to generate the menu HTML with custom classes
function generateMenu($menuTree) {
    $html = '<ul class="custom-nav">';
    foreach ($menuTree as $item) {
        if (!isset($item['menu_name'])) {
            continue; // Skip items that don't have a name
        }

        $hasChildren = !empty($item['children']);
        $uniqueId = 'custom-submenu-' . $item['id'];
        $html .= '<li class="custom-nav-item">';
        $html .= '<a class="custom-nav-link' . ($hasChildren ? ' custom-collapse-toggle' : '') . '" href="' . ($hasChildren ? '#' . $uniqueId : $item['url']) . '" ' . ($hasChildren ? 'aria-expanded="false"' : '') . '>';
        $html .= '<span class="custom-menu-title">' . $item['menu_name'] . '</span>';
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
<nav class="custom-sidebar" id="custom-sidebar">
    <?php echo generateMenu($menuTree); ?>
</nav>

<style>
 /* Custom Sidebar Styling */
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
</style>

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
