<nav class="navbar navbar-expand-lg navbar-dark shadow-lg sticky-top" aria-label="Eighth navbar example">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase" href="#">
            <?php
            $query = mysqli_query($conn, "select * from student where student_id = '$session_id'") or die(mysqli_error($conn));
            $row = mysqli_fetch_array($query);
            ?>
            <div style="display: flex; align-items: center;">
                <img src="admin/images/logo.png" alt="Logo" width="50" style="margin-right: 5px;">
                <div style="display: flex; flex-direction: column;">
                    <span style="font-weight: bold; font-size: 12px;">welcome student, </span>
                    <span style="margin-top: -6px;"><?php echo $row['firstname'] . " " . $row['lastname']; ?></span>
                </div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end align-items-center flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" href="student_dashboard.php"><i class="bi bi-arrow-bar-left"></i> my class</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" aria-current="page" href="student_map.php<?php echo '?id=' . $get_id; ?>">AREAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" href="student_retdem.php<?php echo '?id=' . $get_id; ?>">retdem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold" aria-current="page" href="student_progress.php<?php echo '?id=' . $get_id; ?>">GRADES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fw-bold active" aria-current="page" href="student_announcements.php<?php echo '?id=' . $get_id; ?>">announcements</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        $message_query = mysqli_query($conn, "select * from message where reciever_id = '$session_id' and message_status != 'read' ") or die(mysqli_error($conn));
                        $count_message = mysqli_num_rows($message_query);
                        ?>
                        <a class="nav-link text-uppercase fw-bold position-relative" aria-current="page" href="student_social.php<?php echo '?id=' . $get_id; ?>"> messages
                            <?php if ($count_message == '0') {
                            } else { ?>
                                <span class="position-absolute translate-middle p-2 bg-danger border border-light rounded-circle" style="z-index: 1;">
                                </span>
                            <?php } ?>
                        </a>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle" style="font-size: 20px;"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="student_account_settings.php"><i class="bi bi-gear"></i> Account Settings</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>