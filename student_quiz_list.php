<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php if (empty($_GET['area'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit();
} else {
    $get_area = $_GET['area'];
}
?>

<body>
    <?php include('navbar_student_areas.php'); ?>
    <!-- Breadcrumb -->
    <div class="container-fluid my-4 justify-content-center pb-5">
        <div class="container mx-auto">
            <div class="container py-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-body rounded-3 p-3">
                        <?php $class_query = mysqli_query($conn, "SELECT * FROM teacher_class
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
                        <li class="breadcrumb-item">
                            <a class="link-body-emphasis fw-semibold text-decoration-none"> Areas </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Simulation & Quiz List
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="container">
                <div class="container bg-body rounded-3 p-0 mb-4 me-3">
                    <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-top-3">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-list-task"></i> Simulations &amp; Quizzes</h4>
                        </div>
                        <a class="me-3" href="student_map.php<?php echo '?id=' . $get_id; ?>">
                            <button class="btn btn-outline-secondary mt-1"><i class="bi bi-arrow-bar-left"></i> Back</button>
                        </a>
                        <?php $query = mysqli_query($conn, "SELECT * FROM class_quiz 
										LEFT JOIN quiz on class_quiz.quiz_id = quiz.quiz_id
										WHERE teacher_class_id = '$get_id' and quiz.area = '$get_area' ") or die(mysqli_error($conn));
                        $count = mysqli_num_rows($query);
                        ?>
                        <span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count; ?></span>
                    </div>

                    <div class="container justify-content-sm-center" style="overflow-y: auto; height: 550px; max-height: 550px;">
                        <div class="row justify-content-center">
                            <?php
                            if ($count == '0') { ?>
                                <div class="container p-4">
                                    <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> No Simulation / Quiz Available</div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="table-responsive-lg">
                                    <table class="table table-striped align-middle p-3 text-center justify-content-center" id="">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>time (in minutes)</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-group-divider">
                                            <?php
                                            while ($row = mysqli_fetch_array($query)) {
                                                $id  = $row['class_quiz_id'];
                                                $quiz_id  = $row['quiz_id'];
                                                $quiz_time  = $row['quiz_time'];

                                                $query1 = mysqli_query($conn, "SELECT * FROM student_class_quiz WHERE class_quiz_id = '$id' AND student_id = '$session_id'") or die(mysqli_error($conn));
                                                $row1 = mysqli_fetch_array($query1);
                                                $grade = $row1['grade'] ?? '';
                                            ?>
                                                <tr>
                                                    
                                                    <td><?php echo $row['quiz_title']; ?></td>
                                                    <td><?php echo $row['quiz_description']; ?></td>
                                                    <td><?php echo $row['quiz_time'] / 60; ?></td>
                                                    <td>
                                                        <?php if ($grade == "") { ?>
                                                            <a data-placement="bottom" title="Take This Quiz" id="<?php echo $id; ?>Download" href="student_take_test.php<?php echo '?id=' . $get_id ?>&<?php echo 'class_quiz_id=' . $id; ?>&<?php echo 'test=ok' ?>&<?php echo 'quiz_id=' . $quiz_id; ?>&<?php echo 'quiz_time=' . $quiz_time;     ?>"><i class="icon-check icon-large"></i>
                                                                <button class="btn btn-info btn-sm">
                                                                    Take This Quiz
                                                                </button>
                                                            </a>
                                                        <?php } else { ?>
                                                            <span class="badge bg-success">ALREADY TAKEN</span>
                                                        <?php } ?>
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

        <?php include('scripts.php'); ?>
</body>