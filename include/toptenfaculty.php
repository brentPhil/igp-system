<?php
include 'config.php';
$sql = "SELECT logs.userid, SUM(logs.quantity) AS total_quantity, faculty.first_name, faculty.middle, faculty.last_name
        FROM logs
        INNER JOIN faculty ON logs.userid = faculty.id
        INNER JOIN users ON logs.userid = users.faculty_id
        GROUP BY logs.userid
        ORDER BY total_quantity DESC
        LIMIT 10";
$result = $conn->query($sql);

$labels = [];
$datay = [];
$fullnamesx = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['userid'];
        $datay[] = $row['total_quantity'];
        $fullnamesx[] = $row['first_name'] . ' ' . $row['middle'] . ' ' . $row['last_name'];
    }
}

$quantityDatax = json_encode($datay);
?>