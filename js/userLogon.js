
document.addEventListener("DOMContentLoaded", function() {
    const navUser = document.querySelector('.nav-user');
    const navCart = document.querySelector('.nav-cart');
    const loginForm = document.querySelector('.login-form');
    const signupForm = document.querySelector('.signup-form');
    const forgotPassForm = document.querySelector('.forgot-pass-form');
    const verifyPassForm = document.querySelector('.verify-pass-form'); // Verify password form
    const verifyEmailForm = document.querySelector('.verify-email-form'); // Verify email form
    const formContainer = document.querySelector('.form');
    
    const createAccountButton = document.querySelector('.Sign-up-button');
    const signupcancel = document.querySelector('.Signup-cancel');
    const alreadyAccountButton = document.querySelector('.already-account');
    const logincancel = document.querySelector('.form-cancel');

    const forgotPasscancel = document.querySelector('.forgot-pass-cancel'); 
    const toLoginButton = document.querySelector('.to-login-button');
    const secondLoginButton = document.querySelector('.to-login-button1');
    const thirdLoginButton = document.querySelector('.to-login-button2');
    const forgotPassButton = document.querySelector('.forget');

    const verifyPasscancel = document.querySelector('.verify-pass-cancel'); // Cancel button for verify password OTP form
    const verifyEmailcancel = document.querySelector('.verify-pass-cancel'); // Cancel button for verify email OTP form
    


    const cartElement = document.getElementById("cart");
    const chatbotElement = document.querySelector('[src="https://www.chatbase.co/embed.min.js"]');

    // Add to Cart Button
    const addToCartButtons = document.querySelectorAll('.product-cart-button');

    //  product box
    const productForms = document.querySelectorAll(".product-box");

    console.log("Add to Cart buttons found:", addToCartButtons.length);
    

    function hideChatbot() {
        if (chatbotElement) {
            chatbotElement.style.display = "none"; 
        }
    }

    function showOtpNotification() {
        const notification = document.getElementById('otpNotification');
        notification.classList.add('show');
  
        setTimeout(() => {
            notification.classList.remove('show');
        }, 5000); 
    }

    // SHOW CHANGE PASS SUCCESSFUL
    function showPassNotification() {
        const notification = document.getElementById('passNotification');
        notification.classList.add('show');
  
        setTimeout(() => {
            notification.classList.remove('show');
        }, 5000); 
    }

    // SHOW VERIFY EMAIL SUCCESSFUL
    function showEmailNotification() {
        const notification = document.getElementById('emailNotification');
        notification.classList.add('show');
  
        setTimeout(() => {
            notification.classList.remove('show');
        }, 5000); 
    }

    // Function to show the login form
    function showLoginForm() {
        loginForm.style.visibility = "visible"; 
        loginForm.style.opacity = "1"; 
        formContainer.style.visibility = "visible"; 
        formContainer.style.opacity = "1"; 
        signupForm.style.visibility = "hidden"; 
        signupForm.style.opacity = "0"; 
        forgotPassForm.style.visibility = "hidden"; 
        forgotPassForm.style.opacity = "0"; 
        verifyPassForm.style.visibility = "hidden"; 
        verifyPassForm.style.opacity = "0"; 
        verifyEmailForm.style.visibility = "hidden"; // Hide verify email form
        verifyEmailForm.style.opacity = "0"; 
    }

    // Function to show the signup form
    function showSignupForm() {
        signupForm.style.visibility = "visible"; 
        signupForm.style.opacity = "1"; 
        formContainer.style.visibility = "visible"; 
        formContainer.style.opacity = "1"; 
        loginForm.style.visibility = "hidden"; 
        loginForm.style.opacity = "0"; 
        forgotPassForm.style.visibility = "hidden"; 
        forgotPassForm.style.opacity = "0"; 
        verifyPassForm.style.visibility = "hidden"; 
        verifyPassForm.style.opacity = "0"; 
        verifyEmailForm.style.visibility = "hidden"; // Hide verify email form
        verifyEmailForm.style.opacity = "0"; 
    }

    // Function to show the forgot password form
    function showForgotPassForm() {
        forgotPassForm.style.visibility = "visible"; 
        forgotPassForm.style.opacity = "1"; 
        formContainer.style.visibility = "visible"; 
        formContainer.style.opacity = "1"; 
        loginForm.style.visibility = "hidden"; 
        loginForm.style.opacity = "0"; 
        signupForm.style.visibility = "hidden"; 
        signupForm.style.opacity = "0"; 
        verifyPassForm.style.visibility = "hidden"; 
        verifyPassForm.style.opacity = "0"; 
        verifyEmailForm.style.visibility = "hidden"; // Hide verify email form
        verifyEmailForm.style.opacity = "0"; 
    }

    // Function to show the verify password OTP form
    function showVerifyPassForm() {
        verifyPassForm.style.visibility = "visible"; 
        verifyPassForm.style.opacity = "1"; 
        formContainer.style.visibility = "visible"; 
        formContainer.style.opacity = "1"; 
        forgotPassForm.style.visibility = "hidden"; 
        forgotPassForm.style.opacity = "0"; 
        loginForm.style.visibility = "hidden"; 
        loginForm.style.opacity = "0"; 
        signupForm.style.visibility = "hidden"; 
        signupForm.style.opacity = "0"; 
        verifyEmailForm.style.visibility = "hidden"; // Hide verify email form
        verifyEmailForm.style.opacity = "0"; 
    }

    // Function to show the verify email OTP form
    function showVerifyEmailForm() {
        verifyEmailForm.style.visibility = "visible"; 
        verifyEmailForm.style.opacity = "1"; 
        formContainer.style.visibility = "visible"; 
        formContainer.style.opacity = "1"; 
        forgotPassForm.style.visibility = "hidden"; 
        forgotPassForm.style.opacity = "0"; 
        loginForm.style.visibility = "hidden"; 
        loginForm.style.opacity = "0"; 
        signupForm.style.visibility = "hidden"; 
        signupForm.style.opacity = "0"; 
        verifyPassForm.style.visibility = "hidden"; // Hide verify pass form
        verifyPassForm.style.opacity = "0"; 
    }

    // CATCHES LOGIN ERROR
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('login_error')) {
        console.log("Error detected:", urlParams.get('login_error'));
        showLoginForm(); 
    }

    // CATCHES REGISTER ERROR
    if (urlParams.has('register_error')) {
        console.log("Error detected:", urlParams.get('register_error'));
        showSignupForm(); 
    }

    // CATCHES FORGOT PASS ERROR
    if (urlParams.has('forgot_pass_error')) {
        console.log("Error detected:", urlParams.get('forgot_pass_error'));
        showForgotPassForm(); 
    }

    // CATCHES VERIFY PASS ERROR
    if (urlParams.has('verify_pass_error')) {
        console.log("Error detected:", urlParams.get('verify_pass_error'));
        showVerifyPassForm(); 
    }

    // CATCHES VERIFY EMAIL ERROR
    if (urlParams.has('verify_email_error')) {
        console.log("Error detected:", urlParams.get('verify_email_error'));
        showVerifyEmailForm(); 
    }

    // RESET PASSWORD -> OTP CONFIRMATION
    // 1.) CATCHES RESET PASS / FORGOT PASSWORD
    if (urlParams.has('reset_pass')) {
        console.log("Password reset clicked. OTP SENT");
        showVerifyPassForm(); 
        showOtpNotification();
    }

    // 2.) CATCHES VERIFY PASS SUCCESS
    if (urlParams.has('verify_pass_success')) {
        console.log("OTP Verified", urlParams.get('verify_pass_success'));
        showLoginForm(); 
        showPassNotification();
       
    }

    // 1.) CATCHES EMAIL CONFIRMATION (VERIFY EMAIL FORM)
    if (urlParams.has('confirm_email')) {
        console.log("Email confirmation clicked. OTP SENT");
        showVerifyEmailForm(); 
        showOtpNotification();
    }

    // 2.) CATCHES VERIFY EMAIL SUCCESS
    if (urlParams.has('verify_email_success')) {
        console.log("OTP Verified", urlParams.get('verify_email_success'));
        showLoginForm(); 
        showEmailNotification();
    }
    

    navUser.addEventListener('click', function(event) {
        console.log("User clicked on navUser button");
    
        const currentUrlParams = new URLSearchParams(window.location.search);
        console.log("Current URL Parameters:", currentUrlParams.toString());
    
        if (login_success) {    
            console.log("User is logged in, redirecting to profile page...");
            window.location.assign('/ecommerce-website/profile.php'); 
        } else {
            console.log("User is not logged in, showing login form");
            showLoginForm();
        }
    
        event.preventDefault(); 
    });
    

    navCart.addEventListener('click', function() {
        if (login_success) {
            console.log("User is logged in", login_success);
            showCartBox();  
        } else {
            console.log("User is not logged in, showing login form");
            showLoginForm();  
        }
    });


// ADD TO CART BUTTON: Executes only the add-to-cart functionality when clicked
addToCartButtons.forEach(button => {
    button.addEventListener('click', function(event) {

        // Stop click event from bubbling up to the product box
        event.stopPropagation();
        event.preventDefault();

        if (!login_success) {
            event.preventDefault(); 
            showLoginForm();
        } else {
            event.preventDefault(); 
            let productID = this.value;
            console.log("User is logged in, submitting the form for PHP processing.");
            console.log("ProductID: ", productID);

            // New XMLHttpRequest object
            const postRequest = new XMLHttpRequest();

            // Initialize POST request to server endpoint
            postRequest.open('POST', '/ecommerce-website/pages/cart.php', true);

            // Set the content type for sending form data
            postRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Process request response
            postRequest.onload = function() {
                if (postRequest.status >= 200 && postRequest.status < 400) {
                    console.log("Product added to cart successfully:", postRequest.responseText);
                    showCartBox(); 
                } else {
                    console.error("Error adding product to cart:", postRequest.statusText);
                }
            };

            // Handle network errors
            postRequest.onerror = function() {
                console.error("Request failed due to a network error.");
            };

            // Send the request with the productID in the POST body
            postRequest.send(`productID=${encodeURIComponent(productID)}`);
        }
    });
});

// PRODUCT BOX: Executes the redirection functionality to product page when product box is clicked
productForms.forEach(form => {
    form.addEventListener("click", event => {
        // if (!login_success) {
        //     showLoginForm();
        // } else {
            const productBox = form.closest('.product-box');
            const boxProductID = productBox.getAttribute("data-boxProductID");
            const boxProductName = productBox.getAttribute("data-productName");

            // Set productID in a cookie
            document.cookie = `productID=${encodeURIComponent(boxProductID)}; path=/;`;

            // Redirect to product page with product name in the URL only
            window.location.href = `../pages/product_page.php?productName=${encodeURIComponent(boxProductName)}`;
        // }
    });
});

    

    // Event for the Create Account button
    createAccountButton.addEventListener('click', function() {
        showSignupForm(); 
    });

    // Event for the login cancel button
    logincancel.addEventListener('click', function() {
        loginForm.style.visibility = "hidden"; 
        loginForm.style.opacity = "0"; 
        formContainer.style.visibility = "hidden"; 
        formContainer.style.opacity = "0"; 
    });

    // Event for the signup cancel button 
    signupcancel.addEventListener('click', function() {
        signupForm.style.visibility = "hidden"; 
        signupForm.style.opacity = "0"; 
        formContainer.style.visibility = "hidden";
        formContainer.style.opacity = "0"; 
    });

    // Event for the "Already have an account" button to show the login form
    alreadyAccountButton.addEventListener('click', function() {
        showLoginForm(); 
    });

    toLoginButton.addEventListener('click', function() {
        showLoginForm(); 
    });

    // Event for the Forgot Password button to show the forgot password form
    forgotPassButton.addEventListener('click', function() {
        showForgotPassForm(); 
    });

    // Event for the forgot password cancel button
    forgotPasscancel.addEventListener('click', function() {
        forgotPassForm.style.visibility = "hidden"; 
        forgotPassForm.style.opacity = "0"; 
        formContainer.style.visibility = "hidden"; 
        formContainer.style.opacity = "0"; 
    });

    // Event for the verify pass OTP cancel button
    verifyPasscancel.addEventListener('click', function() {
        verifyPassForm.style.visibility = "hidden"; 
        verifyPassForm.style.opacity = "0"; 
        formContainer.style.visibility = "hidden"; 
        formContainer.style.opacity = "0"; 
    });

    // Event for the verify email OTP cancel button
    verifyEmailcancel.addEventListener('click', function() {
        verifyEmailForm.style.visibility = "hidden"; 
        verifyEmailForm.style.opacity = "0"; 
        formContainer.style.visibility = "hidden"; 
        formContainer.style.opacity = "0"; 
    });

    secondLoginButton.addEventListener('click', function() {
        showLoginForm();
    });

    thirdLoginButton.addEventListener('click', function() {
        showLoginForm();
    });
});