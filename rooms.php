<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Project-Rooms</title>
  <?php require ('inc/links.php') ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/common.css">
</head>

<body class="bg-light">
  <?php require ('inc/header.php') ?>
  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Our Rooms</h2>
    <div class="h-line bg-dark"></div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-lg-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
          <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2">FILTER</h4>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
              data-bs-target="#filterDropdown" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size:18px ">
                  <span>CHECK THE DATES</span>
                  <button id="chk_avail_btn" onclick="chk_avail_clear()"
                    class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                </h5>
                <label class="form-label">Check-in</label>
                <input type="date" class="form-control shadow-none mb-3" id="checkin" onchange="chk_avail_filter()">
                <label class="form-label">Check-out</label>
                <input type="date" class="form-control shadow-none" id="checkout" onchange="chk_avail_filter()">
              </div>
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="mb-3" style="font-size:18px ">Facilities
                <button id="facilities_btn" onclick="facilities_clear()"
                  class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                </h5>
                <?php
                 $facilities_q=selectAll('facilities');
                 while($row=mysqli_fetch_assoc($facilities_q)){
                  echo<<<facilities
                    <div class="mb-2">
                      <input type="checkbox" onclick="facilities_filter()" name="facilities" value="$row[id]" class="form-check-input shadow-none me-1" id="$row[id]">
                      <label class="form-check-label" for="$row[id]">$row[name]</label>
                    </div>
                  facilities;
                 }
                 ?>
              </div>
              <div class="border bg-light p-3 rounded mb-3">
                <h5 class="mb-3" style="font-size:18px ">GUEST
                <button id="quests_btn" onclick="quests_clear()"
                  class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                </h5>
                <div class="d-flex">
                  <div class="me-3">
                    <label class="form-label">Adults</label>
                    <input type="number" min="1" id="adults" oninput="quests_filter()" class="form-control shadow-none">
                  </div>
                  <div>
                    <label class="form-label">Children</label>
                    <input type="number" min="1" id="children" oninput="quests_filter()"
                      class="form-control shadow-none">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>

      <div class="col-lg-9 col-md-12 px-4" id="rooms-data">
      </div>
    </div>
  </div>

  <script>
    function checkLoginToBook(status, room_id) {
      if (status) {
        window.location.href = 'confirm_booking.php?id=' + room_id;
      } else {
        window.alert('Please login to book!');
      }
    }

    let rooms_data = document.getElementById('rooms-data');
    let checkin = document.getElementById('checkin');
    let checkout = document.getElementById('checkout');
    let chk_avail_btn = document.getElementById('chk_avail_btn');
    let adults = document.getElementById('adults');
    let children = document.getElementById('children');
    let quests_btn = document.getElementById('quests_btn');
    let facilities_btn = document.getElementById('facilities_btn');

    function fetch_rooms() {
      let chk_avail = JSON.stringify({
        checkin: checkin.value,
        checkout: checkout.value
      });

      let quests = JSON.stringify({
        adults: adults.value,
        children: children.value
      });

      let facilities_list = { "facilities": [] };
      document.querySelectorAll('[name="facilities"]:checked').forEach((facility) => {
        facilities_list.facilities.push(facility.value);
      });

      if (facilities_list.facilities.length > 0) {
        facilities_btn.classList.remove('d-none');
      } else {
        facilities_btn.classList.add('d-none');
      }

      facilities_list = JSON.stringify(facilities_list);

      let xhr = new XMLHttpRequest();
      xhr.open("GET", "ajax/room.php?fetch_rooms&chk_avail=" + chk_avail + "&quests=" + quests + "&facilities_list=" + facilities_list, true);
      xhr.onprogress = function () {
        rooms_data.innerHTML = `<div class="spinner-border text-info mb-3 mx-auto d-block" id="loader" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>`;
      }
      xhr.onload = function () {
        rooms_data.innerHTML = this.responseText;
      }
      xhr.send();
    }

    function chk_avail_filter() {
      if (checkin.value != '' && checkout.value != '') {
        fetch_rooms();
        chk_avail_btn.classList.remove('d-none');
      }
    }

    function chk_avail_clear() {
      checkin.value = '';
      checkout.value = '';
      chk_avail_btn.classList.add('d-none');
      fetch_rooms();
    }

    function quests_filter() {
      if (adults.value > 0 || children.value > 0) {
        fetch_rooms();
        quests_btn.classList.remove('d-none');
      }
    }

    function quests_clear() {
      adults.value = '';
      children.value = '';
      quests_btn.classList.add('d-none');
      fetch_rooms();
    }

    function facilities_filter() {
      let facilities_checked = document.querySelectorAll('[name="facilities"]:checked').length;
      if (facilities_checked > 0) {
        facilities_btn.classList.remove('d-none');
      } else {
        facilities_btn.classList.add('d-none');
      }
      fetch_rooms();
    }

    function facilities_clear() {
      document.querySelectorAll('[name="facilities"]').forEach((facility) => {
        facility.checked = false;
      });
      facilities_btn.classList.add('d-none');
      fetch_rooms();
    }

    fetch_rooms();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <?php require ('inc/footer.php') ?>
</body>
</html>
