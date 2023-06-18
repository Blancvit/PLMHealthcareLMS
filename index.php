<!-- index.php -->
<?php
require_once 'header.php';
?>

<body>
    <div class="container-fluid h-100 d-flex flex-column justify-content-center align-items-center mt-5">
        <div class="text-center">
            <img class="logo" src="admin/images/logo.png" alt="">
        </div>
        <div class="text-center mt-3 w-75">
            <h1>PLM Healthcare Learning System</h1>
            <p class="text-wrap">This portal provides healthcare students and professionals with a learning opportunity for practising client care in a safe virtual environment. Here you can access a number of simulation experiences that will engage you in clinical decision making.</p>
            <p class="fw-bold mt-5 text-mu">Please select your role:</p>
        </div>
    </div>
    <div>
        <!-- Login Form -->
        <?php include 'login_form.php'; ?>
    </div>
    <!-- Scripts -->
    <?php include 'scripts.php'; ?>
</body>

</html>