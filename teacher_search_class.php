<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_teacher.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex">
        <?php include('teacher_sidebar.php'); ?>
        <div class="container-fluid my-4 justify-content-center pb-5">
            <div class="container mx-auto">
                <div class="container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-body rounded-3 p-3">
                            <?php
                            $sy = $_POST['school_year'];

                            $school_year_query = mysqli_query($conn, "SELECT * FROM school_year WHERE school_year = '$sy' ORDER BY school_year DESC") or die(mysqli_error($conn));
                            $school_year_query_row = mysqli_fetch_array($school_year_query);
                            $school_year = $school_year_query_row['school_year'];
                            ?>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">School Year: <?php echo $school_year_query_row['school_year']; ?></a>
                            </li>
                            <li class="breadcrumb-item active">
                                My Class
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container mb-3">
                    <div class="container bg-body rounded-3 p-2">
                        <form method="post" action="teacher_search_class.php">
                            <div class="d-flex align-middle" style="white-space: nowrap;">
                                <label for="school_year" class="form-label mx-2 my-2 fw-bold" style="color: #fff;"><i class="bi bi-search me-1"></i> Search Class School Year: </label>
                                <div class="input-group">
                                    <select id="school_year" name="school_year" class="form-select" style="width: 150px; max-width:300px;" required>
                                        <option value="" disabled selected class="text-muted">Select School Year</option>
                                        <?php
                                        $query = mysqli_query($conn, "SELECT * FROM school_year order by school_year ASC");
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                            <option><?php echo $row['school_year']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <button type="submit" name="search" class="btn btn-info btn-sm"><i class="icon-search"></i> Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="container d-flex flex-wrap flex-column flex-sm-row">

                    <!-- MY CLASS DIV -->
                    <div class="container bg-body rounded-3 p-0 mb-3 me-3" style="overflow-y: auto; height: 550px; max-height: 550px; flex: 1;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-top-3">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-person-workspace me-2"></i> my class</h4>
                            </div>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM teacher_class
            LEFT JOIN class ON class.class_id = teacher_class.class_id
            LEFT JOIN subject ON subject.subject_id = teacher_class.subject_id
            WHERE teacher_id = '$session_id' and school_year = '$school_year' ORDER BY class_name ASC") or die(mysqli_error($conn));
                            $count = mysqli_num_rows($query);
                            ?>
                            <span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count; ?></span>
                        </div>

                        <div class="container">
                            <div class="row">
                                <?php
                                if ($count > 0) {
                                    while ($row = mysqli_fetch_array($query)) {
                                        $id = $row['teacher_class_id'];
                                ?>
                                        <div class="col class-box justify-content-center text-center my-4" id="del<?php echo $id; ?>">
                                            <div class="card card-1 mx-auto mb-2 p-4" style="background-image: url('<?php echo $row['thumbnails'] ?>'); background-size: cover; width: 150px; height: 150px;">
                                                <a href="teacher_my_students.php<?php echo '?id=' . $id; ?>">
                                                    <div class="card-img-overlay d-flex flex-column justify-content-center" style="background-color: rgba(0, 0, 0, 0.4);">
                                                        <h3><?php echo $row['subject_code']; ?></h3>
                                                        <p class="mb-0 mt-2"><?php echo $row['class_name']; ?></p>
                                                    </div>
                                                </a>
                                            </div>
                                            <a class="btn btn-info btn-sm text-uppercase fw-bold" href="teacher_class_progress.php<?php echo '?id=' . $id; ?>" title="View Class Progress">
                                                progress
                                            </a>
                                            <a class="btn btn-danger btn-sm remove-message" title="Remove Class" data-message-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#myModal">
                                                <i class="bi bi-trash3-fill"></i>
                                                <?php include('student_remove_inbox_message_modal.php'); ?>
                                            </a>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="container p-4">
                                        <div class="alert alert-info"><i class="bi bi-info-circle"></i> No assigned class currently</div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <!-- ADD CLASS DIV -->
                    <div class="container bg-body rounded-3 p-0 mb-3 ms-3" style="flex: 1;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i> add class</h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center">
                                <form class="p-4" method="post" id="add_class">
                                    <div class="mb-3">
                                        <label class="form-label">Class Name:</label>
                                        <div class="input-group">
                                            <select name="class_id" class="form-select" required>
                                                <option value="" disabled selected class="text-muted">Select Class</option>
                                                <?php
                                                $query = mysqli_query($conn, "select * from class order by class_name");
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <option value="<?php echo $row['class_id']; ?>"><?php echo $row['class_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Subject:</label>
                                        <div class="input-group">
                                            <select name="subject_id" class="form-select" required>
                                                <option value="" disabled selected class="text-muted">Select Subject</option>
                                                <?php
                                                $query = mysqli_query($conn, "select * from subject order by subject_code");
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <option value="<?php echo $row['subject_id']; ?>"><?php echo $row['subject_code']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">School Year:</label>
                                        <div class="input-group">
                                            <?php
                                            $query = mysqli_query($conn, "select * from school_year order by school_year DESC");
                                            $row = mysqli_fetch_array($query);
                                            ?>
                                            <input class="form-control" type="text" name="school_year" value="<?php echo $row['school_year']; ?>">
                                        </div>
                                    </div>


                                    <div class="mb-0">
                                        <button class="btn btn-success"><i class="bi bi-plus-square-fill me-1"></i> Add</button>
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
                    url: "teacher_remove_class.php",
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
                                var delay = 850;
                                setTimeout(function() {
                                    location.reload();
                                }, delay);
                            }
                        });
                        $('#myModal').modal('hide');
                        $.jGrowl("Class is successfully removed", {
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

    <script>
        $(document).ready(function() {
            // Submit form using AJAX
            $('#add_class').submit(function(e) {
                e.preventDefault(); // Prevent default form submission
                var form = $(this);

                $.ajax({
                    type: 'POST',
                    url: 'teacher_add_class.php',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.trim() === "true") {
                            $.jGrowl("Class Already Exist", {
                                header: 'Add Class Failed',
                                theme: 'bg-warning',
                                life: 3000
                            });
                        } else if (response.trim() === "false") {
                            $.jGrowl("Class Successfully Added", {
                                header: 'Class Added',
                                theme: 'bg-success',
                                life: 3000
                            });

                            setTimeout(function() {
                                location.reload(); // Reload the page after a delay of 2000 milliseconds (2 seconds)
                            }, 1500);

                        } else {
                            $.jGrowl(response, {
                                theme: 'bg-warning',
                                life: 3000
                            });
                        }
                    },
                    error: function() {
                        // Display error message
                        $.jGrowl("An error occurred. Please try again.", {
                            theme: 'bg-warning',
                            life: 3000
                        });
                    }
                });
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>