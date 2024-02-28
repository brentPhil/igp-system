<?php
session_start();
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Dashboard";
include 'include/config.php';
include 'include/water_consump.php';
include 'include/electric_consump.php';
include 'include/pending_stats.php';
include 'include/toptenfaculty.php';
include 'include/top_department.php';
include 'include/faculty.php';
if(!isset($_SESSION["user_type"]))
  header("location:login.php");
$result = mysqli_query($conn,"SELECT *, users.first_name AS fn, users.middle AS mn, users.last_name AS ln FROM users LEFT JOIN faculty ON users.faculty_id = faculty.id WHERE user_id='" . $_SESSION['user_id'] . "'");
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
  <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-dt/css/jquery.dataTables.css">
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
  <div class="container-fluid page-body-wrapper d-flex h-100">
    <?php include 'sidebar.php'; ?>
    <!-- partial -->
    <div class="main-panel h-100" style="overflow-y: auto">
      <div class="content-wrapper">
        <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Administrator" ): ?>
          <!-- Quick Action Toolbar Ends-->
          <div class="row">
            <div class="col-12 mb-3">
              <div class="row">
                <div class="col-4">
                  <div class="card">
                    <div class="card-body p-3">
                      <h4 class="card-title text-center">Water & Electricity Consumption per Month</h4>
                      <canvas id="elecBillChart"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card">
                    <div class="card-body p-3">
                      <h4 class="card-title text-center">Pending Payments</h4>
                      <div id="rickshaw-time-scale"></div>
                      <canvas id="pendingStatusChart"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card">
                    <div class="card-body p-3">
                      <h4 class="card-title text-center">Top Department</h4>
                      <canvas id="topDepartmentChart"></canvas>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="card">
                    <div class="card-body p-3">
                      <h4 class="card-title text-center">Top 10 Faculty</h4>
                      <canvas id="toptenFacultyChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <button id="toggleFacultyChartBtn" class="btn btn-primary btn-sm mt-2 mb-3" onclick="toggleFacultyChart()">Show More Chart</button>
            <div class="col-12 mb-3">
              <div id="facultyChartContainer" style="display: none;">
                  <div class="card">
                      <div class="card-body p-3">
                          <h4 class="card-title text-center">Top Faculty</h4>
                          <canvas id="topFacultyChartAdmin"></canvas>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-body p-3">
                  <h4 class="table-container">Financial Statements</h4>
                  <table id="myTable" class="table table-bordered">
                    <thead>
                    <tr>
                      <th> Stall No. </th>
                      <th> Total Bill </th>
                      <th> Payment </th>
                      <th>  </th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $result = mysqli_query($conn,"SELECT * FROM billing INNER JOIN stalls ON billing.billing_stall = stalls.stall_id");
                    while($row = mysqli_fetch_array($result)) {
                      $date_filed = $row['date_filed'];
                      $time = strtotime($date_filed);
                      $datefiled = date("M d, Y | g:i A", $time);
                      ?>
                      <tr>
                        <td><?php echo $row['stall_name']; ?></td>
                        <td><b>₱ <?php echo number_format($row['amount'], 2); ?></b></td>
                        <td>
                          <span class="text-light px-3 py-2 rounded-sm bg-<?php echo $row['status'] == 1 ? 'success' : 'secondary'?> " ><?php echo $row['status'] == 0 ? 'Pending' : 'Paid' ?></span>
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
        <?php endif; ?>
        <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Staff" ): ?>
          <!-- Quick Action Toolbar Ends-->
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title text-center">Pending Payments</h4>
                          <div id="rickshaw-time-scale"></div>
                          <canvas id="pendingStatusChart"></canvas>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card mb-3">
                        <div class="card-body p-3">
                          <h4 class="card-title text-center">Water & Electricity Consumption per Month</h4>
                          <canvas id="elecBillChart"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
        <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Concessionaires" ): ?>
          <!-- Quick Action Toolbar Ends-->
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="d-sm-flex align-items-baseline report-summary-header">
                        <h5 class="font-weight-semibold">Charts</h5>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card mb-3">
                        <div class="card-body p-3">
                          <h4 class="card-title text-center">Water & Electricity Consumption per Month</h4>
                          <canvas id="elecBillChart"></canvas>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
        <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Faculty" ): ?>
          <!-- Quick Action Toolbar Ends-->
          <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-sm-flex align-items-baseline report-summary-header">
                                    <h4 class="card-title text-center">Charts</h4>
                                </div>
                                <canvas id="topFacultyChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        <?php endif; ?>
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
<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
<script type="text/javascript" src="node_modules/datatables.net/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="node_modules/datatables.net-responsive/js/dataTables.responsive.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.6.2/randomColor.min.js"></script>
<script>
var facultyChartVisible = false;

function toggleFacultyChart() {
    var facultyChartContainer = document.getElementById('facultyChartContainer');

    facultyChartVisible = !facultyChartVisible;

    if (facultyChartVisible) {
        facultyChartContainer.style.display = 'block';
        document.getElementById('toggleFacultyChartBtn').innerText = 'Hide Chart';
    } else {
        facultyChartContainer.style.display = 'none';
        document.getElementById('toggleFacultyChartBtn').innerText = 'Show More Chart';
    }
}
</script>
<script type="text/javascript">
  $(document).ready(function () {
    new DataTable('#myTable', {
      order: [[2, 'dsc']],
      responsive: true,
      paging: false,
      scrollCollapse: true,
      scrollY: '300px'
    });
  });
</script>
<script>
  var ctx = document.getElementById('elecBillChart').getContext('2d');
  var chartData = <?php echo json_encode($chart_data); ?>;

  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: chartData.labels,
      datasets: [{
        label: 'Electricity Bill',
        data: chartData.data_elec,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      },
        {
          label: 'Water Bill',
          data: chartData.data_water,
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
    var topDepartmentData = <?php echo json_encode($topDepartmentData); ?>;

    var ctx = document.getElementById('topDepartmentChart').getContext('2d');

    if (topDepartmentData && topDepartmentData.labels.length > 0) {
        var topDepartmentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: topDepartmentData.labels,
                datasets: [{
                    label: 'Total Quantity',
                    data: topDepartmentData.data,
                    backgroundColor: topDepartmentData.data.map(() => 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 0.2)'),
                    borderColor: topDepartmentData.data.map(() => 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 1)'),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    } else {
        var emptyTopDepartmentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Total Quantity',
                    data: [],
                    backgroundColor: 'rgba(255, 255, 255, 0)',
                    borderColor: 'rgba(255, 255, 255, 0)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
<script>
  var data = <?php echo $data_json; ?>;

  var ctx = document.getElementById('pendingStatusChart').getContext('2d');

  var chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: data.months,
      datasets: [{
        label: 'Total Pending Status',
        data: data.totals,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      },
    }
  });
</script>
<script>
var ctx = document.getElementById('topFacultyChart').getContext('2d');

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($fullnames); ?>,
        datasets: [{
            label: 'Total Quantity',
            data: <?php echo json_encode($data); ?>,
            backgroundColor: Array.from({ length: <?php echo count($fullnames); ?> }, () => 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 0.2)'),
            borderColor: Array.from({ length: <?php echo count($fullnames); ?> }, () => 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 1)'),
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: {
                beginAtZero: true
            },
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<script>
var ctxs = document.getElementById('toptenFacultyChart').getContext('2d');

var myChart = new Chart(ctxs, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($fullnamesx); ?>,
        datasets: [{
            label: 'Total Quantity',
            data: <?php echo json_encode($datay); ?>,
            backgroundColor: Array.from({ length: <?php echo count($fullnamesx); ?> }, () => 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 0.2)'),
            borderColor: Array.from({ length: <?php echo count($fullnamesx); ?> }, () => 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 1)'),
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: {
                beginAtZero: true
            },
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<script>
var ctxd = document.getElementById('topFacultyChartAdmin').getContext('2d');

var myChart = new Chart(ctxd, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($fullnames); ?>,
        datasets: [{
            label: 'Total Quantity',
            data: <?php echo $quantityData; ?>,
            backgroundColor: Array.from({ length: <?php echo count($fullnames); ?> }, () => 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 0.2)'),
            borderColor: Array.from({ length: <?php echo count($fullnames); ?> }, () => 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 1)'),
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            x: {
                beginAtZero: true
            },
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<script src="js/delete.js"></script>
</body>
</html>
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
      $pending_balance = $row['amount'] - $row['amount_paid'];
      $insertQuery = "INSERT INTO reports (billing_stall, rent_bal, water_bal, electricity_bal, other_bal, amount, amount_paid, date_filed, date_pay, c_receipt) VALUES ('{$row['billing_stall']}', '{$row['rent_bal']}', '{$row['water_bal']}', '{$row['electricity_bal']}', '{$row['other_bal']}', '{$row['amount']}', '{$row['amount_paid']}', '{$row['date_filed']}', '{$row['date_pay']}', '{$row['c_receipt']}')";
      $insertResult = mysqli_query($conn, $insertQuery);
      $pendingQuery = "INSERT INTO pending (stall_id, amount) VALUES ('{$row['billing_stall']}', '$pending_balance')";
      $insertPending = mysqli_query($conn, $pendingQuery);
      if (!$insertResult && $insertPending) {
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