<!-- Modal Markup -->
<div class="modal fade" id="myModal_student" tabindex="-1" role="dialog" aria-labelledby="myModal_studentLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModal_studentLabel">Change Account Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Select an image</label>
                        <input type="file" name="image" id="fileInput" class="form-control">
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-cloud-arrow-up-fill"></i> Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle form submission
        $('#uploadForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            // Check if a file was selected
            var fileInput = $('#fileInput');
            if (fileInput.get(0).files.length === 0) {
                // Show jGrowl notification for error (no file selected)
                $.jGrowl('Please select a file to upload', {
                    theme: 'bg-warning'
                });
                return;
            }

            // Create a new FormData object
            var formData = new FormData(this);

            $.ajax({
                url: 'student_avatar.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle the success response
                    console.log('Picture uploaded successfully');
                    console.log('File URL:', response.fileUrl);
                    // Show jGrowl notification for success
                    $('#myModal_student').modal('hide');
                    $.jGrowl('Picture uploaded successfully', {
                        theme: 'bg-success',
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 1000); // Adjust the delay as needed

                    // Add any additional logic here
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    console.error('Error uploading picture:', error);
                    // Show jGrowl notification for error
                    $.jGrowl('Error uploading picture', {
                        theme: 'bg-warning'
                    });
                    // Add any error handling logic here
                }
            });
        });
    });
</script>