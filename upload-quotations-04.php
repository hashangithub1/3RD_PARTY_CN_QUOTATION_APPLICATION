<?php
$uploadDirectory = 'Quotation_Formats/Standard Quotes - Underwriters [Dont Share]/';

if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}

if (!empty($_FILES['files']) && !empty($_POST['paths'])) {
    foreach ($_FILES['files']['name'] as $key => $name) {
        $tmpName = $_FILES['files']['tmp_name'][$key];
        $relativePath = $_POST['paths'][$key];
        $filePath = $uploadDirectory . $relativePath;

        // Create directory if it does not exist
        $fileDirectory = dirname($filePath);
        if (!is_dir($fileDirectory)) {
            mkdir($fileDirectory, 0777, true);
        }

        if (move_uploaded_file($tmpName, $filePath)) {
            echo "Uploaded: " . htmlspecialchars($relativePath) . "<br>";
            //echo "Upload Successfully";
        } else {
            echo "Failed to upload: " . htmlspecialchars($relativePath) . "<br>";
        }
    }
} else {
    echo "No files uploaded.";
}
?>