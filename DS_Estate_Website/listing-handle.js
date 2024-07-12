document.addEventListener("DOMContentLoaded", function() {
    // Check if user is logged in, send him back to Login if he isn't
    const isLoggedIn = getCookie('user_logged_in') === 'true';

    if (!isLoggedIn) {
        alert("Please log in to create a listing.");
        window.location.href = "Login.html";
    }
});

// Get cookie again here, I could make it to get the function from the other js file though.
function getCookie(cookieName) {
    const name = cookieName + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookieArray = decodedCookie.split(';');
    for (let i = 0; i < cookieArray.length; i++) {
        let cookie = cookieArray[i].trim();
        if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
        }
    }
    return "";
}

document.getElementById('listingForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch('create_listing.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
			window.location.href = "Feed.php"; // Redirect to Feed after successful listing creation
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});