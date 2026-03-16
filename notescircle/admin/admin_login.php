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

<style>

.login-page{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:#f2f2f2;
}

.login-box{
background:white;
padding:40px;
width:350px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,0.1);
text-align:center;
}

.login-box h2{
margin-bottom:20px;
}

.login-box input{
width:100%;
padding:10px;
margin-bottom:15px;
border:1px solid #ccc;
border-radius:5px;
}

.login-box button{
width:100%;
padding:10px;
background:#2c3e50;
color:white;
border:none;
border-radius:5px;
font-size:16px;
cursor:pointer;
}

.login-box button:hover{
background:#1a252f;
}

.error{
color:red;
margin-top:10px;
}

</style>

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
if($error != ""){
echo "<p class='error'>$error</p>";
}
?>

</div>

</div>

</body>
</html>