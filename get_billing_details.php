<?php
// Include your database connection file
include 'include/config.php';

// Check if the request contains a billing ID
if (isset($_GET['billing_id'])) {
    $billing_id = $_GET['billing_id'];
    // Query to fetch billing details from the database
    $query = "SELECT b.*, s.stall_name, CONCAT(u.first_name, ' ', u.middle, ' ', u.last_name) AS tenant_name
              FROM billing b
              INNER JOIN stalls s ON b.billing_stall = s.stall_id
              INNER JOIN tenant t ON s.stall_id = t.stall_id
              INNER JOIN users u ON t.user = u.user_id
              WHERE b.billing_id = '".$billing_id."'";
              
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the data
        $row = mysqli_fetch_assoc($result);
        // Return the data as JSON
        echo json_encode($row);
    } else {
        echo json_encode(array('error' => 'Billing details not found'));
    }
} else {
    echo json_encode(array('error' => 'Billing ID not provided'));
}
