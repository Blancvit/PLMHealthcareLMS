<?php include('session.php'); ?>
<?php include('header.php'); ?>

<body>
    <?php include('navbar_student_account.php'); ?>

    <div class="container-fluid my-4 justify-content-center pb-5">
        <div class="container mx-auto">

            <div class="container d-flex">
                <div class="container bg-body rounded-3 justify-content-center align-items-center p-0 ms-3" style="flex: 1;">
                    <div class="container d-flex bg-body-tertiary mb-3 mx-0 rounded-top-3 p-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-person-fill-gear"></i> account settings</h4>
                        </div>
                    </div>

                    <div class="container justify-content-sm-center">
                        <div class="row justify-content-center">
                            <div class="container" >
                                <img id="avatar" class="rounded mx-auto d-block img-thumbnail" style="height: 200px; width: 200px; object-fit: cover;" alt="NA" src="admin/<?php echo $row['location']; ?>">
                            </div>
                            <form class="p-4" method="post" id="change_password">
                                <div class="alert alert-info p-2"><i class="bi bi-info-circle"></i> Password must contain more than <b>8 CHARACTERS</b> with at least <b>ONE LETTER</b>, <b>ONE NUMBER</b>, and <b>ONE SPECIAL CHARACTER</b></div>
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" id="current_password" class="form-control my_message" required></input>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" name="new_password" id="new_password" class="form-control my_message" required></input>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Retype Password</label>
                                    <div class="input-group">
                                        <input type="password" name="retype_password" id="retype_password" class="form-control my_message" required></input>
                                    </div>
                                </div>

                                <div class="">
                                    <button type="submit" class="btn btn-info"><i class="bi bi-save2-fill"></i> Save</button>
                                </div>
                            </form>

                            <div class="mb-3 ps-4 pb-2">
                                <button data-bs-toggle="modal" data-bs-target="#myModal_student" type="submit" class="btn btn-info"><i class="bi bi-image"></i> Change Account Picture</button>
                                <?php include('student_avatar_modal.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#change_password').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Get form data
                var currentPassword = $('#current_password').val();
                var newPassword = $('#new_password').val();
                var retypePassword = $('#retype_password').val();

                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: 'student_update_password.php',
                    data: {
                        current_password: currentPassword,
                        new_password: newPassword,
                        retype_password: retypePassword
                    },
                    dataType: 'json', // Set the expected response data type as JSON
                    success: function(response) {
                        // Handle the response from the server
                        if (response.status === 'success') {
                            // Password update successful
                            $.jGrowl(response.message, {
                                theme: 'bg-success',
                                life: 3000
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 1500); // Adjust the delay as needed

                            // You can customize the jGrowl settings and perform any other actions
                        } else {
                            // Password update failed
                            $.jGrowl(response.message, {
                                theme: 'bg-warning',
                                life: 5000,
                            });
                            // You can customize the jGrowl settings and perform any other actions
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle the AJAX request error
                        console.log('AJAX error:', error);
                        // You can display an error message or perform any other actions
                    }
                });
            });
        });
    </script>

    <?php include('scripts.php'); ?>
</body>