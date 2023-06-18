<?php
include('session.php');
include('header.php');
?>
<?php $get_id = $_GET['id']; ?>
<?php $post_id = $_GET['post_id']; ?>

<body>
    <?php include('navbar_teacher.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex">
        <?php include('teacher_sidebar_demonstration.php'); ?>
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
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Submitted Demonstrations</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Demonstrations
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap flex-column flex-sm-row">
                    <div class="container bg-body rounded-3 p-0 mb-3" style="overflow-y: auto; height: 550px; max-height: 550px;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <?php
                            $query1 = mysqli_query($conn, "SELECT * FROM assignment WHERE assignment_id = '$post_id'") or die(mysqli_error($conn));
                            $row1 = mysqli_fetch_array($query1);
                            ?>
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-list-task me-2"></i> SUBMITTED REtdem in: <?php echo $row1['fname']; ?></h4>
                            </div>
                            <a href="teacher_demonstration.php<?php echo '?id=' . $get_id ?>">
                                <button class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                            </a>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center p-3">
                                <div class="container justify-content-sm-center">
                                    <div class="row justify-content-center">
                                        <?php
                                        $query = mysqli_query($conn, "select * FROM student_assignment 
										LEFT JOIN student on student.student_id  = student_assignment.student_id
										where assignment_id = '$post_id'  order by assignment_fdatein DESC") or die(mysqli_error($conn));
                                        $count = mysqli_num_rows($query);
                                        if ($count == '0') { ?>
                                            <div class="container p-4">
                                                <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> No Student(s) RETDEM Submitted</div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="table-responsive-lg">
                                                <table class="table table-striped p-3 text-center align-middle" id="">
                                                    <thead>
                                                        <tr class="text-uppercase">
                                                            <th>date uploaded</th>
                                                            <th>file name</th>
                                                            <th>description</th>
                                                            <th>link</th>
                                                            <th>submitted by:</th>
                                                            <th>grade</th>
                                                            <th>download file</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class=" table-group-divider">

                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT * FROM student_assignment 
										LEFT JOIN student ON student.student_id  = student_assignment.student_id
										WHERE assignment_id = '$post_id'  order by assignment_fdatein DESC") or die(mysqli_error($conn));
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $id  = $row['student_assignment_id'];
                                                        ?>
                                                            <tr class="message-box" id="del<?php echo $id; ?>">
                                                                <td><?php echo $row['assignment_fdatein']; ?></td>
                                                                <td><?php echo $row['fname']; ?></td>
                                                                <td><?php echo $row['fdesc']; ?></td>
                                                                <td>
                                                                    <a class="badge bg-info text-dark" href="<?php echo $row['vidlink']; ?>" target="_blank"><?php echo $row['vidlink']; ?></a>
                                                                </td>
                                                                <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                                                                <td>
                                                                    <form method="post" id="save_grade">
                                                                        <input type="hidden" class="span4" name="id" value="<?php echo $id; ?>">
                                                                        <input type="hidden" class="span4" name="post_id" value="<?php echo $post_id; ?>">
                                                                        <input type="hidden" class="span4" name="get_id" value="<?php echo $get_id; ?>">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control form-control-sm text-center" name="grade" value="<?php echo $row['grade']; ?>" style="width: 50px;" required>
                                                                            <button name="save" class="btn btn-success" id="btn_s"><i class="icon-save"></i> Save</button>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                                <td><a class="btn btn-info" href="<?php echo $row['floc']; ?>"><i class="bi bi-download"></i></a></td>
                                                            </tr>


                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } ?>
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
                // Submit form using AJAX
                $('#save_grade').submit(function(e) {
                    e.preventDefault();

                    // Display loading spinner
                    $.jGrowl("Saving Grade...", {
                        header: 'Info',
                        theme: 'bg-info',
                        life: 2000
                    });

                    $.ajax({
                        url: 'teacher_save_grade.php<?php echo '?id=' . $get_id ?>&<?php echo 'post_id=' . $id ?>', // Replace with your AJAX handler URL
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {

                            // Display success notification
                            $.jGrowl("Grade saved successfully!", {
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
                            $.jGrowl("Error saving Grade. Please try again later.", {
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