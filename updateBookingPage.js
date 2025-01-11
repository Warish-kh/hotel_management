function updateBookingPage() {
  const { room, price } = getQueryParams();

  // Update room details
  document.getElementById('room-name').textContent = room;
  document.getElementById('room-price').textContent = price;

  // Update hidden fields
  document.getElementById('hidden-room-name').value = room;
  document.getElementById('hidden-room-price').value = price;

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
