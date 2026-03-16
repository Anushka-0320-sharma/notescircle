<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
/* -------- MY UPLOADED NOTES -------- */
$sql = "SELECT * FROM notes WHERE user_id=? ORDER BY note_id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
/* -------- SAVED NOTES -------- */
$saved = $conn->prepare(
    "SELECT notes.* FROM save_notes
JOIN notes ON save_notes.note_id = notes.note_id
WHERE save_notes.user_id=?"
);
$saved->bind_param("i", $user_id);
$saved->execute();
$saved_result = $saved->get_result();
/* -------- DOWNLOADED NOTES -------- */
$downloaded = $conn->prepare(
    "SELECT DISTINCT notes.* FROM downloads
JOIN notes ON downloads.note_id = notes.note_id
WHERE downloads.user_id=?"
);
$downloaded->bind_param("i", $user_id);
$downloaded->execute();
$downloaded_result = $downloaded->get_result();
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Notes</title>
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
                <h4><i class="fa-solid fa-file-lines"></i> My Uploaded Notes</h4>
                <a href="add_notes.php" class="view-all">+ Add New</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Content</th>
                            <th>Rating</th>
                            <th>View</th>
                            <th>Download</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?php if (!empty($row['cover_image'])) { ?>
                                        <img src="../uploads/<?php echo htmlspecialchars($row['cover_image']); ?>"
                                            class="cover-thumb">
                                    <?php } else {
                                        echo "No Image";
                                    } ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><span class="category-file"><?php echo htmlspecialchars($row['category']); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($row['content']); ?></td>
                                <td>
                                    <?php
                                    $note_id = $row['note_id'];
                                    $rating = mysqli_query(
                                        $conn,
                                        "SELECT AVG(rating) as avg_rating FROM feedback WHERE note_id='$note_id'"
                                    );
                                    $data = mysqli_fetch_assoc($rating);
                                    if ($data['avg_rating'] != NULL) {
                                        echo round($data['avg_rating'], 1);
                                    } else {
                                        echo "No Rating";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['file_name'])) { ?>
                                        <a href="../uploads/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank"
                                            class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    <?php } else {
                                        echo "No File";
                                    } ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['file_name'])) { ?>
                                        <a href="download.php?id=<?php echo $row['note_id']; ?>" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    <?php } else {
                                        echo "-";
                                    } ?>
                                </td>
                                <td><?php echo date('F j, Y, g:i A', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <a href="edit_note.php?id=<?php echo $row['note_id']; ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="delete_note.php?id=<?php echo $row['note_id']; ?>"
                                        onclick="return confirm('Delete this note?')" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- SAVED NOTES -->
            <div class="section-header">
                <h4 style="margin-top:20px;"><i class="fa-solid fa-bookmark"></i> Saved Notes</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>View</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $saved_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><span class="category-file"><?php echo htmlspecialchars($row['category']); ?></span>
                                </td>
                                <td>
                                    <a href="../uploads/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="download.php?id=<?php echo $row['note_id']; ?>" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- DOWNLOADED NOTES -->
            <div class="section-header">
                <h4 style="margin-top:20px;"><i class="fa-solid fa-download"></i> Downloaded Notes</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $downloaded_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><span class="category-file"><?php echo htmlspecialchars($row['category']); ?></span>
                                </td>
                                <td>
                                    <a href="../uploads/<?php echo htmlspecialchars($row['file_name']); ?>" target="_blank"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../js/user.js"></script>
</body>

</html>