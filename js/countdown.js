		// Set your launch date here (format: Year, Month-1, Day, Hour, Minute)
		// Example: new Date(2024, 7, 15) = August 15, 2024 (months are 0-11)
		const launchDate = new Date(2025, 4, 28);
		
		function updateCountdown() {
			const now = new Date();
			const diff = launchDate - now;
			
			// Calculate time remaining
			const days = Math.floor(diff / (1000 * 60 * 60 * 24));
			const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((diff % (1000 * 60)) / 1000);
			
			// Update the display
			document.querySelector('.days').textContent = days.toString().padStart(2, '0');
			document.querySelector('.hours').textContent = hours.toString().padStart(2, '0');
			document.querySelector('.minutes').textContent = minutes.toString().padStart(2, '0');
			document.querySelector('.seconds').textContent = seconds.toString().padStart(2, '0');
			
			// If countdown finished
			if (diff < 0) {
				clearInterval(countdownTimer);
				document.querySelector('.l1-txt1').textContent = "We're Live!";
				document.querySelector('.m2-txt1').textContent = "Our platform is now available!";
				document.querySelector('.cd100').style.display = 'none';
			}
		}
		
		// Run immediately and then every second
		updateCountdown();
		const countdownTimer = setInterval(updateCountdown, 1000);