<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Renting</title>



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!-- <link rel="stylesheet" href="./css/home.css"> -->
    <link rel="stylesheet" href="styleroom.css">
    <link rel="stylesheet" href="./admin/css/roombook.css">
    <!-- <link rel="stylesheet" href="./admin/css/styles.css"> -->
     <style>
        /* Centering the reservation form panel */
     #guestdetailpanel {
       position: fixed; /* Keeps the form on top of other content */
       top: 50%; /* Centers vertically */
       left: 50%; /* Centers horizontally */
       transform: translate(-50%, -50%); /* Perfect centering */
       z-index: 1000; /* Ensures it's above other content */
       background-color: white; /* Panel background */
       padding: 20px; /* Space around form content */
       border-radius: 10px; /* Rounded corners */
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow effect */
       max-width: 1200px; /* Limits form width */
       width: 90%; /* Makes it responsive */
     }

     /* Optional for body dimming when form is open */
     body.form-open {
       overflow: hidden; /* Prevents scrolling in the background */
       position: relative;
     }

     </style>
    
</head>
<body>
<?php
// Database connection configuration
$servername = "localhost"; // Hostname
$username = "bluebird_user"; // Your database username
$password = "password"; // Your database password
$dbname = "bluebirdhotel"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['guestdetailsubmit'])) {
    // Enable error reporting for debugging
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Retrieve form data
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Country = $_POST['Country'];
    $Phone = $_POST['Phone'];
    $RoomType = $_POST['RoomType'];
    $Bed = $_POST['Bed'];
    $NoofRoom = $_POST['NoofRoom'];
    $Meal = $_POST['Meal'];
    $cin = $_POST['cin'];
    $cout = $_POST['cout'];

    // Check for required fields
    if (empty($Name) || empty($Email) || empty($Country) || empty($Phone) || empty($RoomType) || empty($cin) || empty($cout)) {
        echo "<script>swal({
            title: 'Please fill in all required fields',
            icon: 'error',
        });
        </script>";
    } else {
        $sta = "NotConfirm";
        
        // Calculate the number of days and insert into roombook table
        $sql = "INSERT INTO roombook (Name, Email, Country, Phone, RoomType, Bed, NoofRoom, Meal, cin, cout, stat, nodays) 
                VALUES ('$Name', '$Email', '$Country', '$Phone', '$RoomType', '$Bed', '$NoofRoom', '$Meal', '$cin', '$cout', '$sta', DATEDIFF('$cout', '$cin'))";

        if (mysqli_query($conn, $sql)) {
            // If insertion is successful, redirect to the payment page with user details
            $pricePerNight = 2500; // Set your price per night here or fetch from the database

            $redirectUrl = "payment.php?" . 
                "name=" . urlencode($Name) . "&" . 
                "email=" . urlencode($Email) . "&" . 
                "phone=" . urlencode($Phone) . "&" . 
                "country=" . urlencode($Country) . "&" . 
                "roomType=" . urlencode($RoomType) . "&" . 
                "beddingType=" . urlencode($Bed) . "&" . 
                "noOfRooms=" . urlencode($NoofRoom) . "&" . 
                "mealPlan=" . urlencode($Meal) . "&" . 
                "checkinDate=" . urlencode($cin) . "&" . 
                "checkoutDate=" . urlencode($cout) . "&" . 
                "pricePerNight=" . urlencode($pricePerNight);

                echo "<script>
                swal({
                    title: 'Reservation successful',
                    icon: 'success',
                }).then(() => {
                    swal({
                        title: 'Almost there!',
                        text: 'Complete your booking by paying the amount.',
                        icon: 'info',
                        buttons: {
                            confirm: {
                                text: 'Go to Payment Page',
                                className: 'btn btn-primary'
                            }
                        }
                    }).then(() => {
                        window.location.href = '$redirectUrl'; // Redirect to the payment page
                    });
                });
            </script>";
            
        } else {
            // Error message if insertion fails
            echo "<script>swal({
                title: 'Error occurred while saving reservation',
                icon: 'error',
            });
            </script>";
        }
    }
}

// Close the database connection
$conn->close();
?>

    <header>
        <h1>Available Rooms</h1>
    </header>

    <!-- <script src="availability.js"></script> -->

    
    <!-- Luxury Rooms Section -->
    <!-- <section class="room-category"> -->

    <section class="room-category">
  <h2>Luxury Rooms</h2>
  <div class="room-row">

    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/luxury1.1.webp" alt="Luxury Room 1" class="slider-image">
        <img src="image/images/luxury1.2.jpg" alt="Luxury Room 2" class="slider-image" style="display: none;">
        <img src="image/images/luxury1.3.webp" alt="Luxury Room 3" class="slider-image" style="display: none;">
      </div>
      <h3>Luxury Room 1</h3>
      <p>Price: ₹2500/night</p>
      <button class="openReservationForm btn btn-primary" 
              onclick="openReservationForm('Luxury Room 1', 2500)">Make a Reservation</button>
    </div>

    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/luxury2.1.webp" alt="Luxury Room 2" class="slider-image">
        <img src="image/images/luxury2.2.jpg" alt="Luxury Room 2" class="slider-image" style="display: none;">
        <img src="image/images/luxury2.3.webp" alt="Luxury Room 3" class="slider-image" style="display: none;">
      </div>
      <h3>Luxury Room 2</h3>
      <p>Price: ₹3000/night</p>
      <button class="openReservationForm btn btn-primary" 
              onclick="openReservationForm('Luxury Room 2', 3000)">Make a Reservation</button>
    </div>

    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/luxury3.1.avif" alt="Luxury Room 3" class="slider-image">
        <img src="image/images/luxury3.2.jpg" alt="Luxury Room 2" class="slider-image" style="display: none;">
        <img src="image/images/luxury3.3.avif" alt="Luxury Room 3" class="slider-image" style="display: none;">
      </div>
      <h3>Luxury Room 3</h3>
      <p>Price: ₹3500/night</p>
      <button class="openReservationForm btn btn-primary" 
              onclick="openReservationForm('Luxury Room 3', 3500)">Make a Reservation</button>
    </div>

  </div>
</section>

<script>
  function openReservationForm(roomName, roomPrice) {
    // Get the reservation modal
    const reservationModal = document.getElementById('guestdetailpanel');
    
    // Set the room type and price in the form (you may want to add hidden input fields in your form)
    // document.querySelector('select[name="RoomType"]').value = roomName;
    document.querySelector('input[name="RoomPrice"]').value = roomPrice; // Make sure to add this input in your form

    // Display the modal
    reservationModal.style.display = 'block';
  }
</script>
     
         
                <!-- <button class="book-btn" onclick="goToBookingPage('Luxury Room 1', 2500)">Book Now</button> -->
                <!-- <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button> -->
                <!-- <button id="openReservationForm" class="btn btn-primary">Make a Reservation</button> -->

                <!-- <a href="admin/roombook.php"><button class="btn btn-primary bookbtn" >Book</button></a> -->

    <!-- Basic Rooms Section -->
    <section class="room-category">
  <h2>Basic Rooms</h2>
  <div class="room-row">
    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/basic1.1.jpg" alt="Basic Room 1" class="slider-image">
        <img src="image/images/basic1.2.jpg" alt="Basic Room 2" class="slider-image" style="display: none;">
        <img src="image/images/basic1.3.webp" alt="Basic Room 3" class="slider-image" style="display: none;">
      </div>
      <h3>Basic Room 1</h3>
      <p>Price: ₹1000/night</p>
      <button class="openReservationForm btn btn-primary" onclick="openReservationForm('Basic Room 1', 1000)">Make a Reservation</button>
    </div>

    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/basic2.1.webp" alt="Basic Room 2" class="slider-image">
        <img src="image/images/basic2.2.avif" alt="Basic Room 2" class="slider-image" style="display: none;">
        <img src="image/images/basic2.3.avif" alt="Basic Room 3" class="slider-image" style="display: none;">
      </div>
      <h3>Basic Room 2</h3>
      <p>Price: ₹1200/night</p>
      <button class="openReservationForm btn btn-primary" onclick="openReservationForm('Basic Room 2', 1200)">Make a Reservation</button>
    </div>

    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/basic3.1.webp" alt="Basic Room 3" class="slider-image">
        <img src="image/images/basic3.2.jpg" alt="Basic Room 2" class="slider-image" style="display: none;">
        <img src="image/images/basic3.3.jpeg" alt="Basic Room 3" class="slider-image" style="display: none;">
      </div>
      <h3>Basic Room 3</h3>
      <p>Price: ₹1500/night</p>
      <button class="openReservationForm btn btn-primary" onclick="openReservationForm('Basic Room 3', 1500)">Make a Reservation</button>
    </div>
  </div>
</section>

<section class="room-category">
  <h2>Deluxe Rooms</h2>
  <div class="room-row">
    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/delux1.1.avif" alt="Deluxe Room 1" class="slider-image">
        <img src="image/images/delux1.2.avif" alt="Deluxe Room 2" class="slider-image" style="display: none;">
        <img src="image/images/delux1.3.avif" alt="Deluxe Room 3" class="slider-image" style="display: none;">
      </div>
      <h3>Deluxe Room 1</h3>
      <p>Price: ₹2000/night</p>
      <button class="openReservationForm btn btn-primary" onclick="openReservationForm('Deluxe Room 1', 2000)">Make a Reservation</button>
    </div>

    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/delux2.1.jpg" alt="Deluxe Room 2" class="slider-image">
        <img src="image/images/delux2.2.jpg" alt="Deluxe Room 2" class="slider-image" style="display: none;">
        <img src="image/images/delux2.3.jpg" alt="Deluxe Room 3" class="slider-image" style="display: none;">
      </div>
      <h3>Deluxe Room 2</h3>
      <p>Price: ₹2200/night</p>
      <button class="openReservationForm btn btn-primary" onclick="openReservationForm('Deluxe Room 2', 2200)">Make a Reservation</button>
    </div>

    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/delux3.1.jpg" alt="Deluxe Room 3" class="slider-image">
        <img src="image/images/delux3.2.jpg" alt="Deluxe Room 2" class="slider-image" style="display: none;">
        <img src="image/images/delux3.3.jpg" alt="Deluxe Room 3" class="slider-image" style="display: none;">
      </div>
      <h3>Deluxe Room 3</h3>
      <p>Price: ₹2500/night</p>
      <button class="openReservationForm btn btn-primary" onclick="openReservationForm('Deluxe Room 3', 2500)">Make a Reservation</button>
    </div>
  </div>
</section>

<section class="room-category">
  <h2>Family Suites</h2>
  <div class="room-row">
    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/family1.1.jpg" alt="Family Suite 1" class="slider-image">
        <img src="image/images/family1.2.jpg" alt="Family Suite 2" class="slider-image" style="display: none;">
        <img src="image/images/family1.3.jpg" alt="Family Suite 3" class="slider-image" style="display: none;">
      </div>
      <h3>Family Suite 1</h3>
      <p>Price: ₹4000/night</p>
      <button class="openReservationForm btn btn-primary" onclick="openReservationForm('Family Suite 1', 4000)">Make a Reservation</button>
    </div>

    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/family2.1.jpeg" alt="Family Suite 2" class="slider-image">
        <img src="image/images/family2.2.jpg" alt="Family Suite 2" class="slider-image" style="display: none;">
        <img src="image/images/family2.3.avif" alt="Family Suite 3" class="slider-image" style="display: none;">
      </div>
      <h3>Family Suite 2</h3>
      <p>Price: ₹4500/night</p>
      <button class="openReservationForm btn btn-primary" onclick="openReservationForm('Family Suite 2', 4500)">Make a Reservation</button>
    </div>

    <div class="room-card">
      <div class="image-slider">
        <img src="image/images/family3.1.jpg" alt="Family Suite 3" class="slider-image">
        <img src="image/images/family3.2.jpeg" alt="Family Suite 2" class="slider-image" style="display: none;">
        <img src="image/images/family3.3.jpg" alt="Family Suite 3" class="slider-image" style="display: none;">
      </div>
      <h3>Family Suite 3</h3>
      <p>Price: ₹5000/night</p>
      <button class="openReservationForm btn btn-primary" onclick="openReservationForm('Family Suite 3', 5000)">Make a Reservation</button>
    </div>
  </div>
</section>

    <div id="guestdetailpanel" class="modal">
    <div class="modal-content">
        <form action="" method="POST" class="guestdetailpanelform">
            <div class="head">
                <h3>RESERVATION</h3>
                <i class="fa-solid fa-circle-xmark" onclick="adduserclose()"></i>
            </div>
            <div class="middle">
            <div class="guestinfo">
                    <h4>Guest information</h4>
                    <input type="text" name="Name" placeholder="Enter Full name" required>
                    <input type="email" name="Email" placeholder="Enter Email" required>

                    <?php
                    $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
                    ?>

                    <select name="Country" class="selectinput" required>
						<option value selected >Select your country</option>
                        <?php
							foreach($countries as $key => $value):
							echo '<option value="'.$value.'">'.$value.'</option>';
                            //close your tags!!
							endforeach;
						?>
                    </select>
                    <input type="text" name="Phone" placeholder="Enter Phone no" required>
                    <label for="">Price Per Night</label>
                    <input type="text" name="RoomPrice" value="" required >

                </div>

                <div class="line"></div>

                <div class="reservationinfo">
                    <h4>Reservation information</h4>
                    <select name="RoomType" class="selectinput">
						<option value selected >Type Of Room</option>
                        <option value="Luxury Room">Luxury Room</option>
                        <option value="Basic Room">Basic Room</option>
                        <option value="Delux Room">Delux Room </option>
                        <option value="Family Suits">Family Suits</option>
                    </select>
                    <select name="Bed" class="selectinput">
						<option value selected >Bedding Type</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
						            <option value="Triple">Triple</option>
                        <option value="Quad">Quad</option>
						<option value="None">None</option>
                    </select>
                    <select name="NoofRoom" class="selectinput">
						<option value selected >No of Room</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                    <select name="Meal" class="selectinput">
						<option value selected >Meal</option>
                        <option value="Room only">Room only</option>
                        <option value="Breakfast">Breakfast</option>
						<option value="Half Board">Half Board</option>
						<option value="Full Board">Full Board</option>
					</select>
                    <div class="datesection">
                        <span>
                            <label for="cin"> Check-In</label>
                            <input name="cin" type ="date">
                        </span>
                        <span>
                            <label for="cin"> Check-Out</label>
                            <input name="cout" type ="date">
                        </span>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn btn-success" name="guestdetailsubmit">Submit</button>
            </div>
            </div>
        </form>
    </div>
</div>



</body>
<!-- <script>
    var bookbox = document.getElementById("guestdetailpanel");
    openbookbox = () =>{
      bookbox.style.display = "flex";
    }
    closebox = () =>{
      bookbox.style.display = "none";
    }
</script> -->

<script>
    // Improved code to handle modal opening and closing

// Add event listeners for buttons that open the reservation form
document.querySelectorAll('.openReservationForm').forEach(button => {
  button.addEventListener('click', () => {
    document.getElementById('guestdetailpanel').style.display = 'block';
  });
});

// Select the modal and close button elements
const modal = document.getElementById("guestdetailpanel");
const closeBtn = document.querySelector(".fa-circle-xmark"); // Using querySelector for the class

// Open modal function, called by 'Make a Reservation' buttons
function openModal() {
    modal.style.display = "block";
}

// Close modal function
function closeModal() {
    modal.style.display = "none";
}

// Event listener for the close button
if (closeBtn) { // Ensure closeBtn exists before adding event listener
    closeBtn.addEventListener("click", closeModal);
}

// Event listener for clicks outside the modal to close it
window.onclick = function(event) {
    if (event.target === modal) {
        closeModal();
    }
};

</script>

</html>



