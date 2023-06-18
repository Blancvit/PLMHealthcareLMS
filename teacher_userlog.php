<?php include('session.php'); ?>
<?php include('header.php'); ?>

<body>
    <?php include('navbar_teacher.php'); ?>

    
    <div class="d-flex">
        <?php include('teacher_sidebar_userlog.php'); ?>
        <div class="container-fluid my-4 justify-content-center pb-5">
            <div class="container mx-auto">
                <div class="container py-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-body rounded-3 p-3">
                            <?php
                            $school_year_query = mysqli_query($conn, "select * from school_year order by school_year DESC") or die(mysqli_error($conn));
                            $school_year_query_row = mysqli_fetch_array($school_year_query);
                            $school_year = $school_year_query_row['school_year'];
                            ?>
                            <li class="breadcrumb-item">
                                <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">School Year: <?php echo $school_year_query_row['school_year']; ?></a>
                            </li>
                            <li class="breadcrumb-item active">
                                User Log
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="container d-flex flex-wrap">
                    <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 mb-4" style="flex: 1; height: 550px; max-height:550px; overflow-y: auto;">
                        <div class="container d-flex bg-body-tertiary mx-0 rounded-top-3 p-2">
                            <div class="col text-uppercase pt-1 px-2">
                                <h4 style="font-weight: 800; color: #fff;">
                                    <i class="bi bi-person-lines-fill me-2"></i> student log
                                </h4>
                            </div>
                        </div>

                        <div class="container justify-content-sm-center p-3">
                            <div class="col justify-content-center">

                                <div class="col justify-content-center">
                                    <div class="table-responsive-lg">
                                        <table class="table table-striped align-middle justify-content-center" id="example">
                                            <thead>
                                                <tr class="text-uppercase text-center">
                                                    <th>date login</th>
                                                    <th>date logout</th>
                                                    <th>student no.</th>
                                                </tr>
                                            </thead>

                                            <tbody class=" table-group-divider">
                                                <?php
                                                $user_query = mysqli_query($conn, "select * from user_log_students order by user_log_id ") or die(mysqli_error($conn));
                                                while ($row = mysqli_fetch_array($user_query)) {
                                                    $id = $row['user_log_id'];
                                                ?>
                                                    <tr id="del<?php echo $id; ?>">
                                                        <td><?php echo $row['login_date']; ?></td>
                                                        <td><?php echo $row['logout_date']; ?></td>
                                                        <td><?php echo $row['username']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#example').DataTable();
                                                });
                                            </script>
                                        </table>
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