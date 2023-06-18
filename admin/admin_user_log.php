<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body vh-100">
        <?php include('sidebar_admin_user_log.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container bg-body-tertiary rounded-3 p-2 table-responsive-lg" style="max-height: 100vh;">
                <form method="post">
                    <div class="container d-flex text-uppercase pt-1 px-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-person-lines-fill me-2"></i> admin user logs</h4>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped align-middle justify-content-center" id="example">
                        <thead>
                            <tr class="text-uppercase text-center">
                                <th>date login</th>
                                <th>date logout</th>
                                <th>username / User id</th>
                            </tr>
                        </thead>

                        <tbody class=" table-group-divider">
                            <?php
                            $user_query = mysqli_query($conn, "SELECT * FROM user_log ORDER BY user_log_id ") or die(mysqli_error($conn));
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
                </form>
            </div>
        </div>

        <?php include('scripts.php'); ?>
</body>