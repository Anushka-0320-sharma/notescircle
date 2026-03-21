<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $tags = mysqli_real_escape_string($conn, $_POST['tags']);
    $content = "";
    if (isset($_POST['content'])) {
        $content = mysqli_real_escape_string($conn, $_POST['content']);
    }
    $file_name = "";
    $cover_image = "";
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        $original = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            die("Only PDF, JPG, PNG files allowed.");
        }
        if ($size > 20 * 1024 * 1024) {
            die("File too large. Max 20MB allowed.");
        }
        $file_name = time() . "_" . rand(1000, 9999) . "." . $ext;
        $temp = $_FILES['file']['tmp_name'];
        $folder = "../uploads/" . $file_name;
        if (!move_uploaded_file($temp, $folder)) {
            die("File upload failed.");
        }
    }
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
        $img_allowed = ['jpg', 'jpeg', 'png'];
        $img_name = $_FILES['cover_image']['name'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        if (in_array($img_ext, $img_allowed)) {
            $cover_image = time() . "_cover_" . rand(1000, 9999) . "." . $img_ext;
            $tmp = $_FILES['cover_image']['tmp_name'];
            $folder2 = "../uploads/" . $cover_image;
            move_uploaded_file($tmp, $folder2);
        }
    }
    $sql = "INSERT INTO notes
    (user_id,title,content,category,tags,file_name,cover_image,downloads,status,created_at,updated_at)
    VALUES
    ('$user_id','$title','$content','$category','$tags','$file_name','$cover_image',0,'active',NOW(),NOW())";
    mysqli_query($conn, $sql);
    $action = "Uploaded note: " . $title;
    mysqli_query(
        $conn,
        "INSERT INTO activity_log(user_id,action)
     VALUES('$user_id','$action')"
    );
    header("Location: my_notes.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Note</title>
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
                <h4><i class="fa-solid fa-upload"></i> Upload New Notes</h4>
            </div>
            <div class="upload-card">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <input type="text" name="tags" class="form-control" placeholder="php, database, notes">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content (Optional)</label>
                        <textarea name="content" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Notes File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Cover Image</label>
                            <input type="file" name="cover_image" class="form-control">
                        </div>
                    </div>
                    <button type="submit" name="submit" class="save-btn">
                        <i class="fa-solid fa-upload"></i> Upload Note
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/user.js"></script>
</body>
</html>