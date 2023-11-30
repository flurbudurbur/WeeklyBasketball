<?php
require_once './PHP/INCLUDE/voting.class.php';
$uri = $_SERVER['REQUEST_URI'];
$uri = explode('/', $uri);
if (in_array('user', $uri)) {
  echo '<div class="heading text-center font-bold text-2xl m-5 capitalize">' . $user . '\'s Top Videos!</div>';
  $path = '.';
} else {
  echo '<div class="heading text-center font-bold text-5xl m-5">Check Out The Top Rated Goals!</div>';
  $path = '';
}


?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  function like(id, like, user) {
  $.ajax({
    type: "POST",
    url: "./PHP/INCLUDE/likes.php",
    data: JSON.stringify({
      id: id,
      likes: like,
      user: user
    }),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function(response) {
      console.log(response);
    }
  });
}
</script>

<div class="holder mx-auto w-10/12 grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
  <?php
  while ($post = $result->fetch_assoc()) {
    $checkVote = new voting();
    if ($checkVote->hasUserClicked($post['posts_id']) == null) {
      $vote = 1;
      $activeText = 'hover:bg-gray-500';
    } else {
      $vote = 0;
      $activeText = 'bg-gray-500';
    }
  ?>
    <div class="mb-10 m-2 bg-gradient-to-br rounded-md [&:nth-child(3)]:from-[#A37E49] [&:nth-child(3)]:to-[#967444] [&:nth-child(2)]:from-[#808080] [&:nth-child(2)]:to-[#C0C0C0] [&:nth-child(1)]:from-[#DA9100] [&:nth-child(1)]:to-[#996600]">
      <div class="each m-2 shadow-lg border-gray-800 bg-gray-100 relative">
        <video class="w-full min-w-[100px]" controls>
          <source src=".<?php echo $path ?>/uploads/<?php echo $post['posts_path'] ?>" type="video/mp4">
        </video>
        <div class="info-box text-xs flex p-1 font-semibold text-gray-500 bg-gray-300 justify-evenly">
          <span class="mr-1 p-1 px-2 font-bold border-r border-gray-400 inline-flex gap-2"><img src=".<?php echo $path ?>/img/calendar.svg" alt="calendar" class="h-4 w-4"><?php echo $post['posts_date'] ?></span>
          <span onclick="like(<?php echo $post['posts_id'] . ',' . $vote . ',' . $_SESSION['userID']; ?>)" class="mr-1 p-1 px-2 font-bold inline-flex gap-2 hover:shadow-md click active:bg-gray-500/80 rounded-md <?php echo $activeText; ?>"><img class="w-4 h-4" src=".<?php echo $path ?>/img/fire.svg" alt="Fire">
            <p><?php echo $post['posts_likes'] ?></p>
          </span>
          <span class="mr-1 p-1 px-2 font-bold border-l border-gray-400 inline-flex gap-2"><img class="w-4 h-4" src=".<?php echo $path ?>/img/heart.svg" alt="Heart">
            <p><?php echo $post['posts_curated_likes'] ?></p>
          </span>
        </div>
        <div class="desc p-4 text-gray-800">
          <p class="title font-bold block cursor-pointer hover:underline"><?php echo $post['posts_name'] ?></p>
          <a href="./PHP/INCLUDE/redirect.php?user=<?php echo $post['users_username'] ?>" target="_new" class="badge bg-indigo-500 text-blue-100 rounded px-1 text-xs font-bold cursor-pointer">@<?php echo $post['users_username'] ?></a>
          <span class="description text-sm block py-2 border-gray-400 mb-2">lorem ipsum bekhum bukhum !lorem ipsum bekhum bukhum !</span>
        </div>
      </div>
    </div>
  <?php
  }
  // Close database connection if needed
  $conn->close();
  ?>




</div>