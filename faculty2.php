<?php
include 'include/config.php';
$sql = "SELECT logs.userid, SUM(logs.quantity) AS total_quantity, faculty.first_name, faculty.middle, faculty.last_name
        FROM logs
        INNER JOIN faculty ON logs.userid = faculty.id
        INNER JOIN users ON logs.userid = users.faculty_id
        GROUP BY logs.userid";
$result = $conn->query($sql);

$labels = [];
$data = [];
$fullnames = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['userid'];
        $data[] = $row['total_quantity'];
        $fullnames[] = $row['first_name'] . ' ' . $row['middle'] . ' ' . $row['last_name'];
    }
}

$dataTable = array();
$dataTable['cols'] = array(
    array('label' => 'UserID', 'type' => 'string'),
    array('label' => 'Total Quantity', 'type' => 'number')
);

$rows = array();
foreach ($labels as $key => $label) {
    $temp = array();
    $temp[] = array('v' => $label);
    $temp[] = array('v' => $data[$key]);
    $rows[] = array('c' => $temp);
}

$dataTable['rows'] = $rows;

echo json_encode($dataTable);
?>