<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Stalls";
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
                    <h4 class="card-title">Stalls List <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addStall" style="float: right; margin-bottom: 10px;">Add Stall</a></h4>
                      <div class="table-responsive">
                        <?php
                        $result = mysqli_query($conn,"SELECT * FROM stalls ORDER BY stall_name ASC");
                        if ($result->num_rows > 0) {
                          echo "<table class='table table-bordered'><tr><th>Stall Name</th><th>Description</th><th>Action</th></tr>";
                          while($row = $result->fetch_assoc()) {
                              echo "<tr><td>".$row["stall_name"]."</td><td>".$row["stall_desc"]."</td><td><button class='deleteBtnStall btn btn-danger btn-sm' data-stall_id='{$row['stall_id']}'>Delete</button></td></tr>";
                          }
                          echo "</table>";
                          } else {
                              echo "0 results";
                          }
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

    <!-- Modal -->
    <div class="modal fade" id="addStall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Stall</h5>
                </div>
                <form action="" method="POST" id="stallAdd">
                  <div class="modal-body">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Stall Name</label>
                        <div class="col-sm-9">
                          <input type="text" name="stall_name" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                          <input type="text" name="stall_desc" class="form-control" />
                        </div>
                    </div>
                  </div>
                </form>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                  <button class="btn btn-success" name="s_submit" form="stallAdd" type="submit">Save changes</button>
                </div>
            </div>
        </div>
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
    <!-- End custom js for this page -->
    <script src="vendors/sweetalert2/sweetalert2.js"></script>
    <!-- End custom js for this page -->
    <script src="js/delete.js"></script>
  </body>
</html>
<?php
if(isset($_POST['s_submit'])){
  $stall_name = $_POST['stall_name'];
  $stall_desc = $_POST['stall_desc'];

  $query = "INSERT INTO stalls (stall_name, stall_desc) VALUES ('$stall_name', '$stall_desc')";
  $query2 = mysqli_query($conn, $query);
  if($query2){
    ?>
      <script>
        Swal.fire({
          title: 'Stall Saved',
          text: 'Data Inserted',
          icon: 'success',
        }).then(function() {
          window.location.href = "stalls.php";
        });
      </script>
<?php
  }
}
?>
<?php
if(isset($_POST['s_update'])){
  $stall_id = $_POST['stall_id'];
  $stall_name = $_POST['stall_name'];
  $stall_desc = $_POST['stall_desc'];

  $query = "UPDATE stalls SET stall_name = '$stall_name', stall_desc = '$stall_desc' WHERE stall_id = '$stall_id'";
  $query2 = mysqli_query($conn, $query);
  if($query2){
    ?>
      <script>
        Swal.fire({
          title: 'Stall Updated',
          text: 'Updated Successfully',
          icon: 'success',
        }).then(function() {
          window.location.href = "stalls.php";
        });
      </script>
<?php
  }
}
?>