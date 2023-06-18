<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php
$post_id = $_GET['post_id'];
if ($post_id == '') {
?>
    <script>
        window.location = "student_retdem.php<?php echo '?id=' . $get_id; ?>";
    </script>
<?php
}
?>

<body>
    <?php include('navbar_student_retdem.php'); ?>
    <!-- Breadcrumb -->
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
                            <a class="link-body-emphasis fw-semibold text-decoration-none">School Year: <?php echo $class_row['school_year']; ?></a>

                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-body-emphasis fw-semibold text-decoration-none"> <?php echo $class_row['class_name']; ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-body-emphasis fw-semibold text-decoration-none"> <?php echo $class_row['subject_code']; ?></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-body-emphasis fw-semibold text-decoration-none" href="student_retdem.php<?php echo '?id=' . $get_id; ?>"> Return Demonstration</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Submit RETDEM
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="container d-flex">
                <!-- Submit RETDEM -->
                <?php
                // Check if the student has already submitted an assignment
                $submission_query = mysqli_query($conn, "SELECT * FROM student_assignment WHERE assignment_id = '$post_id' AND student_id = '$session_id'") or die(mysqli_error($conn));
                $has_submission = mysqli_num_rows($submission_query) > 0;

                if (!$has_submission) { // Display the assignment submission form if the student hasn't submitted yet
                ?>
                    <div class="container bg-body rounded-3 p-0 mb-4 me-3" style="flex: 1;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                            <?php
                            $query1 = mysqli_query($conn, "select * FROM assignment where assignment_id = '$post_id'") or die(mysqli_error($conn));
                            $row1 = mysqli_fetch_array($query1);
                            ?>
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;">Submit RETDEM in : <?php echo $row1['fname']; ?></h4>
                            </div>
                            <a href="student_retdem.php<?php echo '?id=' . $get_id; ?>">
                                <button class="btn btn-outline-secondary mt-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                            </a>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center p-3">
                                <form id="upload_assignment" method="post">
                                    <div class="mb-3">
                                        <div class="">
                                            <label class="form-label" for="file">(Optional)</label>
                                            <input name="uploaded_file" class="form-control" id="fileInput" type="file" accept=".pdf, .doc, .docx, .jpg, .png, .mp4, .mov, .avi">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="500000000" />
                                            <input type="hidden" name="id" value="<?php echo $post_id; ?>" />
                                            <input type="hidden" name="get_id" value="<?php echo $get_id; ?>" />
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="controls">
                                            <input type="text" name="name" Placeholder="File Name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="controls">
                                            <input type="text" name="link" Placeholder="OneDrive Video Link" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="controls">
                                            <input type="text" name="desc" Placeholder="Description" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="controls">
                                            <button name="Upload" type="submit" value="Upload" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- RETDEM Records -->
                <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 mb-4 ms-3" style="flex: 1;">
                    <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                        <?php
                        $query1 = mysqli_query($conn, "SELECT * FROM assignment WHERE assignment_id = '$post_id'") or die(mysqli_error($conn));
                        $row1 = mysqli_fetch_array($query1);
                        ?>
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;">submitted retdem in: <?php echo $row1['fname']; ?></h4>
                        </div>

                        <?php
                        // Check if there are submitted assignments
                        $query = mysqli_query($conn, "SELECT * FROM student_assignment WHERE assignment_id = '$post_id'") or die(mysqli_error($conn));
                        $count = mysqli_num_rows($query);

                        if ($count > 0) {
                            // Get the grade for the assignment
                            $grade_query = mysqli_query($conn, "SELECT grade FROM student_assignment WHERE assignment_id = '$post_id'") or die(mysqli_error($conn));
                            $grade_row = mysqli_fetch_array($grade_query);
                            $grade = $grade_row['grade'];

                            if (empty($grade)) {
                        ?>
                                <a href="student_retdem.php<?php echo '?id=' . $get_id; ?>">
                                    <button class="btn btn-outline-secondary mt-1 me-2"><i class="bi bi-arrow-bar-left"></i> Back</button>
                                </a>
                                <form method="post">
                                    <button class="btn btn-warning mt-1 text-uppercase fw-bold" name="resubmit">
                                        <i class="bi bi-arrow-counterclockwise"></i> Resubmit
                                    </button>
                                </form>
                            <?php
                            } else {
                            ?>
                                <a href="student_retdem.php<?php echo '?id=' . $get_id; ?>">
                                    <button class="btn btn-outline-secondary mt-1 me-2"><i class="bi bi-arrow-bar-left"></i> Back</button>
                                </a>
                        <?php
                            }
                        }
                        ?>
                        <?php
                        // Add the delete assignment functionality
                        if (isset($_POST['resubmit'])) {
                            $delete_query = mysqli_query($conn, "DELETE FROM student_assignment WHERE assignment_id = '$post_id'") or die(mysqli_error($conn));

                            if ($delete_query) {
                                // Redirect to the same page after deletion
                                echo '<script>window.location.href="student_submit_assignment.php?id=' . $get_id . '&post_id=' . $post_id . '";</script>';
                                exit;
                            }
                        }
                        ?>
                    </div>

                    <div class="container justify-content-sm-center">
                        <div class="row justify-content-center">
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM student_assignment 
                            LEFT JOIN student ON student.student_id  = student_assignment.student_id
                            WHERE assignment_id = '$post_id'  ORDER BY assignment_fdatein DESC") or die(mysqli_error($conn));
                            $count = mysqli_num_rows($query);
                            if ($count == '0') { ?>
                                <div class="container p-4">
                                    <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> No RETDEM Submitted</div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="text-uppercase px-4 py-2 fw-bold" style="white-space: nowrap;">
                                    <?php
                                    while ($row = mysqli_fetch_array($query)) {
                                        $id = $row['student_assignment_id'];
                                        $student_id = $row['student_id'];
                                    ?>
                                        <div class="mb-3">
                                            <label class="form-label" for="date_uploaded">Date uploaded:</label>
                                            <div class="input-group">
                                                <input class="form-control" value="<?php echo $row['assignment_fdatein']; ?>" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="date_uploaded">File Name:</label>
                                            <div class="input-group">
                                                <input class="form-control" value="<?php echo $row['fname']; ?>" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="date_uploaded">OneDrive Video Link:</label>
                                            <div class="input-group">
                                                <input class="form-control" value="<?php echo $row['vidlink']; ?>" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="date_uploaded">Description:</label>
                                            <div class="input-group">
                                                <input class="form-control" value="<?php echo $row['fdesc']; ?>" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="date_uploaded">Submitted By:</label>
                                            <div class="input-group">
                                                <input class="form-control" value="<?php echo $row['firstname'] . " " . $row['lastname']; ?>" disabled readonly>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="date_uploaded">Grade:</label>
                                            <div class="input-group">
                                                <?php if ($session_id == $student_id) { ?>
                                                    <?php if ($row['grade'] != null) { ?>
                                                        <span class="badge bg-success fs-5"><?php echo $row['grade']; ?></span>
                                                    <?php } else { ?>
                                                        <span class="badge bg-secondary fs-5">NOT GRADED</span>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($) {
            $("#upload_assignment").submit(function(e) {

                e.preventDefault();
                var formData = jQuery(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "student_upload_assignment.php",
                    data: formData,
                    success: function(html) {
                        $.jGrowl("Successfully Uploaded", {
                            header: 'RETDEM Added',
                            theme: 'bg-success'
                        });
                        var delay = 1000;
                        setTimeout(function() {
                            window.location = 'student_submit_assignment.php<?php echo '?id=' . $get_id . '&' . 'post_id=' . $post_id; ?>';
                        }, delay);
                    },
                });
                return false;
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>