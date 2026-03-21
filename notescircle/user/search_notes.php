<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$search = "";
if (isset($_GET['q'])) {
    $search = mysqli_real_escape_string($conn, $_GET['q']);
}
$sql = "SELECT notes.note_id, notes.title, notes.category, notes.downloads, users.name
        FROM notes
        JOIN users ON notes.user_id = users.id
        WHERE notes.status='active'
        AND (notes.title LIKE '%$search%'
        OR notes.category LIKE '%$search%'
        OR notes.tags LIKE '%$search%')
        ORDER BY notes.created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Notes</title>
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
                <h4><i class="fa-solid fa-magnifying-glass"></i> Search Notes</h4>
                <a href="dashboard.php" class="view-all">Back</a>
            </div>
            <div class="upload-card">
                <form method="GET">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="q" class="form-control"
                                placeholder="Search by title, category or tags"
                                value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="save-btn">
                                <i class="fa-solid fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Uploaded By</th>
                            <th>Downloads</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td>
                                        <span class="category-file">
                                            <?php echo htmlspecialchars($row['category']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo $row['downloads']; ?></td>
                                    <td>
                                        <a href="download.php?id=<?php echo $row['note_id']; ?>" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5'>No notes found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../js/user.js"></script>
</body>
</html>