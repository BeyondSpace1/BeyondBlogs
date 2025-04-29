<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($post['title']) ?> - BeyondBlogs</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <style>
        .post-container { 
            margin: 50px auto; 
            padding: 20px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
        .post-container h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .post-meta {
            color: #6c757d;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container post-container">
        <h2><?= esc($post['title']) ?></h2>
        <p class="post-meta">By <a href="/author/<?= $post['user_id'] ?>"><?= esc($post['author_name']) ?></a> on <?= $post['created_at'] ?></p>
        <div class="content"><?= $post['content'] ?></div>
        <a href="/posts" class="btn btn-secondary mt-3">Back to Posts</a>
    </div>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>