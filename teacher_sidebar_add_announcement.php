<?php include('teacher_count.php'); ?>

<div class="sidebar flex-column flex-shrink-0 p-3 bg-body-tertiary" tabindex="-1" id="sidebarCollapse" style="width: 280px;">
    <div class="container">
        <img id="avatar" class="rounded mx-auto d-block img-thumbnail" style="height: 200px; width: 200px; object-fit: cover;" alt="NA" src="admin/<?php echo $row['location']; ?>">
    </div>
    <hr />
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="teacher_dashboard.php" class="nav-link link-body-emphasis" aria-current="page">
                <i class="bi bi-person-workspace me-2"></i>
                My Class
            </a>
        </li>
        <li class="nav-item">
            <a href="teacher_notification.php" class="nav-link link-body-emphasis" aria-current="page">
                <i class="bi bi-bell-fill me-2"></i>
                Notification
                <?php if ($not_read == '0') {
                } else { ?>
                    <span class="badge bg-danger rounded-pill"><?php echo $not_read; ?></span>
                <?php } ?>
            </a>
        </li>
        <li>
            <?php
            $message_query = mysqli_query($conn, "select * from message where reciever_id = '$session_id' and message_status != 'read' ") or die(mysqli_error($conn));
            $count_message = mysqli_num_rows($message_query);
            ?>
            <a href="teacher_message.php" class="nav-link link-body-emphasis">
                <i class="bi bi-chat-right-dots-fill me-2"></i>
                Message
                <?php if ($count_message == '0') {
                } else { ?>
                    <span class="badge bg-danger rounded-pill"><?php echo $count_message; ?></span>
                <?php } ?>
            </a>
        </li>
        <li>
            <a href="teacher_add_announcement.php" class="nav-link active">
                <i class="bi bi-megaphone-fill me-2"></i>
                Add Announcements
            </a>
        </li>
        <li>
            <a href="teacher_add_demo.php" class="nav-link link-body-emphasis">
                <i class="bi bi-clipboard-plus-fill me-2"></i>
                Add Demonstration
            </a>
        </li>
        <li>
            <a href="teacher_add_simquiz.php" class="nav-link link-body-emphasis">
                <i class="bi bi-list-task me-2"></i>
                Add Simulations / Quiz
            </a>
        </li>
        <li>
            <a href="teacher_userlog.php" class="nav-link link-body-emphasis">
                <i class="bi bi-person-lines-fill me-2"></i>
                Student Log
            </a>
        </li>
    </ul>
    <hr />
</div>