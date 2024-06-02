<?php
include 'db_connection.php';
session_start();

//for movie rating:

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

    // SQL query to retrieve ratings for a specific movie along with user names
    $sql_ratings = "
        SELECT rating.*, users.name AS user_name
        FROM rating 
        JOIN users ON rating.user_id = users.id
        WHERE rating.movie_id = ?
    ";
    // Prepare the SQL statement
    $stmt_ratings = $conn->prepare($sql_ratings);
    // Bind the movie_id parameter to the SQL statement
    $stmt_ratings->bind_param("i", $movie_id);
    $stmt_ratings->execute();
    $result_ratings = $stmt_ratings->get_result();
    // Initialize an empty array to store the ratings
    $ratings = [];
    if ($result_ratings->num_rows > 0) {
        // Loop through each row in the result set
        while ($row = $result_ratings->fetch_assoc()) {
            $ratings[] = $row;
        }
    }

    $user_id = $_SESSION['user_id'];
    $watchlistEnable = " select * from watchlist 
    where user_id = ? and movie_id = ?";

    $stmt_watchlist = $conn->prepare($watchlistEnable);
    $stmt_watchlist->bind_param("ii", $userID, $movie_id);
    $stmt_watchlist->execute();

    $watchlistData = $stmt_watchlist->get_result();

    $buttonDisable = false;

    if ($watchlistData->num_rows < 1) {
        $buttonDisable = true;
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
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 100px;
            padding: 40px;
            max-width: 900px;
            background-color: white;
            margin-bottom: 100px;
        }

        .ratings {
            margin-top: 50px;
            margin-bottom: 50px;
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

        .card {
            border-radius: 5px;
            background-color: #fff;
            padding-left: 60px;
            padding-right: 60px;
            margin-top: 30px;
            padding-top: 30px;
            padding-bottom: 30px;
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

        #watchStat[disabled] {
            display: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <script>
        function addToWatchlist(movie_id) {
            user_id = <?php echo $_SESSION['user_id']; ?>;
            console.log('Movie: ', movie_id, ' User: ', user_id);

            $.post("watchlistSendData.php",
                {
                    movieID: movie_id,
                    userID: user_id
                },
                function (data, status) {
                    if (status) {
                        alert("Movie saved to the watchlist!");

                        document.getElementById("watchStat").disabled = status;

                    }
                });
        }

    </script>





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
                <a class="nav-link active" href="homepage.php">HOME</a>
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
                    <a class="nav-link" href="logout.php">LOGOUT
                        (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                <?php else: ?>
                    <a class="nav-link" href="login.php">LOGIN</a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>

    <!-- Bootstrap template from free resource and modified by my own design -->
    <section class="container">

        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0"
                    src="<?php echo htmlspecialchars($movie['poster_url']); ?>"
                    alt="<?php echo htmlspecialchars($movie['name']); ?>" /></div>
            <div class="col-md-6">
                <h1 class="display-5 fw-bolder"><?php echo htmlspecialchars($movie['name']); ?></h1>
                <div class="fs-5 mb-5">
                    <span class="text-decoration-line-through">Directed by:
                        <?php echo htmlspecialchars($movie['director']); ?></span>
                </div>
                <div class="fs-5 mb-5">
                    <span class="text-decoration-line-through">Released in:
                        <?php echo htmlspecialchars($movie['release_year']); ?></span>
                </div>
                <p class="lead"><?php echo htmlspecialchars($movie['synopsis']); ?></p>
                <div class="d-flex">
                    <button class="btn btn-outline-dark flex-shrink-0" type="button"
                        onclick="checkLoginRating(<?php echo $movie_id; ?>)">Rate This Movie
                    </button>


                    <div style="padding-left: 30px">
                        <button class="btn btn-outline-success" id="watchStat" type="hidden"
                            onclick="checkLoginWatchlist(<?php echo $movie_id; ?>)">Save to Watchlist
                        </button>
                    </div>

                </div>
            </div>
        </div>
     
        <div class="ratings">
            <h2>Ratings and Reviews</h2>
        </div>
        <div class="ratings">
            <?php foreach ($ratings as $rating): ?>
                <div class="card">
                    <div class="row d-flex">
                        <div>
                            <img class="profile-pic" src="person-circle.svg">
                        </div>
                        <div class="d-flex flex-column">
                            <h3 class="mt-2 mb-0"><?php echo $rating['user_name']; ?></h3>
                            <div>
                                <p class="text-left"><span class="text-mutedpt"><?php echo $rating['star_rating']; ?>
                                        Stars</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="row text-left">
                        <p class="content"><?php echo $rating['review_comment']; ?> </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>


    <footer class="footer">
        <div>
            <p>&copy; 2024 FLIXPICK. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        function checkLoginRating(movie_id) {
            <?php if (!isset($_SESSION['user_id'])): ?>
                // If the user is not logged in, display an alert message
                alert("Please log in or register to rate this movie.");
                // link to login page 
                window.location.href = 'login.php';
                return false;
            <?php else: ?>
                // If the user is logged in, then link to the rate_movie.php with the movie ID
                window.location.href = 'rate_movie.php?id=' + movie_id;
                return true;
            <?php endif; ?>
        }


        function checkLoginWatchlist(movie_id) {
            <?php if (!isset($_SESSION['user_id'])): ?>
                alert("Please log in to rate this movie.");
                window.location.href = 'login.php';
                return false;
            <?php else: ?>
                addToWatchlist(movie_id);
                return true;

            <?php endif; ?>
        }
    </script>
</body>

</html>