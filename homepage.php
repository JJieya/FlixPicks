<?php
include 'db_connection.php';
session_start();

// SQL query to select the id, name, synopsis, and poster_url columns from the movie table
$sql = "SELECT id, name, synopsis, poster_url FROM movie";

// Execute the query and store the result in the $result variable
$result = $conn->query($sql);

// Initialize an empty array to store the movies data
$movies = [];

// Check if there are any rows returned by the query
if ($result->num_rows > 0) {
  // Loop through each row in the result set
  while ($row = $result->fetch_assoc()) {
    // Add the current row's data to the $movies array
    $movies[] = $row;
  }
} else {
  // If no rows are returned, print "0 results"
  echo "0 results";
}

// Close the database connection
$conn->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" type="text/css" href="style.css" />

  <!-- Bootstrap CSS -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <title>FLIXPICK</title>
  <style>
    /*  change the search button color to green */
    #search-btn {
      background-color: green;
      /* Set the background color to green */
      border-color: rgb(246, 247, 244);
      color: white;
      /* Set the text color to white */
    }

    .nav-item.right {
      margin-left: auto;
    }

    .nav-link {
      color: white;
    }

    .card-container {
      margin-top: 50px;
      width: 70%;
      overflow-x: auto;
      white-space: nowrap;
      padding: 20px 0;
    }

    .card-container .card {
      display: inline-block;
      width: 250px;
      margin-right: 10px;
      vertical-align: top;
    }

    .card-container img {
      width: 100%;
      height: auto;
      border-radius: 10px;
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

  <div class="searchbar">
    <!-- Input field for searching movies -->
    <input type="search" id="search-input" class="form-control rounded" placeholder="Search" aria-label="Search"
      aria-describedby="search-addon" list="movie-list" />
    <!-- Datalist for auto-suggestions in the search input -->
    <datalist id="movie-list"></datalist>

    <!-- Button to trigger the search action -->
    <button type="button" class="btn btn-primary" id="search-btn">Search</button>
  </div>


  <div class="card-container">
    <?php foreach ($movies as $movie): ?>
      <div class="card">
        <img src="<?php echo $movie['poster_url']; ?>" alt="<?php echo $movie['name']; ?>">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <a href="movie_detail.php?id=<?php echo $movie['id']; ?>" class="btn btn-sm btn-outline-secondary">View
                Details</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
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

  <!-- some of source code of this fonctionality is from the internet, then modeified by my own design. -->
  <script>
    // Event listener for input changes in the search bar
    document.getElementById('search-input').addEventListener('input', function () {
      var query = this.value.trim(); // Get the input value and remove leading/trailing spaces
      if (query) {
        // If there is a query, send a fetch request to search.php with the query parameter
        fetch('search.php?query=' + encodeURIComponent(query))
          .then(response => response.json())
          .then(data => {
            var movieList = document.getElementById('movie-list');
            movieList.innerHTML = ''; // Clear previous results
            if (data.length > 0) {
              // If there are matching results, populate the dropdown list with movie names
              data.forEach(movie => {
                var movieOption = document.createElement('option');
                movieOption.value = movie.name;
                movieList.appendChild(movieOption);
              });
            }
          })
          .catch(error => console.error('Error fetching movies:', error));
      } else {
        // If the search bar is empty, clear the dropdown list
        var movieList = document.getElementById('movie-list');
        movieList.innerHTML = ''; // Clear previous results
      }
    });

    // Event listener for the search button click
    document.getElementById('search-btn').addEventListener('click', function () {
      var query = document.getElementById('search-input').value.trim(); // Get the search input value and remove leading/trailing spaces
      if (query) {
        // If there is a query, send a fetch request to search.php with the query parameter
        fetch('search.php?query=' + encodeURIComponent(query))
          .then(response => response.json())
          .then(data => {
            if (data.length > 0) {
              // If there are matching results, redirect to the details page of the first matching movie
              window.location.href = 'movie_detail.php?id=' + data[0].id;
            } else {
              // If there are no matching results, display an alert message
              alert('No movies found.');
            }
          })
          .catch(error => console.error('Error fetching movies:', error));
      } else {
        // If the search bar is empty, display an alert message
        alert('Please enter a search query.');
      }
    });
  </script>

</body>

</html>