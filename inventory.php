<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Inventory";
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
        <?php include 'header.php';?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Inventory
                                        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="">
                                                <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Administrator" ): ?>
                                                    <select class="form-select" id="filterType" name="filterType">
                                                        <option value="">All Types</option>
                                                        <option value="Module" <?php echo (isset($_GET['filterType']) && $_GET['filterType'] == 'Module') ? 'selected' : ''; ?>>Module</option>
                                                        <option value="Test Booklet" <?php echo (isset($_GET['filterType']) && $_GET['filterType'] == 'Test Booklet') ? 'selected' : ''; ?>>Test Booklet</option>
                                                    </select>
                                                    <select class="form-select" id="filterDepartment" name="filterDepartment">
                                                        <option value="">All Departments</option>
                                                        <option value="Education" <?php echo (isset($_GET['filterDepartment']) && $_GET['filterDepartment'] == 'Education') ? 'selected' : ''; ?>>Education</option>
                                                        <option value="Technology" <?php echo (isset($_GET['filterDepartment']) && $_GET['filterDepartment'] == 'Technology') ? 'selected' : ''; ?>>Technology</option>
                                                        <option value="BEM" <?php echo (isset($_GET['filterDepartment']) && $_GET['filterDepartment'] == 'BEM') ? 'selected' : ''; ?>>BEM</option>
                                                        <option value="Engineering" <?php echo (isset($_GET['filterDepartment']) && $_GET['filterDepartment'] == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-primary btn-sm ml-2" title='Apply Filter'><i class="bi bi-filter-left"></i></button>
                                                <?php endif; ?>
                                                <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Administrator" ): ?>
                                                    <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_item" style="float: right; margin-bottom: 10px;"><i class="bi bi-bag-plus"></i> Add Product</a>
                                                    <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#stock_request" style="float: right; margin-bottom: 10px; margin-right: 10px;"><i class="bi bi-bag-heart"></i>
                                                        Stock Requests
                                                        <?php
                                                        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM requests");
                                                        $row = mysqli_fetch_array($result);
                                                        $badge_count = $row['total'];
                                                        ?>
                                                        <?php if ($badge_count > 0): ?>
                                                            <span class="badge badge-danger"><?php echo $badge_count; ?></span>
                                                        <?php endif; ?>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Staff" ): ?>
                                                    <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_item" style="float: right; margin-bottom: 10px;"><i class="bi bi-bag-plus"></i> Add Product</a>
                                                    <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#stock_request" style="float: right; margin-bottom: 10px; margin-right: 10px;"><i class="bi bi-bag-heart"></i>
                                                        Stock Requests
                                                        <?php
                                                        $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM requests");
                                                        $row = mysqli_fetch_array($result);
                                                        $badge_count = $row['total'];
                                                        ?>
                                                        <?php if ($badge_count > 0): ?>
                                                            <span class="badge badge-danger"><?php echo $badge_count; ?></span>
                                                        <?php endif; ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </form>
                                    </h4>

                                    <div class="table-responsive">
                                        <?php
                                        $no = 1;
                                        $filterType = isset($_GET['filterType']) ? $_GET['filterType'] : '';
                                        $filterDepartment = isset($_GET['filterDepartment']) ? $_GET['filterDepartment'] : '';
                                        $faculty = $_SESSION["user_type"] === 'Faculty';

                                        $query = "SELECT *, products.id AS product_id, 
                                                            products.stock AS product_stock,
                                                            products.updated AS product_updated
                                                            FROM products WHERE 1";
                                        if($faculty){
                                            $query = "SELECT 
                                                        products.id AS product_id,
                                                        products.type,
                                                        products.description,
                                                        products.department,
                                                        products.stock AS product_stock,
                                                        products.updated AS product_updated,
                                                        faculty_stock.id AS faculty_stock_id,
                                                        faculty_stock.faculty_id,
                                                        faculty_stock.product_id AS faculty_product_id,
                                                        faculty_stock.stock AS faculty_product_stock,
                                                        SUM(logs.quantity) AS total_quantity
                                                    FROM 
                                                        faculty_stock
                                                    INNER JOIN 
                                                        products ON products.id = faculty_stock.product_id
                                                    LEFT JOIN 
                                                        logs ON logs.product_id = products.id AND logs.userid = faculty_stock.faculty_id
                                                    WHERE 
                                                        faculty_stock.faculty_id = '".$row['id']."'
                                                    GROUP BY 
                                                        products.id, faculty_stock.id;
                                                    ";
                                        }

                                        if (!empty($filterType) && $faculty === false) {
                                            $query .= " AND type = '$filterType'";
                                        }

                                        if (!empty($filterDepartment) && $faculty === false) {
                                            $query .= " AND department = '$filterDepartment'";
                                        }

                                        $result = mysqli_query($conn, $query);

                                        $admin_or_staff = $_SESSION['user_type'] == 'Administrator' || $_SESSION['user_type'] == 'Staff';

                                        if ($result->num_rows > 0) {
                                            echo "<table class='table table-bordered'><tr><th>Name</th><th>Requesting Department</th><th>IGP Stock</th>";
                                            if($faculty) {echo "<th>Stock In</th>";}
                                            if($faculty) {echo "<th>Stock Out</th>";}
                                            echo "<th>Updated At</th><th>Action</th></tr>";
                                            while($row = $result->fetch_assoc()) {
                                                $date_filed = $row['product_updated'];
                                                $time = strtotime($date_filed);
                                                $updated = date("F d Y, g:i A", $time);
                                                echo "<tr>";
                                                echo "<td>".$row["type"]."</td>";
                                                echo "<td>".$row['department']."</td>";
                                                echo "<td>".$row['product_stock']."</td>";
                                                if($faculty) {echo "<td>".$row['faculty_product_stock']."</td>";}
                                                if($faculty) {echo "<td>".$row['total_quantity']."</td>";}
                                                echo "<td>".$updated."</td>";
                                                if ($admin_or_staff) {
                                                    echo "<td><button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#sellItem{$row['product_id']}' title='Sell'><i class='bi bi-bag-dash'></i></button>";
                                                }
                                                else {
                                                    echo "<td><button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#sellItems{$row['product_id']}' title='Sell'><i class='bi bi-bag-dash'></i></button>";
                                                    echo " <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#stockRequests{$row['product_id']}' title='Request Stock'><i class='bi bi-bag-heart'></i> </button>";
                                                }
                                                if ($admin_or_staff) {
                                                    echo " <button class='btn btn-success btn-sm' data-toggle='modal' data-target='#addStock{$row['product_id']}' title='Add Stock'><i class='bi bi-plus-circle'></i></button></td>";
                                                }
                                                echo "</tr>";

                                                ?>
                                                <div class='modal fade' id='sellItem<?php echo $row['product_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='sellItemModalLabel' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='sellItemModalLabel'>Sell Item</h5>
                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form id='sellItems' method='post'>
                                                                    <div class='form-group'>
                                                                        <label for='quantity'>Quantity:</label>
                                                                        <input type='number' class='form-control' id='quantity' name='quantity' required>
                                                                        <input type='hidden' name='pid' value='<?php echo $row['product_id'] ?>'>
                                                                    </div>
                                                                    <button type='submit' class='btn btn-danger' name='sellItem'>Sell</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='modal fade' id='sellItems<?php echo $row['product_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='sellItemModalLabel' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='sellItemModalLabel'>Sell Item</h5>
                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form id='sellItems' method='post'>
                                                                    <div class='form-group'>
                                                                        <label for='quantity'>Quantity:</label>
                                                                        <input type='number' class='form-control' id='quantity' name='quantity' required>
                                                                        <input type='hidden' name='fid' value='<?php echo $row['product_id'] ?>'>
                                                                    </div>
                                                                    <button type='submit' class='btn btn-danger' name='sellItems'>Sell</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='modal fade' id='stockRequest<?php echo $row['product_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='stockRequestModalLabel' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='stockRequestModalLabel'>Stock Request</h5>
                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form id='stockRequestForm' method='post'>
                                                                    <div class='form-group'>
                                                                        <label for='requestQuantity'>Request Quantity:</label>
                                                                        <input type='number' class='form-control' id='requestedStock' name='requestedStock' required>
                                                                        <input type='hidden' name='pid' value='<?php echo $row['product_id'] ?>'>
                                                                    </div>
                                                                    <button type='submit' class='btn btn-primary' name='stockRequest'>Request</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='modal fade' id='stockRequests<?php echo $row['product_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='stockRequestModalLabel' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='stockRequestModalLabel'>Stock Request</h5>
                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form id='stockRequestForm' method='post'>
                                                                    <div class='form-group'>
                                                                        <label for='requestQuantity'>Request Quantity:</label>
                                                                        <input type='number' class='form-control' id='requestedStock' name='requestedStock' required>
                                                                        <input type='hidden' name='pid' value='<?php echo $row['product_id'] ?>'>
                                                                    </div>
                                                                    <button type='submit' class='btn btn-primary' name='stockRequests'>Request</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='modal fade' id='addStock<?php echo $row['product_id'] ?>' tabindex='-1' role='dialog' aria-labelledby='addStockModalLabel' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='addStockModalLabel'>Add Stock</h5>
                                                                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <form id='addStockForm' method='post'>
                                                                    <div class='form-group'>
                                                                        <label for='addQuantity'>Add Quantity:</label>
                                                                        <input type='number' class='form-control' id='quantity' name='quantity' required>
                                                                        <input type='hidden' name='pid' value='<?php echo $row['product_id'] ?>'>
                                                                    </div>
                                                                    <button type='submit' class='btn btn-success' name='addStock'>Add</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            echo "</table>";
                                        } else { echo "No records found!"; }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        </div>
                    </footer>
                </div>
            </div>
        </div>

        <!-- Bootstrap Modal -->
        <div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addProductForm" method="post">
                            <div class="form-group d-flex w-100">
                                <div class="w-100">
                                    <label for="productName">Product Type:</label>
                                    <select class="form-select w-100 p-2 border-0" name="productType" aria-label="Small select example">
                                        <option selected value="Module">Module</option>
                                        <option value="Test Booklet">Test Booklet</option>
                                    </select>
                                </div>
                                <div class="w-100 ml-3">
                                    <label for="productName">Department:</label>
                                    <select class="form-select w-100 p-2 border-0" name="department" aria-label="Small select example">
                                        <option selected value="Education">Education</option>
                                        <option value="Technology">Technology</option>
                                        <option value="BEM">BEM</option>
                                        <option value="Engineering">Engineering</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="productDescription">Description:</label>
                                <textarea class="form-control" id="productDescription" name="productDescription"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="initialStock">Initial Stock:</label>
                                <input type="number" class="form-control" id="initialStock" name="initialStock">
                            </div>
                            <button type="submit" class="btn btn-primary" name="addProduct">Add Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="stock_request" tabindex="-1" role="dialog" aria-labelledby="stockRequestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stockRequestModalLabel">Stock Requests</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class='modal-body'>
                        <div class='table-responsive'>
                            <?php
                            // Fetch stock requests from the database
                            $result = mysqli_query($conn, "SELECT *, requests.id, requests.datetime as rd, requests.stock as rs, faculty.id as fid, products.id AS pid FROM requests INNER JOIN products ON requests.product = products.id INNER JOIN faculty ON requests.user_id = faculty.id");
                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered'><tr><th>Requested By</th></th><th>Product</th><th>Description</th><th>amount</th><th>Datetime</th><th>Action</th></tr>";
                                while ($row = $result->fetch_assoc()) {
                                    $faculty_stock = mysqli_query($conn, "SELECT * FROM faculty_stock WHERE faculty_id = '".$row['fid']."' AND product_id = '".$row['pid']."'");
                                    $fs = mysqli_fetch_array($faculty_stock);
                                    $date_filed = $row['rd'];
                                    $time = strtotime($date_filed);
                                    $updated = date("F d Y, g:i A", $time);
                                    echo "<tr>";
                                    echo "<td><b>".$row['first_name']. " " .$row['middle']. " " .$row['last_name']."</b></td>";
                                    echo "<td>".$row["type"]."</td>";
                                    echo "<td>".$row['description']."</td>";
                                    echo "<td>".$row['rs']."</td>";
                                    echo "<td>".$updated."</td>";
                                    echo "<td>";
                                    echo "<form method='post'>";
                                    echo "<input type='hidden' name='requestId' value='".$row['id']."'>";
                                    echo "<input type='hidden' name='my_stock' value='".$fs['stock']."'>";
                                    echo "<input type='hidden' name='fid' value='".$row['fid']."'>";
                                    echo "<button type='submit' class='btn btn-success btn-sm' name='approveStockRequest'>Approve</button>";
                                    echo "</form>";
                                    echo "</td>";
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
    </body>
    </html>
<?php
function addStock($pid, $quantity, $my_stock, $fid) {
    global $conn;

    // Update product stock
    $sql = "UPDATE products SET stock = stock - $quantity WHERE id = $pid";
    $productUpdateResult = $conn->query($sql);

    // Calculate new stock for faculty_stock
    $stock = $my_stock + $quantity;

    // Check if the faculty_stock entry exists
    $facultyStockResult = $conn->query("SELECT * FROM faculty_stock WHERE faculty_id = $fid AND product_id = $pid");

    if ($facultyStockResult && $facultyStockResult->num_rows > 0) {
        // Update existing faculty_stock entry
        $update_stock = $conn->query("UPDATE faculty_stock SET stock = $stock WHERE faculty_id = $fid AND product_id = $pid");
    } else {
        // Insert new faculty_stock entry
        $conn->query("INSERT INTO faculty_stock (faculty_id, product_id, stock) VALUES ('$fid', '$pid', '$stock')");
        // Set $update_stock to true because the insert happened
        $update_stock = true;
    }

    return $productUpdateResult && $update_stock;
}

// Function to add a new product
function addProduct($type, $department, $description, $stock) {
    global $conn;
    $name = $conn->real_escape_string($name);
    $description = $conn->real_escape_string($description);
    $sql = "INSERT INTO products (type, department, description, stock) VALUES ('$type','$department', '$description', $stock)";
    return $conn->query($sql);
}

function stockRequest($pid, $requestedStock) {
    global $conn;
    $pid = $conn->real_escape_string($pid);
    $uid = $_SESSION['faculty_id'];
    $sql = "INSERT INTO requests (product, user_id, stock) VALUES ('$pid', '$uid', $requestedStock)";
    return $conn->query($sql);
}

// Check if the form for adding a product is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["addProduct"])) {
        $productType = $_POST["productType"];
        $department = $_POST["department"];
        $productDescription = $_POST["productDescription"];
        $initialStock = $_POST["initialStock"];
        $user_id = $_SESSION["user_id"];

        // Add the new product
        if (addProduct($productType, $department, $productDescription, $initialStock)) {
            $addLog = "INSERT INTO logs (log, quantity, userid) VALUES ('Added a Product Named " . $productType . " with an Initial Stock of', '" . $initialStock . "', '" . $user_id . "')";
            $saveLog = mysqli_query($conn, $addLog);
            ?>
            <script>
                Swal.fire({
                    title: 'success',
                    text: 'Data Inserted',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = "inventory.php";
                });
            </script>
            <?php
        } else {
            ?>
            <script>
                Swal.fire({
                    title: 'error',
                    text: 'Error Inserting',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = "inventory.php";
                });
            </script>
            <?php
        }
    }

    // Add code to handle other form submissions (Add Stock, Purchase Items, Update Stock) if needed
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sellItem"])) {
    $pid = $_POST["pid"];
    $quantity = $_POST["quantity"];
    $user_id = $_SESSION["user_id"];

    // Check if the product exists and has sufficient stock for sale
    $productQuery = "SELECT * FROM products WHERE id = $pid";
    $productResult = $conn->query($productQuery);

    if ($productResult->num_rows > 0) {
        $productData = $productResult->fetch_assoc();
        $currentStock = $productData['stock'];

        if ($currentStock >= $quantity && $quantity > 0) {
            // Perform the sale - Update the stock after selling items
            $newStock = $currentStock - $quantity;
            $updateStockQuery = "UPDATE products SET stock = $newStock WHERE id = $pid";
            if ($conn->query($updateStockQuery) === TRUE) {
                $addLog = "INSERT INTO logs (log, quantity, userid) VALUES ('Sold a stock of',  '$quantity', '$user_id')";
                $saveLog = mysqli_query($conn, $addLog);
                // Sale successful
                echo "<script>
                      Swal.fire({
                          title: 'Sale successful!',
                          icon: 'success'
                      }).then(function() {
                          window.location.href = 'inventory.php';
                      });
                   </script>";
            } else {
                // Error updating stock
                echo "<script>
                      Swal.fire({
                          title: 'Error occurred while updating stock.',
                          icon: 'error'
                      }).then(function() {
                          window.location.href = 'inventory.php';
                      });
                   </script>";
            }
        } else {
            // Insufficient stock or invalid quantity for sale
            echo "<script>
                  Swal.fire({
                      title: 'Insufficient stock or invalid quantity for sale.',
                      icon: 'error'
                  }).then(function() {
                      window.location.href = 'inventory.php';
                  });
               </script>";
        }
    } else {
        // Product not found
        echo "<script>
              Swal.fire({
                  title: 'Product not found.',
                  icon: 'error'
              }).then(function() {
                  window.location.href = 'inventory.php';
              });
           </script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sellItems"])) {
    $fid = $_POST["fid"];
    $quantity = $_POST["quantity"];
    $user_id = $_SESSION["faculty_id"];

    // Check if the product exists and has sufficient stock for sale
    $productQuery = "SELECT * FROM faculty_stock WHERE product_id = $fid";
    $productResult = $conn->query($productQuery);

    if ($productResult->num_rows > 0) {
        $productData = $productResult->fetch_assoc();
        $currentStock = $productData['stock'];

        if ($currentStock >= $quantity && $quantity > 0) {
            // Perform the sale - Update the stock after selling items
            $newStock = $currentStock - $quantity;
            $updateStockQuery = "UPDATE faculty_stock SET stock = $newStock WHERE product_id = $fid";
            if ($conn->query($updateStockQuery) === TRUE) {
                $addLog = "INSERT INTO logs (log, quantity, product_id, userid) VALUES ('Sold a stock of',  '$quantity', $fid, '$user_id')";
                $saveLog = mysqli_query($conn, $addLog);
                // Sale successful
                echo "<script>
                      Swal.fire({
                          title: 'Sale successful!',
                          icon: 'success'
                      }).then(function() {
                          window.location.href = 'inventory.php';
                      });
                   </script>";
            } else {
                // Error updating stock
                echo "<script>
                      Swal.fire({
                          title: 'Error occurred while updating stock.',
                          icon: 'error'
                      }).then(function() {
                          window.location.href = 'inventory.php';
                      });
                   </script>";
            }
        } else {
            // Insufficient stock or invalid quantity for sale
            echo "<script>
                  Swal.fire({
                      title: 'Insufficient stock or invalid quantity for sale.',
                      icon: 'error'
                  }).then(function() {
                      window.location.href = 'inventory.php';
                  });
               </script>";
        }
    } else {
        // Product not found
        echo "<script>
              Swal.fire({
                  title: 'Product not found.',
                  icon: 'error'
              }).then(function() {
                  window.location.href = 'inventory.php';
              });
           </script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addStock"])) {
    $pid = $_POST["pid"];
    $quantity = $_POST["quantity"];
    $user_id = $_SESSION["user_id"];

    // Validate and sanitize inputs
    $pid = intval($pid); // Convert to integer for safety
    $quantity = intval($quantity);

    if ($pid <= 0 || $quantity <= 0) {
        // Invalid inputs; handle the error accordingly
        echo "<script>
              Swal.fire({
                  title: 'Invalid input data.',
                  icon: 'error'
              }).then(function() {
                  window.location.href = 'inventory.php';
              });
           </script>";
        exit(); // Stop further execution to prevent SQL injection
    }

    // Prepare and execute SQL queries
    $productQuery = "SELECT * FROM products WHERE id = $pid";
    $productResult = $conn->query($productQuery);

    if ($productResult && $productResult->num_rows > 0) {
        $productData = $productResult->fetch_assoc();
        $currentStock = $productData['stock'];

        // Calculate new stock after additions
        $newStock = $currentStock + $quantity;

        // Perform the addition of stock
        $updateStockQuery = "UPDATE products SET stock = $newStock WHERE id = $pid";
        if ($conn->query($updateStockQuery) === TRUE) {
            // Log the stock addition
            $addLog = "INSERT INTO logs (log, quantity, userid) VALUES ('Added a Stock of', '$quantity', '$user_id')";
            $saveLog = mysqli_query($conn, $addLog);
            // Stock addition successful
            echo "<script>
                  Swal.fire({
                      title: 'Stock added successfully!',
                      icon: 'success'
                  }).then(function() {
                      window.location.href = 'inventory.php';
                  });
               </script>";
        } else {
            // Error occurred while adding stock
            echo "<script>
                  Swal.fire({
                      title: 'Error occurred while adding stock.',
                      icon: 'error'
                  }).then(function() {
                      window.location.href = 'inventory.php';
                  });
               </script>";
        }
    } else {
        // Product not found
        echo "<script>
              Swal.fire({
                  title: 'Product not found.',
                  icon: 'error'
              }).then(function() {
                  window.location.href = 'inventory.php';
              });
           </script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["stockRequest"])) {
    $pid = $_POST["pid"];
    $requestedStock = $_POST["requestedStock"];

    // Add the new product
    if (stockRequest($pid, $requestedStock)) {
        ?>
        <script>
            Swal.fire({
                title: 'success',
                text: 'Request Inserted',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "inventory.php";
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            Swal.fire({
                title: 'error',
                text: 'Error Inserting',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "inventory.php";
            });
        </script>
        <?php
    }
}

// Add code to handle other form submissions (Add Stock, Purchase Items, Update Stock) if needed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["stockRequests"])) {
    $pid = $_POST["pid"];
    $requestedStock = $_POST["requestedStock"];

    // Add the new product
    if (stockRequest($pid, $requestedStock)) {
        ?>
        <script>
            Swal.fire({
                title: 'success',
                text: 'Request Inserted',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "inventory.php";
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            Swal.fire({
                title: 'error',
                text: 'Error Inserting',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "inventory.php";
            });
        </script>
        <?php
    }

    // Add code to handle other form submissions (Add Stock, Purchase Items, Update Stock) if needed
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["approveStockRequest"])) {
    $requestId = $_POST["requestId"]; // Get the request ID from the form
    $my_stock = $_POST["my_stock"]; // Get the request ID from the form
    $fid = $_POST["fid"]; // Get the request ID from the form

    // Fetch the requested stock information based on the request ID
    $fetchRequestQuery = "SELECT * FROM requests WHERE id = $requestId";
    $fetchRequestResult = $conn->query($fetchRequestQuery);

    if ($fetchRequestResult && $fetchRequestResult->num_rows > 0) {
        $requestData = $fetchRequestResult->fetch_assoc();
        $pid = $requestData['product'];
        $requestedStock = $requestData['stock'];

        // Add requested stock to the inventory
        if (addStock($pid, $requestedStock, $my_stock, $fid)) {
            // Remove the approved request from the requests table
            $deleteRequestQuery = "DELETE FROM requests WHERE id = $requestId";
            if ($conn->query($deleteRequestQuery)) {
                // Redirect or display success message
                // You can use JavaScript to redirect or display a success message
                echo "<script>
                        Swal.fire({
                            title: 'Stock request approved and added to inventory!',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = 'inventory.php';
                        });
                      </script>";
            } else {
                // Error occurred while removing the request
                // Handle error or display an error message
                echo "<script>
                        Swal.fire({
                            title: 'Error occurred while removing the request.',
                            icon: 'error'
                        }).then(function() {
                            window.location.href = 'inventory.php';
                        });
                      </script>";
            }
        } else {
            // Error occurred while adding requested stock to inventory
            // Handle error or display an error message
            echo "<script>
                    Swal.fire({
                        title: 'Error occurred while adding stock to inventory.',
                        icon: 'error'
                    }).then(function() {
                        window.location.href = 'inventory.php';
                    });
                  </script>";
        }
    } else {
        // Request not found or invalid request ID
        // Handle error or display an error message
        echo "<script>
                Swal.fire({
                    title: 'Request not found or invalid request ID.',
                    icon: 'error'
                }).then(function() {
                    window.location.href = 'inventory.php';
                });
              </script>";
    }
}
?>