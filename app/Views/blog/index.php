<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeyondBlogs</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <style>
        .blog-container { 
            margin: 50px auto; 
            padding: 20px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
        .blog-container h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .post-card { 
            margin-bottom: 20px; 
            padding: 15px; 
        }
        .search-form {
            max-width: 500px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container blog-container">
        <h2>BeyondBlogs</h2>
        <div class="d-flex gap-2 mb-3">
            <a href="/" class="btn btn-secondary">Home</a>
            <?php if (session()->get('isLoggedIn')): ?>
                <a href="/dashboard" class="btn btn-primary">Dashboard</a>
            <?php else: ?>
                <a href="/login" class="btn btn-primary">Login</a>
            <?php endif; ?>
        </div>
        <h3>All Posts</h3>
        <form action="/posts" method="get" class="search-form">
            <div class="input-group">
                <input type="text" name="author" class="form-control" placeholder="Search by author name" value="<?= esc($author ?? '') ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if (isset($author)): ?>
                    <a href="/posts" class="btn btn-secondary">Clear</a>
                <?php endif; ?>
            </div>
        </form>
        <?php if (empty($posts)): ?>
            <div class="alert alert-info">No posts found.</div>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="card post-card">
                    <div class="card-body">
                        <h5 class="card-title"><a href="/posts/<?= $post['id'] ?>" class="text-decoration-none"><?= esc($post['title']) ?></a></h5>
                        <p class="card-text text-muted">By <a href="/author/<?= $post['user_id'] ?>"><?= esc($post['author_name']) ?></a> on <?= $post['created_at'] ?></p>
                        <p class="card-text"><?= substr(strip_tags($post['content']), 0, 100) ?>...</p>
                        <a href="/posts/<?= $post['id'] ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>