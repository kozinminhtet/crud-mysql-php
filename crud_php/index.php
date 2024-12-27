<?php
require_once 'database.php';

// Fetch data
$sql = "SELECT id, title, content, is_published, created_at FROM posts";
$result = $conn->query($sql);
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
      <?php if (isset($_GET['create'])): ?>
        <div class="alert alert-success mt-3 mx-auto alert-dismissible fade show" role="alert">
          Created Post successfully.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif ?>
      <?php if (isset($_GET['delete'])): ?>
        <div class="alert alert-success mt-3 mx-auto alert-dismissible fade show" role="alert">
          Deleted Post successfully.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif ?>
      <?php if (isset($_GET['update'])): ?>
        <div class="alert alert-success mt-3 mx-auto alert-dismissible fade show" role="alert">
          Updated Post successfully.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif ?>
      <a href="create.php" class="btn mt-3 btn-primary">Create</a>
      <div class="card mt-3">
        <h1 class="card-header">Post List</h1>
        <table class="table table-striped">
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Is Published</th>
            <th>Created Date</th>
            <th>Actions</th>
          </tr>

          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['title']; ?></td>
                <td>
                  <!-- Limit content display to 100 characters -->
                  <?php echo substr($row['content'], 0, 100); ?>...
                </td>
                <td><?php echo $row['is_published'] ? 'Published' : 'Unpublished'; ?></td>
                <td>
                  <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                </td>
                <td>
                  <a href="detail.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View</a>
                  <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                  <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onClick="javascript:return confirm('Are you sure to delete.')">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">No posts found</td>
            </tr>
          <?php endif; ?>

        </table>
      </div>
    </div>
  </div>

  <?php $conn->close(); ?>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
