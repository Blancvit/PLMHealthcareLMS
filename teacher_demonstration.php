<?php
include('session.php');
include('header.php');
?>
<?php $get_id = $_GET['id']; ?>

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
                            <li class="breadcrumb-item active">
                                Demonstrations
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap flex-column flex-sm-row">

                    <div class="container bg-body rounded-3 p-0 mb-3 me-3" style="flex: 1; height: 550px; max-height: 550px; overflow-y:auto;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-clipboard-plus-fill me-2"></i> demonstrations</h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center p-3">
                                <div class="container justify-content-sm-center">
                                    <div class="row justify-content-center">
                                        <div class="table-responsive">
                                            <table class="table table-striped p-3 text-center align-middle" id="">
                                                <?php
                                                $query = mysqli_query($conn, "SELECT * FROM assignment WHERE class_id = '$get_id' and teacher_id = '$session_id' order by fdatein DESC ") or die(mysqli_error($conn));
                                                $count = mysqli_num_rows($query);
                                                if ($count == '0') { ?>
                                                    <div class="container p-2">
                                                        <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> No Demonstration(s) Posted</div>
                                                    </div>
                                                <?php } else {
                                                ?>
                                                    <thead>
                                                        <tr class="text-uppercase">
                                                            <th>Date uploaded</th>
                                                            <th>file name</th>
                                                            <th>Description</th>
                                                            <th>Deadline</th>
                                                            <th>actions</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class=" table-group-divider">
                                                        <?php
                                                        $query = mysqli_query($conn, "SELECT * FROM assignment WHERE class_id = '$get_id' AND teacher_id = '$session_id' order by fdatein DESC ") or die(mysqli_error($conn));
                                                        $count = mysqli_num_rows($query);
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $id  = $row['assignment_id'];
                                                            $floc  = $row['floc'];
                                                        ?>
                                                            <tr class="message-box" id="del<?php echo $id; ?>">
                                                                <td><?php echo $row['fdatein']; ?></td>
                                                                <td><?php echo $row['fname']; ?></td>
                                                                <td><?php echo $row['fdesc']; ?></td>
                                                                <td><?php echo $row['deadline']; ?></td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <a data-placement="bottom" title="View Student who submit Demonstration" id="<?php echo $id; ?>view" class="btn btn-success" href="teacher_view_submit_demo.php<?php echo '?id=' . $get_id ?>&<?php echo 'post_id=' . $id ?>"><i class="bi bi-folder-fill"></i></a>

                                                                        <?php
                                                                        if ($floc == "") {
                                                                        } else {
                                                                        ?>
                                                                            <a data-placement="bottom" title="Download" id="<?php echo $id; ?>download" class="btn btn-warning" href="<?php echo $row['floc']; ?>"><i class="bi bi-download"></i></a>
                                                                        <?php } ?>
                                                                        <a data-placement="bottom" title="Remove" class="btn btn-danger remove-message" data-message-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#myModal"><i class="bi bi-trash-fill"></i></i></a>
                                                                        <?php include('student_remove_inbox_message_modal.php'); ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>

                                                    <?php } ?>
                                                    </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Create Message -->
                    <div class="container bg-body rounded-3 p-0 mb-3 ms-3" style="flex: 1;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i> add demonstration</h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center">

                                <form class="p-4" method="post" id="add_demo">
                                    <div class="mb-3">
                                        <div class="mb-3">
                                            <div class="">
                                                <input name="uploaded_file" class="form-control" id="fileInput" type="file" accept=".pdf, .doc, .docx, .jpg, .png, .mp4, .mov, .avi">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="500000000" />
                                                <input type="hidden" name="id" value="<?php echo $post_id; ?>" />
                                                <input type="hidden" name="id_class" value="<?php echo $get_id; ?>" />
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="controls">
                                                <input type="text" name="name" Placeholder="Task Name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="controls">
                                                <input type="datetime-local" name="deadline" Placeholder="OneDrive Video Link" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="controls">
                                                <input type="text" name="desc" Placeholder="Description" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            <button class="btn btn-warning" type="submit"><i class="bi bi-plus-square-fill"></i> Post</button>
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
                    url: "teacher_remove_demonstration.php",
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
                        $.jGrowl("Demonstration is successfully deleted", {
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
            $('#add_demo').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Display loading spinner
                $.jGrowl("Posting Demonstration ...", {
                    header: 'Info',
                    theme: 'bg-info',
                    life: 2000
                });

                // Create a FormData object to store the form data
                var formData = new FormData($('#add_demo')[0]);

                // Make an AJAX request to the PHP file
                $.ajax({
                    url: 'teacher_add_demonstration_save.php<?php echo '?id=' . $get_id; ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle the response
                        if (response.success) {
                            // Show success message using jGrowl
                            $.jGrowl('Demonstration posted successfully!', {
                                theme: 'bg-success',
                                header: 'Success',
                                life: 3000
                            });

                            // Reload the page after a delay
                            setTimeout(function() {
                                location.reload();
                            }, 1500); // Adjust the delay as needed

                        } else {
                            // Show error message using jGrowl
                            $.jGrowl('Error posting demonstration. Please try again later.', {
                                header: 'Error',
                                theme: 'bg-danger',
                                life: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Show error message using jGrowl
                        $.jGrowl('Error posting demonstration. Please try again later.', {
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