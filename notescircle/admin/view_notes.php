<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
include("../config/db.php");
/* NOTES + USER NAME */
$sql = "SELECT notes.note_id, notes.title, notes.content, notes.created_at,
        notes.updated_at, notes.downloads, notes.status, users.name
        FROM notes
        JOIN users ON notes.user_id = users.id
        ORDER BY notes.created_at DESC";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin - View Notes</title>
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
        <h1 class="page-title">All Notes</h1>
        <div class="table-section">
            <table class="dashboard-table">
                <tr>
                    <th>Note ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>User</th>
                    <th>Downloads</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['note_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td>
                                <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['name']); ?>
                            </td>
                            <td>
                                <?php echo $row['downloads']; ?>
                            </td>
                            <td>
                                <?php echo $row['status']; ?>
                            </td>
                           <td><?php echo date('F j, Y, g:i A', strtotime($row['created_at'])); ?></td>
                            <td><?php echo date('F j, Y, g:i A', strtotime($row['updated_at'])); ?></td>
                            <td>
                                <a href="delete_note.php?note_id=<?php echo $row['note_id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this note?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='9'>No notes found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>