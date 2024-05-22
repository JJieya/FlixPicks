<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You need to log in to rate this movie.";
    exit;
}

if (isset($_GET['id'])) {
    $movie_id = $_GET['id'];

    // Fetch movie details
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
} else {
    echo "No movie ID provided.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO rating (movie_id, user_id, star_rating, review_comment) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $movie_id, $user_id, $rating, $review);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Rating submitted successfully.";
    } else {
        $_SESSION['message'] = "Error submitting rating.";
    }
    $stmt->close();
    $conn->close();
    header("Location: movie_detail.php?id=$movie_id");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate <?php echo htmlspecialchars($movie['name']); ?></title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
            max-width: 600px;
            margin-bottom: 50px;
            min-height: 800px; 
        }
        .movie-title {
            text-align: center;
            margin-bottom: 20px;
        }
        .movie-title h1 {
            text-transform: uppercase; 
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); 
            letter-spacing: 2px; 
            color: green;
        }
        .rate-form {
            background-color: rgba(0, 0, 0, 0.2);
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .rate-form label {
            font-size: 18px;
        }
        .rate-form input[type="number"],
        .rate-form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
        }
        .rate-form button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: green;
            color: white;
        }
        .nav-item.right {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <div id="overlay"></div>
    <header style ="display: inline-flex">
        <img src="icon_movies.png" alt="Logo Icon" class="logo-icon" />
        <h1 class="title">FLIXPICK</h1>
    </header>

    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="homepage.html">HOME</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="movies.php">MOVIES</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">DISCUSSION</a>
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
            <h1>Rate <?php echo htmlspecialchars($movie['name']); ?></h1>
        </div>
        <form method="POST" class="rate-form">
            <div class="form-group">
                <label for="rating">Rating (1 to 5 stars):</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="review">Review:</label>
                <textarea id="review" name="review" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Rating</button>
        </form>
    </div>

    <footer class="footer">
        <div>
            <p>&copy; 2024 FLIXPICK. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
