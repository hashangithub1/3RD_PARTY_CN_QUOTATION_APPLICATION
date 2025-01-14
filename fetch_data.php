<?php
$servername = "localhost"; // Change this to your database server name if it's different
$username = "root"; // Change this to your database username
$password = "root"; // Change this to your database password
$database = "insurance"; // Change this to your database name

// Create connection
$con = new mysqli($servername, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
// Check if the product ID is provided in the request
if (isset($_GET['product_id'])) {
    // Sanitize the input to prevent SQL injection
    $product_code = mysqli_real_escape_string($con, $_GET['product_id']);

    // Query to retrieve data based on the selected product
    $sql = "SELECT * FROM tbl_product_cover_mt WHERE prod_code = 'V0102'";
    $result = $con->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            // If data is found, loop through the results and echo HTML for table rows
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td data-label='Product Class'><input type='text' name='product_code[]' value='" . $row['cover_code'] . "' required></td>";
                // Repeat this for other fields
                echo "</tr>";
            }
        } else {
            // If no data found for the selected product, display a message or handle it as needed
            echo "<tr><td colspan='...'>No data found</td></tr>";
        }
    } else {
        // If an error occurred during the query execution, display an error message
        echo "<tr><td colspan='...'>Error: " . $con->error . "</td></tr>";
    }
} else {
    // If the product ID is not provided, display an error message or handle it as needed
    echo "<tr><td colspan='...'>Product ID is missing</td></tr>";
}

// Close the database connection
$con->close();
?>