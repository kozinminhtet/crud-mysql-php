<?php
require_once 'database.php';

$errors = [
    'title' => '',
    'content' => '',
];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (empty($title)) {
        $errors['title'] = "Title name is required.";
    }
    if (empty($content)) {
        $errors['content'] = "Please write some contents.";
    }

    if (empty($errors['title']) && empty($errors['content'])) {
        $publish = isset($_POST['publish']) ? 1 : 0;

        // Check connection before preparing the statement
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO posts (title, content, is_published) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssi", $title, $content, $publish);

            if ($stmt->execute()) {
                $success = "create";
            } else {
                $success = "Error: " . $stmt->error;
            }

            header("location: index.php?$success");
            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>";
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
    <div class="container w-50">
      <div class="card mt-3">
        <h1 class="card-header">Create Post</h1>
        <form action="" method="post" class="p-3">
          <label for="title">Title</label>
          <input type="text" class="form-control mb-3" name="title" placeholder="name@example.com">
          <?php if (!empty($errors['title'])): ?>
            <div class="text-danger"><?php echo $errors['title']; ?></div>
          <?php endif;?>
          <label for="content">Content</label>
          <textarea name="content" rows="10" class="form-control"></textarea>
          <?php if (!empty($errors['content'])): ?>
            <div class="text-danger mt-1"><?php echo $errors['content']; ?></div>
          <?php endif;?>
          <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" name="publish">
            <label class="form-check-label" for="publish">
              Publish
            </label>
            <div class="d-flex justify-content-between mt-5">
              <a href="index.php" class="btn btn-secondary">Back</a>
              <input type="submit" value="Create" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
