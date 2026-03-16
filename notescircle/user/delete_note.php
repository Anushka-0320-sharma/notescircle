<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT file_name FROM notes WHERE note_id='$id'");
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $file_path = "../uploads/" . $row['file_name'];
        if (!empty($row['file_name']) && file_exists($file_path)) {
            unlink($file_path);
        }
        mysqli_query($conn, "DELETE FROM notes WHERE note_id='$id'");
    }
    header("Location: my_notes.php");
    exit();
}
?>