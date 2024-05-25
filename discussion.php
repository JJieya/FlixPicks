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
    .discuss-card {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      width: 50%;
      /* Set a fixed width for the cards */
      padding: 20px;
      box-sizing: border-box;
      align-items: center;
      margin: auto;
    }

    .discuss-body {
      text-align: center;
      align-items: center;
      margin: auto;
      padding: 10px;
    }

    .discuss-title{
      text-align: center;
      padding-bottom: 10px;
    }

    .time-text {
      text-align: right;
      padding-top: 15px;
    }

    .col-md-6{
      padding-top: 25px;
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
        <a class="nav-link active" href="homepage.html" style="color: white;">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="movies.php" style="color: white;">MOVIES</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="discussion.php" style="color: white;">DISCUSSION</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#rating" style="color: white;">WATCHLIST</a>
      </li>
    </ul>
  </nav>

  <div class="card-container">

    <div class="card">
      <div class="card-body">
      <h5 class="discuss-title">Create Discussion</h5>

        <div class="mb-3">
          <div class="col-md-6">
            <label for="discussTitle" class="form-label">Discussion Title*</label>
            <input type="text" class="form-control" id="discussTitle">
        </div>
        <textarea class="form-control" id="discussTextArea"></textarea>
        </div>
        <button type="button" class="btn btn-primary">Start Discussion</button>
      </div>

      <div class="discuss-card">
        <div class="discuss-body">
          <h5 class="discuss-title">Card title</h5>
          <p class="discuss-text">This is a wider card with supporting text below as a natural lead-in to additional
            content. This content is a little bit longer.</p>
          <p class="time-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
        </div>
      </div>
    </div>



  </div>

  <footer>&copy; 2024 FLIXPICK. All Rights Reserved.</footer>

  <!-- Optional JavaScript -->

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
</body>

</html>