<?php
include('session.php');
include('header.php');
?>
<?php $get_id = $_GET['id']; ?>

<body>
    <?php include('navbar_teacher.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex">
        <?php include('teacher_sidebar_my_students.php'); ?>
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
                                Add Student(s)
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap flex-column flex-sm-row">

                    <!-- MY CLASS DIV -->
                    <div class="container bg-body rounded-3 p-0 mb-3" style="overflow-y: auto; height: 550px; max-height: 550px; flex: 1;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-top-3">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i> add student</h4>
                            </div>
                            <?php
                            $my_student = mysqli_query($conn, "SELECT * FROM teacher_class_student
														LEFT JOIN student ON student.student_id = teacher_class_student.student_id 
														INNER JOIN class ON class.class_id = student.class_id where teacher_class_id = '$get_id' order by lastname ") or die(mysqli_error($conn));
                            $count_my_student = mysqli_num_rows($my_student); ?>
                            <div>
                                <a href="teacher_my_students.php<?php echo '?id=' . $get_id; ?>">
                                    <button class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                                </a>
                                <span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count_my_student; ?></span>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center">
                                <div class="col justify-content-center">
                                    <div class="table-responsive-lg p-3">
                                        <form method="post" id="addStudentForm">
                                            <table class="table table-striped align-middle justify-content-center" id="example">
                                                <thead>
                                                    <tr class="text-uppercase text-center">
                                                        <th>photo</th>
                                                        <th>name</th>
                                                        <th>course year and section</th>
                                                        <th>action</th>
                                                    </tr>
                                                </thead>

                                                <tbody class=" table-group-divider">
                                                    <?php
                                                    $a = 0;
                                                    $query = mysqli_query($conn, "SELECT * FROM student LEFT JOIN class ON class.class_id = student.class_id") or die(mysqli_error($conn));
                                                    while ($row = mysqli_fetch_array($query)) {
                                                        $id = $row['student_id'];
                                                        $a++;
                                                    ?>
                                                        <tr id="del<?php echo $id; ?>">
                                                            <input type="hidden" name="test" value="<?php echo $a; ?>">

                                                            <td><img class="rounded img-thumbnail" src="admin/<?php echo $row['location']; ?>" style="height: 75px; width: 75px; object-fit: cover;"></td>
                                                            <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                                                            <td><?php echo $row['class_name']; ?></td>
                                                            <td>
                                                                <select name="add_student<?php echo $a; ?>" class="form-select">
                                                                    <option></option>
                                                                    <option>Add</option>
                                                                </select>
                                                                <input type="hidden" name="student_id<?php echo $a; ?>" value="<?php echo $id; ?>">
                                                                <input type="hidden" name="class_id<?php echo $a; ?>" value="<?php echo $get_id; ?>">
                                                                <input type="hidden" name="teacher_id<?php echo $a; ?>" value="<?php echo $session_id; ?>">
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#example').DataTable();
                                                    });
                                                </script>

                                            </table>
                                            <button class="btn btn-success" name="submit" type="submit">
                                                <i class="bi bi-plus-square-fill me-1"></i>Add Student(s)
                                            </button>
                                        </form>

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
            $('#addStudentForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: 'teacher_add_student_save.php<?php echo '?id=' . $get_id; ?>',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Students added successfully
                            $.jGrowl(response.message, {
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
                            // No students selected
                            $.jGrowl(response.message, {
                                header: 'Warning',
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