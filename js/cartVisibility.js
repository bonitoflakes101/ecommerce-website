document.addEventListener("DOMContentLoaded", function() {
    const cartTab = document.querySelector('.cart-tab'); 
    const formContainer = document.querySelector('.form'); 
    const closeButton = document.querySelector('.cart-close');
    const cartContainer = document.querySelector('.cart-container');
    
    window.cartTab = cartTab; // para global
    window.cartContainer = cartContainer;

    if (closeButton) {
        closeButton.addEventListener('click', function() {
            hideCartBox();
        });
    }
})


function showCartBox() {
    console.log("executing fetch items");
    fetchCartItems();
    cartTab.style.visibility = "visible"; 
    cartTab.style.opacity = "1"; 
    cartContainer.style.visibility = "visible";
    
    // cartContainer.style.opacity = "1";
}

function hideCartBox() {
    cartTab.style.visibility = "hidden"; 
    cartTab.style.opacity = "0"; 
    cartContainer.style.visibility = "hidden";
    // cartContainer.style.opacity = "0";
}


// fetching functions for the cart

// Function to fetch cart items
function fetchCartItems() {
    fetch('/ecommerce-website/pages/cart.php') 
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json(); // Parse the JSON from the response
        })
        .then(cartItems => {
            console.log("Successful Loading of Cart: Updated Product's List: ")
            console.log(cartItems); // Log the cartItems for validation
            displayCartItems(cartItems);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}



// Function to display the cart items in the page
function displayCartItems(cartItems) {
    const cartContainer = document.querySelector('.cart-list'); // The element where you want to display the cart items

    // Clear any existing content in the cart
    cartContainer.innerHTML = '';

    // Loop through the cart items and create HTML elements for each
    cartItems.forEach(item => {
        const cartItemElement = document.createElement('div');
        cartItemElement.className = 'cart-item';
        cartItemElement.id = (item.ProductID);

        // Create the content with the item data
        cartItemElement.innerHTML = `
            
            <div class="cart-item-image">
                <img src="../resources/images/pc1.png" alt="cart-pic">
            </div>
            
            <div id ="${item.ProductID}" class="cart-item-title">
                <p>${item.ProductName}</p>
            </div>

            <div class="cart-item-price" id="">
                <p>${item.Price}</p>
            </div>

            <div class="cart-item-quantity">
                <span class="minus">-</span>
                <span class="amount">${item.Quantity}</span>
                <span class="Plus">+</span>
            </div>
        `;

        // Append the created element to the cart container
        cartContainer.appendChild(cartItemElement);
    });
}