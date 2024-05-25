<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db_connection.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies</title>
    <link rel="stylesheet" href="style_moviedetail.css" >
     <!-- Bootstrap CSS -->
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous"
    >

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


    <style>
    /* Styling for movie container */
    .movie {
        /* Positioning and alignment */
        display: flex;
        flex-direction: column;
        align-items: center;
        /* Ensure container height adjusts based on content */
        height: auto;
        margin-bottom: 20px;
    }

    /* Styling for movie poster image */
    .movie img {
        /* Make the image fill the container */
        width: 100%;
        height: auto;
        object-fit: cover;
        /* Remove default border and ensure block display */
        border: 1px solid #ddd;
        display: block;
    }

    /* Styling for movie title */
    .movie-title {
        /* Full width */
        width: 100%;
        /* Semi-transparent background */
        background-color: #458447;
        border: 1px solid #ddd;
        /* Text color */
        color: white;
        /* Remove margin and add padding */
        margin: 0;
        padding: 10px;
        text-align: center;
        /* Font size */
        font-size: 1.3rem;
         /* Text shadow for effect */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        /* Additional font style */
        font-weight: bold;
    }

    /* Styling for main container */
    .container {
        /* Add padding to top and bottom */
        padding-top: 20px;
        padding-bottom: 50px;
        /* Set maximum height and enable vertical scrollbar */
        max-height: 600px;
        overflow-y: auto;
    }

    /* Adjust row margins */
    .row {
        margin-left: -15px;
        margin-right: -15px;
        margin-bottom: 20px;
        padding: 10px;
    }

    /* Adjust column padding */
    .col-md-4 {
        padding-left: 15px;
        padding-right: 15px;
        /* Ensure consistent height for movie containers */
        height: auto;
    }

    /* Remove margin for last row */
    .last-row {
        margin-bottom: 0;
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
            <a class="nav-link active" href="homepage.html">HOME</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" href="movies.php">MOVIES</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active" href="discussion.php">DISCUSSION</a>
            </li>
        </ul>
    </nav>
        
    <div class="container mt-5">
        <div class="row">
            <?php
            include 'db_connection.php';

            $sql = "SELECT id, name, poster_url FROM movie";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $count = 0;
                while($row = $result->fetch_assoc()) {
                    $count++;
                    echo '<div class="col-md-4 mb-4';
                    if ($count == $result->num_rows) {
                        echo ' last-row'; // 最后一行电影卡片的样式
                    }
                    echo '">';
                    echo '<div class="movie">';
                    echo '<a href="movie_detail.php?id=' . $row["id"] . '">';
                    echo '<img src="' . $row["poster_url"] . '" alt="' . $row["name"] . '">';
                    echo '</a>'; // Closing the anchor tag
                    echo '<div class="movie-title">' . $row["name"] . '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
    </div>
      
       
    <footer class="footer">
        <div>
            <p>&copy; 2024 FLIXPICK. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
