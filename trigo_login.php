<?php
include("config.php");

session_start();

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $sql = "SELECT * FROM user WHERE username=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($password === $row["password"]) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['status'] = $row['status'];

            if ($row['role'] === 'commuter') {
                header("Location: profile.php");
                exit();
            } elseif ($row['role'] === 'driver') {
                header("Location: sample.php");
                exit();
            } elseif ($row['role'] === 'admin') {
                header("Location: ts.php");
                exit();
            }
        } else {
            echo '<script>';
            echo 'alert("Invalid Username or Password");';
            echo 'setTimeout(function() { window.location.href = "login.php"; },);';
            echo '</script>';
            exit();
        }
    } else {
        echo '<script>';
        echo 'alert("Invalid Username or Password");';
        echo 'setTimeout(function() { window.location.href = "login.php"; },);';
        echo '</script>';
        exit();
    }

    $stmt->close();
}

$connection->close();
?>