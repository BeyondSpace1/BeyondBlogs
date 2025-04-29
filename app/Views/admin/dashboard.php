<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BeyondBlogs</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <style>
        .dashboard-container { 
            margin: 50px auto; 
            padding: 20px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
        .dashboard-container h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .table {
            background: #fff;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <h2>Welcome, <?= session()->get('name') ?>!</h2>
        <div class="d-flex gap-2 mb-3">
            <a href="/posts/create" class="btn btn-primary">Create New Post</a>
            <a href="/posts" class="btn btn-success">View Posts</a>
            <a href="/logout" class="btn btn-secondary">Logout</a>
        </div>
        <h3>Your Posts</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?= esc($post['title']) ?></td>
                        <td><?= $post['created_at'] ?></td>
                        <td>
                            <a href="/posts/edit/<?= $post['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <button class="btn btn-sm btn-danger delete-post" data-id="<?= $post['id'] ?>">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-post').click(function() {
                let postId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won’t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/posts/delete/' + postId,
                            type: 'POST',
                            data: {
                                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Deleted!', 'Your post has been deleted.', 'success').then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', 'Failed to delete post.', 'error');
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>