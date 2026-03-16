<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
if (isset($_GET['note_id'])) {
    $note_id = intval($_GET['note_id']);
    /* check if already saved */
    $stmt = $conn->prepare("SELECT * FROM save_notes WHERE user_id=? AND note_id=?");
    $stmt->bind_param("ii", $user_id, $note_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO save_notes (user_id, note_id, saved_at) VALUES (?, ?, NOW())");
        $insert->bind_param("ii", $user_id, $note_id);
        $insert->execute();
    }
}
header("Location: dashboard.php");
exit();
?>