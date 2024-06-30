<?php
session_start();
require ('admin/inc/essen.php');
require ('admin/inc/db_config.php');
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['uId'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = filteration($_POST);
    $query = "UPDATE `user_cred` SET `name`=?, `email`=?, `dob`=?, `address`=?, `phonenum`=?, `country`=? WHERE `id`=?";
    $values = [$data['name'], $data['email'], $data['dob'], $data['address'], $data['phonenum'], $data['country'], $user_id];

    if (update($query, $values, 'ssssssi')) {
        $update_message = "Profile updated successfully.";
    } else {
        $update_message = "Failed to update profile.";
    }
}

$query_select_user = "SELECT `name`, `email`, `dob`, `address`, `phonenum`, `country` FROM `user_cred` WHERE `id`=?";
$user_info = select($query_select_user, [$user_id], "i");

if ($user_info && mysqli_num_rows($user_info) > 0) {
    $user_data = mysqli_fetch_assoc($user_info);
    $user_name = $user_data['name'];
    $user_email = $user_data['email'];
    $user_dob = $user_data['dob'];
    $user_address = $user_data['address'];
    $user_phone = $user_data['phonenum'];
    $user_country = $user_data['country'];
} else {
    echo "Error: User not found.";
    exit;
}

$query_select_bookings = "
    SELECT b.*, r.name AS room_name 
    FROM `bookings` b
    INNER JOIN `rooms` r ON b.room_id = r.id
    WHERE b.`user_id`=?";
$user_bookings = select($query_select_bookings, [$user_id], "i");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 80px;
        }

        .profile-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info label {
            font-weight: bold;
        }

        .profile-info p {
            margin-top: 5px;
        }

        .booking-history {
            margin-top: 20px;
        }

        .booking-history h3 {
            margin-bottom: 10px;
        }

        .booking-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .booking-item p {
            margin: 5px 0;
        }

        .room-name {
            font-weight: bold;
        }

        .logout-btn {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <h1>User Profile</h1>

        <?php if (isset($update_message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $update_message; ?>
            </div>
        <?php endif; ?>
        <div class="profile-info">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="<?php echo htmlspecialchars($user_name); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo htmlspecialchars($user_email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" class="form-control" id="dob" name="dob"
                        value="<?php echo htmlspecialchars($user_dob); ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address"
                        value="<?php echo htmlspecialchars($user_address); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phonenum">Phone Number:</label>
                    <input type="text" class="form-control" id="phonenum" name="phonenum"
                        value="<?php echo htmlspecialchars($user_phone); ?>" required>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" class="form-control" id="country" name="country"
                        value="<?php echo htmlspecialchars($user_country); ?>" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <div class="logout-btn">
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                </div>
            </form>
        </div>

        <div class="booking-history">
            <h3>Booking History</h3>
            <?php if ($user_bookings && mysqli_num_rows($user_bookings) > 0): ?>
                <?php while ($booking = mysqli_fetch_assoc($user_bookings)): ?>
                    <div class="booking-item">
                        <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?></p>
                        <p><strong>Room Name:</strong> <span
                                class="room-name"><?php echo htmlspecialchars($booking['room_name']); ?></span></p>
                        <p><strong>Check-in Date:</strong> <?php echo htmlspecialchars($booking['checkin']); ?></p>
                        <p><strong>Check-out Date:</strong> <?php echo htmlspecialchars($booking['checkout']); ?></p>
                        <p><strong>Number of Adults:</strong> <?php echo htmlspecialchars($booking['adults']); ?></p>
                        <p><strong>Number of Children:</strong> <?php echo htmlspecialchars($booking['children']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No bookings found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Include Bootstrap JS or any other necessary scripts -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>