<?php
include 'config.php';
$result = mysqli_query($conn, "SELECT faculty.department, SUM(logs.quantity) as total_quantity
          FROM logs
          INNER JOIN faculty ON logs.userid = faculty.id
          GROUP BY faculty.department
          ORDER BY total_quantity DESC");

// Fetch all results
$topDepartmentData = array();
while ($row = mysqli_fetch_assoc($result)) {
    $topDepartmentData['labels'][] = $row['department'];
    $topDepartmentData['data'][] = $row['total_quantity'];
}

// Convert data to JSON for JavaScript
$topDepartmentDataJSON = json_encode($topDepartmentData);