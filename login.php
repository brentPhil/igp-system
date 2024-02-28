<?php
session_start();
$title = "Login to IGP";
include 'include/config.php';
if(isset($_SESSION['username'])) {
  header("Location: index.php"); // redirects them to homepage
  exit; // for good measure
}
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
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/evsu_logo.png" />
  </head>
  <body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="images/evsu_logo.png" style="width: 60px;">
              </div>
              <h4>Income Generating Project</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputUsername" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password">
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="submit">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- sweetalert2 -->
  <script src="vendors/sweetalert2/sweetalert2.js"></script>
  </body>
  </html>
<?php
if(isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password = md5($password);

  $query = mysqli_query($conn, "SELECT * FROM users LEFT JOIN faculty ON users.faculty_id = faculty.id WHERE username='$username' AND password='$password' ");
  if(mysqli_num_rows($query) == 0)
  {
    ?>
    <script>
      Swal.fire({
        title: 'Error',
        text: 'Incorrect Credentials',
        icon: 'error',
        showConfirmButton: false,
        timer: 1500
      }).then(function() {
        window.location.href = "login.php";
      });
    </script>
    <?php
  } else {
    $row = mysqli_fetch_assoc($query);
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['middle'] = $_POST['middle'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['password'] = $row['password'];
    $_SESSION['user_type'] = $row['user_type'];
    $_SESSION['stall_id'] = $row['stall_id'];
    $_SESSION['faculty_id'] = $row['faculty_id'];
    ?>
    <script>
      Swal.fire({
        title: 'Success',
        text: 'Login Successfuly',
        icon: 'success',
        showConfirmButton: false,
        timer: 1500
      }).then(function() {
        window.location.href = "index.php";
      });
    </script>
    <?php
  }
}
?>