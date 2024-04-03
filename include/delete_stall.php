<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["stall_id"])) {
    // Get user ID from the POST data
    $stallId = $_POST["stall_id"];

    // Prepare and execute SQL statement to delete the user
    $stmt = $conn->prepare("DELETE FROM stalls WHERE stall_id = ?");
    $stmt->bind_param("i", $stallId);
    $stmt->execute();

    // Check if deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Stall deleted successfully";
    } else {
        echo "Error: Failed to delete stall";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request
    echo "Invalid request";
}
?>
