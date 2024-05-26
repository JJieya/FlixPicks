<?php
include 'db_connection.php';
session_start();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="style.css" />

    <!-- Bootstrap CSS -->
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />

    <title>FLIXPICK</title>
    <style>
        /*  change the search button color to green */
        #search-btn {
            background-color: green; /* Set the background color to green */
            border-color: rgb(246, 247, 244); 
            color: white; /* Set the text color to white */
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
          <a class="nav-link active" href="discussion.php" style="color: white;">DISCUSSION</a>
        </li>
        <li class="nav-item right">
          <?php if (isset($_SESSION['user_id'])): ?>
              <a class="nav-link" href="logout.php">LOGOUT (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
          <?php else: ?>
              <a class="nav-link" href="login.php">LOGIN</a>
          <?php endif; ?>
        </li>
      </ul>
    </nav>

    <div class="searchbar">
      <input 
         type="search" 
         id="search-input" 
         class="form-control rounded" 
         placeholder="Search" 
         aria-label="Search" 
         aria-describedby="search-addon" 
         list="movie-list"
      />
      <datalist id="movie-list"></datalist>
      <button type="button" class="btn btn-primary" id="search-btn">Search</button>
    </div>

    <div class="card-container">
      <div class="card">
        <img class="card-img-top" src="..." alt="Card image cap" />
        <h2>Card 1</h2>
        <p>This is the first card.</p>
        <div class="movie-details">
          <button>View Details</button>
        </div>
      </div>
      <div class="card">
        <img class="card-img-top" src="..." alt="Card image cap" />
        <h2>Card 2</h2>
        <p>This is the second card.</p>
        <div class="movie-details">
          <button>View Details</button>
        </div>
      </div>
      <div class="card">
        <img class="card-img-top" src="..." alt="Card image cap" />
        <h2>Card 3</h2>
        <p>This is the third card.</p>
        <div class="movie-details">
          <button>View Details</button>
        </div>
      </div>
    </div>

    <footer>&copy; 2024 FLIXPICK. All Rights Reserved.</footer>

    <!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>

    <!-- some of source code of this fonctionality is from the internet, then modeified by my own design. -->
    <script>
        // Event listener for input changes in the search bar
        document.getElementById('search-input').addEventListener('input', function() {
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
        document.getElementById('search-btn').addEventListener('click', function() {
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