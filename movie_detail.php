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
            margin-top: 50px;
            max-width: 900px;
            min-height: 800px; /* 设置最小高度 */
            margin-bottom: 200px;
        }
        .movie-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .movie-title h1 {
            text-transform: uppercase; /* 全部变大写 */
            font-weight: bold; /* 加粗 */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* 立体效果 */
            letter-spacing: 2px; /* 字母间距 */
            color: green;
        }
        .movie-details {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
            margin-bottom: 20px;
            margin-left: 15px;
            margin-right: 15px;
            position: relative;
            background-color: rgba(0, 0, 0, 0.2);
            color: white;
        }
        .movie-details img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
        }
        .details {
            display: flex;
            flex-direction: column;
            justify-content: left;
            padding-left: 20px;
            padding-right: 50px;
        }
        .col-md-8.details {
        }
        .details h3,
        .details h4,
        .details p {
            font-size: 20px;
            margin-top: 5px;
        }
        .details p {
            text-align: left;
        }
        .ratings {
            margin-top: 50px;
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

    <div class="container">
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

        <div class="rate-btn-container">
            <button class="btn btn-primary rate-btn" onclick="checkLogin(<?php echo $movie_id; ?>)">Rate This Movie</button>
        </div>
    </div>

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