<?php
include 'include/config.php';

$no = 1;
$result = mysqli_query($conn, "SELECT * FROM projects ORDER BY name ASC");

if ($result->num_rows > 0) {
  $output = "<tr><th>Name</th><th>Total Collection</th><th>Action</th></tr>";
  while ($row = $result->fetch_assoc()) {
    $totalValue = $row["total"] !== null ? $row["total"] : "Empty";

    $output .= "<tr><td>".$no.". " . $row["name"] . "</td><td>" . $totalValue . "</td>
                <td><a class='btn btn-primary btn-sm' href='items.php?getid=".$row['id']."'><i class='bi bi-eye'></i></a>
                <button class='btn btn-danger btn-sm deleteBtn' data-id='".$row["id"]."'><i class='bi bi-trash3'></i></button></td></tr>";
    $no++;
  }
  echo $output;
} else {
  echo "<tr><td colspan='2' class='text-center'>No results</td></tr>";
}
?>