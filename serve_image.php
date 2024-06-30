<?php
require_once('admin/inc/essen.php');

if (isset($_GET['sr_no'])) {
    $id = intval($_GET['sr_no']);
    $query = "SELECT image, mime_type FROM room_images WHERE sr_no = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $sr_no);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($image, $mime_type);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        header("Content-Type: $mime_type");
        echo $image;
    } else {
        header("HTTP/1.1 404 Not Found");
    }
    $stmt->close();
} else {
    header("HTTP/1.1 400 Bad Request");
}
?>
