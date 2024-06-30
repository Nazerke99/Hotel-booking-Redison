<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Project-Home page</title>
  <?php require ('inc/links.php') ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/common.css">
  <style>
    .card {
      max-width: 500px;
      margin: auto;
    }

    .card-img-top {
      height: 200px;
      /* Adjust the height as needed */
      object-fit: cover;
    }

    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 500px;

    }

    .d-flex {
      margin-top: auto;
    }

    .availibility-form {
      margin-top: -50px;
      z-index: 2;
      position: relative;
    }

    @media screen and (max-width:575px) {
      .availibility-form {
        margin-top: 0px;
        padding: 0 35px;
      }
    }
  </style>



</head>

<body class="bg-lidgt">
  <?php require ('inc/header.php') ?>

  <!-- Corousel -->
  <div class="container-fluid px-lg-4 mt-4">
    <div class="swiper swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="images/cor/1.jpg" class="w-100 d-block img-fluid" style="height: 500px;" />
        </div>
        <div class="swiper-slide">
          <img src="images/cor/2.jpg" class="w-100 d-block img-fluid" style="height: 500px;" />
        </div>
        <div class="swiper-slide">
          <img src="images/cor/3.jpg" class="w-100 d-block img-fluid" style="height: 500px;" />
        </div>
        <div class="swiper-slide">
          <img src="images/cor/4.jpg" class="w-100 d-block img-fluid" style="height: 500px;" />
        </div>
        <div class="swiper-slide">
          <img src="images/cor/5.jpg" class="w-100 d-block img-fluid" style="height: 500px;" />
        </div>
        <div class="swiper-slide">
          <img src="images/cor/6.jpg" class="w-100 d-block img-fluid" style="height: 500px;" />
        </div>
      </div>
    </div>
  </div>
  <!-- Checkin checkout -->
  
    
  <!-- Rooms -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-sans-bold h-sans-serif">Rooms</h2>
  <div class="container">
    <div class="row">
      <?php
      require_once ('admin/inc/essen.php');

      $room_res = select("SELECT * FROM `rooms` WHERE `status`=?  ORDER BY `id` DESC LIMIT 3 ", [1], 'i');

      while ($room_data = mysqli_fetch_assoc($room_res)) {
        // Get features of the room
        $fea_q = select("SELECT f.name FROM `features` f INNER JOIN `room_feature` rfea ON f.id=rfea.features_id WHERE rfea.room_id=?", [$room_data['id']], 'i');
        $fac_q = select("SELECT f.name FROM `facilities` f INNER JOIN `room_facilities` rfac ON f.id=rfac.facilities_id WHERE rfac.room_id=?", [$room_data['id']], 'i');

        $features_data = "";
        $facilities_data = "";

        while ($fea_row = mysqli_fetch_assoc($fea_q)) {
          $features_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap' style='text-align: center;'>
             {$fea_row['name']}
           </span>";
        }
        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
          $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap' style='text-align: center;'>
             {$fac_row['name']}
           </span>";
        }


        $room_images = [

          "15.jpg",
          "16.jpg",
          "11.jpg",
          "12.jpg",
          "13.jpg",
          "14.jpg"
        ];

        // Select image index based on room ID (for demonstration)
        $image_index = $room_data['id'] % count($room_images);
        $room_image = "images/rooms/" . $room_images[$image_index];

        $book_btn = "";
        if (!$settings_r['shutdown']) {
          $login = 0;
          if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            $login = 1;
          }
          $book_btn = "<button onclick='checkLoginToBook($login, $room_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Book now</button>";
        }

        // Output room card HTML
        echo <<<data
          <div class="col-lg-4 col-md-6 my-3">
              <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                  <img src="$room_image" class="card-img-top" alt="...">
                  <div class="card-body">
                      <h5>$room_data[name]</h5>
                      <h6 class="mb-4">$room_data[price]</h6>
                      <div class="features mb-4">
                          <h6 class="mb-1">Features of the Room</h6>
                          $features_data
                      </div>
                      <div class="facilities mb-4">
                          <h6 class="mb-4">Facilities</h6>
                          $facilities_data
                      </div>
                      <div class="guests mb-4">
                          <h6 class="mb-4">Guests</h6>
                          <span class="badge rounded-pill bg-light text-dark text-wrap" style="text-align: center;">
                              $room_data[adult] Adults
                          </span>
                          <span class="badge rounded-pill bg-light text-dark text-wrap" style="text-align: center;">
                              $room_data[children] Child
                          </span>
                      </div>
                      <div class="d-flex justify-content-evenly mb-2">
                          $book_btn
                      </div>
                  </div>
              </div>
          </div>
        data;
      }
      ?>
      <div class="col-lg-12 text-center mt-5">
        <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow none">More Rooms</a>
      </div>
    </div>
  </div>
  <!-- Facilities -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-sans-bold h-sans-serif">Facilities</h2>
  <div class="container">
    <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
      <?php
      $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY  `id` DESC LIMIT 4  ");
      $path = FAC_IMG_PATH;
      while ($row = mysqli_fetch_assoc($res)) {
        echo <<<data
          <div class="col-lg-2 col-md-2 text-center bf-white rounded shadow py-4 my-3">
            <img src="$path$row[icon]" width="80px">
            <h5 class="mt-3">$row[name]</h5>
          </div>
        data;
      }
      ?>
      <div class="col-lg-12 text-center mt-5">
        <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow none">Facilities</a>
      </div>
    </div>
  </div>
  <!-- Reach -->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-sans-bold h-sans-serif">Reach us</h2>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
        <iframe class="w-100 rounded " height="320px"
          src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d9719.847482428837!2d62.18279703254775!3d52.47982607793501!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNTLCsDI4JzQ1LjYiTiA2MsKwMTEnMDguNCJF!5e0!3m2!1sru!2spl!4v1713448928948!5m2!1sru!2spl"
          loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="bg-white p-4 rounded mb-4">
          <h5>Telephone</h5>
          <a href="tel: +48 010 000 010" class="d-inline-block mb-2 text-decoration-none text-dark">
            <i class="bi bi-telephone-x-fill"></i> +48 010 000 010
          </a>
          <br>
          <a href="tel: +48 969 000 696" class="d-inline-block text-decoration-none text-dark">
            <i class="bi bi-telephone-x-fill"></i> +48 969 000 696
          </a>
        </div>
        <div class="bg-white p-4 rounded mb-4">
          <h5>Social Media</h5>
          <a href="#" class="d-inline-block mb-3">
            <span class="badge bg-lidgt text-dark fs-6 p-2">
              <i class="bi bi-instagram me-1"></i>Instagram</span>
          </a>
          <br>
          <a href="#" class="d-inline-block mb-3">
            <span class="badge bg-lidgt text-dark fs-6 p-2">
              <i class="bi bi-facebook me-1 "></i>Facebook</span>
          </a>
          <br>
          <a href="#" class="d-inline-block ">
            <span class="badge bg-lidgt text-dark fs-6 p-2">
              <i class="bi bi-twitter me-1"></i>Twitter</span>
          </a>


        </div>
      </div>

    </div>
  </div>
  <!-- Footer -->
  <?php require ('inc/footer.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop: true,
      autoplay: {
        delay: 3500,
        disableOnInteraction: false,
      }
    });
    function checkLoginToBook(status, room_id) {
    if (status) {
        window.location.href = 'confirm_booking.php?id=' + room_id;
    } else {
        window.alert('Please login to book!');
    }
    }
  </script>
</body>

</html>