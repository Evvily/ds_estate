// For Interface 3: Book
document.addEventListener("DOMContentLoaded", function() {
	
	// Check if user is logged in, send him back to Login if he isn't
    const isLoggedIn = getCookie('user_logged_in') === 'true';

    if (!isLoggedIn) {
        alert("Please log in to book a property.");
        window.location.href = "Login.html";
    } else {
		const propertyId = getCookie('property_id');
	
		// Fetch property details from the server
		fetch('fetch-property.php?id=' + propertyId)
		.then(response => response.json())
			.then(data => {
				if (data.success) {
					const property = data.property;
					document.getElementById('property-photo').src = property.photo;
					document.getElementById('property-title').textContent = property.title;
					document.getElementById('property-area').textContent = "Area: " + property.region;
					document.getElementById('property-rooms').textContent = "Rooms: " + property.rooms;
					document.getElementById('property-price').textContent = "Price per night: " + property.price + "€";
					document.getElementById('property-id').value = property.id; // set property_id hidden input
				} else {
					alert("Failed to load property details.");
					window.location.href = "Feed.php";
				}
			})
			.catch(error => {
				console.error('Error fetching property details:', error);
				alert("Error fetching property details.");
				window.location.href = "Feed.php";
        });
	}
	
	// Event listener for form submission (check availability)
	document.getElementById('booking-step1').addEventListener('submit', function(event) {
		event.preventDefault();
		checkAvailability();
	});

	// Event listener for form submission (submit booking)
	document.getElementById('booking-step2').addEventListener('submit', function(event) {
		event.preventDefault();
		submitBooking();
	});
});

// Get cookie again here, I could make it to get the function from the other js file though.
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

function validateDates() {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);

    if (endDate <= startDate) {
        alert('End date cannot be before or equal to start date');
        // reset end_date input
        document.getElementById('end_date').value = '';
    }
}

function checkAvailability() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const listingId = getCookie('property_id');
	
    const data = { startDate, endDate, listingId };

    fetch('check_availability.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        // Check content type explicitly
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new TypeError('Expected JSON response from server');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'available') {
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';

            fetch('get_user_info.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(userData => {
                document.getElementById('name').value = userData.name;
                document.getElementById('surname').value = userData.surname;
                document.getElementById('email').value = userData.email;
				calculateFinalAmount();
            })
            .catch(error => {
                console.error('Error fetching user info:', error);
                alert('Error fetching user info.');
            });
        } else {
            alert('The property is not available for the selected dates. Please choose different dates.');
        }
    })
    .catch(error => {
        console.error('Error checking availability:', error);
        alert('Error checking availability.');
    });
}

function calculateFinalAmount() {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);
	
	const priceText = document.getElementById('property-price').textContent;
	const pricePerNight = parseFloat(priceText.match(/\d+(?:\.\d+)?/));

    const nights = (endDate - startDate) / (1000 * 60 * 60 * 24);
    const initialAmount = pricePerNight * nights;
	
	const discountRate = (Math.floor(Math.random() * (30 - 10 + 1)) + 10)/100;
	const finalAmount = initialAmount - (initialAmount * discountRate);

    document.getElementById('final-amount').innerText = 'Final Amount: $' + finalAmount.toFixed(2);
	
	return finalAmount; // Return the finalAmount value
}

function submitBooking() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    const userId = getCookie('user_id');
    const listingId = getCookie('property_id');
	
	const finalAmount = calculateFinalAmount();
	
    const data = {userId, listingId, startDate, endDate, finalAmount};

    fetch('book.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            alert('Booking successful!');
            window.location.href = 'Feed.php'; // Redirect to Feed after successful booking
        } else {
            alert('Booking failed. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error submitting booking:', error);
        alert('Error submitting booking.');
    });
}
