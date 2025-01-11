<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="payment-styles.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> <!-- Include SweetAlert -->
</head>
<body>

    <header>
        <h1>Payment</h1>
    </header>

    <div class="container">
        <!-- Left side: User details and total amount -->
        <div class="user-details">
            <h2>Booking Summary</h2>
            <div class="detail-item">
                <strong>Name:</strong> <span id="user-name"></span>
            </div>
            <div class="detail-item">
                <strong>Email:</strong> <span id="user-email"></span>
            </div>
            <div class="detail-item">
                <strong>Phone:</strong> <span id="user-phone"></span>
            </div>
            <div class="detail-item">
                <strong>Country:</strong> <span id="user-country"></span>
            </div>
            <div class="detail-item">
                <strong>Room Type:</strong> <span id="room-type"></span>
            </div>
            <div class="detail-item">
                <strong>Bedding Type:</strong> <span id="bedding-type"></span>
            </div>
            <div class="detail-item">
                <strong>No of Rooms:</strong> <span id="no-of-rooms"></span>
            </div>
            <div class="detail-item">
                <strong>Meal Plan:</strong> <span id="meal-plan"></span>
            </div>
            <div class="detail-item">
                <strong>Check-in Date:</strong> <span id="checkin-date"></span>
            </div>
            <div class="detail-item">
                <strong>Check-out Date:</strong> <span id="checkout-date"></span>
            </div>
            <div class="total-days">
                <strong>Total Days:</strong> <span id="total-days"></span>
            </div>
            <div class="total-amount">
                <strong>Total Amount:</strong> ₹<span id="total-amount"></span>
            </div>
        </div>

        <!-- Right side: QR code for payment and invoice button -->
        <div class="payment-section">
            <h2>Online Payment</h2>
            <p>Scan the code below to complete your payment:</p>
            <img src="Payment-img.jpeg" alt="QR Code for Payment" class="qr-code">
            <p class="scan-instruction">Please ensure the amount is correct before proceeding.</p>
        </div>
    </div>

    <script>
        // Function to get URL parameters
        function getQueryParams() {
            const params = new URLSearchParams(window.location.search);
            return {
                name: params.get('name'),
                email: params.get('email'),
                phone: params.get('phone'),
                country: params.get('country'),
                roomType: params.get('roomType'),
                beddingType: params.get('beddingType'),
                noOfRooms: params.get('noOfRooms'),
                mealPlan: params.get('mealPlan'),
                checkinDate: params.get('checkinDate'),
                checkoutDate: params.get('checkoutDate'),
                pricePerNight: parseFloat(params.get('pricePerNight'))
            };
        }

        // Calculate the total amount based on the number of days of stay
        function calculateTotalAmount(checkin, checkout, pricePerNight) {
            const checkinDate = new Date(checkin);
            const checkoutDate = new Date(checkout);
            const diffTime = Math.abs(checkoutDate - checkinDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // Convert ms to days
            return diffDays * pricePerNight;
        }

        // Populate the booking details on the page
        const userDetails = getQueryParams();
        
        document.getElementById('user-name').textContent = userDetails.name;
        document.getElementById('user-email').textContent = userDetails.email;
        document.getElementById('user-phone').textContent = userDetails.phone;
        document.getElementById('user-country').textContent = userDetails.country;
        document.getElementById('room-type').textContent = userDetails.roomType;
        document.getElementById('bedding-type').textContent = userDetails.beddingType;
        document.getElementById('no-of-rooms').textContent = userDetails.noOfRooms;
        document.getElementById('meal-plan').textContent = userDetails.mealPlan;
        document.getElementById('checkin-date').textContent = userDetails.checkinDate;
        document.getElementById('checkout-date').textContent = userDetails.checkoutDate;

        const totalDays = Math.ceil((new Date(userDetails.checkoutDate) - new Date(userDetails.checkinDate)) / (1000 * 60 * 60 * 24));
        document.getElementById('total-days').textContent = totalDays;

        const totalAmount = calculateTotalAmount(
            userDetails.checkinDate,
            userDetails.checkoutDate,
            userDetails.pricePerNight
        );
        document.getElementById('total-amount').textContent = totalAmount.toFixed(2); // Format to 2 decimal places


         // SweetAlert function to show invoice option after payment
         function showInvoicePopup() {
            swal({
                title: "Payment Successful!",
                text: "Would you like to view and print your invoice?",
                icon: "success",
                buttons: {
                    cancel: "Close",
                    
                }
            }).then((viewInvoice) => {
                if (viewInvoice) {
                    // Redirect to the invoice page with booking ID in URL
                    window.location.href = `admin/invoiceprint.php?id=${userDetails.id}`;
                }
            });
        }

        // Example placeholder function simulating payment completion
        function simulatePaymentCompletion() {
            setTimeout(() => {
                showInvoicePopup();
            }, 5000);
        }

        // Simulate payment completion for demo purposes
        simulatePaymentCompletion();

        
    </script>

</body>
</html>
