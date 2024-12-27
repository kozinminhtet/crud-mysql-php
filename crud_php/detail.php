<?php
require_once 'database.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $sql = "SELECT id, title, content, created_at FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a post with the provided ID exists
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
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
    <div class="container">
      <div class="card w-75 mx-auto mt-3">
        <h1 class="card-header">Post Detail</h1>
        <div class="card-body">
          <h2><?php echo ($post['title']); ?></h2>
          <span><i>Published </i><?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
          <p class="text-wrap mt-3"><?php echo ($post['content']); ?></p>
          <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
