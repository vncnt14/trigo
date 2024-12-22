<?php
session_start();

// Include database connection file
include('config.php');  // You'll need to replace this with your actual database connection code
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #93CCAD;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2B6A48;
            color: white;
            text-align: center;
            padding: 1em;
        }

        nav {

            display: flex;
            justify-content: space-between;
            padding: 5px;

        }

        nav a {
            text-decoration: none;
            color: white;
            /* Set the font color of the links to white */
        }


        h2 {
            color: #333;
        }

        form {
            max-width: 300px;
            margin: 20px auto;
            padding: 40px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border-radius: 15px;
            border-color: #93CCAD;
        }

        input[type="submit"] {
            background-color: #2B6A48;
            color: white;
            cursor: pointer;
            padding: 10px;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }


        .login-button {
            background-color: white;
            color: #2B6A48;
            padding: 10px;
            border-radius: 5px;
        }

        .signup-button {
            background-color: #93CCAD;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .dcc {
            text-align: center;
            margin-bottom: 20px;
        }

        .dcc img {
            width: 140px;
            /* Set the desired width */
            height: 120px;
            /* Set the desired height */
            border-radius: 10%;
            /* Make it circular */
            margin-bottom: 20px;
            /* Add margin as needed */
        }
    </style>

</head>

<body>
    <header>

        <nav>
            <a href="landingpage.php">Home</a>
            <a href="#">About</a>
            <a href="#">Service</a>
            <a href="#">Team</a>
            <a href="#">Blog</a>
            <a href="#">Contact</a>
            <a href="#" class="login-button">Log In</a>
            <a href="registration.php" class="signup-button">Sign Up</a>
        </nav>

    </header>
    <form method="post" action="trigo_login.php">
        <div class="dcc">
            <p>Log in to Trigo</p>
            <img src="dcc.png" alt="Your Image">
        </div>
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
    <p>Don't have an account? <a href="registration.php">Register here</a></p>
</body>

</html>