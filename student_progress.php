<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $get_id = $_GET['id']; ?>

<body>
    <?php include('navbar_student_progress.php'); ?>
    <!-- Breadcrumb -->
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
                            Grades
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="container d-flex">
                <!-- RETDEM Records -->
                <div class="container bg-body rounded-3 p-0 mb-3 me-3" style="overflow-y: auto; height: 550px; max-height: 550px;">
                    <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-file-text-fill me-2"></i>submitted retdem progress</h4>
                        </div>
                        <?php
                        $query = mysqli_query($conn, "SELECT sa.* FROM student_assignment sa
                        INNER JOIN assignment a ON sa.assignment_id = a.assignment_id
                        WHERE sa.student_id = '$session_id' AND a.class_id = '$get_id'
                        ORDER BY sa.assignment_fdatein DESC") or die(mysqli_error($conn));
                        $count = mysqli_num_rows($query);
                        ?>
                        <span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count; ?></span>
                    </div>

                    <div class="container justify-content-sm-center">
                        <div class="row justify-content-center p-3">
                            <?php
                            if ($count == '0') { ?>
                                <div class="container p-4">
                                    <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> No Return Demonstrations Submitted Yet.</div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="table-responsive-lg">
                                    <table class="table table-striped p-3 text-center" id="">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th>Date Uploaded</th>
                                                <th>retdem task</th>
                                                <th>grade</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-group-divider">
                                            <?php
                                            while ($row = mysqli_fetch_array($query)) {
                                                $id  = $row['student_assignment_id'];
                                                $student_id = $row['student_id'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['assignment_fdatein']; ?></td>
                                                    <td><?php echo $row['fname']; ?></td>
                                                    <?php if ($session_id == $student_id) { ?>
                                                        <td>
                                                            <?php if ($row['grade'] != null) { ?>
                                                                <span class="badge bg-success"><?php echo $row['grade']; ?></span>
                                                            <?php } else { ?>
                                                                <span class="badge bg-secondary">NOT GRADED</span>
                                                            <?php } ?>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- Simulation / Quiz Records -->
                <div class="container bg-body rounded-3 mb-3 p-0 ms-3" style="overflow-y: auto; height: 550px; max-height: 550px;">
                    <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-file-text-fill me-2"></i> simulation / quiz progress</h4>
                        </div>
                        <?php $query = mysqli_query($conn, "SELECT * FROM class_quiz 
							LEFT JOIN quiz on class_quiz.quiz_id = quiz.quiz_id
							where teacher_class_id = '$get_id' order by class_quiz_id DESC ") or die(mysqli_error($conn));
                        $count  = mysqli_num_rows($query);
                        ?>
                        <span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count; ?></span>
                    </div>

                    <div class="container justify-content-sm-center">
                        <div class="row justify-content-center p-3">
                            <?php
                            if ($count == '0') { ?>
                                <div class="container p-4">
                                    <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> No Simulations / Quizzes right now.</div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="table-responsive-lg">
                                    <table class="table table-striped p-3 text-center" id="">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th>Title</th>
                                                <th>time (min)</th>
                                                <th>area</th>
                                                <th>progress</th>
                                                <th>score</th>
                                            </tr>
                                        </thead>

                                        <tbody class="table-group-divider">
                                            <?php
                                            $query = mysqli_query($conn, "select * FROM class_quiz 
										LEFT JOIN quiz on class_quiz.quiz_id = quiz.quiz_id
										where teacher_class_id = '$get_id' order by class_quiz_id DESC ") or die(mysqli_error($conn));
                                            while ($row = mysqli_fetch_array($query)) {
                                                $id  = $row['class_quiz_id'];
                                                $quiz_id  = $row['quiz_id'];
                                                $quiz_time  = $row['quiz_time'];

                                                $query1 = mysqli_query($conn, "select * from student_class_quiz where class_quiz_id = '$id' and student_id = '$session_id'") or die(mysqli_error($conn));
                                                $row1 = mysqli_fetch_array($query1);
                                                $grade = $row1['grade'] ?? '';

                                            ?>
                                                <?php if ($grade == "") { ?>
                                                    <tr>
                                                        <td><?php echo $row['quiz_title']; ?></td>
                                                        <td><?php echo $row['quiz_time'] / 60; ?></td>
                                                        <td><?php echo $row['area']; ?></td>
                                                        <td>
                                                            <span class="badge bg-secondary">NOT YET TAKEN</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-secondary">NA</span>
                                                        </td>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td><?php echo $row['quiz_title']; ?></td>
                                                        <td><?php echo $row['quiz_time'] / 60; ?></td>
                                                        <td><?php echo $row['area']; ?></td>
                                                        <td>
                                                            <span class="badge bg-success">ALREADY TAKEN</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-success"><?php echo $grade; ?></span>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
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