<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profileStyle.css" />

    <title>TechVault Profile</title>
    <link rel="icon" type="image/x-icon" href="resources/images/logo-icon.png" />
</head>

<body>
    <!-- Main Header -->
    <section id="main">
        <!-- Header -->
        <header>
            <!-- Top Header / Logo Bar -->
            <div class="header-top">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <img src="resources/images/logo-with-icon.png" alt="logo" />
                </a>

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
                    <a href="#" id="navCart" class="nav-cart">
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

    </section>

    <section class="main-profile">
        <div class="page-title">
            <h1>Profile</h1>
            <strong>Welcome to your Techvault Profile!</strong>
        </div>
        <div class="profile-content-container">
            <div class="profile-content">
                <div class="profile-content-image">
                    <img src="resources/images/pfpholder.png" alt="profile-picture">
                </div>
                <div class="profile-content-text">
                    <span>Kennett Miralles</span>
                    <p>example@techvault.com</p>
                    <br>
                    <p>Full Address Here</p>
                    <p>Contact Details Here</p>
                </div>
            </div>
            <div class="other-content-text">
                <span>Customer</span>
                <p>89 Items Rated</p>
                <br>
                <p>Items Ordered : 89</p>
                <a href="#">Logout</a>

            </div>

        </div>
    </section>

    <!-- Order history -->
    <section class="order-profile">
        <div class="order-page-title">
            <h1>Order History</h1>
        </div>
        <!-- Order Container -->
        <div class="order-container">
            <div class="product-order">
                <div class="product-order-image">
                    <img src="resources/images/pc1.png" alt="order-image">
                </div>
                <div class="product-order-details">
                    <strong>Product Title</strong>
                </div>
                <div class="product-order-details">
                    <strong>Product Category</strong>
                </div>
                <div class="product-order-details">
                    <strong>Product Quantity</strong>
                </div>
                <div class="product-order-price">
                    <strong>P100,000.00</strong>
                </div>
                <div class="product-order-status">
                    <strong>In-Transit</strong>
                </div>
                
            </div>
        </div>
        <!-- Order Container -->
        <div class="order-container">
            <div class="product-order">
                <div class="product-order-image">
                    <img src="resources/images/pc1.png" alt="order-image">
                </div>
                <div class="product-order-details">
                    <strong>Product Title</strong>
                </div>
                <div class="product-order-details">
                    <strong>Product Category</strong>
                </div>
                <div class="product-order-details">
                    <strong>Product Quantity</strong>
                </div>
                <div class="product-order-price">
                    <strong>P100,000.00</strong>
                </div>
                <div class="product-order-status">
                    <strong>In-Transit</strong>
                </div>
                
            </div>
        </div>
        
    </section>

</body>

</html>