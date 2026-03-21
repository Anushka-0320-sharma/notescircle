<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
include("../config/db.php");
/* GET FEEDBACK */
$sql = "SELECT feedback.feedback_id, feedback.rating, feedback.message, feedback.created_at,
        users.name, notes.title
        FROM feedback
        JOIN users ON feedback.user_id = users.id
        JOIN notes ON feedback.note_id = notes.note_id
        ORDER BY feedback.created_at DESC";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - View Feedback</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <!-- TOPBAR -->
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
        <h1 class="page-title">All Feedback</h1>
        <div class="table-section">
            <table class="dashboard-table">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Note</th>
                    <th>Rating</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $stars = str_repeat("⭐", $row['rating']);
                        ?>
                        <tr>
                            <td><?php echo $row['feedback_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo $stars; ?></td>
                            <td>
                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                            </td>
                            <td><?php echo date('F j, Y, g:i A', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="delete_feedback.php?id=<?php echo $row['feedback_id']; ?>"
                                    onclick="return confirm('Delete this feedback?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='7'>No Feedback Found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>