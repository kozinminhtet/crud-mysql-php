<?php
require_once 'database.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    
    $sql = "DELETE FROM posts WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the post ID to the prepared statement
        $stmt->bind_param("i", $post_id);

        // Execute the statement
        if ($stmt->execute()) {
            $success = "delete";
            header("Location: index.php?$success");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error deleting post: " . $conn->error . "</div>";
        }

        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error preparing statement: " . $conn->error . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>No post ID provided.</div>";
}
$conn->close();
