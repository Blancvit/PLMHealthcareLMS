<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body">
        <?php include('sidebar_admin_users.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container bg-body-tertiary mb-3 mx-0 p-2 rounded-3">
                <div class="col text-uppercase pt-1 px-2">
                    <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i>add admin</h4>
                </div>
                <hr>
                <div class="container d-flex">
                    <div class="container">
                        <form method="post" id="add_user">

                            <div class="mb-3">
                                <label class="form-label">First Name:</label>
                                <div class="input-group">
                                    <input class="form-control" id="fn" type="text" name="firstname" required></input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name:</label>
                                <div class="input-group">
                                    <input class="form-control" id="ln" type="text" name="lastname" required></input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">User ID:</label>
                                <div class="input-group">
                                    <input class="form-control" id="user_id" type="text" name="username" required></input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password:</label>
                                <div class="input-group">
                                    <input class="form-control" id="password" type="password" name="password" required></input>
                                </div>
                            </div>
                            <button name="save" type="submit" value="post" class="btn btn-warning mb-3"><i class="bi bi-plus-square-fill me-2"></i> Add</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container bg-body-tertiary rounded-3 p-2 table-responsive-lg" style="height: 550px; max-height: 550px;">
                <form method="post">
                    <div class="container d-flex text-uppercase pt-1 px-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-people-fill me-2"></i> admin user list</h4>
                        </div>
                        <a class="btn btn-danger remove"><i class="bi bi-trash-fill"></i></a>
                    </div>
                    <hr>
                    <table class="table table-striped align-middle justify-content-center" id="example">
                        <thead>
                            <tr class="text-uppercase text-center">
                                <th><input class="form-check-input" type="checkbox" name="selectAll" id="checkAll" /></th>
                                <script>
                                    $("#checkAll").click(function() {
                                        $('input:checkbox').not(this).prop('checked', this.checked);
                                    });
                                </script>
                                <th>Name</th>
                                <th>Username / User ID</th>
                            </tr>
                        </thead>

                        <tbody class=" table-group-divider">
                            <?php
                            $user_query = mysqli_query($conn, "select * from users") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($user_query)) {
                                $id = $row['user_id'];
                            ?>
                                <tr id="del<?php echo $id; ?>">
                                    <td>
                                        <input id="optionsCheckbox" class="form-check-input" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                    </td>
                                    <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
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

        <script>
            $(document).ready(function() {
                $('#add_user').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    // Get the password input value
                    var password = $('#password').val();

                    // Validate password strength
                    if (!isPasswordStrong(password)) {
                        // Display an error message using jGrowl
                        $.jGrowl('Password should contain at least 8 characters, including uppercase, lowercase, and special characters.', {
                            header: 'Error',
                            theme: 'bg-danger',
                            life: 3000
                        });
                        return; // Stop form submission
                    }

                    // Proceed with form submission if password is strong
                    $.ajax({
                        url: 'admin_add_user_save.php',
                        type: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            response = JSON.parse(response); // Parse the JSON response

                            if (response.status === 'success') {
                                // Display a success message using jGrowl
                                $.jGrowl('Admin User added successfully!', {
                                    header: 'Success',
                                    theme: 'bg-success',
                                    life: 3000
                                });

                                // Reload the page after a delay
                                setTimeout(function() {
                                    location.reload();
                                }, 1000); // Adjust the delay as needed

                            } else {
                                // Display an error message using jGrowl
                                $.jGrowl(response.message, {
                                    header: 'Error',
                                    theme: 'bg-danger',
                                    life: 3000
                                });
                            }
                        },
                    });
                });

                // Function to validate password strength
                function isPasswordStrong(password) {
                    // Regular expressions for password requirements
                    var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/;
                    return regex.test(password);
                }
            });
        </script>


        <script>
            $(document).ready(function() {
                // Remove button click event
                $('.remove').click(function() {
                    var selectedTeacher = [];

                    // Get the selected subject IDs
                    $('input[name="selector[]"]:checked').each(function() {
                        selectedTeacher.push($(this).val());
                    });

                    if (selectedTeacher.length === 0) {
                        // No subjects selected, display an error message
                        $.jGrowl("No admin(s) selected for removal.", {
                            header: 'Error',
                            theme: 'bg-warning',
                            life: 2000
                        });
                    } else {
                        // Confirm the deletion with the user
                        if (confirm("Are you sure you want to remove the selected admin users?")) {
                            // Perform AJAX request for deletion
                            $.ajax({
                                url: 'admin_user_delete.php',
                                type: 'POST',
                                data: {
                                    selector: selectedTeacher
                                },
                                success: function(response) {
                                    if (response === 'success') {
                                        // Deletion succeeded
                                        $.jGrowl("Admin(s) removed successfully.", {
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
                                        $.jGrowl("Error removing admin. Please try again later.", {
                                            header: 'Error',
                                            theme: 'bg-danger',
                                            life: 2000
                                        });
                                    }
                                },
                                error: function() {
                                    // Display error message
                                    $.jGrowl("Error removing admin. Please try again later.", {
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

        <?php include('scripts.php'); ?>
</body>