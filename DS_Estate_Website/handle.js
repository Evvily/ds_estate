// For Navigation Bar
document.addEventListener("DOMContentLoaded", function() {
    const navLinks = document.getElementById("nav-links")
	
    checkLoginStatus(); // Check login status when the page loads
});

function toggleMenu() {
    const navLinks = document.getElementById("nav-links");
    if (navLinks) {
        navLinks.classList.toggle("active");
    } else {
        console.error("Element with id 'nav-links' not found.");
    }
}

function checkLoginStatus() {
    const isLoggedIn = getCookie('user_logged_in') === 'true';

    const loginButtonForm = document.getElementById('loginButtonForm');
    const logoutButtonForm = document.getElementById('logoutButtonForm');

    if (isLoggedIn) {
        loginButtonForm.classList.add('hide');
        logoutButtonForm.classList.remove('hide');
        logoutButtonForm.classList.add('show');
    } else {
        logoutButtonForm.classList.add('hide');
        loginButtonForm.classList.remove('hide');
        loginButtonForm.classList.add('show');
    }
}

function getCookie(cookieName) {
    const name = cookieName + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookieArray = decodedCookie.split(';');
    for(let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i].trim();
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return "";
}