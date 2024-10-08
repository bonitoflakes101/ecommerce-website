<!-- SESSION START -->
<?php session_start(); 
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Computers</title>

  <!-- STYLES -->
  <style>

    @import url('https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap');

    *{
        margin: 0px;
        padding: 0px;
        box-sizing: border-box;
        font-family: "Afacad Flux", sans-serif;
        text-decoration: none;
        list-style-type: none;
    }

    :root{
    --text-color:#f8f8f8;
    --main-color:#bdbdbd;
    --main-dark:#212121;
    --secondary-color:#3BBECD;
    --tertiary-color:#5edbe9;
    --product-bg-color:#e2e2e2;
    --price-color:#20919e;
    }



    .product-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      grid-gap: 40px;
      padding: 50px;
      align-items: start;
    }


    .product-box {
      display: flex;
      flex-direction: column;
      width: 100%;
      justify-content: center;
      align-content: center;
    }

    /* .product-box:hover {
      border: solid var(--price-color);
      border-radius: 10px;
      transition: all ease 0.2s;
      cursor: pointer;
    } */

    .product-box-img {
      
      width:100%;
      max-height: 300px;
      background-color: var(--product-bg-color);
      padding: 20px;
      position: relative;
      border-radius: 10px;
    }

    .product-box-img img{
      width: 100%;
      height: 200px;
      object-fit: contain;
      object-position: center;
    }

    .product-box-text {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      
    }

    .product-box-text .product-text-title{
      color: #121212;
      font-size: 1.25rem;
      font-weight: 500;
      margin-top: 10px;
      /* text-decoration: none; */
    }

    .product-box-text .product-box-text-tile{
      color: var(--price-color);
      font-size: 1rem;
      font-weight: 500;
    }


    /* ADD TO CART BUTTON STYLES */
    .product-cart-button{
    margin-top: 10px;
    width: 100%;
    padding: 10px;
    color: #121212;
    font-size: 1rem;
    font-weight: 500;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: var(--secondary-color);
    border-radius: 10px;
    transition: all ease 0.3s;
    }

    .product-cart-button svg{
        margin-left: 5px;
    }

    .product-cart-button:hover{
        background-color: var(--tertiary-color);
    }





    /* test */
    #main{
    background-image: linear-gradient(to top, #121212 , #212121, #212121);
    min-height: 15vh;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.header-top{
    max-width: 1200px;
    width: 90%;
    margin: auto;
    padding: 15px 0px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: var(--main-dark);
}

.logo{
    max-width: 180px;
    max-height: 40px;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
}

.logo img{
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    max-height: 40px;
}

.full-search-bar{
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 50%;
}

.search{
    width: max-content;
    display: flex;
    align-items: center;
    padding: 5px;
    border-radius: 20px;
    background: #f6f6f6;
    margin-right: 10px;
}

.search-input{
    margin-left: 15px;
    margin-right: 10px;
    font-size: 1rem;
    color: #151515;
    outline: none;
    border: none;
    background: transparent;
    box-shadow: none;
    width: 200px;
}

.nav-buttons{
    display: flex;
    justify-content: center;
    align-items: center;
    grid-gap: 15px;
}

.nav-buttons a svg{
    fill: #000000;
    height: 30px;
    width: auto;
}

.nav-cart{
    position: relative;
}

.nav-cart span{
    position: absolute;
    right: -8px;
    top: -12px;
    font-size: 0.6rem;
    font-weight: 800;
    width: 20px;
    height: 20px;
    background-color: var(--secondary-color);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: var(--text-color);
}

.menu{
    display: flex;
    align-items: center; 
}

.navigation{
    display: flex;
    justify-content: left;
    align-items: center;
    max-width: 1200px;
    width: 90%;
    margin: auto;
    padding: 20px 0px;
    z-index: 101;
    position: relative;
}

.menu li a{
    margin-left: 0;
    margin-top: 0;
    margin-bottom: 0;
    margin-right: 40px;
    color: var(--text-color);
    letter-spacing: 0.5px;
    font-weight: 500;
    font-size: 1rem;
}

.menu li a:hover{
    color: var(--secondary-color);
}

.menu li{
    position: relative;
}



footer{
    width: 100%;
}

.footer-container{
    max-width: 1200px;
    width: 90%;
    margin: 0px auto;
    padding: 50px 0px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.footer-company-box,
.footer-newsletter{
    max-width: 330px;
}

.footer-company-box .footer-logo{
    max-width: 150px;
    height: 45px;
    display: flex;
}

.footer-company-box .footer-logo img{
    width: 100%;
    min-height: 100%;
    object-fit: contain;
    object-position: center;
}

.footer-company-box p,
.footer-newsletter p{
    color: #121212;
    margin: 5px 0px;
}

.footer-social{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.footer-social a{
    background-color: var(--price-color);
    border-radius: 50%;
    fill: #ffffff;
    margin-top: 10px;
    margin-right: 10px;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;  
    transition: all ease 0.3s;
}

.footer-social a:hover{
    fill: #ffffff;
    background-color: var(--main-dark);
}

.footer-link-box{
    display: flex;
    flex-direction: column;
}

.footer-link-box strong,
.footer-newsletter strong{
    color: #121212;
    font-size: 1.25rem;
    font-weight: 600;
}

.footer-link-box ul{
   margin-top: 5px; 
}

.footer-link-box ul li a{
    color: #121212;
    transition: all ease 0.3s;
}

.footer-link-box ul li a:hover{
    color: var(--price-color);
}

.subscribe-box{
    width: 100%;
    display: flex;
    justify-content: center;
    height: 100%;
    margin-top: 10px;
    border-radius: 20px;
}

.subscribe-box input{
    border: none;
    outline: none;
    width: 100%;
    background-color: #e5e5e5;
    border-radius: 10px 0px 0px 10px;
    padding: 0px 15px;
}

.subscribe-box button{
    border: none;
    outline: none;
    background-color: var(--price-color);
    color: #ffffff;
    text-transform: uppercase;
    font-weight: 500px;
    height: 40px;
    padding: 0px 20px;
    border-radius: 0px 10px 10px 0px;
    transition: all ease 0.3s;
}

.subscribe-box button:hover{
    background-color: var(--main-dark);
    cursor: pointer;   
}

.footer-bottom{
    background-color: var(--main-dark);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.footer-bottom span{
    padding-top: 5px;
    color: #cfcfcf;

}

.footer-bottom p{
    padding-bottom: 5px;
    color: #929292;

}


    

  </style>
  

</head>


<body>

    <!-- Main Header -->
    <section id="main">
        <!-- Header -->
        <header>
            <!-- Top Header / Logo Bar -->
            <div class="header-top">
                <!-- Logo -->
                <a href="../index.php" class="logo">
                    <img src="../resources/images/logo-with-icon.png" alt="logo" />
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
                    <a href="cart.php" id="navCart" class="nav-cart">
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
                    <li><a href="products.php?category=laptops">Laptops</a></li>
                    <li><a href="products.php?category=desktops">Desktops</a></li>
                    <li><a href="products.php?category=Processors">Processors</a></li>
                    <li><a href="products.php?category=Motherboards">Motherboards</a></li>
                    <li><a href="products.php?category=GraphicCards">Graphics Cards</a></li>
                    <li><a href="products.php?category=MemoryStorage">Memory & Storage</a></li>
                    <li><a href="products.php?category=Hardware">Hardware</a></li>
                </ul>
                </ul>
            </nav>
        </header>

    </section>




  <!-- Main Grid for Products -->
  <div class="product-grid">
    
  <?php
    require '../includes/db_config.php';
    
    $category = isset($_GET['category']) ? $_GET['category'] : 'default_category';
    $query = "";

    if ($category === "laptops") {
        $query = "SELECT ProductName, Price, ProductImages FROM product WHERE category = 'Laptops'";
    } elseif ($category === "desktops") {
        $query = "SELECT ProductName, Price, ProductImages FROM product WHERE category = 'Desktops'";
    } elseif  ($category === "Processors") {
        $query = "SELECT ProductName, Price, ProductImages FROM product WHERE category = 'Processors'"; 
    } elseif  ($category === "Motherboards") {
        $query = "SELECT ProductName, Price, ProductImages FROM product WHERE category = 'Motherboards'"; 
    } elseif  ($category === "GraphicCards") {
        $query = "SELECT ProductName, Price, ProductImages FROM product WHERE category = 'Graphics Card'"; 
    } elseif  ($category === "MemoryStorage") {
        $query = "SELECT ProductName, Price, ProductImages FROM product WHERE category = 'Memory & Storage'"; 
    } elseif  ($category === "Hardware") {
        $query = "SELECT ProductName, Price, ProductImages FROM product WHERE category = 'Hardware'"; 
    } else {
        $query = "SELECT ProductName, Price, ProductImages FROM product"; // default query
    }


    $stmt = $pdo->query($query);

    

    while ($row = $stmt->fetch()) { ?>

    <div class="product-box">
    
    <?php
      echo '<a class="product-box-img">';
        echo '<img src="..\resources\images\pc1.png" alt="">';
      echo '</a>';

      echo '<div class="product-box-text">';
        echo '<a href="#" class="product-text-title">'.htmlspecialchars($row['ProductName']).'</a>';
        echo '<span class="product-box-text-title">'.htmlspecialchars($row['Price']).'</span>';
      
        echo '<a href="#" class="product-cart-button">
              Add to Cart
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="1em" width="1em">
                <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" />
              </svg>
            </a>';
      
      echo '</div>';
    ?>  

    </div>

    <?php 
        } 
      ?>
  
  </div>



    <!-- Footer -->
    <footer>
    <!-- Footer Container -->
    <div class="footer-container">
      <!-- Company box -->
      <div class="footer-company-box">
        <!-- Logo -->
        <a href="#" class="footer-logo">
          <img src="../resources/images/logo.png" alt="logo">
        </a>
        <!-- Details -->
        <p>Product names and logos used in this website are for identification purposes only and are trademarks of their respective owners.</p>
        <!-- Social Box -->
        <div class="footer-social">
          <!-- Facebook -->
          <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" width="1em" viewBox="0 0 320 512">
              <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" />
            </svg>
          </a>
          <!-- Instagram -->
          <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="1em" width="1em">
              <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
            </svg>
          </a>
          <!-- Messenger -->
          <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="1em" width="1em">
              <path d="M256.6 8C116.5 8 8 110.3 8 248.6c0 72.3 29.7 134.8 78.1 177.9 8.4 7.5 6.6 11.9 8.1 58.2A19.9 19.9 0 0 0 122 502.3c52.9-23.3 53.6-25.1 62.6-22.7C337.9 521.8 504 423.7 504 248.6 504 110.3 396.6 8 256.6 8zm149.2 185.1l-73 115.6a37.4 37.4 0 0 1 -53.9 9.9l-58.1-43.5a15 15 0 0 0 -18 0l-78.4 59.4c-10.5 7.9-24.2-4.6-17.1-15.7l73-115.6a37.4 37.4 0 0 1 53.9-9.9l58.1 43.5a15 15 0 0 0 18 0l78.4-59.4c10.4-8 24.1 4.5 17.1 15.6z" />
            </svg>
          </a>
          <!-- Youtube -->
          <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" height="1em" width="1em">
              <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z" />
            </svg>
          </a>
        </div>
      </div>

      <!-- Categories -->
      <div class="footer-link-box">
        <strong>Categories</strong>
        <ul>
          <li><a href="#">Computers</a></li>
          <li><a href="#">Components</a></li>
          <li><a href="#">Peripherals</a></li>
          <li><a href="#">Networking</a></li>
          <li><a href="#">Accessories</a></li>
        </ul>
      </div>

      <!-- Mode of Payments -->
      <div class="footer-link-box">
        <strong>Payments</strong>
        <ul>
          <li><a href="#">PayMaya</a></li>
          <li><a href="#">Gcash</a></li>
          <li><a href="#">BDO</a></li>
          <li><a href="#">MetroBank</a></li>
        </ul>
      </div>

      <!-- Physical Stores -->
      <div class="footer-link-box">
        <strong>Physical Stores</strong>
        <ul>
          <li><a href="#">Manila City</a></li>
          <li><a href="#">Makati</a></li>
          <li><a href="#">Quezon City</a></li>
          <li><a href="#">Caloocan</a></li>
          <li><a href="#">Marikina</a></li>
        </ul>
      </div>

      <!-- NewsLetter -->
      <div class="footer-newsletter">
        <strong>Newsletter</strong>
        <p>Enter Email to Receive Latest Discounts & Deals</p>
        <form class="subscribe-box">
          <input type="email" placeholder="example@techvault.com" required />
          <button>Subscribe</button>

        </form>
      </div>

    </div>

    <!-- Bottom Footer -->
    <div class="footer-bottom">
      <span class="footer-owner"> All Rights Reserved 2024</span>
      <p>All Resources and Products in this website is solely for Educational Purposes Only</p>
    </div>
  </footer>

</body>
</html>
