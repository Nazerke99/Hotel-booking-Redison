
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Project-Contact</title>
  <?php require ('inc/links.php') ?>
  <style>
     .alert{
    position: fixed;
    top: 50px;
    right:25px;
  
  }
  </style>
</head>

<body class="bg-lidgt">
  <?php require ('inc/header.php') ?>

  <div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">Contact</h2>
    <div class="h-line bg-dark"></div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 mb-5 px-4">
        <div class="bg-white rounded shadow p-4">
          <iframe class="w-100 rounded mb-4" height="320px"
            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d9719.847482428837!2d62.18279703254775!3d52.47982607793501!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNTLCsDI4JzQ1LjYiTiA2MsKwMTEnMDguNCJF!5e0!3m2!1sru!2spl!4v1713448928948!5m2!1sru!2spl"
            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <h5>Address</h5>
          <a href="https://maps.app.goo.gl/ughLPemXafRzW6Nt7" target="_blank"
            class="d-inline_block text-decoration-none text-dark mb-2">
            <i class="bi bi-geo-alt-fill"></i> Kazakhstan, Lisakovsk</a>
          <h5 class="mt-4">Telephone</h5>
          <a href="tel: +48 010 000 010" class="d-inline-block mb-2 text-decoration-none text-dark">
            <i class="bi bi-telephone-x-fill"></i> +48 010 000 010
          </a>
          <br>
          <a href="tel: +48 969 000 696" class="d-inline-block text-decoration-none text-dark">
            <i class="bi bi-telephone-x-fill"></i> +48 969 000 696
          </a>
          <h5 class="mt-4">Email</h5>
          <a href="Write: nazerke.0210@icloud.com" class="d-inline-block text-decoration-none text-dark">
            <i class="bi bi-envelope-paper-fill"></i> nazerke.0210@icloud.com</a>
          <h5 class="mt-4">Social Media</h5>
          <a href="#" class="d-inline-block text-dark fs-5 me-2">
            <i class="bi bi-instagram me-1"></i>
          </a>

          <a href="#" class="d-inline-block text-dark fs-5 me-2">
            <i class="bi bi-facebook me-1 "></i>
          </a>

          <a href="#" class="d-inline-block  text-dark fs-5 me-2  ">
            <i class="bi bi-twitter me-1"></i>
          </a>
        </div>


      </div>
      <div class="col-lg-6 col-md-6 mb-5 px-4">
        <div class="bg-white rounded shadow p-4 ">
          <form method="POST">
            <h5>Send us a message</h5>
            <div class="mt-3">
              <label class="form-label" style="font-weight:500">Name</label>
              <input name="name" required type="text" class="form-control shadow-none">
            </div>
            <div class="mt-3">
              <label class="form-label" style="font-weight:500">Email</label>
              <input name="email" required type="email" class="form-control shadow-none">
            </div>
            <div class="mt-3">
              <label class="form-label" style="font-weight:500">Message</label>
              <textarea name="message" required class="form-control shadow-none" rows="5" style="resize:none;"></textarea>
            </div>
            <button type="submit" name="send" class="btn btn-dark text-white custom-bg mt-3">SEND</button>
          </form>

        </div>
      </div>
    </div>
  </div>
  <?php

    if(isset($_POST['send'])){
      $frm_data=filteration($_POST);
      $q= "INSERT INTO `user_queries`(`name`, `email`, `message`) VALUES (?,?,?)";
      $values=[$frm_data['name'],$frm_data['email'],$frm_data['message']];
      $res=insert($q,$values,'sss');
      if($res==1){
        alert('success','Mail send');
      }else{
        alert('error','Try again');
      }
    }
  ?>
    <?php require ('inc/footer.php') ?>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>


</html>