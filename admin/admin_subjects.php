<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body vh-100">
        <?php include('sidebar_subjects.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container bg-body-tertiary rounded-3 p-2 table-responsive-lg" style="max-height: 550px; height: 550px;">
                <form>
                    <div class="container d-flex text-uppercase pt-1 px-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-collection-fill me-2"></i> subject list</h4>
                        </div>
                        <a href="admin_add_subject.php" class="btn btn-info mx-2"><i class="bi bi-plus-square-fill me-2"></i>add subject</a>
                        <a class="btn btn-danger mx-2 remove"><i class="bi bi-trash-fill"></i></a>
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
                                <th>subject code</th>
                                <th>subject title</th>
                                <th>actions</th>
                            </tr>
                        </thead>

                        <tbody class=" table-group-divider">
                            <?php
                            $subject_query = mysqli_query($conn, "select * from subject") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($subject_query)) {
                                $id = $row['subject_id'];
                            ?>
                                <tr id="del<?php echo $id; ?>">
                                    <td>
                                        <input id="optionsCheckbox" class="form-check-input" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                    </td>
                                    <td><?php echo $row['subject_code']; ?></td>
                                    <td><?php echo $row['subject_title']; ?></td>
                                    <td>
                                        <a class="btn btn-warning" title="Edit Subject" href="admin_edit_subject.php<?php echo '?id=' . $id; ?>" class="btn btn-success"><i class="bi bi-pencil-square"></i> EDIT SUBJECT</a>
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
                // Remove button click event
                $('.remove').click(function() {
                    var selectedSubjects = [];

                    // Get the selected subject IDs
                    $('input[name="selector[]"]:checked').each(function() {
                        selectedSubjects.push($(this).val());
                    });

                    if (selectedSubjects.length === 0) {
                        // No subjects selected, display an error message
                        $.jGrowl("No subjects selected for deletion.", {
                            header: 'Error',
                            theme: 'bg-warning',
                            life: 2000
                        });
                    } else {
                        // Confirm the deletion with the user
                        if (confirm("Are you sure you want to delete the selected subjects?")) {
                            // Perform AJAX request for deletion
                            $.ajax({
                                url: 'admin_subject_delete.php',
                                type: 'POST',
                                data: {
                                    selector: selectedSubjects
                                },
                                success: function(response) {
                                    if (response === 'success') {
                                        // Deletion succeeded
                                        $.jGrowl("Subjects deleted successfully.", {
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
                                        $.jGrowl("Error deleting subjects. Please try again later.", {
                                            header: 'Error',
                                            theme: 'bg-danger',
                                            life: 2000
                                        });
                                    }
                                },
                                error: function() {
                                    // Display error message
                                    $.jGrowl("Error deleting subjects. Please try again later.", {
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