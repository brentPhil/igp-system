<?php
include 'include/config.php';

$iid = $_GET['getid'];
$result = mysqli_query($conn, "SELECT *,projects.id as pid, items.id as id, projects.name as itemname, items.date as idate FROM items INNER JOIN projects ON items.project_id = projects.id WHERE items.project_id = '$iid' ORDER BY idate ASC");

if ($result->num_rows > 0) {
  $output = "<tr><th>Item Name</th><th>Date</th><th>Collection Added</th></tr>";
  $previousItem = ""; // Variable to store previous item name

  while ($row = $result->fetch_assoc()) {
    $currentItem = $row["itemname"];
    $date = date('F j, Y', strtotime($row["idate"]));
    $quantityAdded = $row["qty_added"];

    if ($currentItem != $previousItem) {
      $output .= "<tr><td rowspan='999'>" . $currentItem . "</td><td>" . $date . "</td><td>" . $quantityAdded . "</td></tr>";
    } else {
      $output .= "<tr><td>" . $date . "</td><td>" . $quantityAdded . "</td></tr>";
    }

    $previousItem = $currentItem;
  }

  echo $output;
} else {
  echo "<tr><td colspan='3' class='text-center'>No results</td></tr>";
}
?>