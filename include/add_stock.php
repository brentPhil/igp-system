<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'config.php';

    $date = $_POST['date'];
    $qty_added = $_POST['qty_added'];
    $itemid = $_POST['project_id'];

    // Perform insertion into the 'items' table
    $insertQuery = "INSERT INTO items (project_id, date, qty_added) VALUES ('$itemid', '$date', '$qty_added')";
    $result = mysqli_query($conn, $insertQuery);

    // Calculate the new total quantity for the project
    $selectQuery = "SELECT SUM(qty_added) AS total_qty FROM items WHERE project_id = $itemid";
    $selectResult = mysqli_query($conn, $selectQuery);
    $row = mysqli_fetch_assoc($selectResult);
    $total_qty = $row['total_qty'];

    // Update the 'total' field in the 'projects' table
    $updateQuery = "UPDATE projects SET total = '$total_qty' WHERE id = $itemid";
    $result2 = mysqli_query($conn, $updateQuery);

    if ($result && $result2) {
        echo "success"; // Sending success message back to the AJAX request
    } else {
        echo "error"; // Sending error message back to the AJAX request
    }

    mysqli_close($conn);

} else {
    echo "Invalid request!";
}
?>