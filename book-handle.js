
// For Interface 3: Book
document.addEventListener("DOMContentLoaded", function() {
    const hamburger = document.getElementById("hamburger");
    const navLinks = document.getElementById("nav-links");

    hamburger.addEventListener("click", function() {
        navLinks.classList.toggle("active");
    });

    // Load property details
    const property = JSON.parse(sessionStorage.getItem('selectedProperty'));
    if (property) {
        document.getElementById('property-photo').src = property.photo;
        document.getElementById('property-title').textContent = property.title;
        document.getElementById('property-area').textContent = "Area: " + property.area;
        document.getElementById('property-rooms').textContent = "Rooms: " + property.rooms;
        document.getElementById('property-price').textContent = "Price per night: $" + property.price;
    }

    // Check if user is logged in
    const user = JSON.parse(sessionStorage.getItem('user'));
    if (user) {
        document.getElementById('login-logout').innerHTML = '<a href="#" onclick="logout()">Logout</a>';
    } else {
        alert("Please log in to book a property.");
        window.location.href = "Login.html";
    }
});

function checkAvailability() {
    const startDate = document.getElementById("start-date").value;
    const endDate = document.getElementById("end-date").value;

    if (new Date(startDate) >= new Date(endDate)) {
        alert("End date must be after start date.");
        return;
    }

    // Placeholder for availability check logic (use AJAX/PHP)
    const isAvailable = true; // Replace with actual availability check

    if (isAvailable) {
        document.getElementById("step-1").style.display = "none";
        document.getElementById("step-2").style.display = "block";

        // Pre-fill user details (assuming they are stored in sessionStorage or similar)
        const user = JSON.parse(sessionStorage.getItem('user'));
        document.getElementById('name').value = user.name;
        document.getElementById('surname').value = user.surname;
        document.getElementById('email').value = user.email;

        // Calculate final amount
        const property = JSON.parse(sessionStorage.getItem('selectedProperty'));
        const nights = (new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24);
        const initialAmount = property.price * nights;
        const discountRate = Math.random() * (0.30 - 0.10) + 0.10;
        const finalAmount = initialAmount - (initialAmount * discountRate);

        document.getElementById('final-amount').textContent = "Final Amount: $" + finalAmount.toFixed(2);
    } else {
        alert("The selected property is not available for the chosen dates. Please select different dates.");
    }
}

function handleBooking(event) {
    event.preventDefault();

    // Collect booking details
    const name = document.getElementById("name").value;
    const surname = document.getElementById("surname").value;
    const email = document.getElementById("email").value;
    const startDate = document.getElementById("start-date").value;
    const endDate = document.getElementById("end-date").value;

    // Placeholder for booking logic (use AJAX/PHP)
    alert("Booking succ

}
