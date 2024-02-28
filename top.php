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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Top Faculty Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Top Faculty Chart</h2>
    <canvas id="topFacultyChart" width="400" height="200"></canvas>

    <script>
        var ctx = document.getElementById('topFacultyChart').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($fullnames); ?>,
                datasets: [{
                    label: 'Total Quantity',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
