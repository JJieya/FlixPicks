<?php
include 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            $error = "Please enter both email and password.";
        } else {
            $sql = "SELECT id, name, password FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($user_id, $name, $hashed_password);
                    $stmt->fetch();

                    if (password_verify($password, $hashed_password)) {
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['username'] = $name; // Store username into session
                        header('Location: homepage.php');
                        exit;
                    } else {
                        $error = "Invalid password.";
                    }
                } else {
                    $error = "Invalid email.";
                }
                $stmt->close();
            } else {
                $error = "Database error: unable to prepare statement.";
            }
        }
    } elseif (isset($_POST['register'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
            $register_error = "Please fill in all fields.";
        } elseif ($password !== $confirm_password) {
            $register_error = "Passwords do not match.";
        } else {
            $sql_check_email = "SELECT id FROM users WHERE email = ?";
            $stmt_check_email = $conn->prepare($sql_check_email);
            if ($stmt_check_email) {
                $stmt_check_email->bind_param("s", $email);
                $stmt_check_email->execute();
                $stmt_check_email->store_result();

                if ($stmt_check_email->num_rows > 0) {
                    $register_error = "Email already registered.";
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql_insert = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
                    $stmt_insert = $conn->prepare($sql_insert);
                    if ($stmt_insert) {
                        $stmt_insert->bind_param("sss", $name, $email, $hashed_password);
                        if ($stmt_insert->execute()) {
                            $register_success = "Registration successful. Please log in.";
                        } else {
                            $register_error = "Registration failed. Please try again.";
                        }
                        $stmt_insert->close();
                    } else {
                        $register_error = "Database error: unable to prepare statement.";
                    }
                }
                $stmt_check_email->close();
            } else {
                $register_error = "Database error: unable to prepare statement.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
            max-width: 400px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .error, .register-error {
            color: red;
        }
        .register-success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-success btn-block">Login</button>
        </form>
        <hr>
        <h2 class="text-center">Register</h2>
        <?php if (isset($register_error)): ?>
            <p class="register-error"><?php echo $register_error; ?></p>
        <?php endif; ?>
        <?php if (isset($register_success)): ?>
            <p class="register-success"><?php echo $register_success; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="register" class="btn btn-success btn-block">Register</button>
        </form>
    </div>
</body>
</html>


