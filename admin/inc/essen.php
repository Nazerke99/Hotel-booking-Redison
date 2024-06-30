<?php
define('SITE_URL', 'http://127.0.0.1/Project');
define('FAC_IMG_PATH', SITE_URL . '/images/fac/');

define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/Project/images');
define('FAC_FOLDER', 'fac/');
define('ROOMS_IMG_PATH', 'rooms/');



function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        header("location:index.php");
        echo "<script>
            window.location.href='index.php';
        </script>";
    }
}

function redirect($url)
{
    echo "
        <script>
        window.location.href='$url';
        </script>";
}
function alert($type, $msg)
{
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
    echo <<<alert
            <div class="alert $bs_class alert-warning alert-dismissible fade show custom" role="alert">
                <strong class="me-3">$msg</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            alert;
}
function uploadSVGImage($image, $folder){
    $valid_mime = ['image/svg+xml'];
    $img_mime = $image['type'];

    if(!in_array($img_mime, $valid_mime)){
        return 'inv_img';
    }
    else if($image['size']/(1024*1024) > 1){
        return 'inv_size';
    }
    else{
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";

        $img_path = UPLOAD_IMAGE_PATH . DIRECTORY_SEPARATOR . $folder . $rname;
        if(move_uploaded_file($image['tmp_name'], $img_path)){
            return $rname;
        }
        else{
            return 'upd_failed';
        }
    }
}
function deleteImage($image, $folder){
    if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
        return true;
    } else {
        return false;
    }
} 

?>