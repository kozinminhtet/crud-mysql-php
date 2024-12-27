<?php
require_once 'database.php';

$title = '';
$content = '';
$is_published = 0;
$error_message = '';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $sql = "SELECT id, title, content, is_published FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a post with the provided ID exists
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
        $title = $post['title'];
        $content = $post['content'];
        $is_published = $post['is_published'];
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Handle the form submission to update the post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $is_published = isset($_POST['publish']) ? 1 : 0; // Determine if post is published

    // Validate the input
    if (empty($title) || empty($content)) {
        $error_message = "Title and Contents are required.";
    } else {
        $sql = "UPDATE posts SET title = ?, content = ?, is_published = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $title, $content, $is_published, $post_id);

        if ($stmt->execute()) {
            $success = "update";
            header("Location: index.php?$success");
            exit;
        } else {
            $error_message = "Error updating post.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
  <div class="container-fluid">
    <div class="container w-75">
      <div class="card mt-3">
        <h1 class="card-header">Edit Post</h1>

        <form action="" method="post" class="p-3">
          <label for="title">Title</label>
          <input type="text" class="form-control mb-3" name="title" value="<?php echo htmlspecialchars($title); ?>" placeholder="Enter title">
          <?php if (!empty($error_message)): ?>
            <div class="text-danger mt-1"><?php echo $error_message; ?></div>
          <?php endif;?>

          <label for="content">Content</label>
          <textarea name="content" rows="10" class="form-control"><?php echo htmlspecialchars($content); ?></textarea>
          <?php if (!empty($error_message)): ?>
            <div class="text-danger mt-1"><?php echo $error_message; ?></div>
          <?php endif;?>

          <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" name="publish" id="publish" <?php echo $is_published ? 'checked' : ''; ?>>
            <label class="form-check-label" for="publish">Publish</label>
          </div>

          <div class="d-flex justify-content-between mt-5">
            <a href="index.php" class="btn btn-secondary">Back</a>
            <input type="submit" value="Update" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
