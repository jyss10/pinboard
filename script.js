const navbarMenu = document.querySelector(".navbar .links");
const hamburgerBtn = document.querySelector(".hamburger-btn");
const hideMenuBtn = navbarMenu.querySelector(".close-btn");
const showPopupBtn = document.querySelector(".login-btn");
const showSignupBtn = document.querySelector(".signup-btn");
const formPopup = document.querySelector(".form-popup");
const hidePopupBtn = formPopup.querySelector(".close-btn");
const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");

// Show mobile menu
hamburgerBtn.addEventListener("click", () => {
    navbarMenu.classList.toggle("show-menu");
});

// Hide mobile menu
hideMenuBtn.addEventListener("click", () => hamburgerBtn.click());

// Show login popup
showPopupBtn.addEventListener("click", () => {
    document.body.classList.add("show-popup");
    formPopup.classList.remove("show-signup"); // Ensure the login form is shown
});

// Show signup popup when "Sign Up" button is clicked
showSignupBtn.addEventListener("click", () => {
    document.body.classList.add("show-popup");
    formPopup.classList.add("show-signup"); // Show the signup form
});

// Hide login/signup popup
hidePopupBtn.addEventListener("click", () => {
    document.body.classList.remove("show-popup");
});

// Show or hide signup form based on link clicked
signupLoginLink.forEach(link => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        if (link.id === 'signup-link') {
            formPopup.classList.add("show-signup"); // Show signup
        } else {
            formPopup.classList.remove("show-signup"); // Show login
        }
    });
});

// Hide notification after 3 seconds
const notification = document.querySelector('.notification');
if (notification) {
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}
