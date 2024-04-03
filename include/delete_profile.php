<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    // Get user ID from the POST data
    $userId = $_POST["user_id"];

    // Retrieve the profile picture filename from the database
    $selectProfilePicStmt = $conn->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
    $selectProfilePicStmt->bind_param("i", $userId);
    $selectProfilePicStmt->execute();
    $selectProfilePicStmt->store_result();

    // Bind the result to a variable
    $selectProfilePicStmt->bind_result($profilePic);
    $selectProfilePicStmt->fetch();

    // Directory where uploaded files are stored
    $uploadsDirectory = "uploads/";

    // Delete the profile picture file from the "uploads" folder
    if (!empty($profilePic)) {
        $filePath = $uploadsDirectory . $profilePic;
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file
        }
    }

    // Prepare and execute SQL statement to delete the user from the users table
    $deleteUserStmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $deleteUserStmt->bind_param("i", $userId);
    $deleteUserStmt->execute();

    // Prepare and execute SQL statement to delete tenant based on user ID
    $deleteTenantStmt = $conn->prepare("DELETE FROM tenant WHERE user = ?");
    $deleteTenantStmt->bind_param("i", $userId);
    $deleteTenantStmt->execute();

    // Check if deletion was successful for both tables
    if ($deleteUserStmt->affected_rows > 0 && $deleteTenantStmt->affected_rows > 0) {
        echo "User and associated tenant data deleted successfully";

        // Close the statements
        $deleteUserStmt->close();
        $deleteTenantStmt->close();

        // Close the select profile picture statement
        $selectProfilePicStmt->close();

        // Close the connection
        $conn->close();
    } else {
        echo "Error: Failed to delete user or associated tenant data";
    }
} else {
    // Handle invalid request
    echo "Invalid request";
}
?>