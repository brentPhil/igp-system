<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Logs";
session_start();
include 'include/config.php';
if(!isset($_SESSION["user_type"]))
header("location:login.php");
$result = mysqli_query($conn,"SELECT * FROM users LEFT JOIN faculty ON users.faculty_id = faculty.id WHERE user_id='" . $_SESSION['user_id'] . "'");
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
          <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Administrator"): ?>
          <div class="content-wrapper">
            <!-- Quick Action Toolbar Ends-->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Logs</h4>
                    <div class="table-responsive">
                      <?php
                        $no = 1;
                        $result = mysqli_query($conn,"SELECT * FROM logs LEFT JOIN faculty ON logs.userid = faculty.id");
                        if ($result->num_rows > 0) {
                          echo "<table class='table table-bordered'><tr><th>Log</th><th>Updated</th><th>User</th></tr>";
                          while($row = $result->fetch_assoc()) {
                              echo "<tr><td>".$row["log"].' '.$row['quantity']."</td>";
                              echo "<td>".$row['updated']."</td>";
                              echo "<td>".$row["first_name"] .' '. $row["middle"] .' '. $row["last_name"]."</td>";
                              echo "</tr>";
                          }
                          echo "</table>";
                          } else {
                              echo "No results";
                          }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Staff"): ?>
          <div class="content-wrapper">
            <!-- Quick Action Toolbar Ends-->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Logs</h4>
                    <div class="table-responsive">
                      <?php
                        $no = 1;
                        $result = mysqli_query($conn,"SELECT * FROM logs INNER JOIN users ON logs.userid = users.user_id");
                        if ($result->num_rows > 0) {
                          echo "<table class='table table-bordered'><tr><th>Log</th><th>Updated</th><th>User</th></tr>";
                          while($row = $result->fetch_assoc()) {
                              echo "<tr><td>".$row["log"].' '.$row['quantity']."</td>";
                              echo "<td>".$row['updated']."</td>";
                              echo "<td>".$row["first_name"] .' '. $row["middle"] .' '. $row["last_name"]."</td>";
                              echo "</tr>";
                          }
                          echo "</table>";
                          } else {
                              echo "No results";
                          }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Faculty" ): ?>
          <div class="content-wrapper">
            <!-- Quick Action Toolbar Ends-->
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Logs</h4>
                    <div class="table-responsive">
                      <?php
                        $no = 1;
                        $user = $_SESSION['faculty_id'];
                        $result = mysqli_query($conn,"SELECT * FROM logs INNER JOIN faculty ON logs.userid = faculty.id WHERE userid = $user");
                        if ($result->num_rows > 0) {
                          echo "<table class='table table-bordered'><tr><th>Log</th><th>Updated</th><th>User</th></tr>";
                          while($row = $result->fetch_assoc()) {
                              echo "<tr><td>".$row["log"].' '.$row['quantity']."</td>";
                              echo "<td>".$row['updated']."</td>";
                              echo "<td>".$row['first_name']. ' ' .$row['middle']. ' ' .$row['last_name']."</td>";
                              echo "</tr>";
                          }
                          echo "</table>";
                          } else {
                              echo "No results";
                          }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
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