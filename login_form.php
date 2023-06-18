<!-- login_form.php -->
<div class="role-selection d-flex justify-content-center align-items-center">
    <button class="btn btn-warning btn-lg me-2 fw-medium" id="student-button" data-bs-toggle="modal" data-bs-target="#studentModal">
        <i class="bi bi-person-fill"></i> Student
    </button>
    <button class="btn btn-warning btn-lg fw-medium" id="teacher-button" data-bs-toggle="modal" data-bs-target="#teacherModal">
        <i class="bi bi-person-badge-fill"></i> Teacher
    </button>
</div>

<!-- Student Login Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel"><i class="bi bi-person-fill"></i> Student Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="studentLoginForm" method="post">
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
</div>

<!-- Teacher Login Modal -->
<div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teacherModalLabel"><i class="bi bi-person-badge-fill"></i> Teacher Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="teacherLoginForm" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        jQuery("#studentLoginForm").submit(function(e) {
            e.preventDefault();
            var formData = jQuery(this).serialize();
            $.ajax({
                type: "POST",
                url: "login_student.php",
                data: formData,
                success: function(html) {
                    if (html.trim() === 'true_student') {
                        $.jGrowl("Welcome to the PLM Healthcare Learning System", {
                            header: 'Login Successful',
                            theme: 'bg-success'
                        });
                        var delay = 850;
                        setTimeout(function() {
                            window.location = 'student_dashboard.php';
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

<script>
    jQuery(document).ready(function() {
        jQuery("#teacherLoginForm").submit(function(e) {
            e.preventDefault();
            var formData = jQuery(this).serialize();
            $.ajax({
                type: "POST",
                url: "login_teacher.php",
                data: formData,
                success: function(html) {
                    if (html.trim() === 'true_teacher') {
                        $.jGrowl("Welcome to the PLM Healthcare Learning System", {
                            header: 'Login Successful',
                            theme: 'bg-success'
                        });
                        var delay = 850;
                        setTimeout(function() {
                            window.location = 'teacher_dashboard.php';
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