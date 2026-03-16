<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
include("../config/db.php");
/* ===== USERS WITH NOTES COUNT ===== */
$sql = "
SELECT users.id, users.name, users.email, users.created_at,
COUNT(notes.note_id) AS total_notes
FROM users
LEFT JOIN notes ON users.id = notes.user_id
GROUP BY users.id
ORDER BY users.created_at DESC
";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin - View Users</title>
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
        <h1 class="page-title">All Users</h1>
        <div class="table-section">
            <table class="dashboard-table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total Notes</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo $row['total_notes']; ?></td>
                            <td><?php echo date('F j, Y, g:i A', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="delete_user.php?id=<?php echo $row['id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>