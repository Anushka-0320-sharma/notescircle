<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
include("../config/db.php");
/* COUNTS */
$user_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
)['total'];
$note_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM notes")
)['total'];
$feedback_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM feedback")
)['total'];
$download_count = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM downloads")
)['total'];
/* LATEST NOTES */
$latest_notes = mysqli_query(
    $conn,
    "SELECT notes.note_id, notes.title, users.name
 FROM notes
 JOIN users ON notes.user_id = users.id
 ORDER BY notes.created_at DESC
 LIMIT 5"
);
/* LATEST FEEDBACK */
$latest_feedback = mysqli_query(
    $conn,
    "SELECT feedback.rating, feedback.message, users.name, notes.title
 FROM feedback
 JOIN users ON feedback.user_id = users.id
 JOIN notes ON feedback.note_id = notes.note_id
 ORDER BY feedback.feedback_id DESC
 LIMIT 5"
);
/* TOP DOWNLOADED NOTES */
$top_downloads = mysqli_query(
    $conn,
    "SELECT notes.title, COUNT(downloads.note_id) AS total_downloads
 FROM downloads
 JOIN notes ON downloads.note_id = notes.note_id
 GROUP BY downloads.note_id
 ORDER BY total_downloads DESC
 LIMIT 5"
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <!-- NAVBAR -->
    <div class="topbar">
        <img src="../uploads/logo.jpeg" class="logo">
        <div class="logo-name">
            Notes Circle - ADMIN
        </div>
        <div class="nav-links">
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="view_users.php">Users</a>
            <a href="view_notes.php">Notes</a>
            <a href="view_feedback.php">Feedback</a>
            <a href="admin_logout.php" class="logout">Logout</a>
        </div>
    </div>
    <div class="container">
        <h1 class="page-title">Admin Dashboard</h1>
        <!-- STATS CARDS -->
        <div class="admin-cards">
            <div class="admin-card users">
                <h3>Total Users</h3>
                <p><?php echo $user_count; ?></p>
            </div>
            <div class="admin-card notes">
                <h3>Total Notes</h3>
                <p><?php echo $note_count; ?></p>
            </div>
            <div class="admin-card feedback">
                <h3>Total Feedback</h3>
                <p><?php echo $feedback_count; ?></p>
            </div>
            <div class="admin-card downloads">
                <h3>Total Downloads</h3>
                <p><?php echo $download_count; ?></p>
            </div>
        </div>
        <!-- TOP DOWNLOADS -->
        <div class="table-section">
            <h2>🔥 Top Downloaded Notes</h2>
            <table class="dashboard-table">
                <tr>
                    <th>Note Title</th>
                    <th>Total Downloads</th>
                </tr>
                <?php while ($top = mysqli_fetch_assoc($top_downloads)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($top['title']); ?></td>
                        <td><?php echo $top['total_downloads']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <!-- LATEST NOTES -->
        <div class="table-section">
            <h2>📝 Latest Notes</h2>
            <table class="dashboard-table">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Uploaded By</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($latest_notes)) { ?>
                    <tr>
                        <td><?php echo $row['note_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <!-- LATEST FEEDBACK -->
        <div class="table-section">
            <h2>⭐ Latest Feedback</h2>
            <table class="dashboard-table">
                <tr>
                    <th>User</th>
                    <th>Note</th>
                    <th>Rating</th>
                    <th>Message</th>
                </tr>
                <?php while ($fb = mysqli_fetch_assoc($latest_feedback)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fb['name']); ?></td>
                        <td><?php echo htmlspecialchars($fb['title']); ?></td>
                        <td>⭐ <?php echo $fb['rating']; ?></td>
                        <td><?php echo htmlspecialchars($fb['message']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>