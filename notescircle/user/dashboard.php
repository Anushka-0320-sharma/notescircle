<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
/* USER PROFILE */
$user_query = $conn->prepare("SELECT name,profile_photo FROM users WHERE id=?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
/* PROFILE PHOTO UPLOAD */
if (isset($_POST['upload_photo'])) {
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($ext, $allowed)) {
            $newname = time() . "_profile." . $ext;
            move_uploaded_file($_FILES['profile_photo']['tmp_name'], "../uploads/" . $newname);
            $update = $conn->prepare("UPDATE users SET profile_photo=? WHERE id=?");
            $update->bind_param("si", $newname, $user_id);
            $update->execute();
            header("Location: dashboard.php");
            exit();
        }
    }
}
/* MY NOTES */
$my_stmt = $conn->prepare("SELECT * FROM notes WHERE user_id=? ORDER BY created_at DESC");
$my_stmt->bind_param("i", $user_id);
$my_stmt->execute();
$my_notes = $my_stmt->get_result();
/* DISCOVER NOTES */
$sql = "SELECT notes.*, users.name
FROM notes
JOIN users ON notes.user_id = users.id
WHERE notes.user_id != ?
ORDER BY notes.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$other_notes = $stmt->get_result();
$total_notes = $other_notes->num_rows;
?>
<!DOCTYPE html>
<html>

<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
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
            <div class="profile-box">
                <?php if ($user['profile_photo'] != "") { ?>
                    <img src="../uploads/<?php echo $user['profile_photo']; ?>" class="profile-img">
                <?php } else { ?>
                    <img src="../uploads/default.jpg" class="profile-img">
                <?php } ?>
                <h4><?php echo htmlspecialchars($user['name']); ?> ❤️</h4>
                <form method="POST" enctype="multipart/form-data" class="profile-form">
                    <input type="file" name="profile_photo" required>
                    <button type="submit" name="upload_photo" class="btn btn-dark btn-sm mt-2">
                        Upload Photo
                    </button>
                </form>
            </div>
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
            <div class="topbar">
                <h3>Welcome, <?php echo htmlspecialchars($user['name']); ?> 👋</h3>
                <form action="search_notes.php" method="GET" class="search-box">
                    <input type="text" name="q" placeholder="Search notes..." required class="input-search">
                    <button type="submit" class="search-btn">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
            <!-- MY NOTES -->
            <div class="section-header">
                <h4><i class="fa-solid fa-file-lines"></i> My Uploaded Notes</h4>
                <a href="my_notes.php" class="view-all">View All →</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>View</th>
                            <th>Download</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $my_notes->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><span class="category-file badge"><?php echo $row['category']; ?></span></td>
                                <td>
                                    <a href="../uploads/<?php echo $row['file_name']; ?>" target="_blank"
                                        class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="download.php?id=<?php echo $row['note_id']; ?>" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                </td>
                                <td><?php echo date('F j, Y, g:i A', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <a href="edit_note.php?id=<?php echo $row['note_id']; ?>"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="delete_note.php?id=<?php echo $row['note_id']; ?>"
                                        onclick="return confirm('Delete this note?')" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- DISCOVER -->
            <div class="section-header">
                <h4><i class="fa-solid fa-globe"></i> Discover Notes</h4>
                <span class="notes-count"><?php echo $total_notes; ?> notes available</span>
            </div>
            <div class="row">
                <?php while ($note = $other_notes->fetch_assoc()) { ?>
                    <?php
                    $note_id = $note['note_id'];
                    $rating_stmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM feedback WHERE note_id=?");
                    $rating_stmt->bind_param("i", $note_id);
                    $rating_stmt->execute();
                    $rating_data = $rating_stmt->get_result()->fetch_assoc();
                    $rating = round($rating_data['avg_rating']);
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="note-card">
                            <div class="note-img">
                                <img src="../uploads/<?php echo $note['cover_image']; ?>">
                                <a href="../uploads/<?php echo $note['file_name']; ?>" target="_blank" class="preview-btn">
                                    <i class="fa-solid fa-eye"></i> Preview
                                </a>
                            </div>
                            <div class="note-body">
                                <div class="note-top">
                                    <h5><?php echo htmlspecialchars($note['title']); ?></h5>
                                    <span class="category-card badge"><?php echo $note['category']; ?></span>
                                </div>
                                <p class="author"><i class="fa-solid fa-circle-user"></i> <?php echo $note['name']; ?></p>
                                <div class="note-stats">
                                    <div class="stars">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $rating) {
                                                echo '<i class="fa fa-star star-filled"></i>';
                                            } else {
                                                echo '<i class="fa fa-star star-empty"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <span class="downloads">
                                        <i class="fa fa-download"></i> <?php echo $note['downloads']; ?>
                                    </span>
                                </div>
                                <div class="note-actions">
                                    <a class="save-btn" href="save_note.php?note_id=<?php echo $note['note_id']; ?>">
                                        <i class="fa-regular fa-bookmark"></i> Save
                                    </a>
                                    <a class="download-btn" href="download.php?id=<?php echo $note['note_id']; ?>">
                                        <i class="fa-solid fa-download"></i> Download
                                    </a>
                                </div>
                                <a class="feedback-btn" href="feedback.php?note_id=<?php echo $note['note_id']; ?>">
                                    <i class="fa-solid fa-comment-dots"></i> Feedback
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script src="../js/user.js"></script>
</body>

</html>