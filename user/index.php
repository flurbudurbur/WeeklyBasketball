<?php
session_start();
require_once '../PHP/DB/_conn.php';
$user = $_SESSION['redirect_user'];

try {
  $stmt = $conn->prepare("SELECT users.users_mail, users.users_username, posts.* from users INNER JOIN posts ON users.users_mail = posts.posts_from_user WHERE users.users_username = ? ORDER BY posts.posts_curated_likes DESC");
  $stmt->bind_param("s", $user);
  $stmt->execute();
  $result = $stmt->get_result();
} catch (Exception $e) {
  echo $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://unpkg.com/@material-tailwind/html@latest/styles/material-tailwind.css" />
  <link rel="stylesheet" href="../css/main.css">
  <!-- Font Awesome Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
</head>

<body>
  <div class="flex mx-10 gap-10">
    <!-- User Profile -->
    <div class="relative flex w-96 h-fit flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
      <div class="relative mx-4 mt-4 h-fit overflow-hidden rounded-xl bg-white bg-clip-border text-gray-700 shadow-lg">
        <img src="https://picsum.photos/900/900" alt="profile-picture" class="object-cover" />
      </div>
      <div class="p-6 text-center">
        <h4 class="mb-2 block font-sans text-2xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased hover:underline underline-offset-4">
          @<?php echo $user; ?>
        </h4>
        <p class="block bg-gradient-to-tr from-pink-600 to-pink-400 bg-clip-text font-sans text-base font-medium leading-relaxed text-transparent antialiased">
          A very cool potato
        </p>
      </div>
    </div>
    <!-- User videos -->
    <div class="w-full flex flex-col">
      <?php
      include '../PHP/INCLUDE/entries.php';
      ?>
    </div>
  </div>







</body>

</html>