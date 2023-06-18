<?php
include('session.php');
include('header.php');
$get_id = $_GET['id'];
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body vh-100">
        <?php include('sidebar_subjects.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-3">
                <div class="col text-uppercase pt-1 px-2">
                    <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-pencil-square me-2"></i> edit subject</h4>
                </div>
                <a href="admin_subjects.php">
                    <button class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                </a>
            </div>
            <div class="container bg-body-tertiary rounded-3 p-3">
                <?php
                $query = mysqli_query($conn, "select * from subject where subject_id = '$get_id'") or die(mysqli_error($conn));
                $row = mysqli_fetch_array($query);
                ?>
                <form method="post" id="edit_subject">
                    <div class="mb-3">
                        <label class="form-label">Subject Code:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" value="<?php echo $row['subject_code']; ?>" name="subject_code" id="inputEmail" required></input>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject Title:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" value="<?php echo $row['subject_title']; ?>" name="title" id="inputPassword" required></input>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Units:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" value="<?php echo $row['unit']; ?>" name="unit" id="inputPassword" required></input>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description:</label>
                        <div class="input-group">
                            <textarea class="form-control" name="description"><?php echo $row['description']; ?></textarea>
                        </div>
                    </div>

                    <button name="post" type="submit" value="post" class="btn btn-warning"><i class="bi bi-pencil-square me-2"></i> Save</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Submit form using AJAX
            $('#edit_subject').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: 'admin_edit_subject_save.php<?php echo '?id=' . $get_id; ?>', // Replace with your AJAX handler URL
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        // Display success notification
                        $.jGrowl("Edit Successful!", {
                            header: 'Success',
                            theme: 'bg-success',
                            life: 2000
                        });
                        // Reload the page after a delay
                        setTimeout(function() {
                            location.reload();
                        }, 1500); // Adjust the delay as needed
                    },
                    error: function() {
                        // Display error notification
                        $.jGrowl("Error Editing. Please try again later.", {
                            header: 'Error',
                            theme: 'bg-danger',
                            life: 2000
                        });
                    }
                });
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>