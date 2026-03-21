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
    $stmt = $conn->prepare("DELETE FROM save_notes WHERE user_id=? AND note_id=?");
    $stmt->bind_param("ii", $user_id, $note_id);
    $stmt->execute();
}
header("Location: saved_notes.php");
exit();
?>