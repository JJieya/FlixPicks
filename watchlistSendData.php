<?php
include 'db_connection.php';

if (isset($_POST['movieID'])){
    $movieID = $_POST['movieID'];
    $userID = $_POST['userID'];

    $sql_insert = "INSERT INTO watchlist (user_id, movie_id) VALUES (?, ?)";


    $stmt_insert = $conn->prepare($sql_insert);
    if ($stmt_insert) {
        $stmt_insert->bind_param("ss",$userID, $movieID );
        if ($stmt_insert->execute()) {
            echo "Success!";
        } else {
            echo "Failed!";
        }
        $stmt_insert->close();
    } else {
        echo "Database Error!";
    }
}


$conn->close();
?>