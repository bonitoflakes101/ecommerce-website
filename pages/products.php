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

    header {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      margin-top: 50px;
      padding: 20px;
    }

  .category-title {
      font-size: 2.5rem;
    }

    .navigation{
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 1200px;
    width: 90%;
    margin: auto;
    padding: 20px 0px;
    z-index: 101;
    position: relative;
  }

  .menu{
    display: flex;
    align-items: center; 
  }

  .menu li {
    list-style-type: none;
  }

  .menu li a{
      text-decoration: none;
      margin-left: 0;
      margin-top: 0;
      margin-bottom: 0;
      margin-right: 40px;
      color: #121212;;
      letter-spacing: 0.5px;
      font-weight: 500;
      font-size: 1.2rem;
  }

  .menu li a:hover{
      color: var(--secondary-color);
      text-decoration: underline;
  }

  .menu li{
      position: relative;
  }


    .product-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr 1fr;
      grid-gap: 40px;
      padding: 30px;
     align-items: start;
    }


    .product-box {
      display: flex;
      flex-direction: column;
      width: 100%;
      justify-content: center;
      align-content: center;
    }

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
      text-decoration: none;
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
    text-decoration: none;
    }

    .product-cart-button svg{
        margin-left: 5px;
    }

    .product-cart-button:hover{
        background-color: var(--tertiary-color);
    }

  </style>
  

</head>


<header>

<h2 class="category-title">Laptops</h2>
<nav class="navigation">
        <ul class="menu">
          <li><a href="#">Laptops</a></li>
          <li><a href="#">Desktops</a></li>
          <li><a href="#">Processors</a></li>
          <li><a href="#">Motherboards</a></li>
          <li><a href="#">Graphic Cards</a></li>
          <li><a href="#">Memory & Storage</a></li>
          <li><a href="#">Hardware</a></li>
        </ul>
      </nav>

</header>
<body>

  <!-- Main Grid for Products -->
  <div class="product-grid">
    
  <?php
    require '../includes/db_config.php';
    $sql = "SELECT ProductName, Price, ProductImages FROM Product WHERE Category = 'Laptops'";
    $stmt = $pdo->query($sql);

    

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
    




    <!-- //echo '<img src="data:image/jpeg;base64,' . base64_encode($row['ProductImages']) . '" alt="Product Image" class="img">';

    // echo '<p>'.htmlspecialchars($row['ProductName']).'</p>';
    // echo '<p>'.htmlspecialchars($row['Price']).'</p>';
  ?> -->

  <!-- <div class="product-box">
    <a class="product-box-img">
      <img src="php" alt="">
    </a>
    <div class="product-box-text">
      <a href="#" class="product-text-title"></a>
      <span class="product-box-text-title"></span>
    </div>
  </div>

  <img src="resources/images/pc1half.png" alt="pc" /> -->
  
    <!-- ENDING TAG FOR PRODUCT GRID -->
  </div>
</body>
</html>
