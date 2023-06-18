<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body">
        <?php include('sidebar_dashboard.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container d-flex bg-body-tertiary mb-3 mx-0 p-2 rounded-3">
                <div class="col text-uppercase pt-1 px-2">
                    <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-bar-chart-fill me-2"></i> data numbers</h4>
                </div>
            </div>
            <div class="container row row-cols-3 d-flex mx-auto p-3">
                <?php
                $query_reg_teacher = mysqli_query($conn, "SELECT * FROM teacher WHERE teacher_status = 'Registered' ") or die(mysqli_error($conn));
                $count_reg_teacher = mysqli_num_rows($query_reg_teacher);
                ?>
                <div class="col box bg-body-tertiary rounded-3 mb-5 text-uppercase text-center p-4 mx-3" style="max-width: 350px;">
                    <div class="chart" data-percent="<?php echo $count_reg_teacher; ?>"></div>
                    <div class="chart-bottom-heading m-3">
                        <strong>Registered Teachers</strong>
                    </div>
                </div>

                <?php
                $query_teacher = mysqli_query($conn, "SELECT * FROM teacher") or die(mysqli_error($conn));
                $count_teacher = mysqli_num_rows($query_teacher);
                ?>
                <div class="col box bg-body-tertiary rounded-3 mb-5 text-uppercase text-center p-4 mx-3" style="max-width: 350px;">
                    <div class="chart" data-percent="<?php echo $count_teacher; ?>"></div>
                    <div class="chart-bottom-heading m-3">
                        <strong>Teachers</strong>
                    </div>
                </div>

                <?php
                $query_student = mysqli_query($conn, "SELECT * FROM student WHERE status='Registered'") or die(mysqli_error($conn));
                $count_student = mysqli_num_rows($query_student);
                ?>
                <div class="col box bg-body-tertiary rounded-3 mb-5 text-uppercase text-center p-4 mx-3" style="max-width: 350px;">
                    <div class="chart" data-percent="<?php echo $count_student ?>"></div>
                    <div class="chart-bottom-heading m-3">
                        <strong>Registered Students</strong>
                    </div>
                </div>

                <?php
                $query_student = mysqli_query($conn, "SELECT * FROM student") or die(mysqli_error($conn));
                $count_student = mysqli_num_rows($query_student);
                ?>
                <div class="col box bg-body-tertiary rounded-3 mb-5 text-uppercase text-center p-4 mx-3" style="max-width: 350px;">
                    <div class="chart" data-percent="<?php echo $count_student ?>"></div>
                    <div class="chart-bottom-heading m-3">
                        <strong>Students</strong>
                    </div>
                </div>

                <?php
                $query_class = mysqli_query($conn, "SELECT * FROM class") or die(mysqli_error($conn));
                $count_class = mysqli_num_rows($query_class);
                ?>
                <div class="col box bg-body-tertiary rounded-3 mb-5 text-uppercase text-center p-4 mx-3" style="max-width: 350px;">
                    <div class="chart" data-percent="<?php echo $count_class; ?>"></div>
                    <div class="chart-bottom-heading m-3">
                        <strong>Class</strong>
                    </div>
                </div>

                <?php
                $query_subject = mysqli_query($conn, "SELECT * FROM subject") or die(mysqli_error($conn));
                $count_subject = mysqli_num_rows($query_subject);
                ?>
                <div class="col box bg-body-tertiary rounded-3 mb-5 text-uppercase text-center p-4 mx-3" style="max-width: 350px;">
                    <div class="chart" data-percent="<?php echo $count_subject; ?>"></div>
                    <div class="chart-bottom-heading m-3">
                        <strong>Subjects</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            // Easy pie charts
            $('.chart').easyPieChart({
                animate: 1000,
                barColor: '#0d6efc',
                size: 200,
                lineCap: 'square',
                scaleLength: 0,
                lineWidth: 12,
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>