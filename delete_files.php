<?php
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['folder'])) {
        $folder = $_POST['folder'];
        $folderPath = __DIR__ . '/' . $folder;

        if (is_dir($folderPath)) {
            // Function to delete all files and subdirectories within a directory
            function deleteFolderContents($dir) {
                $files = array_diff(scandir($dir), array('.', '..'));
                foreach ($files as $file) {
                    $filePath = $dir . '/' . $file;
                    if (is_dir($filePath)) {
                        deleteFolderContents($filePath);
                        rmdir($filePath); // Remove the empty subdirectory
                    } else {
                        unlink($filePath); // Remove the file
                    }
                }
            }

            // Attempt to delete the folder contents
            deleteFolderContents($folderPath);
            $_SESSION["notificationcomp"] = "All files have been deleted successfully!";
            $_SESSION["notification_handlecomp"] = "1";
            echo 'All files and subdirectories within the folder have been deleted successfully.';
        } else {
            $_SESSION["notificationcomp"] = "The folder does not exist.";
            $_SESSION["notification_handlecomp"] = "2";
            //echo 'The folder does not exist.';
        }
    } else {
            $_SESSION["notificationcomp"] = "No folder specified.";
            $_SESSION["notification_handlecomp"] = "2";
        //echo 'No folder specified.';
    }
} else {
            $_SESSION["notificationcomp"] = "Invalid request method.";
            $_SESSION["notification_handlecomp"] = "3";
    //echo 'Invalid request method.';
}
?>
