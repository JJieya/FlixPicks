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
          <a class="nav-link" href="#rating" style="color: white;">RATING</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="discussion.php" style="color: white;">DISCUSSION</a>
        </li>
      </ul>
    </nav>

    <div class="searchbar">
      <input
        type="search"
        class="form-control rounded"
        placeholder="Search"
        aria-label="Search"
        aria-describedby="search-addon"
      />
      <button type="button" class="btn btn-primary">Search</button>
    </div>

    <!-- <div class="search-container">
      <form action="/search">
        <input type="text" placeholder="Search.." name="search" />
        <button type="submit">search</button>
      </form>
    </div>

    <div class="movie-container">
      <div class="movie-poster">
        <img src="movie_1.jpg" alt="Movie 1" />
        <div class="movie-details">
          <button>View Details</button>
        </div>
      </div>
      <div class="movie-poster">
        <img src="movie_2.jpg" alt="Movie 2" />
        <div class="movie-details">
          <button>View Details</button>
        </div>
      </div>
      <div class="movie-poster">
        <img src="movie3.jpg" alt="Movie 3" />
        <div class="movie-details">
          <button>View Details</button>
        </div>
      </div>
    </div> -->
    <!-- <div class="row">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="..." alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Card title 1</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="..." alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Card title 2</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="..." alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Card title 3</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>

    </div> -->

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
  </body>
</html>
