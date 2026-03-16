<?php
session_start();
include("../config/db.php");
$msg = "";
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);
    if (strlen($password) < 6) {
        $msg = "Password must be at least 6 characters long.";
    } else {
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $user_id = $row['id'];
                $action = "User logged in";
                $log = $conn->prepare("INSERT INTO activity_log (user_id,action) VALUES (?,?)");
                $log->bind_param("is", $user_id, $action);
                $log->execute();
                header("Location: dashboard.php");
                exit();
            } else {
                $msg = "Invalid Email or Password";
            }
        } else {
            $msg = "Invalid Email or Password";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - NoteCircle</title>
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
                <a href="login.php" class="active">Login</a>
                <a href="register.php">Register</a>
            </div>
        </div>
    </div>
    <!-- LOGIN SECTION -->
    <div class="container register-wrapper">
        <div class="row align-items-center">
            <!-- LEFT SIDE FORM -->
            <div class="col-lg-6 col-md-12">
                <div class="register-card">
                    <h3 class="mb-4">Login to Your Account</h3>
                    <?php
                    if ($msg != "") {
                        echo "<div class='alert alert-danger'>$msg</div>";
                    }
                    ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" minlength="6" required>
                        </div>
                        <button type="submit" name="login" class=" rl-btn btn btn-primary w-100">
                            Login
                        </button>
                    </form>
                    <p class="mt-3 text-center">
                        New user? <a href="register.php">Register here</a>
                    </p>
                </div>
            </div>
            <!-- RIGHT SIDE INFO -->
            <div class="col-lg-6 info-section">
                <h1>Welcome Back 👋</h1>
                <p>
                    Notes Circle Management System – A Web-Based Notes Sharing Platform</b> is a website made to help
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