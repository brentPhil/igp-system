<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Reports";
session_start();
include 'include/config.php';
if(!isset($_SESSION["user_type"]))
    header("location:login.php");
$result = mysqli_query($conn,"SELECT *, users.first_name AS fn, users.middle AS mn, users.last_name AS ln FROM users INNER JOIN tenant LEFT JOIN faculty ON users.faculty_id = faculty.id WHERE user_id='" . $_SESSION['user_id'] . "'");
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
        <link rel="stylesheet" type="text/css" href="node_modules/datatables.net-dt/css/jquery.dataTables.css">
        <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
        <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
        <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .table-container {
            max-height: 400px; /* Set the maximum height for the scrollbar */
            overflow-y: auto; /* Enable vertical scrollbar */
            overflow-x: hidden; /* Hide horizontal scrollbar */
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
                                    <div class="card-body table-container">
                                        <h4 class="card-title">Billing</h4>
                                        <div style="height: 400px; overflow-y: scroll;">
                                            <table id="myTable" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th> Stall </th>
                                                    <th> Total Bill </th>
                                                    <th> Date Filed </th>
                                                    <th> Due Date </th>
                                                    <th> Days Left </th>
                                                    <th> Status </th>
                                                    <th> Action </th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php
                                                $no = 1;
                                                $user_id = $_SESSION['user_id']; // Example: Get user_id from the request
                                                $sql = "SELECT stall_id FROM users WHERE user_id = $user_id";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    // User found, fetch their stall_id
                                                    $row = $result->fetch_assoc();
                                                    $stall_id = $row["stall_id"];

                                                    $sql = "SELECT stalls.stall_name, billing_id, billing_stall, rent_bal, water_bal, electricity_bal, other_bal, amount, date_filed, billing_note, status, c_receipt FROM billing INNER JOIN stalls ON billing.billing_stall = stalls.stall_id WHERE billing_stall = $stall_id";
                                                    $billingResult = $conn->query($sql);

                                                    if ($billingResult !== false && $billingResult->num_rows > 0) {
                                                        // Billing information found, display or process the data as needed
                                                        while ($row = $billingResult->fetch_assoc()) {
                                                            $date_filed = $row['date_filed'];
                                                            $time = strtotime($date_filed);
                                                            $datefiled = date("M. 20 Y | g:i A", $time);
                                                            $dueDate = date('M. 20 Y', strtotime($date_filed));
                                                            $daysLeft = ceil((strtotime($dueDate) - strtotime(date('Y-m-d'))) / 86400);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $row['stall_name']; ?></td>
                                                                <td><b>₱ <?php echo number_format($row['amount'], 2); ?></b></td>
                                                                <td><?php echo $datefiled; ?></td>
                                                                <td><?php echo $dueDate; ?></td>
                                                                <td><?php echo $daysLeft; ?></td>
                                                                <td>
                                                                    <span class="text-light px-3 py-2 rounded-sm bg-<?php echo $row['status'] == 1 ? 'success' : 'secondary'?> " ><?php echo $row['status'] == 0 ? 'Pending' : 'Paid' ?></span>
                                                                </td>
                                                                <?php if ($row['status'] == 0): ?>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm mr-1" data-bs-toggle='tooltip' data-bs-placement='top' title='view payment details' data-toggle="modal" data-target="#balance<?php echo ($row["billing_id"]); ?>">
                                                                            <i class='bi bi-eye fs-5'></i>
                                                                        </button>

                                                                        <button class="btn btn-<?php echo empty($row['c_receipt']) ? 'primary' : 'dark' ?> btn-sm fs-5" data-bs-toggle='tooltip' data-bs-placement='top' title='<?php echo empty($row['c_receipt']) ? 'Setup payment' : 'waiting for confirmation' ?>' data-toggle="modal" data-target="#uploadReceipt<?php echo $row['billing_id']; ?>">
                                                                        <?php echo empty($row['c_receipt']) ? 'Pay' : 'Waiting for confirmation...' ?>
                                                                        </button>
                                                                    </td>
                                                                <?php elseif ($row['status'] == 1): ?>
                                                                    <td>
                                                                        <a class="btn btn-success btn-sm">Paid</a></td>
                                                                <?php endif; ?>
                                                            </tr>
                                                            <?php
                                                            include 'include/balance.php';
                                                            include 'include/uploadReceipt.php';
                                                            include 'include/awaitConfirm.php';
                                                        }
                                                    } else {
                                                        echo "<td colspan='7' class='text-center'>No billing information found for the user's stall.</td>";
                                                    }
                                                } else {
                                                    echo "User not found.";
                                                }
                                                ?>
                                                <?php
                                                $no++;
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between"><
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
        <!-- End custom js for this page -->
        <script src="vendors/sweetalert2/sweetalert2.js"></script>
        <script type="text/javascript" src="node_modules/datatables.net/js/jquery.dataTables.js"></script>

        <script type="text/javascript" src="node_modules/datatables.net-responsive/js/dataTables.responsive.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                new DataTable('#myTable', {
                    order: [[2, 'dsc']],
                    responsive: true
                });
            });
        </script>
    </body>
    </html>
<?php
if (isset($_POST['submit'])) {
    // Handle file upload
    if (!empty($_FILES['c_receipt']['name'])) {
        $targetDir = "receipts/";
        $originalFileName = basename($_FILES['c_receipt']['name']);

        // Extract file extension
        $fileType = pathinfo($originalFileName, PATHINFO_EXTENSION);

        // Get stall name and format the current date
        $currentDate = date("mdYHi");

        // Construct new filename using stall name and current date
        $fileName = $currentDate . '.' . $fileType;

        $targetFilePath = $targetDir . $fileName;

        // Check file type (you can add more file type validations here)
        if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($_FILES['c_receipt']['tmp_name'], $targetFilePath)) {
                // File uploaded successfully
                $billing_id = $_POST['billing_id'];
                $amount_paid = $_POST['amount_paid'];

                $sql = "UPDATE billing SET c_receipt = '$fileName', amount_paid = '$amount_paid' WHERE billing_id = '$billing_id'";
                if (mysqli_query($conn, $sql)) {
                    ?>
                    <script>
                        Swal.fire({
                            title: 'Receipt Inserted Successfully',
                            text: 'Receipt Updated',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = "billing.php";
                        });
                    </script>
                    <?php
                } else {
                    ?>
                    <script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Receipt Not Updated',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = "billing.php";
                        });
                    </script>
                    <?php
                }

                mysqli_close($conn);
            } else {
                ?>
                <script>
                    Swal.fire({
                        title: 'Receipt Not Saved',
                        text: 'Error Uploading the File',
                        icon: 'error'
                    }).then(function() {
                        window.location.href = "billing.php";
                    });
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    title: 'Invalid file format.',
                    text: 'Only JPG, JPEG, and PNG files are allowed.',
                    icon: 'warning'
                }).then(function() {
                    window.location.href = "billing.php";
                });
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            Swal.fire({
                title: 'Receipt Not Saved',
                text: 'Please Select a File',
                icon: 'error'
            }).then(function() {
                window.location.href = "billing.php";
            });
        </script>
        <?php
    }
}
?>