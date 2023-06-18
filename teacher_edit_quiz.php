<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $get_id = $_GET['id']; ?>

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
                            $school_year_query = mysqli_query($conn, "SELECT * from school_year ORDER BY school_year DESC") or die(mysqli_error($conn));
                            $school_year_query_row = mysqli_fetch_array($school_year_query);
                            $school_year = $school_year_query_row['school_year'];
                            ?>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">School Year: <?php echo $school_year_query_row['school_year']; ?></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Simulations & Quiz</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Edit
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap">
                    <div class="container bg-body rounded-3 p-0 mb-3" style="height: 450px; max-height: 500px;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-pencil-square me-2"></i> edit simulation / quiz</h4>
                            </div>
                            <a href="teacher_add_simquiz.php">
                                <button class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                            </a>
                        </div>

                        <div class="container justify-content-sm-center p-4">
                            <div class="row justify-content-center">
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM quiz WHERE quiz_id = '$get_id'") or die(mysqli_error($conn));
                                $row  = mysqli_fetch_array($query);
                                ?>
                                <form class="px-3 mb-4" method="post" id="create_question">
                                    <div class="mb-3">
                                        <label class="form-label">Question:</label>
                                        <div class="input-group">
                                            <input class="form-control" type="text" name="quiz_title" value="<?php echo $row['quiz_title']; ?>" id="inputEmail" placeholder="Quiz Title">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Description:</label>
                                        <div class="input-group">
                                            <input type="text" value="<?php echo $row['quiz_description']; ?>" class="form-control" name="description" id="inputPassword" placeholder="Quiz Description" required></input>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <button name="save" type="submit" class="btn btn-warning"><i class="bi bi-pencil-square me-1"></i> Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#create_question').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: 'teacher_edit_quiz_save.php<?php echo '?id=' . $get_id; ?>',
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Display a success message using jGrowl
                        $.jGrowl('Edit saved successfully!', {
                            header: 'Success',
                            theme: 'bg-success',
                            life: 3000
                        });
                        // Reload the page after a delay
                        setTimeout(function() {
                            location.reload();
                        }, 1000); // Adjust the delay as needed
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