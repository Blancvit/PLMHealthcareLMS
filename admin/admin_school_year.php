<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body">
        <?php include('sidebar_school_year.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container bg-body-tertiary mb-3 mx-0 p-2 rounded-3">
                <div class="col text-uppercase pt-1 px-2">
                    <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i>add school year</h4>
                </div>
                <hr>
                <div class="container">
                    <form method="post" id="add_school_year">
                        <div class="mb-3">
                            <label class="form-label">School Year:</label>
                            <div class="input-group">
                                <input class="form-control" type="text" oninput="validateInput(this)" name="school_year" required></input>
                            </div>
                        </div>
                        <button name="save" type="submit" value="post" class="btn btn-warning mb-3"><i class="bi bi-plus-square-fill me-2"></i> Add</button>
                    </form>
                </div>
            </div>
            <div class="container bg-body-tertiary rounded-3 p-2 table-responsive-lg" style="height: 550px; max-height: 550px;">
                <form method="post">
                    <div class="container d-flex text-uppercase pt-1 px-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-collection-fill me-2"></i> school year list</h4>
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
                                <th>COURSE YEAR AND SECTION</th>
                                <th>actions</th>
                            </tr>
                        </thead>

                        <tbody class=" table-group-divider">
                            <?php
                            $user_query = mysqli_query($conn, "SELECT * FROM school_year") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($user_query)) {
                                $id = $row['school_year_id'];
                            ?>
                                <tr id="del<?php echo $id; ?>">
                                    <td>
                                        <input id="optionsCheckbox" class="form-check-input" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                    </td>
                                    <td><?php echo $row['school_year']; ?></td>
                                    <td>
                                        <a class="btn btn-warning" title="Edit School Year" href="admin_edit_school_year.php<?php echo '?id=' . $id; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i> EDIT SCHOOL YEAR</a>
                                    </td>
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
                $('#add_school_year').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    $.ajax({
                        url: 'admin_add_school_year.php',
                        type: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            response = JSON.parse(response); // Parse the JSON response

                            if (response.status === 'success') {
                                // Display a success message using jGrowl
                                $.jGrowl('School Year added successfully!', {
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
            });
        </script>

        <script>
            $(document).ready(function() {
                // Remove button click event
                $('.remove').click(function() {
                    var selectedClass = [];

                    // Get the selected subject IDs
                    $('input[name="selector[]"]:checked').each(function() {
                        selectedClass.push($(this).val());
                    });

                    if (selectedClass.length === 0) {
                        // No subjects selected, display an error message
                        $.jGrowl("No school year selected for deletion.", {
                            header: 'Error',
                            theme: 'bg-warning',
                            life: 2000
                        });
                    } else {
                        // Confirm the deletion with the user
                        if (confirm("Are you sure you want to delete the selected school year?")) {
                            // Perform AJAX request for deletion
                            $.ajax({
                                url: 'admin_school_year_delete.php',
                                type: 'POST',
                                data: {
                                    selector: selectedClass
                                },
                                success: function(response) {
                                    if (response === 'success') {
                                        // Deletion succeeded
                                        $.jGrowl("School Year deleted successfully.", {
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
                                        $.jGrowl("Error deleting school year. Please try again later.", {
                                            header: 'Error',
                                            theme: 'bg-danger',
                                            life: 2000
                                        });
                                    }
                                },
                                error: function() {
                                    // Display error message
                                    $.jGrowl("Error deleting school year. Please try again later.", {
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

        <script>
            function validateInput(inputField) {
            var inputValue = inputField.value;
            var pattern = /^\d{4}-\d{4}$/;

            if (!pattern.test(inputValue)) {
                inputField.value = inputValue.replace(/[^0-9!@#$%^&*()_+|{}[\]:'<>,.?/~`-]/g, '');
            }
            }
        </script>

        <?php include('scripts.php'); ?>
</body>