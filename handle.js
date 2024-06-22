// For Navigation Bar
document.addEventListener("DOMContentLoaded", function() {
    const hamburger = document.getElementById("hamburger");
    const navLinks = document.getElementById("nav-links");

    hamburger.addEventListener("click", function() {
        navLinks.classList.toggle("active");
    });

    checkLoginStatus(); // Check login status when the page loads
});

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