<?php include('session.php'); ?>
<?php include('header.php'); ?>
<?php $get_id = $_GET['id']; ?>

<body>
    <?php include('navbar_student_announcements.php'); ?>

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
                            Announcements
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="container d-flex">
                <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 mb-4">
                    <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;">
                                <i class="bi bi-megaphone-fill me-2"></i> class announcements
                            </h4>
                        </div>
                    </div>

                    <div class="container justify-content-sm-center" style="overflow-y: auto; height: 550px; max-height: 550px;">
                        <div class="row justify-content-center p-3">
                            <div class="container justify-content-sm-center">
                                <div class="row justify-content-center">
                                    <div>
                                        <ul class="nav nav-pills mt-0 justify-content-start">
                                            <!-- Navigation links -->
                                        </ul>
                                    </div>
                                    <form action="read_message.php" method="post">
                                        <div class="container mt-3 mb-3"> <!-- Add a container with margin-top -->
                                            <div class="container p-0">
                                                <?php
                                                $query_announcement = mysqli_query($conn, "select * from teacher_class_announcements
																	where  teacher_class_id = '$get_id' order by date DESC
																	") or die(mysqli_error($conn));
                                                $count = mysqli_num_rows($query_announcement);
                                                if ($count > 0) {
                                                    while ($row = mysqli_fetch_array($query_announcement)) {
                                                        $id = $row['teacher_class_announcements_id'];
                                                ?>
                                                        <div class="container mt-3"> <!-- Add a container with margin-top -->
                                                            <div class="message-box border border-2 rounded-3 p-3" id="del<?php echo $id; ?>"> <!-- Add a class for the message box styling -->
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div class="message-content">
                                                                        <?php echo $row['content']; ?>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="justify-content-between align-items-center">
                                                                    <div class="text-muted">
                                                                        <i class="bi bi-calendar3"></i> <?php echo $row['date']; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }
                                                } else { ?>
                                                    <div class="alert alert-info p-2 mt-3"><i class="bi bi-info-circle"></i> No Announcements</div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </form>
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