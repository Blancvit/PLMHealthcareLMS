<?php
include('session.php');
include('header.php');
?>
<?php $get_id = $_GET['id']; ?>

<body>
    <?php include('navbar_teacher.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex">
        <?php include('teacher_sidebar_subject_overview.php'); ?>
        <div class="container-fluid my-4 justify-content-center pb-5">
            <div class="container mx-auto">
                <div class="container py-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-body rounded-3 p-3">
                            <?php $class_query = mysqli_query($conn, "select * from teacher_class
	LEFT JOIN class ON class.class_id = teacher_class.class_id
	LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
	where teacher_class_id = '$get_id'") or die(mysqli_error($conn));
                            $class_row = mysqli_fetch_array($class_query);
                            ?>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">School Year: <?php echo $school_year_query_row['school_year']; ?></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#"><?php echo $class_row['class_name']; ?></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#"><?php echo $class_row['subject_code']; ?></a>
                            </li>
                            <li class="breadcrumb-item active">
                                Subject Overview
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap flex-column flex-sm-row">

                    <!-- MY CLASS DIV -->
                    <div class="container bg-body rounded-3 p-0 mb-3" style="overflow-y: auto; height: 550px; max-height: 550px; flex: 1;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-top-3">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-card-heading me-2"></i> subject overview</h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center">
                                <div class="col justify-content-center">
                                    <div class="table-responsive-lg p-3">
                                        <form method="post" id="edit_subject">
                                            <?php $query = mysqli_query($conn, "select * from teacher_class
                                            LEFT JOIN class_subject_overview ON class_subject_overview.teacher_class_id = teacher_class.teacher_class_id
                                            where class_subject_overview.teacher_class_id = '$get_id'") or die(mysqli_error($conn));
                                            $row = mysqli_fetch_array($query);
                                            $id = $row['class_subject_overview_id'] ?? '';
                                            $count = mysqli_num_rows($query);
                                            if ($count > 0) {
                                            ?>
                                                <div class="container">
                                                    <h3>
                                                        <?php echo $row['content'] ?? ''; ?>
                                                    </h3>
                                                </div>
                                                <hr>
                                                <div class="mb-3">
                                                    <label class="form-label">Subject Overview Content: </label>
                                                    <div class="controls">
                                                        <textarea type="text" name="content" Placeholder="Description" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <button class="btn btn-success" name="save" type="submit">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>
                                        </form>
                                    <?php } else { ?>
                                        <form method="post" id="add_subject">
                                            <div class="mb-3">
                                                <label class="form-label">Subject Overview Content: </label>
                                                <div class="controls">
                                                    <textarea type="text" name="subject_content" Placeholder="Description" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <button class="btn btn-success add_subject" type="submit">
                                                <i class="bi bi-pencil-square me-1"></i> Add Subject Interview
                                            </button>
                                        </form>
                                    <?php } ?>

                                    </div>
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
            $('#edit_subject').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var get_id = '<?php echo $get_id; ?>';
                var id = '<?php echo $id; ?>';

                $.ajax({
                    url: 'teacher_edit_subject_overview.php?id=' + get_id + '&subject_id=' + id,
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Subject overview edited successfully
                            $.jGrowl("Subject Overview Edited Successfully!", {
                                header: 'Success',
                                theme: 'bg-success',
                                life: 3000
                            });
                            // Reload the page after a delay
                            setTimeout(function() {
                                location.reload();
                            }, 1000); // Adjust the delay as needed
                        } else if (response.error) {
                            // Display error message
                            $.jGrowl(response.message, {
                                header: 'Error',
                                theme: 'bg-warning',
                                life: 3000
                            });
                        } else {
                            // Handle other cases or display a generic message
                            $.jGrowl("An error occurred. Please try again later.", {
                                header: 'Error',
                                theme: 'bg-warning',
                                life: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Display an error message using jGrowl
                        $.jGrowl('An error occurred. Please try again later.', {
                            header: 'Error',
                            theme: 'bg-danger',
                            life: 3000
                        });
                    }
                });
            });

            $('#add_subject').on('submit', function(e) {
                e.preventDefault(); // Prevent the default button action

                var get_id = '<?php echo $get_id; ?>';
                var id = '<?php echo $id; ?>';
                var content = $('textarea[name="subject_content"]').val();

                $.ajax({
                    url: 'teacher_add_subject_overview.php?id=' + get_id + '&subject_id=' + id,
                    type: 'POST',
                    data: {
                        subject_content: content
                    }, // Send the subject content in the request
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Subject overview added successfully
                            $.jGrowl("Subject Overview Added Successfully!", {
                                header: 'Success',
                                theme: 'bg-success',
                                life: 3000
                            });
                            // Reload the page after a delay
                            setTimeout(function() {
                                location.reload();
                            }, 1000); // Adjust the delay as needed
                        } else if (response.error) {
                            // Display error message
                            $.jGrowl(response.message, {
                                header: 'Error',
                                theme: 'bg-warning',
                                life: 3000
                            });
                        } else {
                            // Handle other cases or display a generic message
                            $.jGrowl("An error occurred. Please try again later.", {
                                header: 'Error',
                                theme: 'bg-warning',
                                life: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Display an error message using jGrowl
                        $.jGrowl('An error occurred. Please try again later.', {
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