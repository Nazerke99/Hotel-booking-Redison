<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Confirm Booking</title>
  <?php require('inc/links.php') ?>
  <link rel="stylesheet" href="css/common.css">
</head>

<body class="bg-light">
  <?php require('inc/header.php') ?>
  
  <div class="container mt-5">
    <h2 class="fw-bold h-font text-center">Confirm Your Booking</h2>
    <div class="h-line bg-dark"></div>
    
    <div class="row justify-content-center">
      <div class="col-lg-6 mt-5 col-md-8">
        <div class="card border-0 shadow p-4">
          <form action="confirm_booking.php" method="POST">
            <div class="mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control shadow-none" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control shadow-none" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="text" class="form-control shadow-none" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
              <label for="checkin" class="form-label">Check-in Date</label>
              <input type="date" class="form-control shadow-none" id="checkin" name="checkin" required>
            </div>
            <div class="mb-3">
              <label for="checkout" class="form-label">Check-out Date</label>
              <input type="date" class="form-control shadow-none" id="checkout" name="checkout" required>
            </div>
            <div class="mb-3">
              <label for="adults" class="form-label">Number of Adults</label>
              <input type="number" class="form-control shadow-none" id="adults" name="adults" required>
            </div>
            <div class="mb-3">
              <label for="children" class="form-label">Number of Children</label>
              <input type="number" class="form-control shadow-none" id="children" name="children">
            </div>
            <input type="hidden" name="room_id" value="<?php echo $_GET['id']; ?>">
            <button type="submit" name="book_now" class="btn btn-sm text-white custom-bg shadow-none">Book Now</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <?php require('inc/footer.php') ?>
  <?php
    require_once('admin/inc/essen.php'); 
    
    if (isset($_POST['book_now'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $checkin = $_POST['checkin'];
        $checkout = $_POST['checkout'];
        $adults = $_POST['adults'];
        $children = $_POST['children'];
        $room_id = $_POST['room_id'];
    
        $stmt = $con->prepare("INSERT INTO bookings (room_id, name, email, phone, checkin, checkout, adults, children) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssiii", $room_id, $name, $email, $phone, $checkin, $checkout, $adults, $children);
    
        if ($stmt->execute()) {
            echo "<script>alert('Booking successful!'); window.location.href='rooms.php';</script>";
        } else {
            echo "<script>alert('Booking failed. Please try again.');</script>";
        }
    
        $stmt->close();
    }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
