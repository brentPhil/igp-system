<?php
include 'config.php';

$sql = "SELECT billing_id, electricity_bal, water_bal, date_filed FROM billing";
$result = $conn->query($sql);
$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $billing_date = date("F", strtotime($row['date_filed']));

        // Initialize arrays if not set
        if (!isset($data[$billing_date])) {
            $data[$billing_date] = array('electricity' => 0, 'water' => 0);
        }

        // Accumulate electricity and water bills by month
        $data[$billing_date]['electricity'] += $row['electricity_bal'];
        $data[$billing_date]['water'] += $row['water_bal'];
    }
}

$months = array();
$total_values_elec = array();
$total_values_water = array();

foreach ($data as $month => $values) {
    $months[] = $month;
    $total_values_elec[] = $values['electricity'];
    $total_values_water[] = $values['water'];
}

$chart_data = array(
    "labels" => $months,
    "data_elec" => $total_values_elec,
    "data_water" => $total_values_water
);