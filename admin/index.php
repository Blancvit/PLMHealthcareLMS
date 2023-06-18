<!-- index.php -->
<?php
require_once 'header.php';
?>

<body>
    <div class="container-fluid h-100 d-flex flex-column justify-content-center align-items-center mt-5">
        <div class="container p-0 rounded-3 bg-body mt-3" style="max-width: 500px;">
            <div class="container bg-body-tertiary rounded-top-3">
                <div class="container text-center text-uppercase p-2 w-75">
                    <h4><i class="bi bi-person-badge-fill me-2"></i>admin login</h4>
                </div>
            </div>
            <div class="container mb-3 p-3">
                <form id="adminLoginForm" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function() {
            jQuery("#adminLoginForm").submit(function(e) {
                e.preventDefault();
                var formData = jQuery(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "admin_login.php",
                    data: formData,
                    success: function(html) {
                        if (html.trim() === 'true') {
                            $.jGrowl("Welcome Admin!", {
                                header: 'Login Successful',
                                theme: 'bg-success'
                            });
                            var delay = 850;
                            setTimeout(function() {
                                window.location = 'admin_dashboard.php';
                            }, delay);
                        } else {
                            $.jGrowl("Please check your username and password.", {
                                header: 'Login Failed',
                                theme: 'bg-warning'
                            });
                        }
                    }
                });
                return false;
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>

</html>