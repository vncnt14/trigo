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
    <a href="#">Log In</a>
    <a href="#">Sign Up</a>
  </nav>

  <section class="rectangle">
    <img src="dcc.png" alt="Your Image">
    <h2>Log in to Trigo</h2>
    <form id="userTypeDropdown">
      <label for="userType">Select User Type:</label>
      <select id="userType" name="userType" onchange="redirectToPage()">
        <option value="Commuter">Commuter</option>
        <option value="Driver">Driver</option>
      </select>
    </form>
  </section>

  <footer>
    &copy; 2024 Your Company Name. All rights reserved.
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
