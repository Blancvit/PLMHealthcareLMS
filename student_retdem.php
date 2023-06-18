<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $get_id = $_GET['id']; ?>

<body>
    <?php include('navbar_student_retdem.php'); ?>

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
                            Return Demonstrations
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="container">
                <div class="container bg-body rounded-3 p-0 mb-4 me-3" style="overflow-y: auto; height: 550px; max-height: 550px;">
                    <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-top-3">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-clipboard-plus-fill me-2"></i> Return Demonstrations</h4>
                        </div>
                        <?php $query = mysqli_query($conn, "select * FROM assignment where class_id = '$get_id'  order by fdatein DESC") or die(mysqli_error($conn));
                        $count  = mysqli_num_rows($query);
                        ?>
                        <span class="badge bg-info my-2 me-2" style="height: 20px; width: 25px;"><?php echo $count; ?></span>
                    </div>

                    <div class="container justify-content-sm-center">
                        <div class="row justify-content-center">
                            <?php
                            $query = mysqli_query($conn, "select * FROM assignment where class_id = '$get_id'  order by fdatein DESC") or die(mysqli_error($conn));
                            $count = mysqli_num_rows($query);
                            if ($count == '0') { ?>
                                <div class="container p-4">
                                    <div class="alert alert-info"><i class="bi bi-info-circle-fill"></i> No RETDEM Currently Uploaded</div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="table-responsive-lg">
                                    <table class="table table-striped align-middle p-3 text-center justify-content-center" id="">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th>Date Uploaded</th>
                                                <th>File Name</th>
                                                <th>Description</th>
                                                <th>Deadline</th>
                                                <th>status</th>
                                                <th>Actions</th>
                                            </tr>

                                        </thead>
                                        <tbody class="table-group-divider">
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM assignment WHERE class_id = '$get_id' ORDER BY fdatein DESC") or die(mysqli_error($conn));
                                            while ($row = mysqli_fetch_array($query)) {
                                                $id = $row['assignment_id'];
                                                $floc = $row['floc'];

                                                // Check if the student has submitted the assignment
                                                $studentAssignmentQuery = mysqli_query($conn, "SELECT * FROM student_assignment WHERE assignment_id = '$id' AND student_id = '$session_id'") or die(mysqli_error($conn));
                                                $hasSubmitted = mysqli_num_rows($studentAssignmentQuery) > 0;

                                                // Check if the assignment has been graded
                                                $gradeQuery = mysqli_query($conn, "SELECT grade FROM student_assignment WHERE assignment_id = '$id' AND student_id = '$session_id'") or die(mysqli_error($conn));
                                                $hasGraded = mysqli_num_rows($gradeQuery) > 0;
                                                $grade = mysqli_fetch_assoc($gradeQuery);

                                                // Check if the deadline has passed
                                                $deadline = strtotime($row['deadline']);
                                                $currentDate = strtotime(date('Y-m-d'));
                                                $deadlinePassed = ($currentDate > $deadline);

                                                // Set the status based on submission and deadline
                                                if ($hasGraded && $grade['grade'] != '') {
                                                    // If the assignment has been graded, show "GRADED"
                                                    $status = 'GRADED';
                                                } elseif ($hasSubmitted && !$deadlinePassed) {
                                                    // If the student has submitted and the deadline hasn't passed, show "SUBMITTED"
                                                    $status = 'SUBMITTED';
                                                } elseif ($deadlinePassed) {
                                                    // If the deadline has passed, show "DEADLINE PASSED"
                                                    $status = 'DEADLINE PASSED';
                                                } else {
                                                    // If the student hasn't submitted and the deadline hasn't passed, show "NOT YET SUBMITTED"
                                                    $status = 'NOT YET SUBMITTED';
                                                }
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['fdatein']; ?></td>
                                                    <td><?php echo $row['fname']; ?></td>
                                                    <td><?php echo $row['fdesc']; ?></td>
                                                    <td><?php echo $row['deadline']; ?></td>
                                                    <td>
                                                        <?php
                                                        // Display the status badge based on the status
                                                        if ($status == 'SUBMITTED') {
                                                            echo '<span class="badge bg-info text-dark">SUBMITTED</span>';
                                                        } elseif ($status == 'DEADLINE PASSED') {
                                                            echo '<span class="badge bg-danger">DEADLINE PASSED</span>';
                                                        } elseif ($status == 'GRADED') {
                                                            echo '<span class="badge bg-success">GRADED</span>';
                                                        } else {
                                                            echo '<span class="badge bg-secondary">NOT YET SUBMITTED</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <form id="assign" method="post" action="student_submit_assignment.php<?php echo '?id=' . $get_id ?>&<?php echo 'post_id=' . $id ?>">
                                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                            <?php
                                                            if ($floc != "") {
                                                                // If the status is not "SUBMITTED," show the regular download button
                                                                echo '<button data-placement="bottom" title="Download" id="' . $id . 'download" class="btn btn-warning btn-sm my-2 mx-2" onclick="window.open(\'' . $floc . '\'); return false;"><i class="bi bi-download"></i></button>';
                                                            }
                                                            ?>
                                                            <button data-placement="bottom" title="Submit Assignment" id="<?php echo $id; ?>submit" class="btn btn-success btn-sm fw-medium text-uppercase" name="btn_assign" <?php echo ($deadlinePassed ? 'disabled' : ''); ?>>
                                                                <?php echo ($status == 'SUBMITTED' ? '<i class="bi bi-eye"></i> View' : ($status == 'GRADED' ? '<i class="bi bi-eye"></i> View' : '<i class="bi bi-plus-lg"></i> Submit')); ?>
                                                            </button>
                                                        </form>
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