document.addEventListener("DOMContentLoaded", function() {
    const navUser = document.querySelector('.nav-user');
    const loginForm = document.querySelector('.login-form');
    const signupForm = document.querySelector('.signup-form');
    const formContainer = document.querySelector('.form');
    
    const createAccountButton = document.querySelector('.Sign-up-button');
    const alreadyAccountButton = document.querySelector('.already-account');
    const logincancel = document.querySelector('.form-cancel');
    const signupcancel = document.querySelector('.Signup-cancel');

    // Function to show the login form
    function showLoginForm() {
        loginForm.style.visibility = "visible"; 
        loginForm.style.opacity = "1"; 
        formContainer.style.visibility = "visible"; 
        formContainer.style.opacity = "1"; 
        signupForm.style.visibility = "hidden"; 
        signupForm.style.opacity = "0"; 
    }

    // Function to show the signup form
    function showSignupForm() {
        signupForm.style.visibility = "visible"; 
        signupForm.style.opacity = "1"; 
        formContainer.style.visibility = "visible"; 
        formContainer.style.opacity = "1"; 
        loginForm.style.visibility = "hidden"; 
        loginForm.style.opacity = "0"; 
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
        formContainer.style.visibility = "hidden"; // Hide the form container as well
        formContainer.style.opacity = "0"; 
    });

    // Event for the signup cancel button 
    signupcancel.addEventListener('click', function() {
        signupForm.style.visibility = "hidden"; 
        signupForm.style.opacity = "0"; 
        formContainer.style.visibility = "hidden"; // Hide the form container as well
        formContainer.style.opacity = "0"; 
    });

    // Event for the "Already have an account" button to show the login form
    alreadyAccountButton.addEventListener('click', function() {
        showLoginForm(); // Show the login form
    });
});
