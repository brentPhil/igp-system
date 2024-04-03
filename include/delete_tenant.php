<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tenant_id"])) {
    // Get user ID from the POST data
    $tenantId = $_POST["tenant_id"];

    // Prepare and execute SQL statement to delete the user
    $stmt = $conn->prepare("DELETE FROM tenant WHERE tenant_id = ?");
    $stmt->bind_param("i", $tenantId);
    $stmt->execute();

    // Check if deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Tenant deleted successfully";
    } else {
        echo "Error: Failed to delete tenant";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request
    echo "Invalid request";
}