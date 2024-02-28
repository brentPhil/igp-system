<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Reports";
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
                    <h4 class="card-title">Reports</h4>
                    <div class="table-responsive">
                        <?php
                        $previousBalances = array();

                        $result = mysqli_query($conn, "SELECT * FROM reports INNER JOIN stalls ON reports.billing_stall = stalls.stall_id ORDER BY reports.date_pay ASC");

                        if ($result->num_rows > 0) {
                            echo "<table class='table table-bordered'><tr><th>Stall Name</th><th>Total Amount</th><th>Amount Paid</th><th>Balance</th><th>Date Paid</th><th>Approved</th><th>Report</th></tr>";

                            while ($row = $result->fetch_assoc()) {
                                $amount = (float)$row['amount'];
                                $amountPaid = (float)$row['amount_paid'];
                                $remainingAmount = $amount - $amountPaid;

                                $stallId = $row['stall_id'];
                                $previousBalance = isset($previousBalances[$stallId]) ? $previousBalances[$stallId] : 0;

                                $remainingAmount += $previousBalance;

                                $dateApproved = date('F d, Y h:i A', strtotime($row['date_approved']));

                                echo "<tr><td>" . $row["stall_name"] . "</td>";
                                echo "<td>₱ " . number_format($amount, 2) . "</td><td>₱ " . number_format($amountPaid, 2) . "</td>";

                                if ($remainingAmount == 0) {
                                    echo "<td><b>Fully Paid</b></td>";
                                } else {
                                    echo "<td>₱ " . number_format($remainingAmount, 2) . "</td>";
                                }

                                echo "<td>" . $row['date_pay'] . "</td>";
                                echo "<td>" . $dateApproved . "</td>";
                                echo "<td><button class='btn btn-success btn-sm' title='Click to view the bill of {$row['stall_name']}' onclick='generatePDF({$row['id']})'><i class='bi bi-printer'></i></button> <a class='btn btn-danger btn-sm deleteBtnReport' data-id='{$row['id']}'><i class='bi bi-trash3'></i></a>";
                                echo "</tr>";

                                // Update previous balance for the next iteration
                                $previousBalances[$stallId] = $remainingAmount;
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
      function generatePDF(id) {
        var pdfUrl = 'generate_report.php?id=' + id;
        window.open(pdfUrl, '_blank');
      }
    </script>
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