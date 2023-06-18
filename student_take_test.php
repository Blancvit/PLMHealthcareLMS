<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $get_id = $_GET['id']; ?>
<?php $class_quiz_id = $_GET['class_quiz_id']; $_SESSION['class_quiz_id'] = $class_quiz_id; ?>
<?php $quiz_id = $_GET['quiz_id']; ?>
<?php $quiz_time = $_GET['quiz_time']; ?>

<?php
$query1 = mysqli_query($conn, "SELECT * FROM student_class_quiz WHERE student_id = '$session_id' AND class_quiz_id = '$class_quiz_id' ") or die(mysqli_error($conn));
$count = mysqli_num_rows($query1);
if ($count > 0) {
} else {
    mysqli_query($conn, "INSERT INTO student_class_quiz (class_quiz_id,student_id,student_quiz_time) VALUES('$class_quiz_id','$session_id','$quiz_time')");
}
?>

<body>
    <?php include('navbar_student_areas.php'); ?>
    <!-- Breadcrumb -->
    <div class="container-fluid my-4 justify-content-center pb-5">
        <div class="container bg-body rounded-3 justify-content-center align-items-center p-0" style="width: 100%; height: 100%;">
            <div class="container bg-body mb-3 mx-0 rounded-3 p-0" style="width: 100%; height: 100%;">
                <?php
                if (isset($_GET['test']) && $_GET['test'] == 'ok') {
                    $sqlp = mysqli_query($conn, "SELECT * FROM class_quiz WHERE class_quiz_id = '$class_quiz_id'") or die(mysqli_error($conn));
                    $rowp = mysqli_fetch_array($sqlp);

                    $x = 0;
                ?>
                    <script>
                        jQuery(document).ready(function() {
                            var timer = 1;
                            jQuery(".questions-table input").hide();
                            setInterval(function() {
                                var timer = jQuery("#timer").text();
                                jQuery("#timer").load("timer.ajax.php");
                                if (timer == 0) {
                                    jQuery(".questions-table input").hide();
                                    jQuery("#submit-test").show();
                                    jQuery("#msg").text("Please submit your answers.");
                                } else {
                                    jQuery(".questions-table input").show();
                                }
                            }, 990);
                        });
                    </script>

                    <form action="student_take_test.php<?php echo '?id=' . $get_id; ?>&<?php echo 'class_quiz_id=' . $class_quiz_id; ?>&<?php echo 'test=done' ?>&<?php echo 'quiz_id=' . $quiz_id; ?>&<?php echo 'quiz_time=' . $quiz_time; ?>" name="testform" method="POST" id="test-form">
                        <?php
                        $sqla = mysqli_query($conn, "SELECT * FROM class_quiz LEFT JOIN quiz ON quiz.quiz_id  = class_quiz.quiz_id                                            
                                                                WHERE teacher_class_id = '$get_id' 
                                                                ORDER BY class_quiz.date_added DESC ") or die(mysqli_error($conn));
                        $rowa = mysqli_fetch_array($sqla);
                        ?>

                        <div class="mb-3 bg-body-tertiary text-uppercase px-3 py-2 rounded-top-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 style="font-weight: 800; color: #fff;"><b>Test Title: <?php echo $rowa['quiz_title']; ?></b></h3>
                                <div class="align-items-center">
                                    <p class="ms-auto"><b>Time Remaining (In minutes):</b>
                                        <span id="timer" class="badge bg-danger">1</span>
                                    </p>
                                    <div class="badge bg-warning" id="msg"></div>
                                </div>
                            </div>
                            <p><b>Description:</b> <?php echo $rowa['quiz_description']; ?></p>
                        </div>


                        <div class="container p-4">
                            <div class="mb-3">
                                <div class="questions-container p-4">
                                    <?php
                                    $sqlw = mysqli_query($conn, "SELECT * FROM quiz_question WHERE quiz_id = '$quiz_id'  ORDER BY quiz_question_id");
                                    $qt = mysqli_num_rows($sqlw);
                                    while ($roww = mysqli_fetch_array($sqlw)) {
                                        $x++;
                                    ?>
                                        <div id="q_<?php echo $x; ?>" class="question" <?php if ($x > 1) {
                                                                                            echo 'style="display: none;"';
                                                                                        } ?>>
                                            <div class="container mb-3 fs-3 fw-bolder">
                                                <div class="question-text"><?php echo $roww['question_text']; ?></div>
                                            </div>

                                            <?php if ($roww['question_type_id'] == '2') { ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="q-<?php echo $roww['quiz_question_id']; ?>" id="q-<?php echo $roww['quiz_question_id']; ?>-true" value="True">
                                                    <label class="form-check-label" for="q-<?php echo $roww['quiz_question_id']; ?>-true">True</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="q-<?php echo $roww['quiz_question_id']; ?>" id="q-<?php echo $roww['quiz_question_id']; ?>-false" value="False">
                                                    <label class="form-check-label" for="q-<?php echo $roww['quiz_question_id']; ?>-false">False</label>
													<script>simVideo.pause(); </script>
                                                </div>
                                                <?php } else if ($roww['question_type_id'] == '1') {
                                                $sqly = mysqli_query($conn, "SELECT * FROM answer WHERE quiz_question_id = '" . $roww['quiz_question_id'] . "'");
                                                while ($rowy = mysqli_fetch_array($sqly)) {
                                                ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="q-<?php echo $roww['quiz_question_id']; ?>" id="q-<?php echo $roww['quiz_question_id']; ?>-<?php echo $rowy['choices']; ?>" value="<?php echo $rowy['choices']; ?>">
                                                        <label class="form-check-label" for="q-<?php echo $roww['quiz_question_id']; ?>-<?php echo $rowy['choices']; ?>"><?php echo $rowy['choices']; ?>. <?php echo $rowy['answer_text']; ?></label>
                                                    </div>
													<script>simVideo.pause(); </script>
                                                <?php
                                                }
                                            } else {
                                                $sqly = mysqli_query($conn, "SELECT floc FROM quiz_question WHERE quiz_question_id = '" . $roww['quiz_question_id'] . "'");
                                                $row = mysqli_fetch_array($sqly);
                                                $file = $row["floc"];
                                                $ext = pathinfo($file, PATHINFO_EXTENSION);
                                                if ($ext == "mp4" || $ext == "mov" || $ext == "vob" || $ext == "mpeg" || $ext == "3gp" || $ext == "avi" || $ext == "wmv" || $ext == "mov" || $ext == "amv" || $ext == "svi" || $ext == "flv" || $ext == "mkv" || $ext == "webm" || $ext == "gif" || $ext == "asf") {
                                                ?>
                                                    <div class="video-container video-question">
                                                        <div class="video-wrapper">
                                                            <video width="100%" height="auto" id="simVideo" controls controlsList="nodownload">
                                                                <source src="<?php echo $row['floc']; ?>" type="video/mp4">
                                                                Sorry, your browser doesn't support the video element.
                                                            </video>
                                                        </div>
                                                    </div>

                                                <?php
                                                } else { ?>
                                                    <img src="<?php echo $row['floc']; ?>" alt=" " class="img-responsive">
                                            <?php
                                                }
                                            }
                                            ?>
                                            <input type="hidden" name="x-<?php echo $x; ?>" value="<?php echo $roww['quiz_question_id']; ?>">
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="submit-container">
                                        <button class="btn btn-info next-question text-uppercase" onclick="return false;" qn="<?php echo $x; ?>" id="next_<?php echo $x; ?>">Next<i class="bi bi-arrow-right-short"></i></button>
                                        <button class="btn btn-warning submit-test-btn text-uppercase" id="submit-test" name="submit_answer"><i class="bi bi-check2"></i> Submit</button>
                                    </div>
                                </div>
                                <input type="hidden" name="x" value="<?php echo $x; ?>">
                            </div>
                        </div>
                    </form>
                <?php
                } else if (isset($_POST['submit_answer'])) {
                    $x1 = $_POST['x'];
                    $totalscore = 0;
                    $score = 0;
                    for ($x = 1; $x <= $x1; $x++) {

                        $x2 = $_POST["x-$x"];
                        if (isset($_POST["q-$x2"])) {
                            $q = $_POST["q-$x2"];
                        } else {
                            $q = 0;
                        }

                        $sql = mysqli_query($conn, "SELECT * FROM quiz_question WHERE quiz_question_id = " . $x2 . "");
                        $row = mysqli_fetch_array($sql);
                        if (intval("0" . $row['question_type_id']) == 3) {
                        } else {
                            if ($row['answer'] == $q) {
                                $score = $score + 1;
                            }
                            $totalscore = $totalscore + 1;
                        }
                    }
                    mysqli_query($conn, "UPDATE student_class_quiz SET `student_quiz_time` = 3600, `grade` = '" . $score . " out of " . ($totalscore) . "' WHERE student_id = '$session_id' and class_quiz_id = '$class_quiz_id'") or die(mysqli_error($conn));
                    mysqli_query($conn, "UPDATE student_class_quiz SET `student_quiz_time` = 3600, `rightgrade` = '" . $score . "' WHERE student_id = '$session_id' and class_quiz_id = '$class_quiz_id'") or die(mysqli_error($conn));
                    ?>
                    <script>
                        window.location = 'student_progress.php<?php echo '?id=' . $get_id; ?>';
                    </script>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    </div>

    <script>
        jQuery(document).ready(function() {
            jQuery(".question").hide();
            jQuery("#q_1").show();
        });
    </script>

    <script>
        jQuery(document).ready(function() {
            var simVideo = document.getElementById("simVideo");
            var nq = 1; // Start with question ID 1
            var qn = 0;
            jQuery(".next-question").click(function() {
                qn = nq; // Save the current question ID
                nq++; // Increment to the next question ID
                if (jQuery('#q_' + nq).length) {
                    jQuery('#q_' + qn).fadeOut(function() {
                        jQuery('#q_' + nq).fadeIn();
                    });
                    simVideo.pause();
                } else {
                    jQuery(".question").hide();
                    jQuery("#submit-test").show();
                    jQuery("#msg").text("Please submit your answers.");
                }
            });

            jQuery("#submit-test").click(function() {
                if (confirm("Are you sure you want to submit the test?")) {
                    jQuery("#test-form").submit();
                }
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>

</html>