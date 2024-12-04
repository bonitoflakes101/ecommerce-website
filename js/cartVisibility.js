document.addEventListener("DOMContentLoaded", function() {
    const cartTab = document.querySelector('.cart-tab');
    const formContainer = document.querySelector('.form');
    const closeButton = document.querySelector('.cart-close');
    const cartContainer = document.querySelector('.cart-container');
    const cartList = document.querySelector('.cart-list'); // Parent container for cart items

    // para global
    window.cartTab = cartTab;
    window.cartContainer = cartContainer;

    if (closeButton) {
        closeButton.addEventListener('click', function() {
            hideCartBox();
        });
    }

    // Event listener for delete-cart-item buttons (using event delegation)
    if (cartList) {
        cartList.addEventListener('click', function(event) {
            const deleteButton = event.target.closest('.delete-cart-item');
            if (deleteButton) {
                const CartItemID = deleteButton.value; // Access the productItemID
                deleteCartItem(CartItemID);
                fetchCartItems();
            }

            // Event listener for plus button
            const plusButton = event.target.closest('.plus');
            if (plusButton) {
                const cartItemElement = plusButton.closest('.cart-item');
                const cartitemID = cartItemElement.id;
                console.log(cartitemID);
                updateQuantity(cartitemID, 1); // Increment quantity by 1
            }

            // Event listener for minus button
            const minusButton = event.target.closest('.minus');
            if (minusButton) {
                const cartItemElement = minusButton.closest('.cart-item');
                const cartitemID = cartItemElement.id;
                console.log(cartitemID);
                updateQuantity(cartitemID, -1); // Decrement quantity by 1
            }

        });

    }
}); 

// Function to show the cart
function showCartBox() {
    console.log("executing fetch items");
    fetchCartItems();
    cartTab.style.visibility = "visible";
    cartTab.style.opacity = "1";
    cartContainer.style.visibility = "visible";
}

// Function to hide the cart
function hideCartBox() {
    cartTab.style.visibility = "hidden";
    cartTab.style.opacity = "0";
    cartContainer.style.visibility = "hidden";
}

// Function to fetch cart items
function fetchCartItems() {
    fetch('/ecommerce-website/pages/cart.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json(); // Parse yung JSON from the response
        })
        .then(cartItems => {
            console.log("Successful Loading of Cart: Updated Product's List:");
            console.log(cartItems); // Log the cartItems for validation
            displayCartItems(cartItems);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}


// Function to update quantity
function updateQuantity(cartitemID, change) {
    console.log(`Updating quantity for ProductID: ${cartitemID}, Change: ${change}`);

    // Send request to update the quantity
    fetch(`/ecommerce-website/pages/update_cart_quantity.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({cartitemID: cartitemID, change: change })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json(); // Parse JSON from the response
    })
    .then(result => {
        if(result.status === 'error') {
            alert(result.message); // Display error message from the server
        } else {
            console.log("Quantity updated:", result);
            fetchCartItems(); // Refresh the cart after successful update
        }
    })
    .catch(error => {
        console.error('There was a problem with the update operation:', error);
    });
}



// Function to display the cart items on the page
function displayCartItems(cartItems) {
    const cartContainer = document.querySelector('.cart-list');

    // Clear any existing content in the cart to reset after fetching data
    cartContainer.innerHTML = '';

    // Loop through the cart items and create HTML elements for each
    cartItems.forEach(item => {
        const cartItemElement = document.createElement('div');
        cartItemElement.className = 'cart-item';
        cartItemElement.id = item.CartItemID;

        // Creating the content with the item data
        cartItemElement.innerHTML = `
            <div class="cart-item-image">
                <img src="../resources/products/${item.ProductImages}.png" alt="">
            </div>
            
            <div id="${item.ProductID}" class="cart-item-title">
                <p>${item.ProductName}</p>
            </div>

            <div class="cart-item-price">
                <p>${item.Price}</p>
            </div>

            <div class="cart-item-quantity">
                <span class="minus">-</span>
                <span class="amount">${item.Quantity}</span>
                <span class="plus">+</span>
            </div>

            <div class="cart-item-quantity">
                <button name="delete-cart-item" value="${item.CartItemID}" class="delete-cart-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="1em" width="1em">
                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                    </svg>
                </button>
            </div>
        `;

        cartContainer.appendChild(cartItemElement);
    });
}

// Function to handle cart item deletion
function deleteCartItem(CartItemID) {
    console.log(`Deleting cart item with ProductID: ${CartItemID}`);

    // Send request to delete the cart item
    fetch(`/ecommerce-website/pages/delete_cart_items.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({CartItemID: CartItemID})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json(); // Parse JSON from the response
    })
    .then(result => {
        console.log("Item successfully deleted:", result);
        //refetch cart items or remove the deleted item from DOM to make sure
        fetchCartItems(); // Refresh the cart
    })
    .catch(error => {
        console.error('There was a problem with the delete operation:', error);
    });
}
