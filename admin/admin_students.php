<?php
include('session.php');
include('header.php');
?>

<body>
    <?php include('navbar_admin.php'); ?>
    <!-- Breadcrumb -->
    <div class="d-flex bg-body">
        <?php include('sidebar_students.php'); ?>
        <div class="container-fluid my-4 justify-content-center">
            <div class="container bg-body-tertiary mb-3 mx-0 p-2 rounded-3">
                <div class="col text-uppercase pt-1 px-2">
                    <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-plus-square-fill me-2"></i>add student</h4>
                </div>
                <hr>
                <div class="container d-flex">
                    <div class="container">
                        <form method="post" id="add_student">
                            <div class="mb-3">
                                <label class="form-label">Class:</label>
                                <div class="input-group">
                                    <select name="class_id" class="form-select" required>
                                        <option value="" disabled selected class="text-muted">Select Class</option>
                                        <?php
                                        $cys_query = mysqli_query($conn, "SELECT * FROM class ORDER BY class_name");
                                        while ($cys_row = mysqli_fetch_array($cys_query)) {
                                        ?>
                                            <option value="<?php echo $cys_row['class_id']; ?>"><?php echo $cys_row['class_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Student Number:</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="un" required></input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">First Name:</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="fn" required></input>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Last Name:</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="ln" required></input>
                                </div>
                            </div>
							<div class="mb-3">
                                <label class="form-label">Email:</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="email" required></input>
                                </div>
                            </div>
                            <button name="save" type="submit" value="post" class="btn btn-warning mb-3"><i class="bi bi-plus-square-fill me-2"></i> Add</button>
                        </form>
                    </div>

                    <div class="container">
                        <form action="import.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">File (.csv):</label>
                                <input type="file" name="import_file" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <div class="controls">
                                    <label class="form-label">Import To:</label>
                                    <select name="import_class_id" class="form-select" id="import_class_id" required>
                                        <option value="" disabled selected hidden>Select Class To Import Students</option>
                                        <?php
                                        $import_query = mysqli_query($conn, "select * from class order by class_name");
                                        while ($import_row = mysqli_fetch_array($import_query)) {
                                        ?>
                                            <option value="<?php echo $import_row['class_id']; ?>"><?php echo $import_row['class_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="save_excel_data" class="btn btn-warning"><i class="bi bi-upload me-2"></i>Import</button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="container bg-body-tertiary rounded-3 p-2 table-responsive-lg" style="height: 550px; max-height: 550px;">
                <form method="post">
                    <div class="container d-flex text-uppercase pt-1 px-2">
                        <div class="col text-uppercase pt-1 px-2">
                            <h4 style="font-weight: 800; color: #fff;"><i class="bi bi-people-fill me-2"></i> Student list</h4>
                        </div>
                        <div class="">
                            <ul class="nav">
                                <li class="mx-2">
                                    <a class="btn btn-outline-secondary active" href="admin_students.php">All</a>
                                </li>
                                <li class="mx-2">
                                    <a class="btn btn-outline-secondary" href="admin_students_unreg.php">Unregistered</a>
                                </li>
                                <li class="mx-2">
                                    <a class="btn btn-outline-secondary" href="admin_students_reg.php">Registered</a>
                                </li>
                                <li class="mx-2">
                                    <a class="btn btn-danger remove"><i class="bi bi-trash-fill"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-striped align-middle justify-content-center" id="studentTable">
                        <thead>
                            <tr class="text-uppercase text-center">
                                <th><input class="form-check-input" type="checkbox" name="selectAll" id="checkAll" /></th>
                                <script>
                                    $("#checkAll").click(function() {
                                        $('input:checkbox').not(this).prop('checked', this.checked);
                                    });
                                </script>
                                <th>Name</th>
                                <th>student number</th>
                                <th>COURSE YEAR AND SECTION</th>
                                <th>status</th>
								<th>email</th>
                            </tr>
                        </thead>

                        <tbody class=" table-group-divider">
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM student LEFT JOIN class ON student.class_id = class.class_id ORDER BY student.student_id DESC") or die(mysqli_error($conn));
                            while ($row = mysqli_fetch_array($query)) {
                                $id = $row['student_id'];
                            ?>
                                <tr id="del<?php echo $id; ?>">
                                    <td>
                                        <input id="optionsCheckbox" class="form-check-input" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                    </td>
                                    <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['class_name']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
									<td><?php echo $row['email']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
		<script>
			$(document).ready(function() {
				$('#studentTable').DataTable({
					aLengthMenu: [
						[10, 25, 50, 100, -1],
						[10, 25, 50, 100, "All"]
					],
				});
			});
		</script>
        <script>
            $(document).ready(function() {
                $('#add_student').on('submit', function(e) {
                    e.preventDefault(); // Prevent the default form submission

                    $.ajax({
                        url: 'admin_add_student_save.php',
                        type: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            response = JSON.parse(response); // Parse the JSON response

                            if (response.status === 'success') {
                                // Display a success message using jGrowl
                                $.jGrowl('Student added successfully!', {
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
                    var selectedStudent = [];

                    // Get the selected subject IDs
                    $('input[name="selector[]"]:checked').each(function() {
                        selectedStudent.push($(this).val());
                    });

                    if (selectedStudent.length === 0) {
                        // No subjects selected, display an error message
                        $.jGrowl("No student(s) selected for removal.", {
                            header: 'Error',
                            theme: 'bg-warning',
                            life: 2000
                        });
                    } else {
                        // Confirm the deletion with the user
                        if (confirm("Are you sure you want to remove the selected students?")) {
                            // Perform AJAX request for deletion
                            $.ajax({
                                url: 'admin_student_delete.php',
                                type: 'POST',
                                data: {
                                    selector: selectedStudent
                                },
                                success: function(response) {
                                    if (response === 'success') {
                                        // Deletion succeeded
                                        $.jGrowl("Student(s) removed successfully.", {
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
                                        $.jGrowl("Error removing student. Please try again later.", {
                                            header: 'Error',
                                            theme: 'bg-danger',
                                            life: 2000
                                        });
                                    }
                                },
                                error: function() {
                                    // Display error message
                                    $.jGrowl("Error removing student. Please try again later.", {
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