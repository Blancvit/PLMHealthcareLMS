<div class="collapse d-md-block" id="sidebar">
    <?php include('count.php'); ?>

    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark h-100" style="width: 200px" id="sidebar">
        <hr />
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="#" class="nav-link active" aria-current="page">
                    <i class="bi bi-pencil-fill"></i>
                    My Class
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-bell-fill"></i>
                    Notification
                    <?php if ($not_read == '0') {
                    } else { ?>
                        <span class="badge text-bg-danger"><?php echo $not_read; ?></span>
                    <?php } ?>
                </a>
            </li>
            <?php
            $message_query = mysqli_query($conn, "select * from message where reciever_id = '$session_id' and message_status != 'read' ") or die(mysqli_error($conn));
            $count_message = mysqli_num_rows($message_query);
            ?>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-chat-dots-fill"></i>
                    Messages
                    <?php if ($count_message == '0') {
                    } else { ?>
                        <span class="badge text-bg-danger"><?php echo $count_message; ?></span>
                    <?php } ?>
                </a>
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-map-fill"></i>
                    Areas
                </a>
            </li>
        </ul>
        <hr />
    </div>
</div>