<?php
include 'db_connection.php';
session_start();

if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];

    $sql = "SELECT * FROM movie WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movie_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();
    } else {
        echo "Movie not found.";
        exit;
    }

    // Retrieve ratings for this movie
    $sql_ratings = "
        SELECT r.*, u.name AS user_name
        FROM rating r
        JOIN users u ON r.user_id = u.id
        WHERE r.movie_id = ?
    ";
    $stmt_ratings = $conn->prepare($sql_ratings);
    $stmt_ratings->bind_param("i", $movie_id);
    $stmt_ratings->execute();
    $result_ratings = $stmt_ratings->get_result();

    $ratings = [];
    if ($result_ratings->num_rows > 0) {
        while ($row = $result_ratings->fetch_assoc()) {
            $ratings[] = $row;
        }
    }
} else {
    echo "No movie ID provided.";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($movie['name']); ?></title>
    <link rel="stylesheet" href="style_moviedetail.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 100px;
            padding:40px;
            max-width: 900px;
            background-color:white;
            margin-bottom: 100px;
        }

        .ratings {
            margin-top: 50px;
            margin-bottom:50px;
        }
        .ratings h2 {
            margin-bottom: 20px;
            color: green;
        }
       
  
        .nav-item.right {
            margin-left: auto;
        }


        a {
            text-decoration: none !important;
            color: inherit;
        }

        a:hover {
            color: #455A64;
        }

        .card {
            border-radius: 5px;
            background-color: #fff;
            padding-left: 60px;
            padding-right: 60px;
            margin-top: 30px;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .rating-box {
            width: 130px;
            height: 130px;
            margin-right: auto;
            margin-left: auto;
            background-color: #FBC02D;
            color: #fff;
        }

        .rating-label {
            font-weight: bold;
        }

        /* Rating bar width */
        .rating-bar {
            width: 300px;
            padding: 8px;
            border-radius: 5px;
        }

        /* The bar container */
        .bar-container {
        width: 100%;
        background-color: #f1f1f1;
        text-align: center;
        color: white;
        border-radius: 20px;
        cursor: pointer;
        margin-bottom: 5px;
        }

        /* Individual bars */
        .bar-5 {
            width: 70%;
            height: 13px;
            background-color: #FBC02D; 
            border-radius: 20px;

        }
        .bar-4 {
            width: 30%;
            height: 13px;
            background-color: #FBC02D; 
            border-radius: 20px;

        }
        .bar-3 {
            width: 20%;
            height: 13px;
            background-color: #FBC02D; 
            border-radius: 20px;

        }
        .bar-2 {
            width: 10%;
            height: 13px;
            background-color: #FBC02D; 
            border-radius: 20px;

        }
        .bar-1 {
            width: 0%;
            height: 13px;
            background-color: #FBC02D; 
            border-radius: 20px;

        }

        .star-active {
            color: #FBC02D;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .star-active:hover {
            color: #F9A825;
            cursor: pointer;
        }

        .star-inactive {
            color: #CFD8DC;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .blue-text {
            color: #0091EA;
        }

        .content {
            font-size: 18px;
        }

        .profile-pic {
            width: 60px;
            height: 60px;
            border-radius: 100%;
            margin-right: 30px;
        }
        
        .pic {
            width: 80px;
            height: 80px;
            margin-right: 10px;
        }

        .vote {
            cursor: pointer;
        }  
    </style>
</head>
<body>
    <div id="overlay"></div> 
    <header style="display: inline-flex; width: 100%;">
        <img src="icon_movies.png" alt="Logo Icon" class="logo-icon" />
        <h1 class="title">FLIXPICK</h1>
    </header>

    <nav>
        <ul class="nav" style="width: 100%;">
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
            <li class="nav-item right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="nav-link" href="logout.php">LOGOUT (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                <?php else: ?>
                    <a class="nav-link" href="login.php">LOGIN</a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>

    <!-- Bootstrap template from free resource and modified by my own design -->
    <section class="container">
           
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['name']); ?>" /></div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder"><?php echo htmlspecialchars($movie['name']); ?></h1>
                        <div class="fs-5 mb-5">
                            <span class="text-decoration-line-through">Directed by: <?php echo htmlspecialchars($movie['director']); ?></span>
                        </div>
                        <div class="fs-5 mb-5">
                            <span class="text-decoration-line-through">Released in: <?php echo htmlspecialchars($movie['release_year']); ?></span>
                        </div>
                        <p class="lead"><?php echo htmlspecialchars($movie['synopsis']); ?></p>
                        <div class="d-flex">
                            <button class="btn btn-outline-dark flex-shrink-0" type="button"
                                onclick="checkLogin(<?php echo $movie_id; ?>)">Rate This Movie
                            </button>
                        </div>
                    </div>
            </div>
            <div class="ratings">
                <h2>Ratings and Reviews</h2>
            </div>
            <div class="ratings">
                    <?php foreach ($ratings as $rating) : ?>		
                        <div class="card">
                            <div class="row d-flex">
                                <div>
                                    <img class="profile-pic" src="person-circle.svg">
                                </div>
                                <div class="d-flex flex-column">
                                    <h3 class="mt-2 mb-0"><?php echo htmlspecialchars($rating['user_name']); ?></h3>
                                    <div>
                                        <p class="text-left"><span class="text-mutedpt"><?php echo htmlspecialchars($rating['star_rating']); ?> Stars</span>
                                        <span class="fa fa-star star-active ml-3"></span>
                                        <span class="fa fa-star star-active"></span>
                                        <span class="fa fa-star star-active"></span>
                                        <span class="fa fa-star star-active"></span>
                                        <span class="fa fa-star star-inactive"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-left">
                                <p class="content"><?php echo htmlspecialchars($rating['review_comment']); ?> </p>
                            </div>
                        </div>
                    <?php endforeach; ?>    
            </div>
    </section>

   <!-- <div class="container">
        <div class="movie-title">
            <h1><?php echo htmlspecialchars($movie['name']); ?></h1>
        </div>
        <div class="movie-details row">
            <div class="col-md-4">
                <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" alt="<?php echo htmlspecialchars($movie['name']); ?>">
            </div>
            <div class="col-md-8 details">
                <h3>Directed by: <?php echo htmlspecialchars($movie['director']); ?></h3>
                <h4>Released in: <?php echo htmlspecialchars($movie['release_year']); ?></h4>
                <p><?php echo htmlspecialchars($movie['synopsis']); ?></p>
            </div>
        </div>
    -->


    <footer class="footer">
        <div>
            <p>&copy; 2024 FLIXPICK. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        function checkLogin(movie_id) {
            <?php if (!isset($_SESSION['user_id'])): ?>
                alert("Please log in to rate this movie.");
                window.location.href = 'login.php';
                return false;
            <?php else: ?>
                window.location.href = 'rate_movie.php?id=' + movie_id;
                return true;
            <?php endif; ?>
        }
    </script>
</body>
</html>