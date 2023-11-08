<?php
session_start();
require_once '../DB/_conn.php';
require_once 'functions.php';
$_POST = validate($_POST);

$query = $conn->query("SELECT COALESCE(MAX(posts_id), 0) AS max_id FROM posts");
$maxPostsId = $query->fetch_assoc()['max_id'];

if ($maxPostsId != null) {
  $newName = $maxPostsId + 1;
} else {
  $newName = 1;
}

$stmt = $conn->prepare("INSERT INTO posts (posts_name, posts_from_user, posts_date, posts_club, posts_game_score, posts_path) VALUES (?, ?, ?, ?, ?, ?)");

$allowedExts = array("mp4");
$extension = pathinfo($_FILES['fl_file']['name'], PATHINFO_EXTENSION);

$_FILES['fl_file']['name'] = $newName . '.' . $extension;

if ((($_FILES["fl_file"]["type"] == "video/mp4"))

  && ($_FILES["fl_file"]["size"] < 20000000)
  && in_array($extension, $allowedExts)
) {
  if ($_FILES["fl_file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["fl_file"]["error"] . "<br />";
  } else {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "WeeklyBasketball/upload/" . $_FILES["fl_file"]["name"])) {
      echo $_FILES["fl_file"]["name"] . " already exists. ";
    } else {
      move_uploaded_file(
        $_FILES["fl_file"]["tmp_name"],
        $path = $_SERVER['DOCUMENT_ROOT'] . "/WeeklyBasketball/uploads/" . $_FILES["fl_file"]["name"]
      );
      $stmt->bind_param("ssssss", $_POST['fl_title'], $_SESSION['email'], $_POST['fl_date'], $_POST['fl_club'], $_POST['fl_points'], $path);
      if ($stmt->execute()) {
        echo "Data inserted successfully!";
      } else {
        echo "Error: " . $stmt->error;
      }
      echo "Stored in: " . $path;
    }
  }
}
header("Location: ../../index.php");
