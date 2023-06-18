<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('teacher_count.php'); ?>

<body>
    <?php include('navbar_teacher.php'); ?>

    <div class="d-flex">
        <?php include('teacher_sidebar_notification.php'); ?>
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
                                Notification
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap">
                    <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 mb-4" style="flex: 1;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"> <?php if ($not_read == '0') {
                                                                            } else { ?>
                                        <span class="position-absolute translate-middle badge rounded-pill bg-danger" style="z-index: 1;">
                                            <?php echo $not_read; ?>
                                        </span>
                                    <?php } ?><i class="bi bi-bell-fill me-2"></i> Notifications
                                </h4>
                            </div>
                            <div class="col text-end pt-1 pe-1">
                                <input class="form-check-input align-middle" type="checkbox" name="selectAll" id="checkAll">
                                <script>
                                    $("#checkAll").click(function() {
                                        $('input:checkbox').not(this).prop('checked', this.checked);
                                    });
                                </script>
                                <button class="btn btn-info btn-sm ms-2" name="read"><i class="bi bi-check"></i> Read</button>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center p-3">



                                <div class="container justify-content-sm-center">
                                    <div class="row justify-content-center">
                                        <div>
                                            <ul class="nav nav-pills mt-0 justify-content-start">
                                                <!-- Navigation links -->
                                            </ul>
                                        </div>
                                        <form action="read_message.php" method="post">
                                            <div class="container mt-3 mb-3"> <!-- Add a container with margin-top -->
                                                <div class="message-container p-0">
                                                    <?php $query = mysqli_query($conn, "SELECT * FROM teacher_notification
                                                    LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_notification.teacher_class_id
                                                    LEFT JOIN student ON student.student_id = teacher_notification.student_id
                                                    LEFT JOIN assignment ON assignment.assignment_id = teacher_notification.assignment_id 
                                                    LEFT JOIN class ON teacher_class.class_id = class.class_id
                                                    LEFT JOIN subject ON teacher_class.subject_id = subject.subject_id
                                                    WHERE teacher_class.teacher_id = '$session_id'  ORDER BY  teacher_notification.date_of_notification DESC
                                                    ") or die(mysqli_error($conn));
                                                    $count = mysqli_num_rows($query);
                                                    if ($count > 0) {
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $assignment_id = $row['assignment_id'];
                                                            $get_id = $row['teacher_class_id'];
                                                            $id = $row['teacher_notification_id'];

                                                            $query_yes_read = mysqli_query($conn, "SELECT * FROM notification_read_teacher WHERE notification_id = '$id' AND teacher_id = '$session_id'") or die(mysqli_error($conn));
                                                            $read_row = mysqli_fetch_array($query_yes_read);
                                                            $yes = $read_row['student_read'] ?? '';
                                                    ?>
                                                            <div class="container mt-3"> <!-- Add a container with margin-top -->
                                                                <div class="message-box border border-2 rounded-3 p-3" id="del<?php echo $id; ?>"> <!-- Add a class for the message box styling -->
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="message-content">
                                                                            <strong><?php echo $row['firstname'] . " " . $row['lastname']; ?></strong>
                                                                            <?php echo $row['notification']; ?>
                                                                            <strong><a href="<?php echo $row['link']; ?><?php echo '?id=' . $get_id; ?>&<?php echo 'post_id=' . $assignment_id ?>">
                                                                                    <?php echo $row['class_name']; ?>
                                                                                    <?php echo $row['subject_code']; ?>
                                                                                </a></strong>
                                                                        </div>
                                                                        <?php if ($yes == 'yes') {
                                                                        } else { ?>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" id="selector_<?php echo $id; ?>" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="justify-content-between align-items-center">
                                                                        <div class="text-muted">
                                                                            <i class="bi bi-calendar3"></i> <?php echo $row['date_of_notification']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex align-items-center justify-content-between mt-2">
                                                                        <?php if ($yes == 'yes') { ?>
                                                                            <span class="badge bg-success">Read</span>
                                                                            <div class="ms-auto">
                                                                                <a class="btn btn-danger btn-sm remove-message" data-message-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#myModal">
                                                                                    <i class="bi bi-x"></i> Remove
                                                                                    <?php include('student_remove_inbox_message_modal.php'); ?>
                                                                                </a>
                                                                            </div>
                                                                        <?php } else { ?>
                                                                            <span class="badge bg-danger">Unread</span>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } else { ?>
                                                        <div class="alert alert-info p-2 mt-3 me-4"><i class="bi bi-info-circle"></i> No Notifications</div>
                                                    <?php } ?>
                                                </div>
                                            </div>
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
                    url: "teacher_remove_notification.php",
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
                        $.jGrowl("Notification is successfully deleted", {
                            header: 'Data Delete',
                            theme: 'bg-success'
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error(xhr.responseText);
                        $.jGrowl("Error deleting message", {
                            header: 'Error',
                            theme: 'bg-danger'
                        });
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Attach click event to the "Read" button
            $(document).on('click', 'button[name="read"]', function() {
                var selectedMessages = $('input[name="selector[]"]:checked');
                if (selectedMessages.length === 0) {
                    // Display a jGrowl notification indicating that no messages are selected
                    $.jGrowl("Please select at least one message to mark as read.", {
                        header: 'Warning',
                        theme: 'bg-warning'
                    });
                } else {
                    // Send AJAX request to mark selected messages as read
                    var messageIds = [];
                    selectedMessages.each(function() {
                        messageIds.push($(this).val());
                    });

                    $.ajax({
                        type: "POST",
                        url: "teacher_read_notification.php",
                        data: {
                            messages: messageIds
                        }, // Send the selected message IDs as 'messages' parameter
                        cache: false,
                        success: function(response) {
                            // Handle the success response
                            // You may refresh the message list or perform any other necessary actions
                            $.jGrowl(response, {
                                header: 'Success',
                                theme: 'bg-success'
                            });
                            // Reload the page after a delay
                            setTimeout(function() {
                                location.reload();
                            }, 1000); // Adjust the delay as needed
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            console.error(xhr.responseText);
                            $.jGrowl("Error marking notification as read.", {
                                header: 'Error',
                                theme: 'bg-danger'
                            });
                        }
                    });
                }
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>