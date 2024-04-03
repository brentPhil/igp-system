<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'config.php';

    $name = $_POST['name'];
    $insertQuery = "INSERT INTO projects (name) VALUES ('$name')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        echo "success"; // Sending success message back to the AJAX request
    } else {
        echo "error"; // Sending error message back to the AJAX request
    }

    mysqli_close($conn);

} else {
    echo "Invalid request!";
}
?>
