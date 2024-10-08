document.addEventListener("DOMContentLoaded", function() {
    const cartTab = document.querySelector('cart-tab');
    const formContainer = document.querySelector('.form'); 
})

function showCartBox() {
    cartTab.style.visibility = "visible"; 
    cartTab.style.opacity = "1"; 
}

function hideCartBox() {
    cartTab.style.visibility = "hidden"; 
    cartTab.style.opacity = "0"; 
}