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
                                My Students
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap flex-column flex-sm-row">

                    <!-- MY CLASS DIV -->
                    <div class="container bg-body rounded-3 p-0 mb-3" style="overflow-y: auto; height: 550px; max-height: 550px; flex: 1;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-top-3">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-people-fill me-2"></i> my students</h4>
                            </div>
                            <?php
                            $my_student = mysqli_query($conn, "SELECT * FROM teacher_class_student
														LEFT JOIN student ON student.student_id = teacher_class_student.student_id 
														INNER JOIN class ON class.class_id = student.class_id where teacher_class_id = '$get_id' order by lastname ") or die(mysqli_error($conn));
                            $count_my_student = mysqli_num_rows($my_student); ?>
                            <div>
                                <a href="teacher_add_student.php<?php echo '?id=' . $get_id; ?>">
                                    <button class="btn btn-success me-1"><i class="bi bi-plus-square-fill"></i></i> Add Students</button>
                                </a>
                                <span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count_my_student; ?></span>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <?php
                            if ($count_my_student != '0') {
                                while ($row = mysqli_fetch_array($my_student)) {
                                    $id = $row['teacher_class_student_id'];
                            ?>
                                    <div class="col-sm-auto class-box justify-content-center text-center my-4" id="del<?php echo $id; ?>">
                                        <div class="card card-1 mx-auto mb-2 p-4" style="background-image: url('admin/<?php echo $row['location'] ?>'); background-size: cover; width: 150px; height: 150px;">
                                            <a href="teacher_student_progress.php?id=<?php echo $get_id; ?>&student_id=<?php echo $row['student_id']; ?>">
                                                <div class="card-img-overlay d-flex flex-column justify-content-center" style="background-color: rgba(0, 0, 0, 0.4);">
                                                    <p class="mb-0 mt-2 text-white"><?php echo $row['lastname']; ?></p>
                                                    <p class="mb-0 text-white"><?php echo $row['firstname']; ?></p>
                                                </div>
                                            </a>
                                        </div>
                                        <a class="btn btn-danger btn-sm remove-message" data-message-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#myModal">
                                            <i class="bi bi-x"></i> Remove
                                            <?php include('student_remove_inbox_message_modal.php'); ?>
                                        </a>
                                    </div>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="container p-4">
                                    <div class="alert alert-info p-2 mt-3"><i class="bi bi-info-circle"></i> No Students</div>
                                </div>
                            <?php
                            }
                            ?>
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
                    url: "teacher_remove_student.php",
                    data: {
                        id: messageId
                    },
                    cache: false,
                    success: function(response) {
                        // Handle the success response
                        $("#del" + messageId).fadeOut('slow', function() {
                            $(this).remove();
                            var remainingMessages = $('.class-box').length;
                            if (remainingMessages === 0) {
                                var delay = 1500;
                                setTimeout(function() {
                                    location.reload();
                                }, delay);
                            }
                        });
                        $('#myModal').modal('hide');
                        $.jGrowl("Student is successfully removed", {
                            header: 'Data Delete',
                            theme: 'bg-success'
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error(xhr.responseText);
                        $.jGrowl("Error removing class", {
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