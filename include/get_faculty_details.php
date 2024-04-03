<?php
include 'config.php';

if (isset($_POST['id'])) {
  $faculty_id = $_POST['id'];

  // Fetch faculty details
  $result = mysqli_query($conn, "SELECT * FROM faculty WHERE id = $faculty_id");

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Populate the update modal form fields with existing faculty details
    echo "<div class='form-group row'>
            <label class='col-sm-3 col-form-label'>Given Name</label>
            <div class='col-sm-9'>
              <input type='hidden' id='id' name='id' class='form-control' value='" . $faculty_id . "'/>
              <input type='text' id='first_name' name='first_name' class='form-control' value='" . $row['first_name'] . "' required/>
            </div>
          </div>
          <div class='form-group row'>
            <label class='col-sm-3 col-form-label'>Middle</label>
            <div class='col-sm-9'>
              <input type='text' id='middle' name='middle' class='form-control' value='" . $row['middle'] . "' required/>
            </div>
          </div>
          <div class='form-group row'>
            <label class='col-sm-3 col-form-label'>Last Name</label>
            <div class='col-sm-9'>
              <input type='text' id='last_name' name='last_name' class='form-control' value='" . $row['last_name'] . "' required/>
            </div>
          </div>
          <div class='form-group row'>
            <label class='col-sm-3 col-form-label'>Employee Type</label>
            <div class='col-sm-9'>
              <select class='form-control' name='emp_type' required>";
              $emp_types = ['regular', 'part-time'];
              foreach ($emp_types as $emp_type) {
                $selected = ($row['emp_type'] == $emp_type) ? 'selected' : '';
                echo "<option value='$emp_type' $selected>$emp_type</option>";
              }
          echo "</select>
            </div>
          </div>
          <div class='form-group row'>
            <label class='col-sm-3 col-form-label'>Department</label>
            <div class='col-sm-9'>
              <select class='form-control' name='department' required>";
              $departments = ['BEM', 'Technology', 'Education', 'Engineering'];
              foreach ($departments as $department) {
                $selected = ($row['department'] == $department) ? 'selected' : '';
                echo "<option value='$department' $selected>$department</option>";
              }
          echo "</select>
            </div>
          </div>";
  } else {
    echo "Error: Faculty not found";
  }
} else {
  echo "Error: Invalid request";
}
?>
