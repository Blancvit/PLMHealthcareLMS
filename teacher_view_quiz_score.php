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
        <?php include('teacher_sidebar_simquiz.php'); ?>
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
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Class Simulation & Quiz</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Simulation & Quiz Score List
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap">
                    <div class="container bg-body rounded-3 p-0 mb-3" style="overflow-y: auto; height: 550px; max-height: 550px;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-list-task me-2"></i> simulations / quizzes score list</h4>
                            </div>
                            <a href="teacher_simquiz.php<?php echo '?id=' . $get_id ?>">
                                <button class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                            </a>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center p-3">
                                <div class="container justify-content-sm-center">
                                    <div class="row justify-content-center">
                                        <div class="table-responsive-lg">
                                            <table class="table table-striped p-3 text-center align-middle" id="">
                                                <thead>
                                                    <tr class="text-uppercase">
                                                        <th>last name</th>
                                                        <th>first name</th>
                                                        <th>TIME (IN MINUTES)</th>
                                                        <th>score</th>
                                                    </tr>
                                                </thead>

                                                <tbody class="table-group-divider">
                                                    <?php
                                                    $query = mysqli_query($conn, "select * FROM class_quiz 
										LEFT JOIN teacher_class_student on class_quiz.teacher_class_id = teacher_class_student.teacher_class_id
										LEFT JOIN student on teacher_class_student.student_id = student.student_id
                                        where class_quiz_id ='$post_id' order by lastname ASC ") or die(mysqli_error($conn));
                                                    $count = mysqli_num_rows($query);
                                                    if ($count != '0') {
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $id  = $row['class_quiz_id'];
                                                            $quiz_id  = $row['quiz_id'];
                                                            $quiz_time  = $row['quiz_time'];
                                                            $student_id = $row['student_id'];

                                                            $query1 = mysqli_query($conn, "select * from student_class_quiz where class_quiz_id = '$post_id' and student_id = '$student_id' ") or die(mysqli_error($conn));
                                                            $row1 = mysqli_fetch_array($query1);
                                                            $grade = $row1['grade'] ?? '';

                                                    ?>
                                                            <tr class="message-box" id="del<?php echo $id; ?>">
                                                                <td><?php echo $row['lastname']; ?></td>
                                                                <td><?php echo $row['firstname']; ?></td>
                                                                <td><?php echo $row['quiz_time'] / 60; ?></td>
                                                                <td>
                                                                    <?php if ($grade == "") { ?>
                                                                        <span class="badge bg-secondary">NOT ANSWERED</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge bg-success"><?php echo $grade; ?></span>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>

                                                        <?php }
                                                    } else { ?>
                                                        <div class="container p-4">
                                                            <div class="alert alert-info"><i class="icon-info-sign"></i> No Students' Record(s)</div>
                                                        </div>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // Attach click event to the remove button in the modal
            $(document).on('click', '.remove-message', function() {
                var messageId = $(this).data("message-id"); // Get the message ID from the clicked button
                $('#removeMessageBtn').data("message-id", messageId); // Set the message ID to the confirmation button

                // Show the modal
                $('#myModal').modal('show');
            });

            // Attach click event to the confirm removal button in the modal
            $(document).on('click', '#removeMessageBtn', function() {
                var messageId = $(this).data("message-id");

                // Send AJAX request to delete the message
                $.ajax({
                    type: "POST",
                    url: "teacher_delete_class_quiz.php",
                    data: {
                        id: messageId
                    },
                    cache: false,
                    success: function(response) {
                        // Handle the success response
                        $("#del" + messageId).fadeOut('slow', function() {
                            $(this).remove();
                            var remainingMessages = $('.message-box').length;
                            if (remainingMessages === 0) {
                                var delay = 850;
                                setTimeout(function() {
                                    location.reload();
                                }, delay);
                            }
                        });
                        $('#myModal').modal('hide');
                        $.jGrowl("Simulation / Quiz is successfully deleted", {
                            header: 'Data Delete',
                            theme: 'bg-success'
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error(xhr.responseText);
                        $.jGrowl("Error deleting Simulation / Quiz", {
                            header: 'Error',
                            theme: 'bg-danger'
                        });
                    }
                });
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>