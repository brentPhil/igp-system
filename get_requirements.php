<?php
include 'include/config.php';

if(isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $no = 1;

    $result = mysqli_query($conn, "SELECT * FROM requirements WHERE user_id = '$userId' ORDER BY req_name ASC");

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'><tr><th>Requirements</th><th>Date</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>$no. ".$row["req_name"]."</td><td>".$row["date"]."</td><td><button class='btn btn-primary btn-sm' onclick=\"window.open('requirements/{$row['file_name']}', '_blank')\"><i class='bi bi-eye'></i></button></td></tr>";
        $no++;
        }
        echo "</table>";
    } else {
        echo "No requirements found for this user.";
    }
} else {
    echo "User ID not provided.";
}
?>