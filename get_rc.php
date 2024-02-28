<?php
include 'include/config.php';

if(isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];
    $no = 1;

    $result = mysqli_query($conn, "SELECT * FROM remarks_complaint WHERE user = '$userId' ORDER BY datetime ASC");

    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered'><tr><th>Details</th><th>Date</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>$no. ".$row["description"]."</td><td>".$row["datetime"]."</td></tr>";
        $no++;
        }
        echo "</table>";
    } else {
        echo "No complaints/remarks found for this user.";
    }
} else {
    echo "User ID not provided.";
}
?>