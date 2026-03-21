<?php
session_start();
include("../config/db.php");
/* Already logged in -> dashboard */
if (isset($_SESSION['admin'])) {
    header("Location: admin_dashboard.php");
    exit();
}
$error = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['admin'] = $row['username'];
        $_SESSION['admin_id'] = $row['admin_id'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login-page">
        <div class="login-box">
            <h2>Admin Login</h2>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <?php
            if ($error != "") {
                echo "<p class='error'>$error</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>