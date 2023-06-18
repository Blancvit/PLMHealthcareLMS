<nav class="navbar navbar-expand-lg navbar-dark shadow-lg sticky-top" aria-label="Eighth navbar example">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase" href="#">
            <div style="display: flex; align-items: center;">
                <img src="images/logo.png" alt="Logo" width="50" style="margin-right: 5px;">
                <div style="display: flex; flex-direction: column;">
                    <span style="font-weight: bold; font-size: 12px;">welcome admin, </span>
                    <span style="margin-top: -6px;">Plm-lms admin panel</span>
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
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-badge-fill" style="font-size: 20px;"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>