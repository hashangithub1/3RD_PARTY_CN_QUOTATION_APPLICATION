<?php
include_once('includes/config.php');

// Get the product code from the query string
$productCode = isset($_GET['prod_code']) ? $_GET['prod_code'] : '';

// Prepare the SQL query to fetch makes and models based on the product code
if ($productCode) {
    $sql = "SELECT model, m_code FROM tbl_model WHERE bus_class = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $productCode);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results and store them in an array
    $makesModels = array();
    while ($row = $result->fetch_assoc()) {
        $makesModels[] = $row;
    }

    // Return the results as JSON
    echo json_encode($makesModels);
} else {
    echo json_encode([]);
}
?>
