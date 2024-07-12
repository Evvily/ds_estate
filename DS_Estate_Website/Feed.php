<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DS Estate - Property Listings</title>
    
	<!-- The css files needed -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="feed-style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> <!-- For the icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- For hamburger menu (bars) on small screens -->
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <div class="logo">DS Estate</div>
		
        <!-- Hamburger Icon for Mobile -->
        <div class="menu-toggle" onclick="toggleMenu()">
            <i class="fa fa-bars"></i>
        </div>
		
        <ul class="nav-links" id="nav-links">
            <li><a href="Feed.php">Feed</a></li>
            <li><a href="Create_Listing.html">Create Listing</a></li>
			
			<li id="loginButtonForm">
				<div class="button-link">
                    <p><a href="Login.html" id="showloginButtonForm">Login</a></p>
                </div>
			</li>
			
			<li id="logoutButtonForm" style="display: none;">
				<div class="button-link">
                    <p><a href="logout.php" id="showlogoutButtonForm">Logout</a></p>
                </div>
			</li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main>
        <h1 style="text-align: center;">Available Properties</h1>
        <div class="property-list">
			<?php
				include 'database.php';
				try {
					$select_listings = $pdo->prepare("SELECT * FROM `listings` ORDER BY id DESC");
					$select_listings->execute();

					if($select_listings->rowCount() > 0) {
						// This while loop iterates over all rows in the `listings`, fetching one row at a time into the $fetch_listings variable as an associative array, 
						// where the column names are the keys and the column values are the values. The loop will continue until there are no more rows to fetch.
						while ($fetch_listings = $select_listings->fetch(PDO::FETCH_ASSOC)) {
			?>
				<div class="box">
                    <!-- HTML to display the data -->
					<img src="<?= htmlspecialchars($fetch_listings['photo']); ?>" alt="Property Photo"/>
                    <p><span><?= htmlspecialchars($fetch_listings['price']); ?>€</span></p>
					<p><span><?= htmlspecialchars($fetch_listings['rooms']); ?> <i class='bx bx-bed'></i> </span></p>
                    <p><span><?= htmlspecialchars($fetch_listings['title']); ?></span> </p>
					<p><span><?= htmlspecialchars($fetch_listings['region']); ?></span></p>
					<form action="reserve.php" method="POST">
						<input type="hidden" name="property_id" value="<?= htmlspecialchars($fetch_listings['id']); ?>">
						<a><button type="submit" class="reserve-btn">Reserve</button></a>
					</form>
                </div>
			<?php	
						}
					} else {
						echo '<p> No listings found in database </p>';
					}
				} catch(PDOException $e) {
					echo 'Connection failed: ' . $e->getMessage();
				  }

			?>
        </div>
    </main>

    <!-- Footer -->
	<footer>
		<div class="footer-content">
			<div class="footer-column">					   
				<div class="contact-details">
					<p>DS Estate</p>
					<p><a href="tel:+1234567890">+1 234 567 890</a></p>
					<p><a href="mailto:info@dsestate.com">info@dsestate.com</a></p>
					<p>&copy; 2024 DS Estate. All rights reserved.</p>
				</div>
			</div>
			<div class="footer-column">						   
				<div class="map">
					<iframe 
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3146.521770723334!2d23.65040437574289!3d37.94160127194379!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bbe5bb8515a1%3A0x3e0dce8e58812705!2zzqDOsc69zrXPgM65z4PPhM6uzrzOuc6_IM6gzrXOuc-BzrHOuc-Oz4I!5e0!3m2!1sel!2sgr!4v1718471912350!5m2!1sel!2sgr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" 
						width="400" 
						height="300" 
						style="border:0;" 
						allowfullscreen="" 
						loading="lazy">
					</iframe>
				</div>
			</div>	
		</div>
	</footer>

	<!-- The js files needed -->
	<script src="handle.js"></script>

</body>
</html>
