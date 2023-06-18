<?php include('session.php'); ?>
<?php include('header.php'); ?>

<body>
    <?php include('navbar_teacher.php'); ?>

    <div class="d-flex">
        <?php include('teacher_sidebar_add_simquiz.php'); ?>
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
                                Add Simulation / Quiz
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap">

                    <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 mb-3" style="flex: 1;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;">
                                    <i class="bi bi-plus-square-fill me-2"></i> Add to class
                                </h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center p-4">
                            <div class="col justify-content-center">
                                <form method="post" id="add_simquiz_class">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <select name="quiz_id" class="form-select" required>
                                                <option value="" disabled selected class="text-muted">Select Simulation / Quiz</option>
                                                <?php $query = mysqli_query($conn, "SELECT * FROM quiz WHERE teacher_id = '$session_id'") or die(mysqli_error($conn));
                                                while ($row = mysqli_fetch_array($query)) {
                                                    $id = $row['quiz_id']; ?>
                                                    <option value="<?php echo $id; ?>|<?php echo $row['area'];?>"><?php echo $row['quiz_title']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="controls">
                                            <input type="text" name="time" Placeholder="Time (in minutes)" class="form-control" required>
                                        </div>
                                    </div>
                            </div>

                            <hr>
                            <div class="col justify-content-center">
                                <div class="table-responsive-lg">
                                    <table class="table table-striped align-middle text-center justify-content-center" id="">
                                        <div class="alert alert-info p-2">
                                            <h5><i class="bi bi-info-circle"></i> Select a class to add Simulation / Quiz</h5>
                                        </div>
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th><input class="form-check-input" type="checkbox" name="selectAll" id="checkAll" /></th>
                                                <script>
                                                    $("#checkAll").click(function() {
                                                        $('input:checkbox').not(this).prop('checked', this.checked);
                                                    });
                                                </script>
                                                <th>Class Name</th>
                                                <th>Subject Code</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $query = mysqli_query($conn, "SELECT * FROM teacher_class
                                            LEFT JOIN class ON class.class_id = teacher_class.class_id
                                            LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
                                            WHERE teacher_id = '$session_id' AND school_year = '$school_year' ORDER BY class_name ASC") or die(mysqli_error($conn));
                                            $count = mysqli_num_rows($query);
                                            while ($row = mysqli_fetch_array($query)) {
                                                $id = $row['teacher_class_id'];
                                            ?>
                                                <tr id="del<?php echo $id; ?>">
                                                    <td>
                                                        <input id="" class="form-check-input" id="selector_<?php echo $id; ?>" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                                    </td>
                                                    <td><?php echo $row['class_name']; ?></td>
                                                    <td><?php echo $row['subject_code']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <button name="save" type="submit" value="post" class="btn btn-warning"><i class="bi bi-plus-square-fill me-1"></i> Post</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container bg-body rounded-3 p-0 mb-3 ms-3" style="flex: 1;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-pen-fill me-2"></i> create simulation / quiz</h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center">
                                <form class="p-4" method="post" id="create_simquiz">
                                    <div class="mb-3">
                                        <label class="form-label">Title:</label>
                                        <div class="controls">
                                            <input type="text" name="quiz_title" Placeholder="Simulation / Quiz Title" class="form-control" required>
                                        </div>
                                    </div>
									<div class="mb-3">
									<label class="form-label">Area</label>
										<div class="controls">
											<select name="area" class="form-select" required>
												<option disabled selected class="text-muted">Select Area</option>
													<option>Emergency</option>
													<option>Faculty Resources</option>
													<option>Gerontology</option>
													<option>Library</option>
													<option>Maternal and Child</option>
													<option>Medical-Surgical</option>
													<option>Mental Health</option>
													<option>Pediatrics</option>
											</select>
										</div>
									</div>
                                    <div class="mb-3">
                                        <label class="form-label">Description:</label>
                                        <div class="input-group">
                                            <textarea name="description" class="form-control" required></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <button class="btn btn-warning"><i class="bi bi-plus-square-fill me-1"></i> Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="container bg-body rounded-3 p-0 mb-3" style="overflow-y: auto; height: 550px; max-height: 550px;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-list-task me-2"></i> simulations / quizzes list</h4>
                            </div>
                            <?php $query = mysqli_query($conn, "select quiz_id FROM quiz") or die(mysqli_error($conn));
                            $count  = mysqli_num_rows($query);
                            ?>
                            <span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count; ?></span>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center p-3">
                                <div class="container justify-content-sm-center">
                                    <div class="row justify-content-center">
                                        <?php
                                        $query = mysqli_query($conn, "select * FROM quiz where teacher_id = '$session_id'  order by date_added DESC ") or die(mysqli_error($conn));
                                        $count = mysqli_num_rows($query);
                                        $count = mysqli_num_rows($query);
                                        if ($count == '0') { ?>
                                            <div class="container p-4">
                                                <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> No Created Simulation / Quiz</div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="table-responsive-lg">
                                                <table class="table table-striped p-3 text-center align-middle" id="">
                                                    <thead>
                                                        <tr class="text-uppercase">
                                                            <th>Title</th>
                                                            <th>Description</th>
															<th>Area</th>
                                                            <th>Date created</th>
                                                            <th>actions</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $id  = $row['quiz_id'];
                                                        ?>
                                                            <tr class="message-box" id="del<?php echo $id; ?>">
                                                                <td><?php echo $row['quiz_title']; ?></td>
                                                                <td><?php echo $row['quiz_description']; ?></td>
																<td><?php echo $row['area']; ?></td>
                                                                <td><?php echo $row['date_added']; ?></td>
                                                                <td>
                                                                    <a class="btn btn-info btn-sm" href="teacher_quiz_question.php<?php echo '?id=' . $id; ?>"><b>ADD QUESTIONS</b></a>
                                                                    <a class="btn btn-warning btn-sm" title="Edit" href="teacher_edit_quiz.php<?php echo '?id=' . $id; ?>"><i class="bi bi-pencil-square"></i></a>
                                                                    <a class="btn btn-danger btn-sm remove-message" title="Delete" data-message-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#myModal"><i class="bi bi-trash3-fill"></i>
                                                                        <?php include('student_remove_inbox_message_modal.php'); ?>
                                                                    </a>
                                                                </td>
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
                $('#add_simquiz_class').submit(function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    // Check if at least one class is selected
                    if ($('input[name="selector[]"]:checked').length === 0) {
                        // Display error notification
                        $.jGrowl("Please select at least one class.", {
                            header: 'Error',
                            theme: 'bg-warning',
                            life: 2000
                        });
                        return;
                    }

                    // Display loading spinner
                    $.jGrowl("Adding Simulation / Quiz ...", {
                        header: 'Info',
                        theme: 'bg-info',
                        life: 2000
                    });

                    // Make an AJAX request to the PHP file
                    $.ajax({
                        url: 'teacher_add_simquiz_to_class.php', // Replace with your AJAX handler URL
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            // Check the response
                            var result = JSON.parse(response);
                            if (result.success) {
                                // Display success notification
                                $.jGrowl("Simulation / Quiz added successfully!", {
                                    header: 'Success',
                                    theme: 'bg-success',
                                    life: 2000
                                });
                                // Reload the page after a delay
                                setTimeout(function() {
                                    location.reload();
                                }, 1500); // Adjust the delay as needed
                            } else {
                                // Display error notification
                                $.jGrowl("Simulation / Quiz already exists in the class.", {
                                    header: 'Error',
                                    theme: 'bg-warning',
                                    life: 2000
                                });
                            }
                        },
                        error: function() {
                            // Display error notification
                            $.jGrowl("Error adding Simulation / Quiz. Please try again later.", {
                                header: 'Error',
                                theme: 'bg-danger',
                                life: 2000
                            });
                        }
                    });
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                // Attach submit event to the send message form
                $(document).on('submit', '#create_simquiz', function(event) {
                    event.preventDefault(); // Prevent the default form submission

                    // Get the form data
                    var formData = $(this).serialize();

                    // Send AJAX request to create the message
                    $.ajax({
                        type: "POST",
                        url: "teacher_create_simquiz.php",
                        data: formData,
                        cache: false,
                        success: function(response) {
                            // Handle the success response
                            // Clear the form fields or perform any other necessary actions
                            $('.my_message').val(''); // Clear the message input field
                            $.jGrowl("Simulation / Quiz created successfully", {
                                header: 'Success',
                                theme: 'bg-success'
                            });

                            // Reload the page after a delay
                            setTimeout(function() {
                                location.reload();
                            }, 1500); // Adjust the delay as needed

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
            });
        </script>

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
                        url: "teacher_delete_quiz.php",
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