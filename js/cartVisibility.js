document.addEventListener("DOMContentLoaded", function() {
    const cartTab = document.querySelector('.cart-tab'); 
    const formContainer = document.querySelector('.form'); 
    const closeButton = document.querySelector('.cart-close');

    window.cartTab = cartTab; // para global

    if (closeButton) {
        closeButton.addEventListener('click', function() {
            hideCartBox();
        });
    }
})


function showCartBox() {
    cartTab.style.visibility = "visible"; 
    cartTab.style.opacity = "1"; 
}

function hideCartBox() {
    cartTab.style.visibility = "hidden"; 
    cartTab.style.opacity = "0"; 
}