<?php

session_start();

//checking if the user logged in or not:
if (!isset($_SESSION['user_id'])) {
  echo "<script type='text/javascript'>alert('Please login to start discussion.');</script>";
  header("Location: login.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="styleDiscuss.css" />

  <!-- Bootstrap CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script> -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <title>FLIXPICK</title>

  <style>
    .discuss-card {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 70%;
      /* Set a fixed width for the cards */
      padding: 20px;
      box-sizing: border-box;
      align-items: center;
      margin: auto;
      margin-top: 10px;
    }

    .discuss-body {
      text-align: left;
      align-items: center;
      margin: auto;
      padding: 10px;
    }

    .discuss-title {
      text-align: left;
      padding-bottom: 10px;
      font-weight: bold;
    }

    .time-text {
      text-align: right;
      padding-top: 15px;
    }

    .col-md-6 {
      padding-top: 25px;
    }

    /* .form-control {
      margin: 10px;
    } */

    #title {
      margin: 10px;
    }

    #comment {
      margin-left: 25px;
      width: 94%;
    }

    #dcalc {
      display: none;
    }

    .divider {
      border: 2px;
    }

    .discussButton {
      text-align: center;
      align-items: center;
      margin: auto;
      padding: 10px;
    }

    .commentButton {
      text-align: right;
      align-items: center;
      margin: auto;
      /* padding: 5px; */
      padding-top: 15px;
      padding-right: 40px;
    }

    .profile-pic {
      width: 40px;
      height: 40px;
      border-radius: 100%;
      margin-right: 10px;
    }
  </style>

  <script>
    
    function handleSubmit(title, comment) {

      console.log('title', title);
      console.log('comment', comment);

      if (!title == '' && !comment == '') {
        $.post("discussDataSend.php",
          {
            title: title,
            comment: comment,

          },
          function (data, status) {
            alert("Discussion posted successfully");
            location.reload();
          });
      }
      else {
        alert('forms cannot be empty.');
      }
    }


  </script>
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
        <a class="nav-link active" href="homepage.html" style="color: white;">HOME</a>
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
    </ul>
  </nav>

  <div class="card-container">

    <div class="card">
      <div class="card-body">
        <h5 class="discuss-title">Discussion Forum:</h5>

        <div class="mb-3">
          <div class="col-md-6">
            <!-- <label for="title" class="form-label">Discussion Title*</label> -->
            <input type="text" class="form-control" id="title" placeholder="Give a Title" required>
          </div>
          <!-- <label for="title" class="form-label">Your Comment*</label> -->
          <textarea class="form-control" id="comment" placeholder="What do you think about your interested movie?"
            required></textarea>
        </div>
        <div class="discussButton">
          <button type="button" class="btn btn-outline-success"
            onclick="handleSubmit(document.getElementById('title').value, document.getElementById('comment').value)">Create
            Discussion</button>
        </div>
      </div>

      <!-- discuss feed starts from here: -->
      <!-- <div id="dcalc" class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div> -->

      <?php
      include 'db_connection.php';
      session_start();


      $sql = "SELECT u.name, f.title, f.comment, f.created_at FROM forum f, users u WHERE u.id = f.user_id order by f.created_at desc;";

      $result = $conn->query($sql);


      if ($result) {
        if ($result->num_rows > 0) {
          $count = 0;
          while ($row = $result->fetch_assoc()) {

            $count++;

            echo '<div class="discuss-card">';

            echo '<h5 class="card-header"><img class="profile-pic" src="person-circle.svg"/>' . $row["name"] . '</h5>';
            echo '<div class="discuss-body">';
            echo ' <h5 class="discuss-title">' . $row['title'] . '</h5>';
            echo ' <p class="discuss-text">' . $row['comment'] . '</p>';
            echo '<p class="time-text"><small class="text-body-secondary">' . $row['created_at'] . '</small></p>';
            echo '<div class="commentButton">
            <button type="button" class="btn btn-success btn-sm" onclick="">Comment to this thread</button></div>';
            echo '</div>';
            echo '</div>';


            echo '<div class="divider">';
            echo '</div>';
          }
        } else {
          echo "0 results";
        }
      }
      ?>

    </div>
  </div>

  <footer>&copy; 2024 FLIXPICK. All Rights Reserved.</footer>

</body>

</html>