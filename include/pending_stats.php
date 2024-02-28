<?php
include 'config.php';

// Query to get monthly counts of 'Pending' status (0 value)
$query = "SELECT MONTH(date_filed) AS month, COUNT(*) AS total_pending
          FROM billing
          WHERE status = 0
          GROUP BY MONTH(date_filed)";

$result = $conn->query($query);

// Prepare data for Chart.js
$data = array();
while ($row = $result->fetch_assoc()) {
    $data['months'][] = date("F", mktime(0, 0, 0, $row['month'], 1));
    $data['totals'][] = $row['total_pending'];
}

// Convert data to JSON for Chart.js
$data_json = json_encode($data);

?>
