<?php
session_start();
include("../config/db.php");
$msg = "";
$success = "";
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $check_query = "SELECT * FROM users WHERE email='$email'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $msg = "Email already exists!";
    } elseif (strlen($password) < 6) {
        $msg = "Password must be at least 6 characters long!";
    } elseif ($password !== $confirm_password) {
        $msg = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_query = "INSERT INTO users (name, email, password)
                         VALUES ('$name', '$email', '$hashed_password')";
        if (mysqli_query($conn, $insert_query)) {
            $success = "Registration successful! You can now login.";
        } else {
            $msg = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register - NotesCircle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/user.css">
</head>

<body class="register-bg">
    <!-- HEADER -->
    <div class="top-header">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo-section">
                <img src="../uploads/logo.jpeg" class="logo">
                <span class="sites-name">Notes Circle</span>
            </div>
            <div class="nav-links">
                <a href="login.php">Login</a>
                <a href="register.php" class="active">Register</a>
            </div>
        </div>
    </div>
    <!-- REGISTER SECTION -->
    <div class="container register-wrapper">
        <div class="row align-items-center">
            <!-- LEFT SIDE FORM -->
            <div class="col-lg-6 col-md-12">
                <div class="register-card">
                    <h3 class="mb-4">Create Account</h3>
                    <?php if ($msg != ""): ?>
                        <div class="alert alert-danger"><?php echo $msg; ?></div>
                    <?php endif; ?>
                    <?php if ($success != ""): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" minlength="6" required>
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" minlength="6" required>
                        </div>
                        <button type="submit" name="register" class="rl-btn btn btn-primary w-100">
                            Register
                        </button>
                    </form>
                    <p class="mt-3 text-center">
                        Already have an account?
                        <a href="login.php">Login here</a>
                    </p>
                </div>
            </div>
            <!-- RIGHT SIDE INFO -->
            <div class="col-lg-6 info-section">
                <h1>Welcome to Notes Circle 🙏</h1>
                <p>
                    <b>Notes Circle Management System – A Web-Based Notes Sharing Platform</b> is a website made to help
                    students easily find and use study notes. It provides a simple platform where users can access
                    helpful learning materials in one place, making studying easier and more convenient.
                </p>
                <p>
                    Register or log in to join the Notes Circle Management System and start exploring the platform.
                </p>
            </div>
        </div>
    </div>
    <script src="../js/user.js"></script>
</body>

</html>