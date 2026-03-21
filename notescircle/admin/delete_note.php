<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
include("../config/db.php");
if (!isset($_GET['note_id'])) {
    header("Location: view_notes.php");
    exit;
}
$note_id = intval($_GET['note_id']);
/* NOTE FILE + COVER IMAGE GET */
$stmt = $conn->prepare("SELECT file_name,cover_image,title FROM notes WHERE note_id=?");
$stmt->bind_param("i", $note_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    header("Location: view_notes.php");
    exit;
}
$data = $result->fetch_assoc();
$file_name = $data['file_name'];
$cover_image = $data['cover_image'];
$title = $data['title'];
/* DELETE NOTE FILE */
$file_path = "../uploads/" . $file_name;
if ($file_name != "" && file_exists($file_path)) {
    unlink($file_path);
}
/* DELETE COVER IMAGE */
$cover_path = "../uploads/" . $cover_image;
if ($cover_image != "" && file_exists($cover_path)) {
    unlink($cover_path);
}
/* DELETE NOTE FROM DATABASE */
$delete = $conn->prepare("DELETE FROM notes WHERE note_id=?");
$delete->bind_param("i", $note_id);
$delete->execute();
/* ACTIVITY LOG */
$admin_id = 0; // admin action
$action = "Admin deleted note: " . $title;
$log = $conn->prepare("INSERT INTO activity_log(user_id,action) VALUES (?,?)");
$log->bind_param("is", $admin_id, $action);
$log->execute();
header("Location: view_notes.php");
exit;
?>