<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "User Profile";
session_start();
include 'include/config.php';
if(!isset($_SESSION["user_type"]))
  header("location:login.php");
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_SESSION['user_id'] . "'");
$row= mysqli_fetch_array($result);
$row = $row;
$rows = $row;
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
            <div class="col-12 grid-margin">
              <form action="" method="POST">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Personal Info</h4>
                    <form class="form-sample">
                      <input type="hidden" name="user_id" value="<?php echo $rows['user_id'];?>">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Full Name</label>
                            <div class="col-sm-9">
                              <input type="text" id="first_name" name="first_name" value="<?php echo $rows['first_name']; ?>" class="form-control" required/>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Middle Initial</label>
                            <div class="col-sm-9">
                              <input type="text" id="middle" name="middle" value="<?php echo $rows['middle']; ?>" class="form-control" maxlength="1"/>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-9">
                              <input type="text" id="last_name" name="last_name" value="<?php echo $rows['last_name']; ?>" class="form-control" required/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="username" value="<?php echo $rows['username']; ?>"/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">User Type</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" value="<?php echo $rows['user_type']; ?>" disabled/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                              <input type="password" class="form-control" name="password" placeholder="dont leave it blank when saving" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Phone</label>
                            <div class="col-sm-9">
                              <input type="number" class="form-control" name="phone" value="<?php echo $rows['phone']; ?>" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-success" name="update_profile" style="float:right;">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </form>
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
  </body>
  </html>
<?php
if(isset($_POST['update_profile'])){

  $user_id = $_POST['user_id'];
  $first_name = $_POST['first_name'];
  $middle = $_POST['middle'];
  $last_name = $_POST['last_name'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password = md5($password);
  $phone = $_POST['phone'];

  $query = "UPDATE users SET first_name = '$first_name', middle = '$middle', last_name = '$last_name', username = '$username', password = '$password', phone = '$phone' WHERE user_id = '$user_id'";
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