<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
if (isset($_GET['id'])) {
    $note_id = intval($_GET['id']);
    /* ===== Get note file ===== */
    $stmt = $conn->prepare("SELECT file_name,status FROM notes WHERE note_id=?");
    $stmt->bind_param("i", $note_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if ($row['status'] != 'active') {
            die("This note is not available.");
        }
        if (empty($row['file_name'])) {
            die("No file attached with this note.");
        }
        $file = "../uploads/" . $row['file_name'];
        if (!file_exists($file)) {
            die("File not found.");
        }
        /* ===== Save download history ===== */
        $insert = $conn->prepare("INSERT INTO downloads (user_id,note_id,downloaded_at) VALUES (?,?,NOW())");
        $insert->bind_param("ii", $user_id, $note_id);
        $insert->execute();
        /* ===== Increase download counter ===== */
        $update = $conn->prepare("UPDATE notes SET downloads = downloads + 1 WHERE note_id=?");
        $update->bind_param("i", $note_id);
        $update->execute();
        /* ===== Activity log ===== */
        $log = $conn->prepare("INSERT INTO activity_log(user_id,action) VALUES (?,?)");
        $action = "Downloaded note ID " . $note_id;
        $log->bind_param("is", $user_id, $action);
        $log->execute();
        /* ===== Force download ===== */
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        flush();
        readfile($file);
        exit();
    }
}
header("Location: dashboard.php");
exit();
?>