<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Tenants";
session_start();
include 'include/config.php';
if(!isset($_SESSION["user_type"]))
    header("location:login.php");
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_SESSION['user_id'] . "'");
$row= mysqli_fetch_array($result);
$queryx = "SELECT * FROM stalls ORDER BY stall_name ASC";
$stallx = $conn->query($queryx);
$query = "SELECT * FROM users WHERE user_type='Concessionaires'";
$users = $conn->query($query);
$queryx = "SELECT * FROM users WHERE user_type='Concessionaires' AND stall_id IS NULL";
$userx = $conn->query($queryx);
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
                                    <h4 class="card-title">Tenants List </h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <?php
                                            function getTenants($conn) {
                                                return mysqli_query($conn, "SELECT tenant.tenant_id AS tid, stalls.stall_id as sid, users.first_name, users.middle, users.last_name, stalls.stall_name, tenant.date_assigned, tenant.user, tenant.user AS tuser FROM tenant INNER JOIN users ON tenant.user = users.user_id INNER JOIN stalls ON tenant.stall_id = stalls.stall_id ORDER BY stall_name ASC");
                                            }

                                            $tenantResult = getTenants($conn);

                                            if ($tenantResult->num_rows > 0) {
                                                $currentStall = null;

                                                while ($row = $tenantResult->fetch_assoc()) {
                                                    $sid = $row['sid'];
                                                    $user = $row["first_name"] . ' ' . $row["middle"] . ' ' . $row["last_name"];
                                                    $stallId = $row["stall_name"];
                                                    $das = $row['date_assigned'];

                                                    // Check if stall number has changed
                                                    if ($stallId != $currentStall) {
                                                        echo "<th class='text-center'>$stallId</th>";
                                                        echo "<th class='text-center'>Tenants</th>";
                                                        echo "<th class='text-center'>Date Assigned</th>";
                                                        echo "<th class='text-center'>Requirements</th>";
                                                        echo "<th class='text-center'>Stall/Assignment</th>";
                                                        echo "<th class='text-center'>Remarks/Complaints</th>";
                                                        $currentStall = $stallId;
                                                    }

                                                    // Display tenant information for the respective stall
                                                    echo "<tr>";
                                                    echo "<td class='text-center'></td>";
                                                    echo "<td class='text-center'>$user<br></td>";
                                                    echo "<td class='text-center'>$das<br></td>";
                                                    echo "<td class='text-center'><button class='btn btn-primary btn-sm' data-bs-toggle='tooltip' data-bs-placement='top' title='view requirements' data-toggle='modal' data-target='#viewReq' data-user='{$row['user']}'><i class='bi bi-eye'></i></button>";
                                                    echo "<button class='btn btn-success btn-sm ml-1' data-bs-toggle='tooltip' data-bs-placement='top' title='Add requirements' data-toggle='modal' data-target='#addReq' data-user='{$row['user']}'><i class='bi bi-plus-lg'></i></button><br>";
                                                    echo "</td>";
                                                    echo "<td class='text-center'><a class='btn btn-warning btn-sm' data-bs-toggle='tooltip' data-bs-placement='top' title='Change Stall/Assignment' data-toggle='modal' data-target='#editTenantModal{$row['tid']}'><i class='bi bi-pencil-square'></i></a></td>";
                                                    echo "<td class='text-center'><a class='btn btn-primary btn-sm' data-toggle='modal' data-target='#viewrc' data-user='{$row['user']}'><i class='bi bi-eye'></i></a>";
                                                    echo "<a class='btn btn-success btn-sm ml-1' data-toggle='modal' data-target='#addRc' data-users='{$row['user']}'><i class='bi bi-plus-lg'></i></a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    include 'include/updateTenant.php';
                                                }
                                            } else {
                                                echo "0 results";
                                            }
                                            ?>
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
    <div class="modal fade" id="addTenant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Tenant</h5>
                </div>
                <form action="" method="POST" id="tenantAdd">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Stall Name</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="stall_id" aria-label="Default select example" required>
                                    <option hidden>Select Stall</option>
                                    <?php while ($stall = $stallx->fetch_assoc()): ?>
                                        <option value="<?php echo $stall['stall_id']; ?>"><?php echo $stall['stall_name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tenant Name</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="user" aria-label="Default select example" required>
                                    <option hidden>Select Concessionaires</option>
                                    <?php while ($user = $userx->fetch_assoc()): ?>
                                        <option value="<?php echo $user['user_id']; ?>"><?php echo $row["first_name"] .' '. $row["middle"] .' '. $row["last_name"]; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" name="t_submit" form="tenantAdd" type="submit">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Requirements Modal -->
    <div class="modal fade" id="viewReq">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Requirements List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display requirements based on the user ID -->
                    <div id="requirementsContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Requirements Modal -->
    <div class="modal fade" id="addReq">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Add Requirements</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="reqSubmit" enctype="multipart/form-data">
                        <input type="hidden" id="userIdInput" name="user_id">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Requirement</label>
                            <div class="col-sm-9">
                                <select class="form-select w-100 p-2 border-0" name="req_name" aria-label="Small select example">
                                    <option selected value="Mayor's business permit">Mayor's business permit</option>
                                    <option value="Sanitary permit">Sanitary permit</option>
                                    <option value="Inventory of equipment and tools">Inventory of equipment and tools</option>
                                    <option value="Health Certificate">Health Certificate</option>
                                    <option value="Lease Contract">Lease Contract</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Photo</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file" accept="image/png, image/jpeg">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="reqSubmit" form="reqSubmit">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Remarks / Complaints Modal -->
    <div class="modal fade" id="addRc">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Add Remarks/Complaint</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="rcSubmit">
                        <input type="hidden" id="userIdInput" name="user_id">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Details</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="rcSubmit" form="rcSubmit">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Remarks / Complaints Modal -->
    <div class="modal fade" id="viewrc">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Remarks/Complaints</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display requirements based on the user ID -->
                    <div id="remarkscomplaintContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    <!-- Delete -->
    <script src="js/delete.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        $(document).ready(function() {

            $('#viewReq').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('user');

                
                $.ajax({
                    url: 'get_requirements.php',
                    type: 'GET',
                    data: { user_id: userId },
                    success: function(response) {
                        
                        $('#requirementsContent').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(status + ": " + error);
                    }
                });
            });
            $('#viewrc').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('user');

                $.ajax({
                    url: 'get_rc.php',
                    type: 'GET',
                    data: { user_id: userId },
                    success: function(response) {

                        $('#remarkscomplaintContent').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(status + ": " + error);
                    }
                });
            });
            $('#addReq').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('user');

                $('#userIdInput').val(userId);
            });
            $('#addRc').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var userId = button.data('users');

                $('#userIdInput').val(userId);
                $('#rcSubmit input[name="user_id"]').val(userId);
            });
        });
    </script>
    </body>
    </html>
<?php
if(isset($_POST['t_submit'])){
    $tenant_id = $_POST['user'];
    $stall_id = $_POST['stall_id'];
    $tenant = $tenant_id;

    $query = "INSERT INTO tenant (stall_id, user) VALUES ('$stall_id', '$tenant_id')";
    $query2 = mysqli_query($conn, $query);
    if($query2){
        ?>
        <script>
            Swal.fire({
                title: 'Tenant Saved',
                text: 'Data Inserted',
                icon: 'success',
            }).then(function() {
                window.location.href = "tenants.php";
            });
        </script>
        <?php
    }
    $query3 = "UPDATE users SET stall_id = '$stall_id' WHERE user_id = $tenant";
    $query4 = mysqli_query($conn, $query3);
}
?>
<?php
if(isset($_POST['rcSubmit'])){
    $user_id = $_POST['user_id'];
    $description = $_POST['description'];

    $query = "INSERT INTO remarks_complaint (user, description) VALUES ('$user_id', '$description')";
    $query2 = mysqli_query($conn, $query);
    if($query2){
        ?>
        <script>
            Swal.fire({
                title: 'Remarks Saved',
                text: 'Data Inserted',
                icon: 'success',
            }).then(function() {
                window.location.href = "";
            });
        </script>
        <?php
    }
    else {
        ?>
        <script>
            Swal.fire({
                title: 'Remarks Not Inserted',
                text: 'Data Not Inserted',
                icon: 'error',
            }).then(function() {
                window.location.href = "";
            });
        </script>
        <?php
    }
}
?>
<?php
if(isset($_POST['reqSubmit'])){
    $user_id = $_POST['user_id'];
    $req_name = $_POST['req_name'];

    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){
        $file_name = $_FILES['file']['name'];
        $file_tmp = $_FILES['file']['tmp_name'];

        $upload_directory = "requirements/";
        $target_file = $upload_directory . basename($file_name);

        if(move_uploaded_file($file_tmp, $target_file)){
            $query = "INSERT INTO requirements (req_name, user_id, file_name) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);

            mysqli_stmt_bind_param($stmt, "sss", $req_name, $user_id, $file_name);

            if (mysqli_stmt_execute($stmt)) {
                ?>
                <script>
                    Swal.fire({
                        title: 'Requirement Saved',
                        text: 'Data Inserted',
                        icon: 'success',
                    }).then(function() {
                        window.location.href = "tenants.php";
                    });
                </script>
                <?php
            } else {
                echo "Error inserting data into database: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        echo "File upload error: " . $_FILES['file']['error'];
    }
}
?>
<?php

if (isset($_POST['t_update'])) {
    $tid = $_POST['tid'];
    $sid = $_POST['sid'];
    $user = $_POST['user'];

    $found = false;

    foreach ($tenantResult as $row) {
        if ($row['sid'] == $sid) {
            $found = true;
            break;
        }
    }

    if (!$found && $sid != 'selected') {
        $query = "UPDATE tenant SET stall_id = '$sid' WHERE tenant.tenant_id = '$tid'";
        $query2 = mysqli_query($conn, $query);
        $query3 = "UPDATE users SET stall_id = '$sid' WHERE user_id = '$user'";
        $query4 = mysqli_query($conn, $query3);

        if ($query2) {
            ?>
            <script>
                Swal.fire({
                    title: 'Tenant Updated',
                    text: 'Updated Successfully',
                    icon: 'success',
                }).then(function() {
                    window.location.href = "tenants.php";
                });
            </script>
            <?php
        }
    } elseif ($sid == 'selected') {
        ?>
        <script>
            Swal.fire({
                title: 'Stall Unchanged',
                text: 'Selected stall is the same as the current one',
                icon: 'warning',
            });
        </script>
        <?php
    }else {
        ?>
        <script>
            Swal.fire({
                title: 'Stall already assigned',
                text: 'Selected stall is already assigned to another user',
                icon: 'warning',
            });
        </script>
        <?php
    }
}
?>
