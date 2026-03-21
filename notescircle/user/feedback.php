<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$msg = "";
if (isset($_GET['note_id'])) {
    $note_id = intval($_GET['note_id']);
} else {
    header("Location: dashboard.php");
    exit();
}
/* ---------- NOTE TITLE + STATUS CHECK ---------- */
$note = $conn->prepare("SELECT title,status FROM notes WHERE note_id=?");
$note->bind_param("i", $note_id);
$note->execute();
$result = $note->get_result();
if ($result->num_rows == 0) {
    die("Note not found.");
}
$data = $result->fetch_assoc();
if ($data['status'] != "active") {
    die("This note is not available.");
}
$note_title = $data['title'];
/* ---------- SUBMIT FEEDBACK ---------- */
if (isset($_POST['submit_feedback'])) {
    $message = trim($_POST['message']);
    $rating = intval($_POST['rating']);
    if ($message == "") {
        $msg = "Message cannot be empty.";
    } elseif ($rating < 1 || $rating > 5) {
        $msg = "Rating must be between 1 and 5.";
    } else {
        $check = $conn->prepare("SELECT feedback_id FROM feedback WHERE user_id=? AND note_id=?");
        $check->bind_param("ii", $user_id, $note_id);
        $check->execute();
        $res = $check->get_result();
        if ($res->num_rows > 0) {
            $msg = "You already submitted feedback for this note.";
        } else {
            $stmt = $conn->prepare("INSERT INTO feedback (user_id,note_id,message,rating) VALUES (?,?,?,?)");
            $stmt->bind_param("iisi", $user_id, $note_id, $message, $rating);
            if ($stmt->execute()) {
                $action = "Submitted feedback for note: " . $note_title;
                $log = $conn->prepare("INSERT INTO activity_log(user_id,action) VALUES (?,?)");
                $log->bind_param("is", $user_id, $action);
                $log->execute();
                $msg = "Feedback submitted successfully!";
            } else {
                $msg = "Something went wrong.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Give Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/user.css">
</head>
<body>
    <button class="hamburger" onclick="toggleSidebar()">
        <i class="fa fa-bars"></i>
    </button>
    <div class="dashboard-wrapper">
        <!-- SIDEBAR -->
        <div class="sidebar" id="sidebar">
            <div class="logo-box">
                <img src="../uploads/logo.jpeg" class="logo">
                <h4 class="site-name">Notes Circle</h4>
            </div>
            <hr>
            <ul class="menu">
                <li><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="add_notes.php"><i class="fa-solid fa-circle-plus"></i> Add Note</a></li>
                <li><a href="my_notes.php"><i class="fa fa-book"></i> My Notes</a></li>
                <li><a href="saved_notes.php"><i class="fa fa-bookmark"></i> Saved Notes</a></li>
                <li><a href="logout.php" style="color:red;"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </div>
        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="section-header">
                <h4><i class="fa-solid fa-star"></i> Give Feedback</h4>
                <a href="dashboard.php" class="view-all">Back</a>
            </div>
            <div class="upload-card">
                <p><b>Note:</b> <?php echo htmlspecialchars($note_title); ?></p>
                <?php
                if ($msg != "") {
                    echo "<div class='alert alert-info'>$msg</div>";
                }
                ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-control" required>
                            <option value="">Select Rating</option>
                            <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="4">⭐⭐⭐⭐ Good</option>
                            <option value="3">⭐⭐⭐ Average</option>
                            <option value="2">⭐⭐ Poor</option>
                            <option value="1">⭐ Bad</option>
                        </select>
                    </div>
                    <br>
                    <button type="submit" name="submit_feedback" class="save-btn">
                        <i class="fa-solid fa-paper-plane"></i> Submit Feedback
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/user.js"></script>
</body>
</html>