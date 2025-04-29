<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts by <?= esc($author['name']) ?> - BeyondBlogs</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <style>
        .author-container { 
            margin: 50px auto; 
            padding: 20px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
        .author-container h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .post-card { 
            margin-bottom: 20px; 
            padding: 15px; 
        }
    </style>
</head>
<body>
    <div class="container author-container">
        <h2>Posts by <?= esc($author['name']) ?></h2>
        <a href="/posts" class="btn btn-secondary mb-3">Back to Posts</a>
        <?php foreach ($posts as $post): ?>
            <div class="card post-card">
                <div class="card-body">
                    <h5 class="card-title"><a href="/posts/<?= $post['id'] ?>" class="text-decoration-none"><?= esc($post['title']) ?></a></h5>
                    <p class="card-text text-muted">On <?= $post['created_at'] ?></p>
                    <p class="card-text"><?= substr(strip_tags($post['content']), 0, 100) ?>...</p>
                    <a href="/posts/<?= $post['id'] ?>" class="btn btn-primary">Read More</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>