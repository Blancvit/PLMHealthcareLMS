<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body vh-100">
        <?php include('sidebar_subjects.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-3">
                <div class="col text-uppercase pt-1 px-2">
                    <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i> ADD subject</h4>
                </div>
                <a href="admin_subjects.php">
                    <button class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                </a>
            </div>
            <div class="container bg-body-tertiary rounded-3 p-3">
                <form method="post" id="add_subject">
                    <div class="mb-3">
                        <label class="form-label">Subject Code:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="subject_code" id="inputEmail" required></input>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject Title:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="title" id="inputPassword" required></input>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Units:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="unit" id="inputPassword" required></input>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester:</label>
                        <div class="input-group">
                            <select class="form-select" name="semester">
                                <option value="" disabled selected class="text-muted">Select Semester</option>
                                <option>1st</option>
                                <option>2nd</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                    </div>

                    <button name="post" type="submit" value="post" class="btn btn-warning"><i class="bi bi-plus-square-fill me-2"></i> Add</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#add_subject').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: 'admin_add_subject_save.php',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        response = JSON.parse(response); // Parse the JSON response

                        if (response.status === 'success') {
                            // Display a success message using jGrowl
                            $.jGrowl('Subject added successfully!', {
                                header: 'Success',
                                theme: 'bg-success',
                                life: 3000
                            });

                            // Reload the page after a delay
                            setTimeout(function() {
                                location.reload();
                            }, 1000); // Adjust the delay as needed
                        } else {
                            // Display an error message using jGrowl
                            $.jGrowl(response.message, {
                                header: 'Error',
                                theme: 'bg-danger',
                                life: 3000
                            });
                        }
                    },
                });
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>