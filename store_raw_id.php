<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['rowId'])) {
        $rawID = $_POST['rowId'];
        $_SESSION['rawID'] = $rawID;
        echo 'Raw ID stored in session successfully.';
        
        
    } else {
        echo 'Invalid request.';
    }
} else {
    echo 'Invalid request method.';
}
?>
<html>
    <head>
        <body>
            <h1>prev_upload <?php echo $_SESSION['rawID']; ?> </h1>
        </body>
    </head>
</html>
