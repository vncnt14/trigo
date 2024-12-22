<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary-color: #2B6A48;
            --secondary-color: #93CCAD;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: var(--secondary-color);
            min-height: 100vh;
        }

        header {
            background-color: var(--primary-color);
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        nav a {
            text-decoration: none;
            color: var(--white);
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        nav a:hover {
            background-color: var(--secondary-color);
            border-radius: 5px;
        }

        .login-button, .signup-button {
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            font-weight: bold;
        }

        .login-button {
            background-color: var(--white);
            color: var(--primary-color);
        }

        .signup-button {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        form {
            max-width: 500px;
            width: 90%;
            margin: 120px auto 2rem;
            padding: 2rem;
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.8rem;
        }

        select, input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid var(--primary-color);
            border-radius: 15px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        select:focus, input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 5px rgba(43, 106, 72, 0.2);
        }

        input[type="submit"] {
            background-color: var(--primary-color);
            color: var(--white);
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
            border: none;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        input[type="file"] {
            padding: 8px;
            border: 2px dashed var(--primary-color);
            background-color: #f8f8f8;
        }

        @media (max-width: 768px) {
            nav {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            nav a {
                font-size: 0.9rem;
                padding: 0.4rem 0.8rem;
            }

            form {
                width: 95%;
                padding: 1.5rem;
                margin-top: 100px;
            }

            h2 {
                font-size: 1.5rem;
            }

            select, input {
                padding: 10px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            nav {
                justify-content: center;
                text-align: center;
            }

            .login-button, .signup-button {
                width: 100%;
                margin: 0.2rem 0;
            }

            form {
                padding: 1rem;
            }
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
            <a href="login.php" class="login-button">Log In</a>
            <a href="registration.php" class="signup-button">Sign Up</a>
        </nav>
    </header>

    <form method="post" action="register.php" enctype="multipart/form-data">
        <h2>Create New Account</h2>
        <select name="role" id="role" style="width: 100%; padding: 10px; margin: 5px 0; box-sizing: border-box; border-radius: 15px; border-color: #2B6A48;">
            <option value="">Select Role</option>
            <option value="commuter">Commuter</option>
            <option value="driver">Driver</option>
            <option value="admin">Admin</option>
        </select>
        First Name: <input type="text" name="first_name"><br>
        Middle Name: <input type="text" name="middle_name"><br>
        Last Name: <input type="text" name="last_name"><br>
        Email: <input type="email" name="email"><br>
        Contact Number: <input type="text" name="contact_number"><br>
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        Profile Image: <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png"><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
