<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    // Get user ID from the POST data
    $reportId = $_POST["id"];

    // Prepare and execute SQL statement to delete the user
    $stmt = $conn->prepare("DELETE FROM reports WHERE id = ?");
    $stmt->bind_param("i", $reportId);
    $stmt->execute();

    // Check if deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Report deleted successfully";
    } else {
        echo "Error: Failed to delete report";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request
    echo "Invalid request";
}