<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
$title = "Items";
$item_id = $_GET['getid'];
session_start();
include 'include/config.php';
if(!isset($_SESSION["user_type"])){
header("location:login.php");
}
$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id='" . $_SESSION['user_id'] . "'");
$row= mysqli_fetch_array($result);
$result2 = mysqli_query($conn, "SELECT * FROM projects WHERE id = $item_id");
$rows = mysqli_fetch_array($result2);
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
                    <h4 class="card-title">Items
                      <button class="btn btn-info btn-sm" id="addItemButton" style="float: right; margin-bottom: 10px;"> Add </button>
                      <button class="btn btn-success btn-sm" style="float: right; margin-right: 10px;" onclick="generatePDF('<?php echo $rows['id']; ?>')">Print</button>
                      <button class="btn btn-danger btn-sm" style="float: right; margin-right: 10px;" onclick="window.location.href='project.php';">Go Back</button>
                    </h4>
                    <div class="table-responsive">
                      <table id="items" class="table table-bordered">
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                    <br>
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

    <!-- Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Stock for <?php echo $rows['name']; ?></h5>
                </div>
                <form action="include/add_stock.php" method="POST" id="additemForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="hidden" class="form-control" name="project_id" value="<?php echo $item_id; ?>">
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Collection Added:</label>
                        <input type="number" class="form-control" id="new_qty" name="qty_added" required>
                    </div>
                </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" form="additemForm">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery:js -->
    <script src="js/jquery-3.6.0.min.js"></script>
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
      $(document).ready(function() {
        // Function to fetch and update items
        function fetchItems() {
            var item_id = <?php echo json_encode($item_id); ?>; // Get the item_id from PHP

            // AJAX call to fetch items.php
            $.ajax({
              url: 'fetch_items.php',
              method: 'GET',
              data: { getid: item_id }, // Pass the item_id as a parameter
              success: function(response) {
                $('#items tbody').html(response); // Populate the table body with fetched data
              }
            });
        }

        // Initial fetch of items when the page loads
        fetchItems();

        // Function to handle row count select change
        $('#rowCountSelect').change(function () {
          var rowCount = parseInt($(this).val());

          // Show the selected number of rows
          $('#items tbody tr').hide();
          $('#items tbody tr:lt(' + rowCount + ')').show();
        });

        // Function to handle adding a new project
        $('#addItemButton').click(function() {
          $('#addItemModal').modal('show'); // Show the modal to add a new project
        });

        // On form submission (adding a project), handle AJAX request
        $('#additemForm').submit(function(event) {
          event.preventDefault(); // Prevent the default form submission

          $.ajax({
              url: $(this).attr('action'), // The form's action URL
              type: $(this).attr('method'), // The form's method (POST)
              data: $(this).serialize(), // Form data
              success: function(response) {
                if (response.trim() === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'The quantity has been added successfully.',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(function() {
                        $('#addItemModal').modal('hide'); // Hide the modal after successful submission
                        fetchItems();
                        $('#additemForm')[0].reset();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to add the quantity. Please try again.'
                    });
                }
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText);
                  Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'There was an error while adding the quantity. Please try again.'
                  });
              }
          });
        });

        setInterval(fetchItems, 1000);
      });
    </script>
    <script>
      function generatePDF(id) {
        var pdfUrl = 'generate_pdf.php?getid=' + id;
        window.open(pdfUrl, '_blank');
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