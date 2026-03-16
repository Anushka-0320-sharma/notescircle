<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
include("../config/db.php");
if (!isset($_GET['id'])) {
    header("Location: view_users.php");
    exit;
}
$user_id = intval($_GET['id']);
/* Step 1: Delete user's notes */
mysqli_query($conn, "DELETE FROM notes WHERE user_id = $user_id");
/* Step 2: Delete saved notes */
mysqli_query($conn, "DELETE FROM save_notes WHERE user_id = $user_id");
/* Step 3: Delete downloads */
mysqli_query($conn, "DELETE FROM downloads WHERE user_id = $user_id");
/* Step 4: Delete feedback */
mysqli_query($conn, "DELETE FROM feedback WHERE user_id = $user_id");
/* Step 5: Delete user */
mysqli_query($conn, "DELETE FROM users WHERE id = $user_id");
/* redirect */
header("Location: view_users.php");
exit;
?>