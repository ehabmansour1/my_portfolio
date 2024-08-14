<?php
require 'db.php';

$stmt = $pdo->query("SELECT id, title, image FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header><link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anek+Devanagari:wght@100..800&family=Asap+Condensed:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
            <h1>Blog Page</h1>
        </header>
    <div class="container">
        <div class="blog-list">
            <?php if (empty($blogs)): ?>
                <p>No blogs available.</p>
            <?php else: ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="blog-item">
                        <a href="blog.php?id=<?php echo $blog['id']; ?>">
                            <?php if ($blog['image']): ?>
                                <img src="<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                            <?php else: ?>
                                <img src="placeholder.jpg" alt="No Image Available">
                            <?php endif; ?>
                            <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
