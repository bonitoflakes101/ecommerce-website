<?php
session_start();
// require 'includes/db_config.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['CustomerID']);
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width-device-width, initial-scale=1.0" />

  <!-- Stylesheet for CSS -->
  <link rel="stylesheet" href="css/mainStyle.css" />
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Title for Website -->
  <title>TechVault</title>
  <link
    rel="icon"
    type="image/x-icon"
    href="resources/images/logo-icon.png" />
  <script type="text/javascript"></script>
</head>

<body>
  <!-- Main-->
  <section id="main">
    <!-- Header -->
    <header>
<<<<<<< Updated upstream
        <h1>Welcome to Our eCommerce Store!</h1>
=======
      <!-- Top Header / Logo Bar -->
      <div class="header-top">
        <!-- Logo -->
        <a href="#" class="logo">
          <img src="resources/images/logo-with-icon.png" alt="logo" />
        </a>
>>>>>>> Stashed changes

        <div class="full-search-bar">
          <!-- Search Bar -->
          <div class="search">
            <form>
              <input
                class="search-input"
                type="search"
                placeholder="Search for Product"
                name="search" />
            </form>
          </div>
          <!-- Search BTN -->
          <a href="#" class="nav-search">
            <svg
              width="20"
              height="20"
              viewBox="0 0 23 23"
              fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M18.6875 9.34375C18.6875 11.4057 18.0182 13.3104 16.8906 14.8557L22.5777 20.5473C23.1393 21.1088 23.1393 22.0207 22.5777 22.5822C22.0162 23.1438 21.1043 23.1438 20.5428 22.5822L14.8557 16.8906C13.3104 18.0227 11.4057 18.6875 9.34375 18.6875C4.18223 18.6875 0 14.5053 0 9.34375C0 4.18223 4.18223 0 9.34375 0C14.5053 0 18.6875 4.18223 18.6875 9.34375ZM9.34375 15.8125C10.1932 15.8125 11.0344 15.6452 11.8192 15.3201C12.6041 14.995 13.3172 14.5185 13.9178 13.9178C14.5185 13.3172 14.995 12.6041 15.3201 11.8192C15.6452 11.0344 15.8125 10.1932 15.8125 9.34375C15.8125 8.49426 15.6452 7.65309 15.3201 6.86827C14.995 6.08344 14.5185 5.37033 13.9178 4.76965C13.3172 4.16897 12.6041 3.69249 11.8192 3.3674C11.0344 3.04232 10.1932 2.875 9.34375 2.875C8.49426 2.875 7.65309 3.04232 6.86827 3.3674C6.08344 3.69249 5.37033 4.16897 4.76965 4.76965C4.16897 5.37033 3.69249 6.08344 3.3674 6.86827C3.04232 7.65309 2.875 8.49426 2.875 9.34375C2.875 10.1932 3.04232 11.0344 3.3674 11.8192C3.69249 12.6041 4.16897 13.3172 4.76965 13.9178C5.37033 14.5185 6.08344 14.995 6.86827 15.3201C7.65309 15.6452 8.49426 15.8125 9.34375 15.8125Z"
                fill="white" />
            </svg>
          </a>
        </div>

        <!-- Navigation Buttons -->
        <div class="nav-buttons">
          <!-- User BTN -->
          <a href="#" class="nav-user">
            <svg
              width="28"
              height="28"
              viewBox="0 0 28 28"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink">
              <rect width="28" height="28" fill="url(#pattern0_6_24)" />
              <defs>
                <pattern
                  id="pattern0_6_24"
                  patternContentUnits="objectBoundingBox"
                  width="1"
                  height="1">
                  <use
                    xlink:href="#image0_6_24"
                    transform="scale(0.0111111)" />
                </pattern>
                <image
                  id="image0_6_24"
                  width="90"
                  height="90"
                  xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAADAklEQVR4nO3cS4tcRRgG4NKoGBcK3kG8hOhWXIgoGhDRoAuX3l0IKgFd+BdcioJR1BBEV17+gODGlUSNxEvEaxgjuAuY0UQEb1EfKU4tRIwy4/Sp6qrvgbOZbpiul+rq6q++PimFEEIIIYQQQlg7XIqH8So+xLf4tVyr5W/5sYewdR3/Ylw4CffgHWv3Nu7GptrjaBpuxor/7wC21x5Pc3AaXrDxnsfm2uNrAs7FBxbnPZyTRmYKOb/NF+3AsGGblotFzuR/mtmnptFYzJr8X3ankWC7em5JA+2TVyoG/cUQ+2zcq747U++wt3bKeCsNULtowR/YknplKhC1YkfqlanS1oqXU6+wXzveT70y1ZBb8U3qFX7Rjp9TrzQm9UpjUq80JvVKrNGzBb2qHV3vOvZrR9f76Fe046XUK1OjSyu6rnVsLZWz2vJruCT1zPo6kDbantQ7U8tWbben3mHTTL0cx/PZEGeGGW6qGPQNaSSmvri57UqjwebSPTSXd4fsVMpyP9xM63Xu5Tg7jcwU9r4Fz+QxGxyPs4zsXkDIu4ZdLv4Nbixv843Ywo21u1jnPvuu3E20xq/r+bl7cAdOrD2OpYItufiTezBKL/VqOeDN1+Fc6iyP7ei+dhFCCCGEEEIIw8AZuAYP4im8XipwuZx6CD+V61Cpi+wtz9mJB3A1Tq89jubg/HJg+yK+snEOll/n5rrJeWlEuAKP41PzyAWnj/EYLk89w0V4pNyep7ZcRn0Ul6Ve4Dq81kiH0t/l1/QGbsUJadngFNyPTyyPj3AfTk7LoMyOLy2vFdzW7AzHVeVUpBdv4srU2G0h8gfLb/rzO56uvpzk46Nyr7ne7cs3DKgV8vU4ahxHsG3ukLeVr8Gj+RHXzhXyWeUEelSHceYcQT9Ze6QNeGKOoGveeKoVn88RdF6nRvfDHEF/XXuUDTg4R9DP1B5lA3bOEfQF+M64juLChQf9lx/7fG88R2ZvBy6dns+VXcgx/TpWxvgsLp415BBCCCGEEEIIIYTUpj8BC/LLBrcKHY4AAAAASUVORK5CYII=" />
              </defs>
            </svg>
          </a>
          <!-- Cart BTN -->
          <a href="#" class="nav-cart">
            <svg
              width="27"
              height="28"
              viewBox="0 0 27 28"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink">
              <rect width="27" height="28" fill="url(#pattern0_6_25)" />
              <defs>
                <pattern
                  id="pattern0_6_25"
                  patternContentUnits="objectBoundingBox"
                  width="1"
                  height="1">
                  <use
                    xlink:href="#image0_6_25"
                    transform="matrix(0.0111111 0 0 0.0107143 0 0.0178571)" />
                </pattern>
                <image
                  id="image0_6_25"
                  width="90"
                  height="90"
                  xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAAC60lEQVR4nO3cvY9MURjH8YPYDQkR2UaoDYXWS7WFxF/ARC1EM6NZkWgk2H4JErIFWhGSaVToLBuMGt1IvMSulxkSYX3lZk4xzZnd2bj3Oec5z6faYpPnOb/cufeceSbXOWOMMcaYygEbgWvAV8IWgIfASWBD9V0qAFxnNG+BvdJ9JwVYC/xkdD+AA9L95xB04R2wSXoNmm8dg85K95+M4uEGXAG+rCLo19L9qwGsA44OCXu3dI+qAM8DQZ+W7k0V4Hwg6MfSvalS7J0DQf8Gtkj3p20r+CEQdl26P1WAm4Ggb0v3pgpwOBD0p+KKl+5PDWAz8CsQ9n7p/lQBHgWCvijdmyrAVCDol9K9qQLUAkH/BXZI96cK8CYQ9gnp3lQBLgWCzskCMAOMlRn0IelVRmSmzKDHga70CiPxubSgfdj3pFcYicWygz4uvcJItMoOepvf0uWuWWrQPuwX0quMQK2KoC+Qt07pIfug95G32RiGATmobuAB3CJPS8BElUEfIU/zlYW8gmGAZtOVBr3MMECzyZiGAVr1iu97JILeRV5alYe8gmGARk3JoC+Tj5pk0LkMAzpiIQ8MA76j36xo0D7s++hXl845h2HAUqXH7oyHAfMuFsqHAdMuFsqHAZMuFoqHAT2RY3eGw4CWi43SYUDTxUbpMKDmYqNwGNBxsULXMED+2J3JMKDuYgXsRIfiFrjVxQx4QvruutgBB0nbH2CPSwFwg3Sdc6kA1gN3SM9VYI1LCf1j+ZR/6VXsFoFjLmXABHDG77E/+i/SY7gPvwceAA17IZcxxhhjzGp/1XQKeOpncT3/d7PMuZxUXRHAduDVkH1tu/gfLXVF0L+ihi12cNHjqdcVQ/9ju1KN1OuKAZ6NsOC51OuKYbR3fHRTryuG0Rb8LfW6YrBbR2VBN4UehiJ1xdDfZhVbqOW0/+fbt6TqiqJ/cGgLHVgqrysKGPPTjDn/oOr6nyY0yryipOoaY4wxxhhjjIvNP1oG66QRTSVLAAAAAElFTkSuQmCC" />
              </defs>
            </svg>

            <!-- Cart Number -->
            <span>3</span>
          </a>
        </div>
      </div>

      <!-- Navigation Bar -->
      <nav class="navigation">
        <ul class="menu">
          <li><a href="#">Computers</a></li>
          <li><a href="#">Components</a></li>
          <li><a href="#">Peripherals</a></li>
          <li><a href="#">Networking</a></li>
          <li><a href="#">Accessories</a></li>
          <li><a href="#">Gadgets</a></li>
          <li><a href="#">Deals</a></li>
        </ul>
      </nav>
    </header>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Welcome Text -->
      <div class="mc-text">
        <strong>Unleash the Ultimate Performance</strong>
        <h1>The Beast</h1>
        <p>
          Experience lightning-fast speeds and seamless performance with our
          cutting-edge PC.
        </p>
        <a href="#">Check out now</a>
      </div>

      <!-- Welcome Image -->
      <div class="mc-image">
        <img src="resources/images/pc1half.png" alt="pc" />
      </div>
    </div>
  </section>

  <!-- Login / Signup -->
  <div class="form">
    <!-- Main Login Form -->
    <div class="login-form">
      <a href="#" class="form-cancel">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512"
          height="1em"
          width="1em">
          <path
            d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
        </svg>
      </a>
      <img src="resources/images/logo.png" alt="black_icon" />
      <strong>Account</strong>

      <?php if (isset($_GET['error'])): ?>
        <div class="error-message" style="color: red;">
          <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
      <?php endif; ?>

      <!-- Forms to Fill-up -->
      <form action="pages/login.php" method="POST">
        <input
          type="text"
          placeholder="Enter Username"
          name="username"
          required />
        <input
          type="password"
          placeholder="Enter Password"
          name="password"
          required />
        <input type="submit" value="Sign In" />
      </form>

      <!-- MiscButtons -->
      <div class="form-buttons">
        <a href="#" class="forget">Forgot Your Password?</a>
        <a href="#" class="Sign-up-button">Create Account</a>
      </div>
    </div>

    <!-- Main SignUp Form -->
    <div class="signup-form">
      <a href="#" class="Signup-cancel">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512"
          height="1em"
          width="1em">
          <path
            d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z" />
        </svg>
      </a>

      <p>Join TechVault Today!</p>
      <strong>Create an Account</strong>

      <!-- Forms to Fill-up -->
      <form>
        <input type="text" placeholder="John Doe" name="fullname" required />
        <input
          type="email"
          placeholder="example@gmail.com"
          name="email"
          required />
        <input
          type="password"
          placeholder="Enter Password here"
          name="password"
          required />
        <input type="submit" value="Create Account" />
      </form>

      <!-- MiscButtons -->
      <div class="signup-form-buttons">
        <a href="#" class="already-account">Already have an Account?</a>
      </div>
    </div>
  </div>

  <!-- Category Section -->
  <section id="category">
    <!-- Box -->
    <a href="" class="category-box">
      <div class="category-box-img">
        <img src="resources/images/pc2.png" alt="pc1" />
      </div>
      <strong>Laptops</strong>
    </a>
    <!-- Box -->
    <a href="" class="category-box">
      <div class="category-box-img">
        <img src="resources/images/pc1.png" alt="pc2" />
      </div>
      <strong>Desktops</strong>
    </a>
    <!-- Box -->
    <a href="" class="category-box">
      <div class="category-box-img">
        <img src="resources/images/pc3.png" alt="pc3" />
      </div>
      <strong>Processors</strong>
    </a>
    <!-- Box -->
    <a href="" class="category-box">
      <div class="category-box-img">
        <img src="resources/images/pc4.png" alt="pc4" />
      </div>
      <strong>Motherboards</strong>
    </a>
    <!-- Box -->
    <a href="" class="category-box">
      <div class="category-box-img">
        <img src="resources/images/pc5.png" alt="pc5" />
      </div>
      <strong>Graphics Card</strong>
    </a>
    <!-- Box -->
    <a href="" class="category-box">
      <div class="category-box-img">
        <img src="resources/images/pc6.png" alt="pc6" />
      </div>
      <strong>Memory & Storage</strong>
    </a>
    <!-- Box -->
    <a href="" class="category-box">
      <div class="category-box-img">
        <img src="resources/images/pc7.png" alt="pc7" />
      </div>
      <strong>Hardware</strong>
    </a>
  </section>

  <script src="js/userLogon.js"></script>
</body>

</html>