<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Project-About</title>
  <?php require ('inc/links.php') ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/common.css">
  <style>
    .box {
      border-top-color: rgb(73, 46, 152) !important;
    }
  </style>

</head>

<body class="bg-lidgt">

  <?php require ('inc/header.php') ?>
  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">About</h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">
      Welcome to our hotel!<br>
      At Redison, we strive to provide our guests with an unforgettable experience, combining comfort, convenience,
      and exceptional service.
    </p>
  </div>
  <div class="container">
    <div class="row justify-content-between align-items-center ">
      <div class="col-lg-7 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
        <h3 class="mb-3">Nazerke Baimenova<h3>
            <p>
            Its cobblestone path winds and twists, 
            a labyrinth of secrets waiting to be discovered.
            </p>
      </div>
      <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1 ">
        <img src="images/about/1.jpg" class="w-100 overflow-hidden rounded">
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row justify-content-between align-items-center ">
      <div class="col-lg-7 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
        <h3 class="mb-3">Alesia Tureiko<h3>
            <p>
            At the entrance, a weathered sign swings gently in the breeze,
             its faded letters hinting at the mysteries within.
            </p>
      </div>
      <div class="col-lg-5 col-md-5 mb-4 order-lg-1 order-md-1 order-2 ">
        <img src="images/about/6.jpg" class="w-100 overflow-hidden rounded">
      </div>
    </div>

  </div>
  <div class="container mt-5">
    <div class="row">
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/hotel.svg" width="70px">
          <h4 class="mt-3">Service</h4>
        </div>

      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/customers.svg" width="70px">
          <h4 class="mt-3">Happy customers</h4>
        </div>

      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/rating.svg" width="70px">
          <h4 class="mt-3">High Ratings</h4>
        </div>

      </div>
      <div class="col-lg-3 col-md-6 mb-4 px-4">
        <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
          <img src="images/about/staff.svg" width="70px">
          <h4 class="mt-3">Support</h4>
        </div>

      </div>
    </div>
  </div>
  <h3 class="my-5 fw-bold h-font text-center">Management Team</h3>
  <div class="container px-4">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper mb-5">
        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
          <img src="images/about/3.jpg" class="w-100">
          <h5 class="mt-2">Rustem Andassov</h5>
        </div>
        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
          <img src="images/about/4.jpg" class="w-100">
          <h5 class="mt-2">Alibek Aldongarov</h5>
        </div>
        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
          <img src="images/about/5.jpg" class="w-100">
          <h5 class="mt-2">Bekbolat Aldiyarov</h5>
        </div>
        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
          <img src="images/about/3.jpg" class="w-100">
          <h5 class="mt-2">Rustem Andassov</h5>
        </div>
        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
          <img src="images/about/4.jpg" class="w-100">
          <h5 class="mt-2">Alibek Aldongarov</h5>
        </div>
        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
          <img src="images/about/5.jpg" class="w-100">
          <h5 class="mt-2">Bekbolat Aldiyarov</h5>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>

  </div>


  <?php require ('inc/footer.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 3,
      spaceBetween:40,
      pagination: {
        el: ".swiper-pagination",
      },
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>