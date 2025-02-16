<?php
require('../inc/db_config.php');
require('../inc/essen.php');
adminLogin();

if (isset($_POST['add_room'])) {
    $features = filteration(json_decode($_POST['features']));
    $facilities = filteration(json_decode($_POST['facilities']));
    $frm_data = filteration($_POST);
    $flag = 0;

    // Correct SQL query and binding parameters
    $q1 = "INSERT INTO `rooms` (`name`, `area`, `price`, `quantity`, `adult`, `children`, `description`) VALUES (?,?,?,?,?,?,?)";
    $values = [$frm_data['name'], $frm_data['area'], $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['description']];
    
    if (insert($q1, $values, 'siiiiis')) {
        $flag = 1;
    } else {
        $flag = 0;
    }

    $room_id = mysqli_insert_id($con);

    // Inserting room facilities
    $q2 = "INSERT INTO `room_facilities` (`room_id`, `facilities_id`) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($con, $q2)) {
        foreach ($facilities as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $flag = 0;
        die('Query cannot be prepared');
    }

    // Inserting room features
    $q3 = "INSERT INTO `room_feature` (`room_id`, `features_id`) VALUES (?, ?)";
    if ($stmt = mysqli_prepare($con, $q3)) {
        foreach ($features as $f) {
            mysqli_stmt_bind_param($stmt, 'ii', $room_id, $f);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $flag = 0;
        die('Query cannot be prepared');
    }

    echo $flag ? 1 : 0;
}
?>
``
