<?php
include('session.php');
include('header.php');
?>
<?php $get_id = $_GET['id']; ?>

<body>
    <?php include('navbar_teacher.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex">
        <?php include('teacher_sidebar_announcement.php'); ?>
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
                                Announcements
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap flex-column flex-sm-row">

                    <div class="container bg-body rounded-3 p-0 mb-3 me-3" style="flex: 1; height: 550px; max-height: 550px; overflow-y:auto;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-megaphone-fill me-2"></i> posted Announcements</h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center p-3">
                                <div class="container justify-content-sm-center">
                                    <div class="row justify-content-center">
                                        <div class="container justify-content-sm-center">
                                            <div class="row justify-content-center">
                                                <div>
                                                    <ul class="nav nav-pills mt-0 justify-content-start">
                                                        <!-- Navigation links -->
                                                    </ul>
                                                </div>
                                                <form action="read_message.php" method="post">
                                                    <div class="container mt-3 mb-3"> <!-- Add a container with margin-top -->
                                                        <div class="p-0">
                                                            <?php
                                                            $query_announcement = mysqli_query($conn, "select * from teacher_class_announcements
                                                                                        where teacher_id = '$session_id'  and  teacher_class_id = '$get_id' order by date DESC
                                                                                        ") or die(mysqli_error($conn));
                                                            $count_my_message = mysqli_num_rows($query_announcement);
                                                            if ($count_my_message != '0') {
                                                                while ($row = mysqli_fetch_array($query_announcement)) {
                                                                    $id = $row['teacher_class_announcements_id'];
                                                            ?>
                                                                    <div class="container mt-3"> <!-- Add a container with margin-top -->
                                                                        <div class="message-box border border-2 rounded-3 p-3" id="del<?php echo $id; ?>"> <!-- Add a class for the message box styling -->
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <div class="message-content">
                                                                                    <?php echo $row['content']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="justify-content-between align-items-center">
                                                                                <div class="text-muted">
                                                                                    <i class="bi bi-calendar3"></i> <?php echo $row['date']; ?>
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-flex align-items-center justify-content-between mt-2">
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
                                                                <div class="alert alert-info p-2 mt-3 me-4"><i class="bi bi-info-circle"></i> No Announcement(s)</div>
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


                    <!-- Create Message -->
                    <div class="container bg-body rounded-3 p-0 mb-3 ms-3" style="flex: 1; max-width: 400px;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i> add Announcement</h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center p-4">
                            <div class="col justify-content-center">
                                <form method="post" id="add_announcement">
                                    <div class="mb-4">
                                        <label class="form-control-label mb-3">Announcement Content:</label>

                                        <textarea name="content" id="editor"></textarea>
                                    </div>
                                    <script>
                                        ClassicEditor
                                            .create(document.querySelector('#editor'))
                                            .catch(error => {
                                                console.error(error);
                                            });
                                    </script>
                                    <div>
                                        <button name="post" type="submit" value="post" class="btn btn-warning"><i class="bi bi-plus-square-fill me-1"></i> Post</button>
                                    </div>
                                </form>
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
                        url: "teacher_remove_announcement.php",
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
                            $.jGrowl("Announcement is successfully deleted", {
                                header: 'Data Delete',
                                theme: 'bg-success'
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            console.error(xhr.responseText);
                            $.jGrowl("Error deleting demonstration", {
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
                // Submit form using AJAX
                $('#add_announcement').submit(function(e) {
                    e.preventDefault();

                    // Check if the textarea is filled
                    var textareaValue = $("#editor").val().trim();
                    if (textareaValue === "") {
                        // Show jGrowl notification for empty textarea
                        $.jGrowl("Please fill in the text area", {
                            theme: 'bg-warning'
                        });
                        return;
                    }

                    // Display loading spinner
                    $.jGrowl("Posting announcement(s)...", {
                        header: 'Info',
                        theme: 'bg-info',
                        life: 2000
                    });

                    $.ajax({
                        url: 'teacher_announcement_save.php<?php echo '?id=' . $get_id; ?>', // Replace with your AJAX handler URL
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            // Clear form inputs
                            $('#add_announcement').trigger("reset");

                            // Display success notification
                            $.jGrowl("Announcement(s) posted successfully!", {
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
                            $.jGrowl("Error posting announcement(s). Please try again later.", {
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