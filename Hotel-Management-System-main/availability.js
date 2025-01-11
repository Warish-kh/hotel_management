function checkAvailability() {
  const checkinDate = document.getElementById('checkin-date').value;
  const checkoutDate = document.getElementById('checkout-date').value;
  const roomCategory = 'Luxury';  // Example room category

  // Check if the dates are filled
  if (!checkinDate || !checkoutDate) {
      alert('Please select both check-in and check-out dates.');
      return;
  }

  // Convert dates to Date objects for comparison
  const checkin = new Date(checkinDate);
  const checkout = new Date(checkoutDate);
  const today = new Date();

  // Validate: Check if check-in date is before today's date
  if (checkin < today) {
      alert('Check-in date cannot be in the past.');
      return;
  }

  // Validate: Check if check-out date is after check-in date
  if (checkout <= checkin) {
      alert('Check-out date must be after check-in date.');
      return;
  }

  // Proceed with availability check
  fetch('/check-availability', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ checkinDate, checkoutDate, roomCategory })
  })
  .then(response => response.json())
  .then(data => {
      const resultDiv = document.getElementById('availability-result');
      if (data.available) {
          resultDiv.innerHTML = `<p style="color: green;">Room is available! You can proceed to payment.</p>`;
          document.querySelector('.book-btn').textContent = 'Proceed to Payment';
          document.querySelector('.book-btn').onclick = () => { window.location.href = '/payment-page'; };  // Redirect to payment
      } else {
          resultDiv.innerHTML = `<p style="color: red;">Sorry, no rooms are available for the selected dates.</p>`;
      }
  })
  .catch(error => {
      console.error('Error checking availability:', error);
  });
}



// function goToBookingPage(roomName, pricePerNight) {
//   // You can add query parameters to pass room details to the booking page
//   const checkinDate = new Date().toISOString().split('T')[0]; // Placeholder check-in date (current date)
//   const checkoutDate = new Date(new Date().setDate(new Date().getDate() + 1)).toISOString().split('T')[0]; // Placeholder checkout date (next day)

//   // Example of passing room name, price, and dates via URL
//   const bookingUrl = `/booking-page.html?room=${encodeURIComponent(roomName)}&price=${pricePerNight}&checkin=${checkinDate}&checkout=${checkoutDate}`;

//   // Redirect the user to the booking page with details
//   window.location.href = bookingUrl;
// }



function goToBookingPage() {
  window.location.href = "roombook.php"; // Redirect to the booking page
}

function goToPaymentPage(){
    window.location.href="payment.php"; //Redirect to payment page 
}