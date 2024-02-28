<?php
// Include your database connection or config file
include 'include/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pid"]) && isset($_POST["quantity"])) {
    $pid = $_POST["pid"];
    $quantity = $_POST["quantity"];
    $user_id = $_SESSION["user_id"];

    // Validate and sanitize inputs
    $pid = intval($pid); // Convert to integer for safety
    $quantity = intval($quantity);

    if ($pid <= 0 || $quantity <= 0) {
        // Invalid inputs; handle the error accordingly
        echo json_encode(array("status" => "error", "message" => "Invalid input data."));
        exit(); // Stop further execution to prevent SQL injection
    }

    // Check if the product exists and has sufficient stock for sale
    $productQuery = "SELECT * FROM products WHERE id = $pid";
    $productResult = $conn->query($productQuery);

    if ($productResult && $productResult->num_rows > 0) {
        $productData = $productResult->fetch_assoc();
        $currentStock = $productData['stock'];

        if ($currentStock >= $quantity && $quantity > 0) {
            // Perform the sale - Update the stock after selling items
            $newStock = $currentStock - $quantity;
            $updateStockQuery = "UPDATE products SET stock = $newStock WHERE id = $pid";
            if ($conn->query($updateStockQuery) === TRUE) {
                $addLog = "INSERT INTO logs (log, userid) VALUES ('Sold a stock of $quantity', '$user_id')";
                $saveLog = mysqli_query($conn, $addLog);
                // Sale successful
                echo json_encode(array("status" => "success", "message" => "Sale successful."));
            } else {
                // Error updating stock
                echo json_encode(array("status" => "error", "message" => "Error occurred while updating stock."));
            }
        } else {
            // Insufficient stock or invalid quantity for sale
            echo json_encode(array("status" => "error", "message" => "Insufficient stock or invalid quantity for sale."));
        }
    } else {
        // Product not found
        echo json_encode(array("status" => "error", "message" => "Product not found."));
    }
} else {
    // Invalid request
    echo json_encode(array("status" => "error", "message" => "Invalid request."));
}
?>