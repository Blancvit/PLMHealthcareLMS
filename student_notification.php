<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php include('count.php'); ?>

<body>
    <?php include('navbar_student_notification.php'); ?>

    <div class="container-fluid my-4 justify-content-center pb-5">
        <div class="container mx-auto">

            <div class="container d-flex">
                <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 mb-4">
                    <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"> <?php if ($not_read == '0') {
                                                                        } else { ?>
                                    <span class="position-absolute translate-middle badge rounded-pill bg-danger" style="z-index: 1;">
                                        <?php echo $not_read; ?>
                                    </span>
                                <?php } ?><i class="bi bi-bell-fill"></i> Notifications
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

                    <div class="container justify-content-sm-center" style="overflow-y: auto; height: 550px; max-height: 550px;">
                        <div class="row justify-content-center p-3">
                            <div>
                                <ul class="nav nav-pills mt-0 justify-content-start">
                                    <!-- Navigation links -->
                                </ul>
                            </div>
                            <form action="read_message.php" method="post">
                                <div class="container mt-3 mb-3"> <!-- Add a container with margin-top -->
                                    <div class="p-0">
                                        <?php
                                        $query = mysqli_query($conn, "select * from teacher_class_student
										LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_class_student.teacher_class_id 
										LEFT JOIN class ON class.class_id = teacher_class.class_id 
										LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
										LEFT JOIN teacher ON teacher.teacher_id = teacher_class_student.teacher_id
										LEFT JOIN notification ON notification.teacher_class_id = teacher_class.teacher_class_id 
										JOIN class_quiz ON class_quiz.teacher_class_id = notification.teacher_class_id
										where teacher_class_student.student_id = '$session_id' and school_year = '$school_year'  order by notification.date_of_notification DESC") or die(mysqli_error($conn));
                                        $count = mysqli_num_rows($query);
                                        if ($count > 0) {
                                            while ($row = mysqli_fetch_array($query)) {
                                                $get_id = $row['teacher_class_id'];
                                                $get_area = $row['area'];
                                                $id = $row['notification_id'];

                                                $query_yes_read = mysqli_query($conn, "select * from notification_read where notification_id = '$id' and student_id = '$session_id'") or die(mysqli_error($conn));
                                                $read_row = mysqli_fetch_array($query_yes_read);
                                                $yes = $read_row['student_read'] ?? '';
                                        ?>
                                                <div class="container mt-3"> <!-- Add a container with margin-top -->
                                                    <div class="message-box border border-2 rounded-3 p-3" id="del<?php echo $id; ?>"> <!-- Add a class for the message box styling -->
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="message-content">
                                                                <strong><?php echo $row['firstname'] . " " . $row['lastname']; ?></strong>
                                                                <?php echo $row['notification']; ?>
                                                                <strong><a href="<?php echo $row['link']; ?><?php echo '?id=' . $get_id; ?><?php echo '&area=' . $get_area; ?>">
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
                                            <div class="alert alert-info p-2 mt-3"><i class="bi bi-info-circle"></i> No Notifications</div>
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
                    url: "student_remove_notification.php",
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
                        url: "student_read_notification.php",
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