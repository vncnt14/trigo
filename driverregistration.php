<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Registration</title>
</head>
<body>
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
    color: white; /* Set the font color of the links to white */
}
h2 {
    color: #333;
    position: center;
}

form {
    max-width: 500px;
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
    border-color: #2B6A48;
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
button {
            background-color: #2B6A48;
            color: white;
            cursor: pointer;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width:500px;
        }

        button:hover {
            background-color: #1F513B;
        }
</style>
<header>
    
    <nav>
    <a href="landingpage.php">Home</a>
    <a href="#">About</a>
    <a href="#">Service</a>
    <a href="#">Team</a>
    <a href="#">Blog</a>
    <a href="#">Contact</a>
    <a href="driverlogin.php" class="login-button">Log In</a>
    <a href="driverregistration.php" class="signup-button">Sign Up</a>
</nav>

</header>
    <form method="post" action="driverregister.php">
        <h2>Create New Account</h2>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" required><br>

        <label for="email">Email:</label>
        <input type="text" name="email" required><br>

        <label for="contact">Contact Number:</label>
        <input type="text" name="contact" required><br>

        <label for="plate_number">Plate Number:</label>
        <input type="text" name="plate_number" required><br>

        <label for="license_number">License Number:</label>
        <input type="text" name="license_number"><br>

        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        Profile Image: <input type="file" name="dimage" class="box" accept="image/jpg, image/jpeg, image/png"><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
