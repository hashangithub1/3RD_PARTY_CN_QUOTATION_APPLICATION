<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $requiredFields = ['product_type', 'make_model', 'fuel_type', 'registration_number', 'usage', 'seating_capacity', 'year_of_manufacture', 'sum_insured'];
    foreach ($requiredFields as $field) {
        if (!isset($input[$field]) || empty($input[$field])) {
            http_response_code(400); // Bad Request
            echo json_encode(["error" => "Missing or empty field: $field"]);
            exit;
        }
    }

    $productType = $input['product_type'];
    $makeModel = $input['make_model'];
    $fuelType = $input['fuel_type'];
    $registrationNumber = $input['registration_number'];
    $usage = $input['usage'];
    $seatingCapacity = $input['seating_capacity'];
    $yearOfManufacture = $input['year_of_manufacture'];
    $sumInsured = $input['sum_insured'];

    $premium = 105000.00; 

    // Return the response
    http_response_code(200);
    echo json_encode([
        "message" => "Premium calculated successfully",
        "premium" => number_format($premium, 2)
    ]);
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Invalid request method. Please use POST."]);
}
