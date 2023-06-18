<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body">
        <?php include('sidebar_class.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container bg-body-tertiary mb-3 mx-0 p-2 rounded-3">
                <div class="col text-uppercase pt-1 px-2">
                    <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i>add class</h4>
                </div>
                <hr>
                <div class="container">
                    <form method="post" id="add_class">
                        <div class="mb-3">
                            <label class="form-label">Class Name:</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="class_name" required></input>
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
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-collection-fill me-2"></i> class list</h4>
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
                            $class_query = mysqli_query($conn, "select * from class") or die(mysqli_error($conn));
                            while ($class_row = mysqli_fetch_array($class_query)) {
                                $id = $class_row['class_id'];
                            ?>
                                <tr id="del<?php echo $id; ?>">
                                    <td>
                                        <input id="optionsCheckbox" class="form-check-input" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                    </td>
                                    <td><?php echo $class_row['class_name']; ?></td>
                                    <td>
                                        <a class="btn btn-warning" title="Edit Subject" href="admin_edit_class.php<?php echo '?id=' . $id; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i> EDIT CLASS</a>
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
                $('#add_class').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    $.ajax({
                        url: 'admin_add_class.php',
                        type: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            response = JSON.parse(response); // Parse the JSON response

                            if (response.status === 'success') {
                                // Display a success message using jGrowl
                                $.jGrowl('Class added successfully!', {
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
                        $.jGrowl("No class selected for deletion.", {
                            header: 'Error',
                            theme: 'bg-warning',
                            life: 2000
                        });
                    } else {
                        // Confirm the deletion with the user
                        if (confirm("Are you sure you want to delete the selected classes?")) {
                            // Perform AJAX request for deletion
                            $.ajax({
                                url: 'admin_class_delete.php',
                                type: 'POST',
                                data: {
                                    selector: selectedClass
                                },
                                success: function(response) {
                                    if (response === 'success') {
                                        // Deletion succeeded
                                        $.jGrowl("Class deleted successfully.", {
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
                                        $.jGrowl("Error deleting class. Please try again later.", {
                                            header: 'Error',
                                            theme: 'bg-danger',
                                            life: 2000
                                        });
                                    }
                                },
                                error: function() {
                                    // Display error message
                                    $.jGrowl("Error deleting class. Please try again later.", {
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