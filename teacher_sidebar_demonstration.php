<div class="sidebar flex-column flex-shrink-0 p-3 bg-body-tertiary" tabindex="-1" id="sidebarCollapse" style="width: 280px;">
    <div class="container">
        <img id="avatar" class="rounded mx-auto d-block img-thumbnail" style="height: 200px; width: 200px; object-fit: cover;" alt="NA" src="admin/<?php echo $row['location']; ?>">
    </div>
    <hr />
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="teacher_dashboard.php" class="nav-link link-body-emphasis" aria-current="page">
                <i class="bi bi-backspace-fill me-2"></i>
                Back
            </a>
        </li>
        <li class="nav-item">
            <a href="teacher_my_students.php<?php echo '?id=' . $get_id; ?>" class="nav-link link-body-emphasis" aria-current="page">
                <i class="bi bi-people-fill me-2"></i></i>
                My Students
            </a>
        </li>
        <li>
            <a href="teacher_subject_overview.php<?php echo '?id=' . $get_id; ?>" class="nav-link link-body-emphasis">
                <i class="bi bi-card-heading me-2"></i>
                Subject Overview
            </a>
        </li>
        <li>
            <a href="teacher_demonstration.php<?php echo '?id=' . $get_id; ?>" class="nav-link active">
                <i class="bi bi-clipboard-plus-fill me-2"></i>
                Demonstrations
            </a>
        </li>
        <li>
            <a href="teacher_announcement.php<?php echo '?id=' . $get_id; ?>" class="nav-link link-body-emphasis">
                <i class="bi bi-megaphone-fill me-2"></i>
                Announcements
            </a>
        </li>
        <li>
            <a href="teacher_simquiz.php<?php echo '?id=' . $get_id; ?>" class="nav-link link-body-emphasis">
                <i class="bi bi-list-task me-2"></i>
                Simulations / Quiz
            </a>
        </li>
    </ul>
    <hr />
</div>