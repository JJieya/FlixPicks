<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connection.php'; 
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="styleDiscuss.css" />

  <!-- Bootstrap CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <title>FLIXPICK</title>

  <style>
    .movie {
        /* Positioning and alignment */
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Ensure container height adjusts based on content */
        height: auto;
        margin-bottom: 20px;
    }

    /* Styling for movie poster image */
    .movie img {
        /* Make the image fill the container */
        width: 100%;
        height: auto;
        object-fit: cover;
        /* Remove default border and ensure block display */
        border: 1px solid #ddd;
        display: block;
    }

    /* Styling for movie title */
    .movie-title {
        /* Full width */
        width: 100%;
        /* Semi-transparent background */
        background-color: rgba(0, 0, 0, 0.7);
        /* Text color */
        color: white;
        /* Remove margin and add padding */
        margin: 0;
        padding: 10px;
        text-align: center;
        /* Font size */
        font-size: 1.3rem;
         /* Text shadow for effect */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        /* Additional font style */
        font-weight: bold;
    }

    /* Styling for main container */
    .container {
        /* Add padding to top and bottom */
        padding-top: 20px;
        padding-bottom: 50px;
        /* Set maximum height and enable vertical scrollbar */
        max-height: 600px;
        overflow-y: auto;
    }

    /* Adjust row margins */
    .row {
        margin-left: -15px;
        margin-right: -15px;
        margin-bottom: 20px;
        padding: 10px;
    }

    /* Adjust column padding */
    .col-md-4 {
        padding-left: 15px;
        padding-right: 15px;
        /* Ensure consistent height for movie containers */
        height: auto;
    }

    /* Remove margin for last row */
    .last-row {
        margin-bottom: 0;
    }
    .nav-item.right {
      margin-left: auto;
    }

    .nav-link {
      color: white;
    }
  </style>
</head>

<body>
  <div id="overlay"></div>

  <header style="display: inline-flex">
    <img src="icon_movies.png" alt="Logo Icon" class="logo-icon" />
    <h1 class="title">FLIXPICK</h1>
  </header>

  <nav>
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link active" href="homepage.php" style="color: white;">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="movies.php" style="color: white;">MOVIES</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="watchlist.php" style="color: white;">WATCHLIST</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="discussion.php" style="color: white;">DISCUSSION</a>
      </li>
      <li class="nav-item right">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a class="nav-link" href="logout.php">LOGOUT (<?php echo $_SESSION['username']; ?>)</a>
        <?php else: ?>
          <a class="nav-link" href="login.php">LOGIN</a>
        <?php endif; ?>
      </li>
    </ul>
  </nav>

  <div class="container mt-5">
    <div class="row">
    <?php
    // include 'db_connection.php';
    // session_start();

    if (!isset($_SESSION['user_id'])) {
      echo 'Login please!';
      header('Location: login.php');

      return false;
    } else {

      $user_id = $_SESSION['user_id'];


      $sql = "select m.id, name, poster_url 
      from watchlist w JOIN movie m 
      ON w.movie_id = m.id 
      WHERE w.user_id = '$user_id'";
      
      $result = $conn->query($sql);

      
      if ($result) {
        if ($result->num_rows > 0) {
          $count = 0;
          while ($row = $result->fetch_assoc()) {
            
            $count++;
           
            echo '<div class="col-6 col-md-3';
            if ($count == $result->num_rows) {
              echo ' last-row'; // 最后一行电影卡片的样式
            }
            echo '">';
            echo '<div class="movie">';
            echo '<a href="movie_detail.php?id=' . $row["id"] . '">';
            echo '<img src="' . $row["poster_url"] . '" alt="' . $row["name"] . '">';
            echo '</a>'; // Closing the anchor tag
            echo '<div class="movie-title">' . $row["name"] . '</div>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo "0 results";
        }
      }
    }
    $conn->close();
    ?>

</div>
  </div>

  <footer>&copy; 2024 FLIXPICK. All Rights Reserved.</footer>

  <!-- Optional JavaScript -->

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>