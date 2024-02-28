      <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Administrator" ): ?>
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="images/evsu_logo.png" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?php echo $row['username']; ?></p>
                  <p class="designation"><?php echo $row['user_type']; ?></p>
                </div>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'index') ? 'active':''; ?>">
              <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'users-list') ? 'active':''; ?>">
              <a class="nav-link" href="users-list.php">
                <span class="menu-title">Users List</span>
                <i class="icon-people menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'project') ? 'active':''; ?>">
              <a class="nav-link" href="project.php">
                <span class="menu-title">Project</span>
                <i class="icon-briefcase menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'tenants') ? 'active':''; ?>">
              <a class="nav-link" href="tenants.php">
                <span class="menu-title">Tenants</span>
                <i class="icon-handbag menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'faculty') ? 'active':''; ?>">
              <a class="nav-link" href="faculty_list.php">
                <span class="menu-title">Faculty</span>
                <i class="icon-user menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'billingevsu') ? 'active' : ''; ?>">
              <a class="nav-link" href="billingevsu.php">
                <span class="menu-title">Billing</span>
                <?php
                    $result = mysqli_query($conn, "SELECT COUNT(*) AS count_receipts FROM billing WHERE c_receipt IS NOT NULL AND status = 0");
                    $row = mysqli_fetch_array($result);
                    $badge_count = $row['count_receipts'];
                ?>
                <?php if ($badge_count > 0): ?>
                    <span class="badge badge-danger"><?php echo $badge_count; ?></span>
                <?php endif; ?>
                <i class="icon-briefcase menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'reports') ? 'active':''; ?>">
              <a class="nav-link" href="reports.php">
                <span class="menu-title">Reports</span>
                <i class="icon-flag menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'inventory') ? 'active':''; ?>">
              <a class="nav-link" href="inventory.php">
                <span class="menu-title">Inventory</span>
                <?php
                    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM requests");
                    $row = mysqli_fetch_array($result);
                    $badge_count = $row['total'];
                ?>
                <?php if ($badge_count > 0): ?>
                    <span class="badge badge-danger"><?php echo $badge_count; ?></span>
                <?php endif; ?>
                <i class="icon-handbag menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'inventory_logs') ? 'active':''; ?>">
              <a class="nav-link" href="inventory_logs.php">
                <span class="menu-title">Inventory Logs</span>
                <i class="icon-list menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>

      <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Staff" ): ?>
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="images/evsu_logo.png" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?php echo $row["first_name"] .' '. $row["middle"] .' '. $row["last_name"]; ?></p>
                  <p class="designation"><?php echo $row['user_type']; ?></p>
                </div>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'index') ? 'active':''; ?>">
              <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'users-list') ? 'active':''; ?>">
              <a class="nav-link" href="users-list.php">
                <span class="menu-title">Users List</span>
                <i class="icon-people menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'project') ? 'active':''; ?>">
              <a class="nav-link" href="project.php">
                <span class="menu-title">Project</span>
                <i class="icon-briefcase menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'tenants') ? 'active':''; ?>">
              <a class="nav-link" href="tenants.php">
                <span class="menu-title">Tenants</span>
                <i class="icon-handbag menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'billing-evsu') ? 'active':''; ?>">
              <a class="nav-link" href="billingevsu.php">
                <span class="menu-title">Billing</span>
                <?php
                    $result = mysqli_query($conn, "SELECT COUNT(*) AS count_receipts FROM billing WHERE c_receipt IS NOT NULL AND status = 0");
                    $row = mysqli_fetch_array($result);
                    $badge_count = $row['count_receipts'];
                ?>
                <?php if ($badge_count > 0): ?>
                    <span class="badge badge-danger"><?php echo $badge_count; ?></span>
                <?php endif; ?>
                <i class="icon-briefcase menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>

      <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Concessionaires" ): ?>
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="images/evsu_logo.png" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?php echo $row["fn"] .' '. $row["mn"] .' '. $row["ln"]; ?></p>
                  <p class="designation"><?php echo $row['user_type']; ?></p>
                </div>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'index') ? 'active':''; ?>">
              <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'billing') ? 'active':''; ?>">
              <a class="nav-link" href="billing.php">
                <span class="menu-title">Billing</span>
                <i class="icon-briefcase menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>

      <?php if ( isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Faculty" ): ?>
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="images/evsu_logo.png" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?php echo $row["first_name"] .' '. $row["middle"] .' '. $row["last_name"]; ?></p>
                  <p class="designation"><?php echo $row['user_type']; ?></p>
                </div>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'index') ? 'active':''; ?>">
              <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'inventory') ? 'active':''; ?>">
              <a class="nav-link" href="inventory.php">
                <span class="menu-title">Inventory</span>
                <i class="icon-people menu-icon"></i>
              </a>
            </li>
            <li class="nav-item <?= ($activePage == 'inventory_logs') ? 'active':''; ?>">
              <a class="nav-link" href="inventory_logs.php">
                <span class="menu-title">Inventory Logs</span>
                <i class="icon-people menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>
      <?php endif; ?>