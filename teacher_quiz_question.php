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
                                Add Questions
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap">
                    <div class="container bg-body rounded-3 p-0 mb-3" style="overflow-y: auto; height: 550px; max-height: 550px; flex: 1">
                        <div class="container d-flex justify-content-center bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-list-task me-2"></i> Questions</h4>
                            </div>
                            <div class="">
                                <a href="teacher_add_simquiz.php">
                                    <button class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                                </a>
                                <a id="delete_question" class="remove btn btn-danger" name=""><i class="bi bi-trash3-fill"></i></a>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center p-3">
                                <div class="container justify-content-sm-center">
                                    <div class="row justify-content-center">
                                        <?php
                                        $query = mysqli_query($conn, "SELECT * FROM quiz_question
										LEFT JOIN question_type on quiz_question.question_type_id = question_type.question_type_id
										WHERE quiz_id = '$get_id'  ORDER BY date_added DESC ") or die(mysqli_error($conn));
                                        $count = mysqli_num_rows($query);
                                        if ($count == '0') { ?>
                                            <div class="container p-4">
                                                <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> No Questions</div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="table-responsive-lg">
                                                <form method="post" action="teacher_delete_quiz_question.php">
                                                    <table class="table table-striped p-3 text-center align-middle" id="">
                                                        <thead>
                                                            <tr class="text-uppercase">
                                                                <th><input class="form-check-input" type="checkbox" name="selectAll" id="checkAll" /></th>
                                                                <script>
                                                                    $(document).ready(function() {
                                                                        $("#checkAll").click(function() {
                                                                            $('input:checkbox').not(this).prop('checked', this.checked);
                                                                        });
                                                                    });
                                                                </script>
                                                                <th>question</th>
                                                                <th>question type</th>
                                                                <th>answer</th>
                                                                <th>date added</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $id  = $row['quiz_question_id'];
                                                            ?>
                                                                <tr id="del<?php echo $id; ?>">
                                                                    <td>
                                                                        <input class="form-check-input" id="optionsCheckbox" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                                                    </td>
                                                                    <td><?php echo $row['question_text']; ?></td>
                                                                    <td><?php echo $row['question_type']; ?></td>
                                                                    <td><?php echo $row['answer']; ?></td>
                                                                    <td><?php echo $row['date_added']; ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container bg-body rounded-3 p-0 mb-3 ms-3" style="flex: 1;">
                        <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-question-lg me-2"></i> add question</h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center">
                            <div class="row justify-content-center">
                                <form class="px-3" method="post" id="create_question">
                                    <div class="mb-3">
                                        <label class="form-label">Question:</label>
                                        <div class="input-group">
                                            <textarea name="question" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Question Type:</label>
                                        <div class="input-group">
                                            <select id="qtype" name="question_type" class="form-select" required>
                                                <option value="" disabled selected class="text-muted">Choose Question Type</option>
                                                <?php
                                                $query_question = mysqli_query($conn, "SELECT * FROM question_type") or die(mysqli_error($conn));
                                                while ($query_question_row = mysqli_fetch_array($query_question)) {
                                                ?>
                                                    <option value="<?php echo $query_question_row['question_type_id']; ?>"><?php echo $query_question_row['question_type'];  ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="controls">
                                            <div id="opt11">
                                                <label class="form-label">Answers: </label>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text">A</span>
                                                    <input type="text" name="ans1" class="form-control">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="radio" name="answer" value="A" aria-label="Radio button for following text input">
                                                    </div>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text">B</span>
                                                    <input type="text" name="ans2" class="form-control">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="radio" name="answer" value="B" aria-label="Radio button for following text input">
                                                    </div>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text">C</span>
                                                    <input type="text" name="ans3" class="form-control">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="radio" name="answer" value="C" aria-label="Radio button for following text input">
                                                    </div>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text">D</span>
                                                    <input type="text" name="ans4" class="form-control">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="radio" name="answer" value="D" aria-label="Radio button for following text input">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="opt12">
                                                <label class="form-label">Answers:</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="correctt" value="True" type="radio">
                                                    <span class="form-check-label">TRUE</span>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="correctt" value="False" type="radio">
                                                    <span class="form-check-label">FALSE</span>
                                                </div>
                                            </div>

                                            <div id="opt13">
                                                <input name="uploaded_file" class="form-control" id="fileInput" type="file">
                                                <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                                                <input type="hidden" name="id" value="<?php echo $session_id ?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <button name="save" type="submit" class="btn btn-warning"><i class="bi bi-plus-square-fill me-1"></i> Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Remove button click event
                $('.remove').click(function() {
                    var selectedClass = [];

                    // Get the selected subject IDs
                    $('input[name="selector[]"]:checked').each(function() {
                        selectedClass.push($(this).val());
                    });

                    if (selectedClass.length === 0) {
                        // No subjects selected, display an error message
                        $.jGrowl("No question(s) selected for deletion.", {
                            header: 'Error',
                            theme: 'bg-warning',
                            life: 2000
                        });
                    } else {
                        // Confirm the deletion with the user
                        if (confirm("Are you sure you want to delete the selected question(s)?")) {
                            // Perform AJAX request for deletion
                            $.ajax({
                                url: 'teacher_delete_quiz_question.php<?php echo '?id=' . $get_id; ?>',
                                type: 'POST',
                                data: {
                                    selector: selectedClass
                                },
                                success: function(response) {
                                    if (response === 'success') {
                                        // Deletion succeeded
                                        $.jGrowl("Question(s) deleted successfully.", {
                                            header: 'Success',
                                            theme: 'bg-success',
                                            life: 2000
                                        });
                                        // Reload the page after a delay
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1500);
                                    } else {
                                        // Deletion failed
                                        $.jGrowl("Error deleting question. Please try again later.", {
                                            header: 'Error',
                                            theme: 'bg-danger',
                                            life: 2000
                                        });
                                    }
                                },
                                error: function() {
                                    // Display error message
                                    $.jGrowl("Error deleting question. Please try again later.", {
                                        header: 'Error',
                                        theme: 'bg-danger',
                                        life: 2000
                                    });
                                }
                            });
                        }
                    }
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                $('#create_question').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    $.ajax({
                        url: 'teacher_quiz_question_save.php<?php echo '?id=' . $get_id; ?>',
                        type: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // Display a success message using jGrowl
                            $.jGrowl('Question saved successfully!', {
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

        <script>
            // Function to show or hide the div elements based on the selected question type
            function toggleQuestionOptions() {
                var questionType = document.getElementById("qtype").value;
                var opt11 = document.getElementById("opt11");
                var opt12 = document.getElementById("opt12");
                var opt13 = document.getElementById("opt13");

                opt11.style.display = (questionType === "1") ? "block" : "none";
                opt12.style.display = (questionType === "2") ? "block" : "none";
                opt13.style.display = (questionType === "3") ? "block" : "none";
            }

            // Add event listener to the question type select element
            document.getElementById("qtype").addEventListener("change", toggleQuestionOptions);

            // Call the function initially to set the correct visibility based on the initial selected value
            toggleQuestionOptions();
        </script>

        <?php include('scripts.php'); ?>
</body>