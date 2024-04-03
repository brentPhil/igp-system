<?php
include 'config.php';

if (isset($_GET["id"])) {
  $projectId = $_GET["id"];

  // First, delete the project
  $deleteProjectSql = "DELETE FROM projects WHERE id = $projectId";
  if ($conn->query($deleteProjectSql) === TRUE) {
    echo "Project deletion success.";

    // If the project deletion was successful, proceed to delete associated items
    $deleteItemsSql = "DELETE FROM items WHERE project_id = $projectId";
    if ($conn->query($deleteItemsSql) === TRUE) {
      echo " Items associated with the project have been deleted.";
    } else {
      echo " Error deleting associated items: " . $conn->error;
    }
  } else {
    echo "Error deleting project: " . $conn->error;
  }
}
?>
