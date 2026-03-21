<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
if (!isset($_GET['id'])) {
    header("Location: my_notes.php");
    exit();
}
$note_id = intval($_GET['id']);
/* GET NOTE DATA */
$stmt = $conn->prepare("SELECT * FROM notes WHERE note_id=? AND user_id=?");
$stmt->bind_param("ii", $note_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "Note not found!";
    exit();
}
$note = $result->fetch_assoc();
/* UPDATE NOTE */
if (isset($_POST['update_note'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $file_name = $note['file_name'];
    $cover_image = $note['cover_image'];
    /* FILE UPDATE */
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $new_file = time() . "_" . $_FILES['file']['name'];
        $tmp = $_FILES['file']['tmp_name'];
        if (move_uploaded_file($tmp, "../uploads/" . $new_file)) {
            if ($file_name != "" && file_exists("../uploads/" . $file_name)) {
                unlink("../uploads/" . $file_name);
            }
            $file_name = $new_file;
        }
    }
    /* COVER IMAGE UPDATE */
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
        $new_cover = time() . "_" . $_FILES['cover']['name'];
        $tmp = $_FILES['cover']['tmp_name'];
        if (move_uploaded_file($tmp, "../uploads/" . $new_cover)) {
            if ($cover_image != "" && file_exists("../uploads/" . $cover_image)) {
                unlink("../uploads/" . $cover_image);
            }
            $cover_image = $new_cover;
        }
    }
    /* UPDATE QUERY */
    $update = $conn->prepare("UPDATE notes
SET title=?, category=?, content=?, file_name=?, cover_image=?, updated_at=NOW()
WHERE note_id=? AND user_id=?");
    $update->bind_param("sssssii", $title, $category, $content, $file_name, $cover_image, $note_id, $user_id);
    $update->execute();
    header("Location: my_notes.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Note</title>
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
                <h4><i class="fa-solid fa-pen"></i> Edit Note</h4>
                <a href="my_notes.php" class="view-all">Back</a>
            </div>
            <div class="upload-card">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" value="<?php echo htmlspecialchars($note['title']); ?>"
                                class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category"
                                value="<?php echo htmlspecialchars($note['category']); ?>" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" rows="4"
                            class="form-control"><?php echo htmlspecialchars($note['content']); ?></textarea>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Current File</label><br>
                        <?php
                        if ($note['file_name'] != "") {
                            echo "<span class='category-file'>" . $note['file_name'] . "</span>";
                        } else {
                            echo "No File";
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Replace File</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Current Cover</label><br>
                        <?php
                        if ($note['cover_image'] != "") {
                            echo "<img src='../uploads/" . $note['cover_image'] . "' class='cover-thumb'>";
                        } else {
                            echo "No Cover";
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Replace Cover Image</label>
                        <input type="file" name="cover" class="form-control">
                    </div>
                    <br>
                    <button type="submit" name="update_note" class="save-btn">
                        <i class="fa-solid fa-floppy-disk"></i> Update Note
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/user.js"></script>
</body>
</html>