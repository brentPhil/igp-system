<?php
$activePage = basename($_SERVER['PHP_SELF'], ".php");[[]]
$title = "Users List";
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
    .img {

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
                  <h4 class="card-title">Users List <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addUser" style="float: right; margin-bottom: 10px;"> Add User</a></h4>
                  <div class="table-responsive">
                    <?php
                    $result = mysqli_query($conn, "
                    SELECT
                        users.*,
                        faculty.first_name AS faculty_first_name,
                        faculty.middle AS faculty_middle,
                        faculty.last_name AS faculty_last_name,
                        CONCAT(users.first_name, ' ', users.middle, ' ', users.last_name) AS user_fullname,
                        CONCAT(faculty.first_name, ' ', faculty.middle, ' ', faculty.last_name) AS faculty_fullname
                    FROM users
                    LEFT JOIN faculty ON users.faculty_id = faculty.id
                    ORDER BY users.user_type ASC
                    ");
                    if ($result->num_rows > 0) {
                      echo "<table class='table table-bordered'><tr><th width='10px;'>Profile</th><th>Fullname</th><th>Username</th><th>Contact</th><th>User Type</th><th>Action</th></tr>";

                      while ($row = $result->fetch_assoc()) {
                          echo "<tr>";

                          if ($row['profile_picture'] == NULL) {
                              echo "<td><img src='images/evsu_logo.png' width='50px'></td>";
                          } else {
                              echo "<td><a href='uploads/{$row['profile_picture']}' target='_blank'><img src='uploads/{$row['profile_picture']}' width='50px'></a></td>";
                          }

                          $mergedFullname = $row["faculty_fullname"] ?: $row["user_fullname"];
                          echo "<td>" . $mergedFullname . "</td><td>" . $row["username"] . "</td><td>" . $row["phone"] . "</td>";

                          if (!empty($row['faculty_id']) && ($row['user_type'] == 'Administrator' || $row['user_type'] == 'Staff' || $row['user_type'] == 'Faculty')) {

                              echo "<td>{$row['user_type']}</td>";
                          } else {

                              echo "<td><a href='tenants.php' style='text-decoration: none;'>{$row['user_type']}</a></td>";
                          }

                          if ($row['user_id'] == $_SESSION['user_id']) {
                              echo "<td><a class='btn btn-success btn-sm' data-toggle='modal' data-target='#editUserModal{$row['user_id']}'><i class='bi bi-pencil-square'></i></a></td>";
                          } else {
                              echo "<td><a class='btn btn-success btn-sm' data-toggle='modal' data-target='#editUserModal{$row['user_id']}'><i class='bi bi-pencil-square'></i></a> <button class='deleteBtnUser btn btn-danger btn-sm' data-user_id='{$row['user_id']}'><i class='bi bi-trash3'></i></button></td>";
                          }

                          echo "</tr>";
                          include 'include/updateProfile.php';
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
  <!-- container-scroller -->
  <!-- Modal -->
  <script>
    // Get the input fields
    var firstName = document.querySelector('input[name="first_name"]');
    var middleName = document.querySelector('input[name="middle"]');
    var lastName = document.querySelector('input[name="last_name"]');
    var username = document.querySelector('input[name="username"]');

    // Function to update the username
    function updateUsername() {
      var initials = (firstName.value[0] || '') + (middleName.value[0] || '') + (lastName.value[0] || '');
      username.value = 'tc_engg(' + initials.toUpperCase() + ')';
    }

    // Add event listeners to the name fields
    firstName.addEventListener('input', updateUsername);
    middleName.addEventListener('input', updateUsername);
    lastName.addEventListener('input', updateUsername);
  </script>
  <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        </div>
        <form action="" method="POST" id="createaccount" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Profile Picture</label>
              <div class="col-sm-9">
                <input type="file" name="profile_picture" class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Account Type</label>
              <div class="col-sm-9">
                <select class="form-control" id="userType" name="user_type" required>
                  <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Administrator" ): ?>
                    <option value="Administrator">Administrator</option>
                  <?php endif; ?>
                  <option value="Staff">Staff</option>
                  <option value="Faculty">Faculty</option>
                  <option value="Concessionaires">Concessionaires</option>
                </select>
              </div>
            </div>
            <div class="form-group row" id="stallDropdown" style="display:none;">
              <label class="col-sm-3 col-form-label">Select Stall</label>
              <div class="col-sm-9">
                <select class="form-control" name="stall_id">
                  <option selected disabled>Select Stall</option>
                  <?php
                  $query = "SELECT stalls.stall_id, stalls.stall_name FROM stalls
                  LEFT JOIN users ON stalls.stall_id = users.stall_id
                  WHERE users.stall_id IS NULL
                  ORDER BY stalls.stall_name ASC";
                  $resultx = mysqli_query($conn, $query);
                  while ($row = mysqli_fetch_array($resultx)){
                    ?>
                    <option value ="<?php echo $row['stall_id'];?>"><?php echo $row['stall_name'];?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row" id="gn">
              <label class="col-sm-3 col-form-label">Given Name</label>
              <div class="col-sm-9">
                <input type="text" id="first_name" name="first_name" class="form-control"/>
              </div>
            </div>
            <div class="form-group row" id="mi">
              <label class="col-sm-3 col-form-label">Middle Initial</label>
              <div class="col-sm-9">
                <input type="text" id="middle" name="middle" class="form-control" maxlength="1"/>
              </div>
            </div>
            <div class="form-group row" id="ln">
              <label class="col-sm-3 col-form-label">Last Name</label>
              <div class="col-sm-9">
                <input type="text" id="last_name" name="last_name" class="form-control"/>
              </div>
            </div>
            <div class="form-group row faculty-dropdown" id ="faculty_selection" style="display:none;">
              <label class="col-sm-3 col-form-label">Faculty Selection</label>
              <div class="col-sm-9">
              <select class="form-control" name="faculty_selection">
                <?php
                $query = "SELECT * FROM faculty ORDER BY department, last_name";
                $resultx = mysqli_query($conn, $query);

                if ($resultx->num_rows > 0) {
                  $currentDepartment = null;

                  while ($row = mysqli_fetch_array($resultx)) {
                    $department = $row['department'];

                    if ($department != $currentDepartment) {

                      if ($currentDepartment !== null) {
                        echo "</optgroup>";
                      }


                      echo "<optgroup label='{$department}'>";
                    }


                    echo "<option value ='{$row['id']}'>{$row['first_name']} {$row['middle']} {$row['last_name']}</option>";


                    $currentDepartment = $department;
                  }


                  echo "</optgroup>";
                } else {
                  echo "<option value='' disabled>No faculty available</option>";
                }
                ?>
              </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Username</label>
              <div class="col-sm-9">
                <input type="text" name="username" id="username" class="form-control" autocomplete="false" required/>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-9">
                <input type="password" value="EVSUTC2021" name="password" class="form-control"/>
                <div class="form-text fs-1" id="basic-addon4">Default pass: EVSUTC2021</div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Contact #</label>
              <div class="col-sm-9">
                <input type="text" onkeypress='validate(event)' minlength="10" maxlength="11" name="phone" class="form-control" required/>
              </div>
            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
          <button class="btn btn-success" name="save_user" form="createaccount" type="submit">Save User</button>
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

  <script>
    $(document).ready(function () {
      // Function to update the username field
      function updateUsername() {
        let firstName = $("#first_name").val().trim();
        let middleInitial = $("#middle").val().trim();
        let lastName = $("#last_name").val().trim();

        // Combine initials and update the username field
        let initials = (firstName.charAt(0) + (middleInitial ? middleInitial.charAt(0) : "") + lastName.charAt(0)).toUpperCase();
        $("#username").val("tc_engg(" + initials + ")");
      }

      // Listen for changes in name fields and update the username accordingly
      $("#first_name, #middle, #last_name").on("input", function () {
        updateUsername();
      });
    });
  </script>
  <script>
  $(document).ready(function () {
      // Function to update the username field
      function updateUsername() {
          let firstName = $("#first_name").val().trim();
          let middleInitial = $("#middle").val().trim();
          let lastName = $("#last_name").val().trim();

          // Combine initials and update the username field
          let initials = (firstName.charAt(0) + (middleInitial ? middleInitial.charAt(0) : "") + lastName.charAt(0)).toLowerCase();
          $("#username").val("tc_" + initials);
      }

      // Listen for changes in name fields and update the username accordingly
      $("#first_name, #middle, #last_name").on("input", function () {
          updateUsername();
      });
  });
  </script>
  <script>
    $(document).ready(function(){
      $('#userType').change(function(){
        const selectedUserType = $(this).val();
        if(selectedUserType === 'Concessionaires'){
          $('#stallDropdown').show();
          $('#faculty_selection').hide();
          $('#faculty_selection select').val('');
          $('#gn').show();
          $('#mi').show();
          $('#ln').show();
        } else if (selectedUserType === 'Faculty'){
          $('#stallDropdown').hide();
          // Clear the selected value in Stall Selection dropdown
          $('#stallDropdown select').val('');
          $('#gn').hide();
          $('#mi').hide();
          $('#ln').hide();
          $('#faculty_selection').show();
        } else if(selectedUserType === 'Staff'){
          $('#stallDropdown').hide();
          $('#stallDropdown select').val('');
          $('#faculty_selection').hide();
          $('#faculty_selection select').val('');
          $('#gn').show();
          $('#mi').show();
          $('#ln').show();
        } else if(selectedUserType === 'Administrator'){
          $('#stallDropdown').hide();
          $('#stallDropdown select').val('');
          $('#faculty_selection select').val('');
        }
      });
    });
  </script>
  <script>
    function validate(evt) {
      const theEvent = evt || window.event;

      // Handle paste
      if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
      } else {
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
      }
      const regex = /[0-9]|\./;
      if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
      }
    }
  </script>
  <script>
    function updateUsername() {
        const userType = $("#userType").val();
        const firstName = $("#first_name").val().trim();
        const middleInitial = $("#middle").val().trim();
        const lastName = $("#last_name").val().trim();
        const facultySelection = $("#faculty_selection").val();

        let initials = (firstName.charAt(0) + (middleInitial ? middleInitial.charAt(0) : "") + lastName.charAt(0)).toLowerCase();

        if (userType === 'Faculty' && facultySelection !== null) {
            const facultyName = $("#faculty_selection option:selected").text();
            const department = $("#faculty_selection option:selected").parent().attr('label').substring(0, 3).toLowerCase();
            const facultyInitials = facultyName.split(' ').map(name => name.charAt(0)).join('').toLowerCase();
            $("#username").val("tc_" + department + "_" + facultyInitials);
        } else {
            $("#username").val("");
        }
    }

    $("#first_name, #middle, #last_name, #userType, #faculty_selection").on("input change", function () {
        updateUsername();
    });

    $(document).ready(function () {
        updateUsername();
    });
  </script>
  </body>
  </html>
<?php
if(isset($_POST['save_user'])){
  $first_name = $_POST['first_name'];
  $middle = $_POST['middle'];
  $last_name = $_POST['last_name'];
  $user_type = $_POST['user_type'];
  $phone = $_POST['phone'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password = md5($password);
  $stall_id = $_POST['stall_id'];
  $faculty_id = $_POST['faculty_selection'];

  $targetDir = "uploads/";
  $profilePic = basename($_FILES["profile_picture"]["name"]);
  $targetFilePath = $targetDir . $profilePic;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

  if(!empty($profilePic)){
    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
    if(in_array($fileType, $allowTypes)){
      if(move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)){
        $query = "INSERT INTO users (first_name, middle, last_name, user_type, username, password, phone, stall_id, profile_picture, faculty_id) VALUES ('$first_name','$middle','$last_name', '$user_type', '$username', '$password', '$phone', '$stall_id', '$profilePic', '$faculty_id')";
        $query2 = mysqli_query($conn, $query);

        if($query2){
          if($user_type == "Concessionaires") {
            $user_id = mysqli_insert_id($conn);
            $query3 = "INSERT INTO tenant (stall_id, user) VALUES ('$stall_id', '$user_id')";
            $query4 = mysqli_query($conn, $query3);
          }

          if($query4 || $user_type != "Concessionaires"){
            ?>
            <script>
              Swal.fire({
                title: 'Success',
                text: 'Data Inserted',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                window.location.href = "users-list.php";
              });
            </script>
            <?php
          } else {
            echo "<script>
            Swal.fire({
              title: 'Failed',
              text: 'Concessionaire Insertion Failed',
              icon: 'error',
              showConfirmButton: false,
              timer: 1500
            }).then(function() {
              window.location.href = 'users-list.php';
            });
          </script>";
          }
        } else {
          echo "<script>
          Swal.fire({
            title: 'Failed',
            text: 'Failed to Insert Userdata',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500
          }).then(function() {
            window.location.href = 'users-list.php';
          });
        </script>";
        }
      } else {
        echo "<script>
        Swal.fire({
          title: 'Failed',
          text: 'Sorry there was a Error uploading your file',
          icon: 'error',
          showConfirmButton: false,
          timer: 1500
        }).then(function() {
          window.location.href = 'users-list.php';
        });
      </script>";
      }
    } else {
      echo "<script>
          Swal.fire({
            title: 'Failed',
            text: 'Sorry, only JPG, JPEG, PNG, GIF files are allowed',
            icon: 'error',
            showConfirmButton: false,
            timer: 1500
          }).then(function() {
            window.location.href = 'users-list.php';
          });
        </script>";
    }
  } else {
    $query = "INSERT INTO users (first_name, middle, last_name, user_type, username, password, phone, stall_id, faculty_id) VALUES ('$first_name','$middle','$last_name', '$user_type', '$username', '$password', '$phone', '$stall_id', '$faculty_id')";
    $query2 = mysqli_query($conn, $query);

    if($query2){
      if($user_type == "Concessionaires") {
        $user_id = mysqli_insert_id($conn);
        $query3 = "INSERT INTO tenant (stall_id, user) VALUES ('$stall_id', '$user_id')";
        $query4 = mysqli_query($conn, $query3);
      }

      if($query4 || $user_type != "Concessionaires"){
        ?>
        <script>
          Swal.fire({
            title: 'Success',
            text: 'Data Inserted',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
          }).then(function() {
            window.location.href = "users-list.php";
          });
        </script>
        <?php
      } else {
        echo "<script>
        Swal.fire({
          title: 'Failed',
          text: 'Concessionaire Insertion Failed',
          icon: 'error',
          showConfirmButton: false,
          timer: 1500
        }).then(function() {
          window.location.href = 'users-list.php';
        });
      </script>";
      }
    } else {
      echo "<script>
      Swal.fire({
        title: 'Failed',
        text: 'Failed to Insert Userdata',
        icon: 'error',
        showConfirmButton: false,
        timer: 1500
      }).then(function() {
        window.location.href = 'users-list.php';
      });
    </script>";
    }
  }
}
?>
<?php
if(isset($_POST['update'])){
  $first_name = $_POST['first_name'];
  $middle = $_POST['middle'];
  $last_name = $_POST['last_name'];
  $user_id = $_POST['user_id'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password = md5($password);
  $phone = $_POST['phone'];

  $query = "UPDATE users SET first_name = '$first_name',middle = '$middle',last_name = '$last_name', username = '$username', phone = '$phone', password = '$password' WHERE user_id = '$user_id'";
  $query2 = mysqli_query($conn, $query);

  if($query2){
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
  } else {
    ?>
    <script>
      Swal.fire({
        title: 'Failed to Update Profile',
        text: 'Profile Not Updated',
        icon: 'error'
      }).then(function() {
        window.location.href = "";
      });
    </script>
    <?php
  }
}
?>