<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Reports";
session_start();
include 'include/config.php';
if(!isset($_SESSION["user_type"]))
  header("location:login.php");
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_SESSION['user_id'] . "'");
$row= mysqli_fetch_array($result);
$query = "SELECT * FROM stalls ORDER BY stall_name ASC";
$stallx = $conn->query($query);
?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title; ?></title>
    <!-- plugins:css -->
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-dt/css/jquery.dataTables.css">
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
  <div class="container-scroller d-flex flex-column" style=" height: 100vh">
    <!-- partial:partials/_navbar.html -->
    <?php include 'header.php';?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <?php include 'sidebar.php'; ?>
      <!-- partial -->
      <div class="main-panel h-100" style="overflow-y: auto">
        <div class="content-wrapper">
          <!-- Quick Action Toolbar Ends-->
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="table-container">Billing <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#upload" style="float: right; margin-bottom: 10px;"> Add Bill</a></h4>
                  <table id="myTable" class="table table-bordered">
                    <thead>
                    <tr>
                      <th> Stall No. </th>
                      <th> Total Bill </th>
                      <th> Date Filed </th>
                      <th> Payment </th>
                      <th> Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $result = mysqli_query($conn,"SELECT * FROM billing INNER JOIN stalls ON billing.billing_stall = stalls.stall_id");
                    while($row = mysqli_fetch_array($result)) {
                      $date_filed = $row['date_filed'];
                      $time = strtotime($date_filed);
                      $datefiled = date("M d, Y | g:i A", $time);
                       $fullyPaid = $row['status'] === '1' && $row['amount'] != $row['amount_paid'];
                      $bgColor = $row['status'] === '1' ? ($fullyPaid ? 'primary' : 'success') : 'secondary';
                      ?>
                      <tr>
                        <td><?php echo $row['stall_name']; ?></td>
                        <td><b>₱ <?php echo number_format($row['amount'], 2); ?></b></td>
                        <td><?php echo $datefiled; ?></td>
                        <td>
                          <span class="text-light px-3 py-2 rounded-sm bg-<?php echo $bgColor; ?>"><?php echo $row['status'] == 0 ? 'Pending' : 'Paid'; ?></span>
                        </td>
                        <td class="d-flex justify-content-end">
                          <button class="btn btn-primary btn-sm mr-2" data-bs-toggle='tooltip' data-bs-placement='top' title='view receipt' data-toggle="modal" data-target="#c_receipt<?php echo ($row["billing_id"]); ?>">
                            <i class="bi bi-receipt"></i>
                            <?php if(!empty($row['c_receipt']) && $row['status'] == 0): ?>
                              <span class="badge badge-danger">1</span>
                            <?php endif; ?>
                          </button>
                          <button class="btn btn-warning btn-sm mr-2" data-bs-toggle='tooltip' data-bs-placement='top' title='view payment details' data-toggle="modal" data-target="#balance<?php echo ($row["billing_id"]); ?>">
                            <i class='bi bi-eye'></i>
                          </button>
                          <button class='deleteBtnBill btn btn-danger btn-sm' data-bs-toggle='tooltip' data-bs-placement='top' title='Remove bill' data-billing_id='<?php echo $row['billing_id'] ?>'><i class="bi bi-trash3"></i></button>
                        </td>
                      </tr>
                      <?php
                      include 'include/c_receipt.php';
                      include 'include/balance.php';
                    }
                    ?>
                    </tbody>
                  </table>
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
  <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="Billing Form" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="" method="POST" id="billing">
          <div class="modal-body">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Stall Name</label>
              <div class="col-sm-9">
                <select class="form-control" name="billing_stall" required>
                  <option disabled selected>Select Stall</option>
                  <?php while ($stall = $stallx->fetch_assoc()): ?>
                    <option value="<?php echo $stall['stall_id']; ?>"><?php echo $stall['stall_name']; ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Monthly Rent</label>
              <div class="col-sm-9">
                <div class="input-group mb-3">
                  <span class="input-group-text border-0">₱</span>
                  <input type="number" class="form-control" name="rent_bal" id="rent" aria-label="Amount (to the nearest dollar)" required>
                  <span class="input-group-text border-0">.00</span>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Water Bill</label>
              <div class="col-sm-9">
                <div class="input-group mb-3">
                  <span class="input-group-text border-0">₱</span>
                  <input type="number" class="form-control" name="water_bal" id="water" aria-label="Amount (to the nearest dollar)" required>
                  <span class="input-group-text border-0">.00</span>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="electricity" class="col-sm-3 col-form-label">Electricity Bill</label>
              <div class="col-sm-9">
                <div class="input-group mb-3">
                  <span class="input-group-text border-0">₱</span>
                  <input type="number" class="form-control" name="electricity_bal" id="electricity" aria-label="Amount (to the nearest dollar)" required>
                  <span class="input-group-text border-0">.00</span>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="other" class="col-sm-3 col-form-label">Other Bill</label>
              <div class="col-sm-9">
                <div class="input-group mb-3">
                  <span class="input-group-text border-0">₱</span>
                  <input type="number" class="form-control" name="other_bal" id="other" aria-label="Amount (to the nearest dollar)" required>
                  <span class="input-group-text border-0">.00</span>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="total" class="col-sm-3 col-form-label">Total Bill</label>
              <div class="col-sm-9">
                <div class="input-group mb-3">
                  <span class="input-group-text border-0">₱</span>
                  <input type="number" class="form-control" readonly name="amount" id="total" aria-label="Amount (to the nearest dollar)">
                  <span class="input-group-text border-0">.00</span>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="floatingTextarea2" class="col-sm-3 col-form-label">Note</label>
              <div class="col-sm-9">
                <textarea class="form-control" name="billing_note" placeholder="Leave a note here" id="floatingTextarea2" style="height: 100px"></textarea>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
          <button class="btn btn-success" name="save_bill" form="billing" type="submit">Save</button>
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
  <script type="text/javascript" src="node_modules/datatables.net/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="node_modules/datatables.net-responsive/js/dataTables.responsive.js"></script>
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
  <!-- End custom js for this page -->
  <script src="vendors/sweetalert2/sweetalert2.js"></script>
  <!-- Delete -->
  <script src="js/delete.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      new DataTable('#myTable', {
        order: [[2, 'dsc']],
        responsive: true,
        paging: false,
        scrollCollapse: true,
        scrollY: '56vh'
      });
    });
  </script>

  <script>
    function calculateTotal() {
      const waterValue = parseFloat(document.getElementById('water').value) || 0;
      const electricityValue = parseFloat(document.getElementById('electricity').value) || 0;
      const otherValue = parseFloat(document.getElementById('other').value) || 0;
      const rent = parseFloat(document.getElementById('rent').value) || 0;

      document.getElementById('total').value = waterValue + electricityValue + otherValue + rent;
    }

    document.getElementById('rent').addEventListener('input', calculateTotal);
    document.getElementById('water').addEventListener('input', calculateTotal);
    document.getElementById('electricity').addEventListener('input', calculateTotal);
    document.getElementById('other').addEventListener('input', calculateTotal);
  </script>
  <!-- Basic math -->
  </body>
  </html>
<?php
if(isset($_POST['save_bill'])){
  $billing_stall = $_POST['billing_stall'];
  $rent_bal = isset($_POST['rent_bal']) ? $_POST['rent_bal'] : 0;
  $water_bal = isset($_POST['water_bal']) ? $_POST['water_bal'] : 0;
  $electricity_bal = isset($_POST['electricity_bal']) ? $_POST['electricity_bal'] : 0;
  $other_bal = isset($_POST['other_bal']) ? $_POST['other_bal'] : 0;
  $amount = $_POST['amount'];
  $billing_note = $_POST['billing_note'];

  $query = "INSERT INTO billing (billing_stall, rent_bal, water_bal, electricity_bal, other_bal, amount, billing_note, status) VALUES ('$billing_stall', '$rent_bal', '$water_bal', '$electricity_bal', '$other_bal', '$amount', '$billing_note', 0)";
  $query2 = mysqli_query($conn, $query);
  if($query2){
    ?>
    <script>
      Swal.fire({
        title: 'success',
        text: 'Data Inserted',
        icon: 'success',
        showConfirmButton: false,
        timer: 1500
      }).then(function() {
        window.location.href = "billingevsu.php";
      });
    </script>
    <?php
  }
}
?>
<?php
if (isset($_POST['pay'])) {
  $billing_id = mysqli_real_escape_string($conn, $_POST['billing_id']);

  $updateSql = "UPDATE billing SET status = 1, date_pay = NOW() WHERE billing_id='$billing_id'";
  $updateResult = mysqli_query($conn, $updateSql);

  if ($updateResult) {
    echo "<script>
                Swal.fire({
                  title: 'Payment Approved',
                  text: 'Bill Updated',
                  icon: 'success'
                }).then(function() {
                  window.location.href = '';
                });
              </script>";
  } else {
    echo "<script>
                Swal.fire({
                  title: 'Payment Failed',
                  text: 'Bill Not Updated',
                  icon: 'error'
                }).then(function() {
                  window.location.href = '';
                });
           </script>";
  }

  $selectQuery = "SELECT * FROM billing WHERE billing_id = '$billing_id'";
  $selectResult = mysqli_query($conn, $selectQuery);

  if ($selectResult) {
    $row = mysqli_fetch_assoc($selectResult);
    if ($row) {
      $insertQuery = "INSERT INTO reports (billing_stall, rent_bal, water_bal, electricity_bal, other_bal, amount, amount_paid, date_filed, date_pay, c_receipt) VALUES ('{$row['billing_stall']}', '{$row['rent_bal']}', '{$row['water_bal']}', '{$row['electricity_bal']}', '{$row['other_bal']}', '{$row['amount']}', '{$row['amount_paid']}', '{$row['date_filed']}', '{$row['date_pay']}', '{$row['c_receipt']}')";
      $insertResult = mysqli_query($conn, $insertQuery);
      if (!$insertResult) {
        echo "Error inserting data into reports table: " . mysqli_error($conn);
      }
    } else {
      echo "No valid row found in the source table with ID: $billing_id";
    }
  } else {
    echo "Error fetching row from source table: " . mysqli_error($conn);
  }
}
?>