<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Project";
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
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link href="node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                    <h4 class="card-title">Projects
                      <button class="btn btn-primary btn-sm" id="addProjectButton" style="float: right; margin-bottom: 10px;"> Add Project</button>
                    </h4>
                    <div class="table-responsive">
                      <table id="projects" class="table table-bordered">
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                    <br>
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

    <!-- Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
          </div>
          <form action="include/add_project.php" method="POST" id="addprojectForm">
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" oninput="this.value = this.value.toUpperCase()" id="name" name="name" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success" id="addprojectForm">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- jquery:js -->
    <script src="js/jquery-3.6.0.min.js"></script>
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
    <script src="js/script.js"></script>
  </body>
</html>
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

$query = "UPDATE users SET first_name = '$first_name',middle = '$middle',last_name = '$last_name', username = '$username', phone = '$phone', password = '$password' WHERE user_id = '$user_id'";
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