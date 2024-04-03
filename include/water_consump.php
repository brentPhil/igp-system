<?php
include 'config.php';

$sql = "SELECT billing_id, water_bal, date_filed FROM billing";
$result = $conn->query($sql);
$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$monthly_totals = array();

foreach ($data as $row) {
    $billing_date = date("F", strtotime($row['date_filed']));
    if (array_key_exists($billing_date, $monthly_totals)) {
        $monthly_totals[$billing_date] += $row['water_bal'];
    } else {
        $monthly_totals[$billing_date] = $row['water_bal'];
    }
}

$months = array();
$total_values = array();

foreach ($monthly_totals as $month => $total) {
    $months[] = $month;
    $total_values[] = $total;
}

$chart_data = array(
    "labels" => $months,
    "data" => $total_values
);
