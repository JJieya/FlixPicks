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
            padding:20px;
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
        .ratings table {
            width: 100%;
            border-collapse: collapse;
        }
        .ratings th,
        .ratings td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }
        .ratings th {
            background-color: #f8f9fa;
            color: #212529;
            font-weight: bold;
        }
        .rate-btn-container {
            text-align: center;
            margin-top: 20px;
            
        }
        .rate-btn {
            padding: 10px 20px;
            font-size: 16px;

        }
        .nav-item.right {
            margin-left: auto;
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
                <a class="nav-link active" href="homepage.html">HOME</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="movies.php">MOVIES</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">DISSCUSSION</a>
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
            <div class="container px-4 px-lg-5 my-5">
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
            </div>
            <div class="ratings">
                <h2>Ratings and Reviews</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Rating</th>
                            <th>Review</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ratings as $rating) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rating['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($rating['star_rating']); ?> Stars</td>
                                <td><?php echo htmlspecialchars($rating['review_comment']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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