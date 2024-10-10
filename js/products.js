document.querySelectorAll('.menu a').forEach(link => {
    link.addEventListener('click', function(event) {
        const category = this.getAttribute('data-category');
            
        window.location.href = `products.php?category=${category}`;
        if (login_success) {
            const href = this.href;
            const newHref = new URL(href);
            newHref.searchParams.set('login_success', 'true');
            window.location.href = newHref.toString();
        } else {
            window.location.href = this.href;
        }
        event.preventDefault(); 
    });
});


