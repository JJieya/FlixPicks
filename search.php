<?php
header('Content-Type: application/json');
include 'db_connection.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $sql = "SELECT id, name FROM movie WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchQuery = "%" . $query . "%";
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    $movies = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $movies[] = $row;
        }
    }

    echo json_encode($movies);
} else {
    echo json_encode([]);
}

$conn->close();
?>
