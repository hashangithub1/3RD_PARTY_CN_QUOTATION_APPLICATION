<?php
session_start();

// Mark all notifications as read
if (isset($_SESSION['notifications']) && !empty($_SESSION['notifications'])) {
    foreach ($_SESSION['notifications'] as &$notification) {
        $notification['is_read'] = true;
    }
    unset($notification); // Unset reference to avoid issues with future loops
}

// Optionally, return the updated notifications to be displayed
if (isset($_SESSION['notifications']) && !empty($_SESSION['notifications'])) {
    echo '<ul>';
    foreach ($_SESSION['notifications'] as $notification) {
        $status = $notification['is_read'] ? 'read' : 'unread';
        echo '<li>';
        echo '<strong>' . $notification['message'] . '</strong><br>';
        echo '<small>' . $notification['time'] . '</small><br>';
        echo '<span>Status: ' . $status . '</span>';
        echo '</li><br>';
    }
    echo '</ul>';
} else {
    echo 'No notifications available.';
}
?>