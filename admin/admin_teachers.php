<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body">
        <?php include('sidebar_teachers.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container bg-body-tertiary mb-3 mx-0 p-2 rounded-3">
                <div class="col text-uppercase pt-1 px-2">
                    <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i>add teacher</h4>
                </div>
                <hr>
                <div class="container d-flex">
                    <div class="container">
                        <form method="post" id="add_teachers">
                            <div class="mb-3">
                                <label class="form-label">ID Number:</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="un" required></input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">First Name:</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="firstname" required></input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name:</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="lastname" required></input>
                                </div>
                            </div>
                            <button name="save" type="submit" value="post" class="btn btn-warning mb-3"><i class="bi bi-plus-square-fill me-2"></i> Add</button>
                        </form>
                    </div>

                    <div class="container">
                        <form action="import_teacher.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">File (.csv):</label>
                                <input type="file" name="import_file" class="form-control" />
                            </div>
                            <button type="submit" name="save_excel_data" class="btn btn-warning"><i class="bi bi-upload me-2"></i>Import</button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="container bg-body-tertiary rounded-3 p-2 table-responsive-lg" style="height: 550px; max-height: 550px;">
                <form method="post">
                    <div class="container d-flex text-uppercase pt-1 px-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-people-fill me-2"></i> teacher list</h4>
                        </div>
                        <a class="btn btn-danger remove"><i class="bi bi-trash-fill"></i></a>
                    </div>
                    <hr>
                    <table class="table table-striped align-middle justify-content-center" id="example">
                        <thead>
                            <tr class="text-uppercase text-center">
                                <th><input class="form-check-input" type="checkbox" name="selectAll" id="checkAll" /></th>
                                <script>
                                    $("#checkAll").click(function() {
                                        $('input:checkbox').not(this).prop('checked', this.checked);
                                    });
                                </script>
                                <th>Name</th>
                                <th>Username / ID Number</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody class=" table-group-divider">
                            <?php
                            $teacher_query = mysqli_query($conn, "SELECT * FROM teacher") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($teacher_query)) {
                                $id = $row['teacher_id'];
                                $teacher_stat = $row['teacher_stat'];
                            ?>
                                <tr id="del<?php echo $id; ?>">
                                    <td>
                                        <input id="optionsCheckbox" class="form-check-input" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                    </td>
                                    <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['teacher_status']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <script>
                            $(document).ready(function() {
                                $('#example').DataTable();
                            });
                        </script>
                    </table>
                </form>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#add_teachers').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    $.ajax({
                        url: 'admin_add_teacher_save.php',
                        type: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            response = JSON.parse(response); // Parse the JSON response

                            if (response.status === 'success') {
                                // Display a success message using jGrowl
                                $.jGrowl('Teacher added successfully!', {
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

        <script>
            $(document).ready(function() {
                // Remove button click event
                $('.remove').click(function() {
                    var selectedTeacher = [];

                    // Get the selected subject IDs
                    $('input[name="selector[]"]:checked').each(function() {
                        selectedTeacher.push($(this).val());
                    });

                    if (selectedTeacher.length === 0) {
                        // No subjects selected, display an error message
                        $.jGrowl("No teacher(s) selected for removal.", {
                            header: 'Error',
                            theme: 'bg-warning',
                            life: 2000
                        });
                    } else {
                        // Confirm the deletion with the user
                        if (confirm("Are you sure you want to remove the selected teachers?")) {
                            // Perform AJAX request for deletion
                            $.ajax({
                                url: 'admin_teacher_delete.php',
                                type: 'POST',
                                data: {
                                    selector: selectedTeacher
                                },
                                success: function(response) {
                                    if (response === 'success') {
                                        // Deletion succeeded
                                        $.jGrowl("Teacher(s) removed successfully.", {
                                            header: 'Success',
                                            theme: 'bg-success',
                                            life: 2000
                                        });
                                        // Reload the page after a delay
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1500);
                                    } else {
                                        // Deletion failed
                                        $.jGrowl("Error removing teachers. Please try again later.", {
                                            header: 'Error',
                                            theme: 'bg-danger',
                                            life: 2000
                                        });
                                    }
                                },
                                error: function() {
                                    // Display error message
                                    $.jGrowl("Error removing teachers. Please try again later.", {
                                        header: 'Error',
                                        theme: 'bg-danger',
                                        life: 2000
                                    });
                                }
                            });
                        }
                    }
                });
            });
        </script>

        <?php include('scripts.php'); ?>
</body>