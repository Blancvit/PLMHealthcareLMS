<?php
include('session.php');
include('header.php');
$get_id = $_GET['id'];
?>

<body>
    <?php include('navbar_teacher.php'); ?>


    <div class="d-flex">
        <?php include('teacher_sidebar.php'); ?>
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
                                Class Progress
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap">
                    <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 mb-4" style="flex: 1; height: 550px; max-height: 100vh; overflow-y: auto;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;">
                                    <i class="bi bi-bar-chart-fill me-2"></i><?php echo $class_row['class_name']; ?>: <?php echo $class_row['subject_code']; ?> Class Progress
                                </h4>
                            </div>
                            <a href="teacher_dashboard.php">
                                <button class="btn btn-outline-secondary me-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                            </a>
                        </div>

                        <div class="container justify-content-sm-center p-3">
                            <div class="col justify-content-center">

                                <!-- QUERY FOR STUDENT COUNT -->
                                <?php
                                $my_student = mysqli_query($conn, "SELECT * FROM teacher_class_student
														LEFT JOIN student ON student.student_id = teacher_class_student.student_id 
														INNER JOIN class ON class.class_id = student.class_id where teacher_class_id = '$get_id' order by lastname ") or die(mysqli_error($conn));
                                $count_my_student = mysqli_num_rows($my_student); ?>

                                <!-- QUERY FOR QUIZ COUNT -->
                                <?php
                                $query_quiz = mysqli_query($conn, "SELECT class_quiz_id, teacher_class_id, quiz_time, class_quiz.quiz_id,  class_quiz.date_added, quiz_title, quiz_description, teacher_id FROM class_quiz 
										LEFT JOIN quiz ON quiz.quiz_id  = class_quiz.quiz_id
										where teacher_class_id = '$get_id' 
										order by date_added DESC ") or die(mysqli_error($conn));
                                $count_quiz = mysqli_num_rows($query_quiz); ?>

                                <!-- QUERY FOR RETDEM COUNT -->
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM assignment WHERE class_id = '$get_id' AND teacher_id = '$session_id' order by fdatein DESC ") or die(mysqli_error($conn));
                                $count_retdem = mysqli_num_rows($query); ?>

                                <div class="col justify-content-center">
                                    <div class="table-responsive-lg">
                                        <table class="table table-dark table-striped table-sm table-hover" id="example">
                                            <thead>
                                                <tr class="text-uppercase">
                                                    <th class="text-center">student<span class="badge bg-info ms-2 text-dark"><?php echo $count_my_student; ?></span></th>
                                                    <th class="text-center">completed / total simquiz<span class="badge bg-info ms-2 text-dark"><?php echo $count_quiz; ?></span></th>
                                                    <th class="text-center">submitted / total retdem<span class="badge bg-info ms-2 text-dark"><?php echo $count_retdem; ?></span></th>
                                                    <th class="text-center">progress</th>
                                                    <th class="text-center">status</th>
                                                </tr>
                                            </thead>

                                            <tbody class="table-group-divider">
                                                <?php
                                                $my_student = mysqli_query($conn, "SELECT * FROM teacher_class_student
                                                LEFT JOIN student ON student.student_id = teacher_class_student.student_id 
                                                INNER JOIN class ON class.class_id = student.class_id
                                                WHERE teacher_class_id = '$get_id'
                                                ORDER BY lastname") or die(mysqli_error($conn));

                                                $taken_quiz = mysqli_query($conn, "SELECT COUNT(*) AS total_quizzes FROM class_quiz WHERE teacher_class_id = '$get_id'") or die(mysqli_error($conn));

                                                $row_total_quizzes = mysqli_fetch_assoc($taken_quiz);
                                                $total_quizzes = $row_total_quizzes['total_quizzes'];

                                                $taken_assignments = mysqli_query($conn, "SELECT COUNT(*) AS total_assignments FROM assignment WHERE class_id = '$get_id'") or die(mysqli_error($conn));

                                                $row_total_assignments = mysqli_fetch_assoc($taken_assignments);
                                                $total_assignments = $row_total_assignments['total_assignments'];

                                                while ($row = mysqli_fetch_array($my_student)) {
                                                    $student_id = $row['student_id'];

                                                    // Get the number of quizzes taken by the current student in the specific class
                                                    $student_quiz_taken = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM class_quiz
                                                    LEFT JOIN student_class_quiz ON class_quiz.class_quiz_id = student_class_quiz.class_quiz_id
                                                    WHERE class_quiz.teacher_class_id = '$get_id'
                                                    AND student_class_quiz.student_id = '$student_id'"));

                                                    // Get the number of assignments submitted by the current student in the specific class
                                                    $student_assignments_submitted = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM assignment
                                                    LEFT JOIN student_assignment ON assignment.assignment_id = student_assignment.assignment_id WHERE assignment.class_id = '$get_id'
                                                    AND student_assignment.student_id = '$student_id'"));

                                                    // Calculate the progress as a ratio of quizzes taken and assignments submitted by the student over the total quizzes and assignments in the class
                                                    $total_progress = (($student_quiz_taken + $student_assignments_submitted) > 0) ? (($student_quiz_taken + $student_assignments_submitted) / ($total_quizzes + $total_assignments)) * 100 : 0;

                                                    // Determine the submission status color
                                                    $submission_status = 'danger'; // Default color is red
                                                    if ($student_quiz_taken + $student_assignments_submitted === ($total_quizzes + $total_assignments)) {
                                                        $submission_status = 'success'; // All quizzes and assignments submitted
                                                    } elseif ($student_quiz_taken > 0 || $student_assignments_submitted > 0) {
                                                        $submission_status = 'warning'; // Partial quizzes or assignments submitted
                                                    }
                                                ?>
                                                    <tr class="text-center" id="del<?php echo $student_id; ?>">
                                                        <td><?php echo $row['lastname']; ?> <?php echo $row['firstname']; ?></td>
                                                        <td><?php echo $student_quiz_taken; ?> / <?php echo $total_quizzes; ?></td>
                                                        <td><?php echo $student_assignments_submitted; ?> / <?php echo $total_assignments; ?></td>
                                                        <td class="align-middle">
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $total_progress; ?>%;" aria-valuenow="<?php echo $total_progress; ?>" aria-valuemin="0" aria-valuemax="100">
                                                                    <span class="progress-label fw-bold"><?php echo $total_progress; ?>%</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="btn px-2 py-2 border border-3 border-black bg-<?php echo $submission_status; ?> rounded-circle" data-bs-toggle="tooltip" data-bs-original-title="<?php echo getTooltipDescription($submission_status); ?>"></span>
                                                            <script>
                                                                document.addEventListener('DOMContentLoaded', function() {
                                                                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                                                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                                                                        return new bootstrap.Tooltip(tooltipTriggerEl)
                                                                    })
                                                                });
                                                            </script>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>

                                            <?php
                                            function getTooltipDescription($submission_status)
                                            {
                                                switch ($submission_status) {
                                                    case 'success':
                                                        return 'All Simulations / Quizzes and RETDEMs submitted';
                                                    case 'warning':
                                                        return 'Partial Simulations / Quizzes or RETDEMs submitted';
                                                    case 'danger':
                                                    default:
                                                        return 'No Simulations / Quizzes or RETDEMs submitted';
                                                }
                                            }
                                            ?>

                                            <script>
                                                $(document).ready(function() {
                                                    $('#example').DataTable();
                                                });
                                            </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include('scripts.php'); ?>
</body>