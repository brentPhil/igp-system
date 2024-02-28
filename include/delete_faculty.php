<?php
include 'config.php';

if (isset($_POST['id'])) {
  $faculty_id = $_POST['id'];

  // Perform the deletion
  $query = "DELETE FROM faculty WHERE faculty.id = $faculty_id";
  $result = mysqli_query($conn, $query);

  if ($result) {
    echo 'success';
  } else {
    echo 'error';
  }
} else {
  echo 'error';
}
?>
