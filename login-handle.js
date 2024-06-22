// submit login
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            alert('Login successful!');
            window.location.href = 'Feed.php'; // Redirect to the feed page
        } else {
            alert('Login failed: ' + result.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

// submit register
document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    
    fetch('register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            alert('Registration successful!');
            window.location.href = 'Login.html'; // Redirect to the login page
        } else {
            alert('Registration failed: ' + result.message);
        }
    })
    .catch(error => console.error('Error:', error));
});

// Change forms
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const showRegisterLink = document.getElementById('showRegisterForm');
    const showLoginLink = document.getElementById('showLoginForm');

    showRegisterLink.addEventListener('click', function(event) {
        event.preventDefault();
        loginForm.classList.add('hide');
        registerForm.classList.remove('hide');
        registerForm.classList.add('show');
    });

    showLoginLink.addEventListener('click', function(event) {
        event.preventDefault();
        registerForm.classList.add('hide');
        loginForm.classList.remove('hide');
        loginForm.classList.add('show');
    });
});