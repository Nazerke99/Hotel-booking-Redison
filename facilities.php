<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Project-Facilities</title>
  <?php require('inc/links.php') ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/common.css">
  <style>
    .pop:hover{
      border-top-color: rgb(73, 46, 152) !important;
      transform:scale(1.03) ;
      transition: all 0.3s;
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
  <?php require('inc/header.php') ?>

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Facilities</h2>
    <div class="h-line bg-dark"></div>
  </div>
  
  <div class="container">
    <div class="row">
      <?php
        $res=selectAll('facilities');
        $path=FAC_IMG_PATH;
        while($row=mysqli_fetch_assoc($res)){
          echo<<<data
            <div class="col-lg-4 col-md-6 mb-5 px-4">
              <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop" >
                <div class="d-flex align-items-center mb-2">
                    <img src="$path$row[icon]" width="40px">
                    <h5 class="m-0 ms-3">$row[name]</h5>
                </div>
                <p>$row[description]</p>
              </div>
            </div>
        data;
        }
      ?>
    </div>
  </div>
  <?php require('inc/footer.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>