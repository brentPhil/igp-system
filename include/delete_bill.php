<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["billing_id"])) {
    // Get billing ID from the POST data
    $billingId = $_POST["billing_id"];

    // Prepare and execute SQL statement to get the c_receipt filename
    $stmtSelect = $conn->prepare("SELECT c_receipt FROM billing WHERE billing_id = ?");
    $stmtSelect->bind_param("i", $billingId);
    $stmtSelect->execute();
    $stmtSelect->bind_result($c_receipt);

    // Fetch the c_receipt filename
    if ($stmtSelect->fetch()) {
        // Close the statement
        $stmtSelect->close();

        // Check if c_receipt is not empty and the file exists
        if (!empty($c_receipt) && file_exists("receipts/{$c_receipt}")) {
            // Delete the file
            unlink("receipts/{$c_receipt}");
        }

        // Prepare and execute SQL statement to delete the billing
        $stmtDelete = $conn->prepare("DELETE FROM billing WHERE billing_id = ?");
        $stmtDelete->bind_param("i", $billingId);
        $stmtDelete->execute();

        // Check if deletion was successful
        if ($stmtDelete->affected_rows > 0) {
            echo "Bill and associated file deleted successfully";
        } else {
            echo "Error: Failed to delete bill or associated file";
        }

        // Close the statement
        $stmtDelete->close();
    } else {
        // Close the statement
        $stmtSelect->close();

        echo "Error: Billing record not found";
    }

    // Close the connection
    $conn->close();
} else {
    // Handle invalid request
    echo "Invalid request";
}
?>