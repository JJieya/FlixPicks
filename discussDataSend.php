<?php
include 'db_connection.php';
session_start();

//checking if the user logged in or not:
if (!isset($_SESSION['user_id'])) {
    echo "Please login to start discussion.";
    exit;
}

//posting discussion details to DB:
if (isset($_POST['title'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $comment = $_POST['comment'];

    $sql_insert = "INSERT INTO forum (user_id, title, comment) VALUES (?,?,? )";


    $stmt_insert = $conn->prepare($sql_insert);
    if ($stmt_insert) {
        $stmt_insert->bind_param("iss",$user_id, $title, $comment);
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