<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $get_id = $_GET['id']; ?>

<body>
    <?php include('navbar_student_social.php'); ?>

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
                        <li class="breadcrumb-item active">
                            Social
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="container d-flex flex-wrap">
                <!-- Messages -->
                <div class="container bg-body rounded-3 p-0 mb-3 me-3" style="flex: 1;">
                    <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-chat-right-text-fill me-2"></i> messages</h4>
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
                            <div class="btn-group position-relative" role="group" aria-label="Message Navigation">
                                <a class="btn btn-outline-primary active" href="student_social.php<?php echo '?id=' . $get_id; ?>"><i class="bi bi-envelope-fill"></i> Inbox</a>
                                <?php if ($count_message == '0') {
                                } else { ?>
                                    <span class="position-absolute translate-middle badge rounded-pill bg-danger" style="z-index: 1;">
                                        <?php echo $count_message; ?>
                                    </span>
                                <?php } ?>
                                <a class="btn btn-outline-primary" href="student_social_sent.php<?php echo '?id=' . $get_id; ?>"><i class="bi bi-envelope-fill"></i> Sent messages</a>
                            </div>



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
                                                <?php
                                                $query_announcement = mysqli_query($conn, "SELECT * FROM message
            LEFT JOIN student ON student.student_id = message.sender_id
            WHERE message.reciever_id = '$session_id' ORDER BY date_sended DESC") or die(mysqli_error($conn));
                                                $count_my_message = mysqli_num_rows($query_announcement);
                                                if ($count_my_message != '0') {
                                                    while ($row = mysqli_fetch_array($query_announcement)) {
                                                        $id = $row['message_id'];
                                                        $id_2 = $row['message_id'];
                                                        $status = $row['message_status'];
                                                        $sender_id = $row['sender_id'];
                                                        $sender_name = $row['sender_name'];
                                                        $reciever_name = $row['reciever_name'];
                                                ?>
                                                        <div class="container mt-3"> <!-- Add a container with margin-top -->
                                                            <div class="message-box border border-2 rounded-3 p-3" id="del<?php echo $id; ?>"> <!-- Add a class for the message box styling -->
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div class="message-content">
                                                                        <?php echo $row['content']; ?>
                                                                    </div>
                                                                    <?php if ($row['message_status'] == 'read') {
                                                                    } else { ?>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" id="selector_<?php echo $id; ?>" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <hr>
                                                                <div class="justify-content-between align-items-center">
                                                                    <div>
                                                                        Sent by: <strong><?php echo $row['sender_name']; ?></strong>
                                                                    </div>
                                                                    <div class="text-muted">
                                                                        <i class="bi bi-calendar3"></i> <?php echo $row['date_sended']; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex align-items-center justify-content-between mt-2">
                                                                    <?php if ($status == 'read') { ?>
                                                                        <span class="badge bg-success">Read</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge bg-danger">Unread</span>
                                                                    <?php } ?>
                                                                    <div class="ms-auto">
                                                                        <a class="btn btn-danger btn-sm remove-message" data-message-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#myModal">
                                                                            <i class="bi bi-x"></i> Remove
                                                                            <?php include('student_remove_inbox_message_modal.php'); ?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }
                                                } else { ?>
                                                    <div class="alert alert-info p-2 mt-3 me-4"><i class="bi bi-info-circle"></i> No Inbox Messages</div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Create Message -->
                <div class="container bg-body rounded-3 p-0 mb-3 ms-3" style="flex: 1;">
                    <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-pen-fill me-2"></i> create message</h4>
                        </div>
                    </div>

                    <div class="container justify-content-sm-center">
                        <div class="row justify-content-center">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="student_social.php<?php echo '?id=' . $get_id; ?>">For Teacher</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="student_social_send.php<?php echo '?id=' . $get_id; ?>">For Student</a>
                                </li>
                            </ul>

                            <form class="p-4" method="post" id="send_message">
                                <div class="mb-3">
                                    <label class="form-label">To:</label>
                                    <div class="input-group">
                                        <select name="teacher_id" class="form-select" required>
                                            <option value="" disabled selected class="text-muted">Select Teacher</option>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM teacher ORDER BY firstname");
                                            while ($row = mysqli_fetch_array($query)) {
                                            ?>
                                                <option value="<?php echo $row['teacher_id']; ?>"><?php echo $row['firstname']; ?> <?php echo $row['lastname']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Content:</label>
                                    <div class="input-group">
                                        <textarea name="my_message" class="form-control my_message" required></textarea>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <button class="btn btn-success"><i class="bi bi-send-fill"></i> Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 mt-3" style="overflow-y: auto; height: 550px; max-height: 550px;">
                    <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-top-3">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-people-fill me-2"></i> classmates</h4>
                        </div>

                        <?php $query = mysqli_query($conn, "SELECT * FROM teacher_class_student
					LEFT JOIN teacher_class ON teacher_class.teacher_class_id = teacher_class_student.teacher_class_id 
					JOIN class ON class.class_id = teacher_class.class_id 
					JOIN subject ON subject.subject_id = teacher_class.subject_id
					WHERE student_id = '$session_id'
					") or die(mysqli_error($conn));
                        $row = mysqli_fetch_array($query);
                        $id = $row['teacher_class_student_id'];
                        $my_student = mysqli_query($conn, "SELECT * FROM teacher_class_student
                        LEFT JOIN student ON student.student_id = teacher_class_student.student_id
                        INNER JOIN class ON class.class_id = student.class_id 
                        WHERE teacher_class_id = '$get_id' 
                        AND student.student_id != '$session_id' 
                        ORDER BY lastname")
                            or die(mysqli_error($conn));
                        $count = mysqli_num_rows($my_student);
                        ?>
                        <span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count; ?></span>
                    </div>

                    <div class="container row row-cols-5 justify-content-sm-center">
                        <?php
                        $my_student = mysqli_query($conn, "SELECT * FROM teacher_class_student
                                    LEFT JOIN student ON student.student_id = teacher_class_student.student_id
                                    INNER JOIN class ON class.class_id = student.class_id WHERE teacher_class_id = '$get_id' order by lastname ")
                            or die(mysqli_error($conn));
                        if ($count != '0') {
                            while ($row = mysqli_fetch_array($my_student)) {
                                $id = $row['teacher_class_student_id'];

                                // Check if the current student is the current user
                                if ($row['student_id'] == $session_id) {
                                    continue; // Skip displaying the current user
                                }
                        ?>
                                <div class="col-sm-auto justify-content-center text-center my-4">
                                    <div class="card card-1 mx-auto mb-2 p-4" style="background-image: url('admin/<?php echo $row['location'] ?>'); background-size: cover; width: 150px; height: 150px;">
                                        <div class="card-img-overlay d-flex flex-column justify-content-center" style="background-color: rgba(0, 0, 0, 0.4);">
                                            <p class="mb-0 mt-2 text-white"><?php echo $row['lastname']; ?></p>
                                            <p class="mb-0 text-white"><?php echo $row['firstname']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <div class="container p-4">
                                <div class="alert alert-info p-2 mt-3"><i class="bi bi-info-circle"></i> No Classmates</div>
                            </div>
                        <?php
                        }
                        ?>
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
                    url: "student_remove_inbox_message.php",
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
                        $.jGrowl("Message is successfully deleted", {
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
            // Attach submit event to the send message form
            $(document).on('submit', '#send_message', function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Get the form data
                var formData = $(this).serialize();

                // Send AJAX request to create the message
                $.ajax({
                    type: "POST",
                    url: "student_send_message.php",
                    data: formData,
                    cache: false,
                    success: function(response) {
                        // Handle the success response
                        // Clear the form fields or perform any other necessary actions
                        $('.my_message').val(''); // Clear the message input field
                        $.jGrowl("Message sent successfully", {
                            header: 'Success',
                            theme: 'bg-success'
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        console.error(xhr.responseText);
                        $.jGrowl("Error sending message", {
                            header: 'Error',
                            theme: 'bg-danger'
                        });
                    }
                });
            });

            function checkMessageDisplay() {
                var messageCount = $('.post').length;
                if (messageCount === 0) {
                    $('.alert-info').show();
                }
            }
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
                        url: "student_read_message.php",
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
                            $.jGrowl("Error marking messages as read.", {
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