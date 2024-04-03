<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Faculty List";
session_start();
include 'include/config.php';
if(!isset($_SESSION["user_type"]))
header("location:login.php");
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_SESSION['user_id'] . "'");
$row= mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link href="node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="images/evsu_logo.png" />
  </head>
  <style>
    .table-responsive {
      height: 300px; /* Adjust height as needed */
      overflow-y: auto;
    }
  </style>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include 'header.php';?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <?php include 'sidebar.php'; ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Quick Action Toolbar Ends-->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Faculty List
                      <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addFaculty" style="float: right; margin-bottom: 10px;"> Add Faculty</a></h4>
                    <div class="table-responsive">
                      <?php
                        $no = 1;
                        $result = mysqli_query($conn,"SELECT * FROM faculty");
                        if ($result->num_rows > 0) {
                          echo "<table class='table table-bordered'><tr><th>Name</th><th>Department</th><th>Employee Type</th><th>Updated</th><th>Action</th></tr>";
                          while($row = $result->fetch_assoc()) {
                              echo "<tr><td>".$row["first_name"].' '.$row['middle'].' '.$row['last_name']."</td>";
                              echo "<td>".$row['department']."</td>";
                              if ($row['emp_type'] == "regular"){
                              echo "<td>Regular</td>";
                              } else {
                              echo "<td>Part Time</td>";
                              }
                              echo "<td>".$row['datetime']."</td>";
                              echo "<td>
                              <button class='btn btn-success btn-sm' onclick='openUpdateModal(" . $row['id'] . ")'><i class='bi bi-pencil-square'></i></button>
                              <button class='btn btn-danger btn-sm' onclick='deleteFaculty(" . $row['id'] . ")'><i class='bi bi-trash3'></i></button>
                              </td>";
                              echo "</tr>";
                          }
                          echo "</table>";
                          } else {
                              echo "No results";
                          }
                          include 'include/updateFaculty.php';
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <div class="modal fade" id="addFaculty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Faculty</h5>
          </div>
          <form action="" method="POST" id="createaccount" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Given Name</label>
                <div class="col-sm-9">
                  <input type="text" id="first_name" name="first_name" class="form-control" required/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Middle Initial</label>
                <div class="col-sm-9">
                  <input type="text" id="middle" name="middle" class="form-control" maxlength="1"/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-9">
                  <input type="text" id="last_name" name="last_name" class="form-control" required/>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Employee Type</label>
                <div class="col-sm-9">
                  <select class="form-control" name="emp_type" required>
                    <option value="regular">Regular</option>
                    <option value="part-time">Part Time</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Department</label>
                <div class="col-sm-9">
                  <select class="form-control" name="department" required>
                    <option selected disabled>Select Department</option>
                    <option value="BEM">BEM</option>
                    <option value="Technology">Technology</option>
                    <option value="Education">Education</option>
                    <option value="Engineering">Engineering</option>
                  </select>
                </div>
              </div>
            </div>
          </form>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            <button class="btn btn-success" name="save_user" form="createaccount" type="submit">Save User</button>
          </div>
        </div>
      </div>
    </div>

    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/moment/moment.min.js"></script>
    <script src="vendors/daterangepicker/daterangepicker.js"></script>
    <script src="vendors/chartist/chartist.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/dashboard.js"></script>
    <script src="vendors/sweetalert2/sweetalert2.js"></script>
    <!-- End custom js for this page -->
    <!-- Delete -->
    <script src="js/delete.js"></script>
    <script>
      function validate(evt) {
        var theEvent = evt || window.event;

        // Handle paste
        if (theEvent.type === 'paste') {
            key = event.clipboardData.getData('text/plain');
        } else {
        // Handle key press
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
        }
        var regex = /[0-9]|\./;
        if( !regex.test(key) ) {
          theEvent.returnValue = false;
          if(theEvent.preventDefault) theEvent.preventDefault();
        }
      }
    </script>
    <script>
      function openUpdateModal(id) {
        $.ajax({
          type: 'POST',
          url: 'include/get_faculty_details.php',
          data: { id: id },
          success: function(response) {
            $('#updateFacultyModal .modal-body').html(response);
            $('#updateFacultyModal').modal('show');
          }
        });
      }
    </script>
    <script>
      function deleteFaculty(id) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You won\'t be able to revert this!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: 'POST',
              url: 'include/delete_faculty.php',
              data: { id: id },
              success: function(response) {
                if (response == 'success') {
                  Swal.fire({
                    title: 'Deleted!',
                    text: 'Faculty has been deleted.',
                    icon: 'success'
                  }).then(function() {
                    window.location.reload();
                  });
                } else {
                  Swal.fire({
                    title: 'Error!',
                    text: 'Failed to delete faculty.',
                    icon: 'error'
                  });
                }
              }
            });
          }
        });
      }
    </script>
  </body>
</html>
<?php
if(isset($_POST['save_user'])){
  $first_name = $_POST['first_name'];
  $middle = $_POST['middle'];
  $last_name = $_POST['last_name'];
  $emp_type = $_POST['emp_type'];
  $department = $_POST['department'];

  $query = "INSERT INTO faculty (first_name, middle, last_name, department, emp_type) VALUES ('$first_name', '$middle', '$last_name', '$department', '$emp_type')";
  $query2 = mysqli_query($conn, $query);

  if($query2){
    ?>
    <script>
      Swal.fire({
        title: 'Added Successfully',
        text: 'Profile Updated',
        icon: 'success'
      }).then(function() {
        window.location.href = "";
      });
    </script>
    <?php
  } else {
    ?>
    <script>
      Swal.fire({
        title: 'Failed to Add User',
        text: 'Profile Not Saved',
        icon: 'error'
      }).then(function() {
        window.location.href = "";
      });
    </script>
    <?php
  }
}
?>
<?php
if (isset($_POST['update_user'])) {
  // Retrieve form data
  $faculty_id = $_POST['id'];
  $first_name = $_POST['first_name'];
  $middle = $_POST['middle'];
  $last_name = $_POST['last_name'];
  $emp_type = $_POST['emp_type'];
  $department = $_POST['department'];

  // Perform the update
  $query = "UPDATE faculty SET first_name = '$first_name', middle = '$middle', last_name = '$last_name', department = '$department', emp_type = '$emp_type' WHERE id = '$faculty_id'";
  $query2 = mysqli_query($conn, $query);

  if ($query2) {
    ?>
    <script>
      Swal.fire({
        title: 'Faculty Updated',
        text: 'Updated Successfully',
        icon: 'success'
      }).then(function() {
        window.location.href = "";
      });
    </script>
    <?php
  } else {
    ?>
    <script>
      Swal.fire({
        title: 'Failed to Update Faculty',
        text: 'Profile Not Updated',
        icon: 'error'
      }).then(function() {
        window.location.href = "";
      });
    </script>
    <?php
  }
}
?>
<?php
if(isset($_POST['update'])){

  $user_id = $_POST['user_id'];
  $first_name = $_POST['first_name'];
  $middle = $_POST['middle'];
  $last_name = $_POST['last_name'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password = md5($password);
  $phone = $_POST['phone'];

$query = "UPDATE users SET first_name = $first_name',middle = '$middle',last_name = '$last_name', username = '$username', phone = '$phone', password = '$password' WHERE user_id = '$user_id'";
$query2 = mysqli_query($conn, $query);
?>
<script>
    Swal.fire({
    title: 'Updated Successfully',
    text: 'Profile Updated',
    icon: 'success'
    }).then(function() {
      window.location.href = "";
    });
</script>
<?php
}
?>