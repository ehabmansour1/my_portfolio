<?php
require 'db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Initialize variables
$id = null;
$title = '';
$content = '';
$image = '';
$isEditing = false;

// Handle form submission for adding or editing a blog post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];
        $imageNameCmps = explode(".", $imageName);
        $imageExtension = strtolower(end($imageNameCmps));
        $newImageName = md5(time() . $imageName) . '.' . $imageExtension;
        $uploadFileDir = './uploads/';
        $dest_path = $uploadFileDir . $newImageName;

        if (move_uploaded_file($imageTmpPath, $dest_path)) {
            $image = $dest_path;
        }
    }

    if ($id) {
        // Update existing blog post
        $stmt = $pdo->prepare("UPDATE blogs SET title = ?, content = ?, image = ? WHERE id = ?");
        $stmt->execute([$title, $content, $image, $id]);
    } else {
        // Insert new blog post
        $stmt = $pdo->prepare("INSERT INTO blogs (title, content, image) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, $image]);
    }

    header("Location: admin.php");
    exit;
}

// Handle edit action
if (isset($_GET['edit_id'])) {
    $isEditing = true;
    $id = $_GET['edit_id'];

    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($blog) {
        $title = $blog['title'];
        $content = $blog['content'];
        $image = $blog['image'];
    }
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Fetch the blog post to delete the image
    $stmt = $pdo->prepare("SELECT image FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($blog) {
        // Delete the image file if it exists
        if ($blog['image'] && file_exists($blog['image'])) {
            unlink($blog['image']);
        }

        // Delete the blog post from the database
        $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: admin.php");
        exit;
    } else {
        die("Blog post not found.");
    }
}

// Fetch existing blogs for editing and deletion
$stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anek+Devanagari:wght@100..800&family=Asap+Condensed:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
<style>
    .logout {
        background-color: #28cb8b;
    color: #f5f7fa;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.3);
    }
</style>
</head>
<body>


<div class="container">
    <h1><?php echo $isEditing ? 'Edit' : 'Add a New'; ?> Blog Post</h1>
    <form method="post" action="admin.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="10" cols="30" required><?php echo htmlspecialchars($content); ?></textarea><br><br>

        <label for="image">Upload Image:</label><br>
        <input type="file" id="image" name="image"><br><br>
        <?php if ($image): ?>
            <p>Current Image:</p>
            <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($title); ?>" style="width: 150px; height: auto;"><br><br>
        <?php endif; ?>

        <input type="submit" value="<?php echo $isEditing ? 'Update Blog' : 'Add Blog'; ?>">
    </form>

    <!-- Existing Blogs -->
    <h1>Manage Existing Blogs</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $blog): ?>
            <tr>
                <td><?php echo htmlspecialchars($blog['title']); ?></td>
                <td>
                    <?php if ($blog['image']): ?>
                        <img src="<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" style="width: 100px; height: auto;">
                    <?php else: ?>
                        No Image
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="admin.php?edit_id=<?php echo $blog['id']; ?>">Edit</a>
                    <a href="admin.php?delete_id=<?php echo $blog['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a class='logout' href="logout.php">Logout</a>
</div>
</body>
</html>
