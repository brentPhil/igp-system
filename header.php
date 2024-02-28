      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex align-items-center">
          <a class="navbar-brand brand-logo" href="index.php">
           <h4 style="color: white;">EVSU-TC | IGP</h4>
          </a>
          <a class="navbar-brand brand-logo-mini" href="index.php"><img src="images/evsu_logo.png" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
          <!--<h5 class="mb-0 font-weight-medium d-none d-lg-flex">Welcome stallar dashboard!</h5>-->
          <ul class="navbar-nav navbar-nav-right ml-auto">
            <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle ml-2" src="images/evsu_logo.png" alt="Profile image"> <span class="font-weight-normal"> <?php echo $row["username"]?> </span></a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="images/evsu_logo.png" width="30%" alt="Profile image">
                  <p class="mb-1 mt-3"><?php echo $row["first_name"] .' '. $row["middle"] .' '. $row["last_name"]?></p>
                  <p class="font-weight-light text-muted mb-0">@<?php echo $row['username'];?> | <?php echo $row['user_type'];?></p>
                </div>
                <a class="dropdown-item" href="users.php"><i class="dropdown-item-icon icon-user text-primary"></i> My Profile</a>
                <a class="dropdown-item" href="include/logout.php"><i class="dropdown-item-icon icon-power text-primary"></i>Sign Out</a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
          </button>
        </div>
      </nav>