<?php include('session.php'); ?>
<?php include('header.php'); ?>

<body>
    <?php include('navbar_teacher.php'); ?>

    <div class="d-flex">
        <?php include('teacher_sidebar_add_demo.php'); ?>
        <div class="container-fluid my-4 justify-content-center pb-5">
            <div class="container mx-auto">
                <div class="container py-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-body rounded-3 p-3">
                            <?php
                            $school_year_query = mysqli_query($conn, "select * from school_year order by school_year DESC") or die(mysqli_error($conn));
                            $school_year_query_row = mysqli_fetch_array($school_year_query);
                            $school_year = $school_year_query_row['school_year'];
                            ?>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">School Year: <?php echo $school_year_query_row['school_year']; ?></a>
                            </li>
                            <li class="breadcrumb-item active">
                                Add Demonstration
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap">
                    <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 mb-4" style="flex: 1;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;">
                                    <i class="bi bi-clipboard-plus-fill me-2"></i> Add Demonstration
                                </h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center p-5">
                            <div class="col justify-content-center">
                                <form method="post" id="add_demo">
                                    <div class="mb-3">
                                        <div class="">
                                            <input name="uploaded_file" class="form-control" id="fileInput" type="file" accept=".pdf, .doc, .docx, .jpg, .png, .mp4, .mov, .avi">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="500000000" />
                                            <input type="hidden" name="id" value="<?php echo $post_id; ?>" />
                                            <input type="hidden" name="get_id" value="<?php echo $get_id; ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="controls">
                                            <input type="text" name="name" Placeholder="Task Name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="controls">
                                            <input type="datetime-local" name="deadline" Placeholder="OneDrive Video Link" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="controls">
                                            <textarea type="text" name="desc" Placeholder="Description" class="form-control" required></textarea>
                                        </div>
                                    </div>
                            </div>

                            <hr>
                            <div class="col justify-content-center">
                                <div class="table-responsive-lg">
                                    <table class="table table-striped align-middle text-center justify-content-center" id="">
                                        <div class="alert alert-info p-2">
                                            <h5><i class="bi bi-info-circle"></i> Select a class to post Demonstration</h5>
                                        </div>
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th><input class="form-check-input" type="checkbox" name="selectAll" id="checkAll" /></th>
                                                <script>
                                                    $("#checkAll").click(function() {
                                                        $('input:checkbox').not(this).prop('checked', this.checked);
                                                    });
                                                </script>
                                                <th>Class Name</th>
                                                <th>Subject Code</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $query = mysqli_query($conn, "SELECT * FROM teacher_class
                                            LEFT JOIN class ON class.class_id = teacher_class.class_id
                                            LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                                            WHERE teacher_id = '$session_id' AND school_year = '$school_year' ORDER BY class_name ASC") or die(mysqli_error($conn));
                                            $count = mysqli_num_rows($query);
                                            while ($row = mysqli_fetch_array($query)) {
                                                $id = $row['teacher_class_id'];
                                            ?>
                                                <tr id="del<?php echo $id; ?>">
                                                    <td width="30">
                                                        <input id="" class="form-check-input" id="selector_<?php echo $id; ?>" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                                    </td>
                                                    <td><?php echo $row['class_name']; ?></td>
                                                    <td><?php echo $row['subject_code']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <button name="post" type="submit" value="post" class="btn btn-warning"><i class="bi bi-plus-square-fill me-1"></i> Post</button>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#add_demo').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Check if at least one class is selected
                var selectedClasses = $("input[name='selector[]']:checked");
                if (selectedClasses.length === 0) {
                    // Show error message using jGrowl
                    $.jGrowl('Please select at least one class.', {
                        header: 'Warning',
                        theme: 'bg-warning',
                        life: 3000
                    });
                    return; // Exit the function
                }

                // Display loading spinner
                $.jGrowl("Posting announcement(s)...", {
                    header: 'Info',
                    theme: 'bg-info',
                    life: 2000
                });

                // Create a FormData object to store the form data
                var formData = new FormData($('#add_demo')[0]);

                // Make an AJAX request to the PHP file
                $.ajax({
                    url: 'teacher_add_demo_save.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle the response
                        if (response.success) {
                            // Show success message using jGrowl
                            $.jGrowl('Demonstration posted successfully!', {
                                theme: 'bg-success',
                                header: 'Success',
                                life: 3000
                            });

                            // Reload the page after a delay
                            setTimeout(function() {
                                location.reload();
                            }, 1500); // Adjust the delay as needed

                        } else {
                            // Show error message using jGrowl
                            $.jGrowl('Error posting demonstration. Please try again later.', {
                                header: 'Error',
                                theme: 'bg-danger',
                                life: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Show error message using jGrowl
                        $.jGrowl('Error posting demonstration. Please try again later.', {
                            header: 'Error',
                            theme: 'bg-danger',
                            life: 3000
                        });
                    }
                });
            });
        });
    </script>


    <?php include('scripts.php'); ?>
</body>