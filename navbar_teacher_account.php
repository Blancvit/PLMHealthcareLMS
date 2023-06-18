<nav class="navbar navbar-expand-lg navbar-dark shadow-lg sticky-top" aria-label="Eighth navbar example">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase" href="#">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM teacher WHERE teacher_id = '$session_id'") or die(mysqli_error($conn));
            $row = mysqli_fetch_array($query);
            ?>
            <div style="display: flex; align-items: center;">
                <img src="admin/images/logo.png" alt="Logo" width="50" style="margin-right: 5px;">
                <div style="display: flex; flex-direction: column;">
                    <span style="font-weight: bold; font-size: 12px;">WELCOME teacher,</span>
                    <span style="margin-top: -6px;"><?php echo $row['firstname'] . " " . $row['lastname']; ?></span>
                </div>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-person-circle"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-uppercase fw-bold" href="#" onclick="goBack()"><i class="bi bi-arrow-bar-left"></i> back</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-badge-fill" style="font-size: 20px;"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="teacher_account_settings.php"><i class="bi bi-gear"></i> Account Settings</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    function goBack() {
        window.history.go(-1);
    }
</script>