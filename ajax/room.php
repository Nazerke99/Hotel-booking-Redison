<?php
require('../admin/inc/db_config.php');
require('../admin/inc/essen.php');

session_start();

if (isset($_GET['fetch_rooms'])) {

    $chk_avail = json_decode($_GET['chk_avail'], true);
    $quests = json_decode($_GET['quests'], true);
    $facilities_list = json_decode($_GET['facilities_list'], true);

    if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
        $checkin_date = DateTime::createFromFormat('Y-m-d', $chk_avail['checkin']);
        $checkout_date = DateTime::createFromFormat('Y-m-d', $chk_avail['checkout']);
        $today_date = new DateTime();

        if ($checkin_date >= $checkout_date) {
            echo "<h3 class='text-center text-danger'>Invalid Dates Entered!</h3>";
            exit;
        }
        
        if ($checkin_date < $today_date) {
            echo "<h3 class='text-center text-danger'>Check-in date cannot be in the past!</h3>";
            exit;
        }
    }

    $count_rooms = 0;
    $output = "";

    $settings_q = "SELECT * FROM `settings` WHERE `sr_no` = '1'";
    $settings_r = mysqli_fetch_assoc(mysqli_query($con, $settings_q));

    $query = "SELECT * FROM `rooms` WHERE `status` = 1";

    // Filter by number of guests
    if ($quests['adults'] != '' || $quests['children'] != '') {
        if ($quests['adults'] != '') {
            $query .= " AND adult >= " . intval($quests['adults']);
        }
        if ($quests['children'] != '') {
            $query .= " AND children >= " . intval($quests['children']);
        }
    }

    $room_res = mysqli_query($con, $query);

    while ($room_data = mysqli_fetch_assoc($room_res)) {
        if ($chk_avail['checkin'] != '' && $chk_avail['checkout'] != '') {
            $tb_query = "SELECT COUNT(*) AS total_bookings FROM `bookings`
                         WHERE booking_status = ? AND room_id = ?
                         AND checkout > ? AND checkin < ?";
            $values = ['booked', $room_data['id'], $chk_avail['checkin'], $chk_avail['checkout']];

            $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'siss'));

            if (($room_data['quantity'] - $tb_fetch['total_bookings']) == 0) {
                continue;
            }
        }
        
        // Fetch room facilities
        $fac_count = 0;
        $fac_q = select("SELECT f.name, f.id FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id WHERE rfac.room_id = ?", [$room_data['id']], 'i');
        $facilities_data = "";
        
        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
            if (in_array($fac_row['id'], $facilities_list['facilities'])) {
                $fac_count++;
            }
            $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap' style='text-align: center;'>{$fac_row['name']}</span>";
        }

        if (count($facilities_list['facilities']) != $fac_count) {
            continue;
        }

        // Fetch room features
        $fea_q = select("SELECT f.name FROM `features` f INNER JOIN `room_feature` rfea ON f.id = rfea.features_id WHERE rfea.room_id = ?", [$room_data['id']], 'i');
        $features_data = "";

        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
            $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap' style='text-align: center;'>{$fea_row['name']}</span>";
        }

        $room_images = ["16.jpg", "11.jpg", "12.jpg", "13.jpg", "14.jpg", "15.jpg"];
        $image_index = $room_data['id'] % count($room_images);
        $room_image = "images/rooms/" . $room_images[$image_index];

        $book_btn = "";
        if (!$settings_r['shutdown']) {
            $login = isset($_SESSION['login']) && $_SESSION['login'] ? 1 : 0;
            $book_btn = "<button onclick='checkLoginToBook($login, {$room_data['id']})' class='btn btn-sm text-white custom-bg shadow-none'>Book now</button>";
        }

        $output .= "
            <div class='card mb-4 border-0 shadow'>
                <div class='row g-0 p-3 align-items-center'>
                    <div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>
                        <img src='$room_image' class='img-fluid rounded'>
                    </div>
                    <div class='col-md-7 px-lg-3 px-md-3 px-0'>
                        <h5 class='mb-3'>{$room_data['name']}</h5>
                        
                        <div class='features mb-3'>
                            <h6 class='mb-1'>Features of the Room</h6>
                            $features_data
                        </div>
                        
                        <div class='facilities mb-3'>
                            <h6 class='mb-1'>Facilities</h6>
                            $facilities_data
                        </div>
                        
                        <div class='guests'>
                            <h6 class='mb-1'>Guests</h6>
                            <span class='badge rounded-pill bg-light text-dark text-wrap' style='text-align: center;'>
                                {$room_data['adult']} Adults
                            </span>
                            <span class='badge rounded-pill bg-light text-dark text-wrap' style='text-align: center;'>
                                {$room_data['children']} Child
                            </span>
                        </div>
                      
                        <div class='row justify-content-end'>
                            <div class='badge rounded-pill bg-light text-dark text-wrap' style='text-align: center;'>
                                <h6 class='mb-1'>{$room_data['price']} PLN per night</h6>
                                $book_btn
                            </div>
                        </div>
                         
                    </div>
                </div>
            </div>
        ";
        $count_rooms++;
    }

    if ($count_rooms > 0) {
        echo $output;
    } else {
        echo "<h3 class='text-center text-danger'>No rooms to show</h3>";
    }

}
?>
