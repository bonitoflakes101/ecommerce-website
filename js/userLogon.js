document.addEventListener("DOMContentLoaded", function() {
    const navUser = document.querySelector('.nav-user');
    const loginForm = document.querySelector('.login-form');
    const signupForm = document.querySelector('.signup-form');
    const forgotPassForm = document.querySelector('.forgot-pass-form'); 
    const formContainer = document.querySelector('.form');
    
    const createAccountButton = document.querySelector('.Sign-up-button');
    const signupcancel = document.querySelector('.Signup-cancel');
    const alreadyAccountButton = document.querySelector('.already-account');
    const logincancel = document.querySelector('.form-cancel');

    const forgotPasscancel = document.querySelector('.forgot-pass-cancel'); 
    const toLoginButton = document.querySelector('.to-login-button'); 
    const forgotPassButton = document.querySelector('.forget');
    
    

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

    // Show the login form when the nav user is clicked
    navUser.addEventListener('click', function() {
        showLoginForm();
    });

    // Event for the Create Account button
    createAccountButton.addEventListener('click', function() {
        showSignupForm(); // Show the signup form
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
});
