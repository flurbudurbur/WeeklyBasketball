<?php
class voting
{
  // Function to check if the user has already clicked
  function hasUserClicked($postId)
  {
    global $conn; // Your database connection

    $query = "SELECT user_clicks_user_id FROM user_clicks WHERE user_clicks_video_id = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
  }

  // Function to record a user click
  function recordUserClick($userId, $postId)
  {
    global $conn; // Your database connection

    $query = "INSERT INTO user_clicks (user_clicks_user_id, user_clicks_video_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
      die('Error in prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ii", $userId, $postId);
    $stmt->execute();

    if ($stmt->errno) {
      die('Error in execute statement: ' . $stmt->error);
    }
  }

  function deleteRecord($userId, $postId)
  {
    global $conn;

    $query = "DELETE FROM user_clicks WHERE user_clicks_user_id = ? AND user_clicks_video_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $postId);
    $stmt->execute();

  }

  function execute($userId, $postId)
  {
    if (!$this->hasUserClicked($postId)) {
      $this->recordUserClick($userId, $postId);
    } else {
        $this->deleteRecord($userId, $postId);
    }
  }

  // Example usage
}
?>