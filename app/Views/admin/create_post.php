<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - BeyondBlogs</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <script src="/assets/ckeditor/ckeditor.js"></script>
    <style>
        .create-container { 
            margin: 50px auto; 
            padding: 20px; 
            background: white; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
        .create-container h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container create-container">
        <h2>Create New Post</h2>
        <a href="/dashboard" class="btn btn-secondary mb-3">Back to Dashboard</a>
        <form id="postForm">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Post</button>
        </form>
    </div>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/sweetalert2/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('content');
            $('#postForm').submit(function(e) {
                e.preventDefault();
                let formData = {
                    title: $('#title').val(),
                    content: CKEDITOR.instances.content.getData(),
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                };
                $.ajax({
                    url: '/posts/store',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success!', 'Post created successfully.', 'success').then(() => {
                                window.location.href = '/dashboard';
                            });
                        } else {
                            Swal.fire('Error!', 'Failed to save post: ' + (response.errors ? JSON.stringify(response.errors) : 'Unknown error'), 'error');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>