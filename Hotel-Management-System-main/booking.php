<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Booking</title>
    <link rel="stylesheet" href="booking-styles.css">
</head>
<body>

    <header>
        <h1>Complete Your Booking</h1>
    </header>
    <script src="availability.js"></script>
    
    <div class="booking-container">
        <!-- Left side with room images -->
        <div class="image-slider">
            <img id="room-img1" class="slider-image" src="" alt="Room Image 1">
            <img id="room-img2" class="slider-image" src="" alt="Room Image 2" style="display: none;">
            <img id="room-img3" class="slider-image" src="" alt="Room Image 3" style="display: none;">
        </div>


        <!-- Right side with booking details -->
        <div class="booking-details">
            <h2>Room: <span id="room-name"></span></h2>
            <p>Price: ₹<span id="room-price"></span>/night</p>
            
            <form id="booking-form" action="your-booking-endpoint.php" method="POST">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="country">Country:</label>
                <input type="text" id="country" name="country" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="room-type">Room Type:</label>
                <select id="room-type" name="room-type" required>
                    <option value="" disabled selected>Select Room Type</option>
                    <option value="Luxury">Luxury</option>
                    <option value="Deluxe">Deluxe</option>
                    <option value="Basic">Basic</option>
                    <option value="Family Suite">Family Suite</option>
                </select>

                <label for="bed-type">Bed Type:</label>
                <select id="bed-type" name="bed" required>
                    <option value="" disabled selected>Select Bed Type</option>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Queen">Queen</option>
                    <option value="King">King</option>
                </select>

                <label for="meal-plan">Meal Plan:</label>
                <select id="meal-plan" name="meal" required>
                    <option value="" disabled selected>Select Meal Plan</option>
                    <option value="Breakfast Only">Breakfast Only</option>
                    <option value="Half Board">Half Board</option>
                    <option value="Full Board">Full Board</option>
                    <option value="All Inclusive">All Inclusive</option>
                </select>

                <label for="no-of-rooms">Number of Rooms:</label>
                <input type="number" id="no-of-rooms" name="noofroom" required>

                <label for="checkin-date">Check-in Date:</label>
                <input type="date" id="checkin-date" name="checkin-date" required>

                <label for="checkout-date">Check-out Date:</label>
                <input type="date" id="checkout-date" name="checkout-date" required>

                <label for="num-days">Number of Days:</label>
                <input type="number" id="num-days" name="num-days" readonly required>

<script>
    // Function to calculate number of days between check-in and check-out
    function calculateDays() {
        const checkinDate = new Date(document.getElementById("checkin-date").value);
        const checkoutDate = new Date(document.getElementById("checkout-date").value);

        if (isNaN(checkinDate.getTime()) || isNaN(checkoutDate.getTime())) {
            // If either date is invalid (not selected), reset the number of days
            document.getElementById("num-days").value = 0;
            return;
        }

        if (checkoutDate >= checkinDate) {
            const timeDiff = checkoutDate - checkinDate;
            const daysDiff = timeDiff / (1000 * 3600 * 24); // Convert milliseconds to days

            document.getElementById("num-days").value = daysDiff; // Set the number of days in the input field
        } else {
            document.getElementById("num-days").value = 0; // Reset the number of days
            alert("Check-out date cannot be earlier than the check-in date."); // Show alert for invalid date range
        }
    }

    // Add event listeners to the date inputs
    document.getElementById("checkin-date").addEventListener("change", calculateDays);
    document.getElementById("checkout-date").addEventListener("change", calculateDays);
</script>




                <label for="booking-status">Booking Status:</label>
                <input type="text" id="booking-status" name="status" value="Pending" readonly>

                <button type="submit" id="confirm-booking-btn">Confirm Booking</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById("confirm-booking-btn").addEventListener("click", function() {
            // Redirect the user to the payment page
            window.location.href = "payment.php";
            
        });
    </script>
    

    <script>
        // Function to get URL parameters
        function getQueryParams() {
            const params = new URLSearchParams(window.location.search);
            return {
                room: params.get('room'),
                price: params.get('price')
            };
        }

        // Dynamically update room details and images
        function updateBookingPage() {
            const { room, price } = getQueryParams();

            // Update room details
            document.getElementById('room-name').textContent = room;
            document.getElementById('room-price').textContent = price;

            // Update images based on room selection
            const images = {
                'Luxury Room 1': ['image/images/luxury1.1.webp', 'image/images/luxury1.2.jpg', 'image/images/luxury1.3.webp'],
                'Luxury Room 2': ['image/images/luxury2.1.webp', 'image/images/luxury2.2.jpg', 'image/images/luxury2.3.webp'],
                'Luxury Room 3': ['image/images/luxury3.1.avif', 'image/images/luxury3.2.jpg', 'image/images/luxury3.3.avif'],
                'Basic Room 1': ['image/images/basic1.1.jpg', 'image/images/basic1.2.jpg', 'image/images/basic1.3.webp'],
                'Basic Room 2': ['image/images/basic2.1.webp', 'image/images/basic2.2.avif', 'image/images/basic2.3.avif'],
                'Basic Room 3': ['image/images/basic3.1.webp', 'image/images/basic3.2.jpg', 'image/images/basic3.3.jpeg'],
                'Deluxe Room 1': ['image/images/delux1.1.avif', 'image/images/delux1.2.avif', 'image/images/delux1.3.avif'],
                'Deluxe Room 2': ['image/images/delux2.1.jpg', 'image/images/delux2.2.jpg', 'image/images/delux2.3.jpg'],
                'Deluxe Room 3': ['image/images/delux3.1.jpg', 'image/images/delux3.2.jpg', 'image/images/delux3.3.jpg'],
                'Family Suite 1': ['image/images/family1.1.jpg', 'image/images/family1.2.jpg', 'image/images/family1.3.jpg'],
                'Family Suite 2': ['image/images/family2.1.jpeg', 'image/images/family2.2.jpg', 'image/images/family2.3.avif'],
                'Family Suite 3': ['image/images/family3.1.jpg', 'image/images/family3.2.jpeg', 'image/images/family3.3.jpg']
            };

            const roomImages = images[room] || [];
            if (roomImages.length > 0) {
                document.getElementById('room-img1').src = roomImages[0];
                document.getElementById('room-img2').src = roomImages[1];
                document.getElementById('room-img3').src = roomImages[2];
            }
        }

        // Image slider functionality
        let currentIndex = 0;
        function slideImages() {
            const images = document.querySelectorAll('.slider-image');
            images.forEach((img, index) => {
                img.style.display = (index === currentIndex) ? 'block' : 'none';
            });
            currentIndex = (currentIndex + 1) % images.length;
        }

        // Change image every 3 seconds
        setInterval(slideImages, 3000);

        // Initialize page with data
        updateBookingPage();
    </script>

</body>
</html>
