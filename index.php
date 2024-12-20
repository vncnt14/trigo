<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Trigo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      background-color: #93CCAD;
    }

    nav {
      display: flex;
      justify-content: space-between;
      background-color: #2B6A48;
      padding: 10px;
      flex-wrap: wrap;
    }

    nav a {
      text-decoration: none;
      color: white;
      padding: 10px;
      transition: background-color 0.3s ease;
    }

    nav a:hover {
      background-color: #777;
    }

    .rectangle {
      background-color: #fff;
      padding: 100px;
      margin: 20px;
      text-align: center;
      border-radius: 10px;
      margin-top: 80px;
      position: relative;
    }

    #userTypeDropdown {
      margin-top: 20px;
    }

    img {
      max-width: 100%;
      height: auto;
    }

    footer {
      text-align: center;
      padding: 50px;
      background-color: #2B6A48;
      color: white;
    }

    /* Added styles for responsive navigation */
    .menu-icon {
      display: none;
      cursor: pointer;
    }

    @media only screen and (max-width: 600px) {
      nav {
        flex-direction: column;
        align-items: center;
      }

      nav a {
        width: 100%;
        text-align: center;
        box-sizing: border-box;
        margin-bottom: 5px;
      }

      .rectangle {
        margin: 20px;
      }

      .menu-icon {
        display: block;
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
      }
    }
    .rectangle {
        text-align: center;
    }

    .rectangle img {
        width: 200px; /* Set the desired width */
        height: 150px; /* Set the desired height */
        border-radius: 10%; /* Make it circular */
        margin: 10px; /* Add margin as needed */
    }

    #userTypeDropdown {
        margin-top: 10px;
    }
    
    .get-started-btn {
        background-color: #2B6A48; /* Dark green from your color scheme */
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: block; /* Makes the button a block element */
        margin: 20px auto; /* Centers the button and adds vertical spacing */
    }

    .get-started-btn:hover {
        background-color: #93CCAD; /* Light green from your color scheme */
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
    }
  </style>
</head>

<body>

  <nav>
    <div class="menu-icon" onclick="toggleNav()">☰</div>
    <a href="landingpage.php">Home</a>
    <a href="#">About</a>
    <a href="#">Service</a>
    <a href="#">Team</a>
    <a href="#">Blog</a>
    <a href="#">Contact</a>
    <a href="login.php">Log In</a>
    <a href="#">Sign Up</a>
  </nav>

  <section class="rectangle">
    <h1>Welcome To Trigo</h1>
    <img src="dcc.png" alt="Your Image">
    <a href="login.php" style="text-decoration: none;"><button class="get-started-btn">GET STARTED</button></a>
  </section>

  <footer>
    &copy; 2024 Trigo. All rights reserved.
  </footer>

  <script>
    function redirectToPage() {
      var userType = document.getElementById("userType").value;
      if (userType === "Commuter") {
        window.location.href = "login.php";
      } else if (userType === "Driver") {
        window.location.href = "Driverlogin.php";
      }
    }

    // Added toggleNav function for responsive navigation
    function toggleNav() {
      var navLinks = document.querySelector('nav');
      navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
    }
  </script>

</body>

</html>
