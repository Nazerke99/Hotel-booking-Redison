<div class="container-fluid " style="background-color: rgb(203, 203, 203);">
  <h3 class="h-font fw-bold text-center lg-4 p-4"><?php echo $settings_r['site_title']?></h3>
  <p class="text-center">
   <?php echo $settings_r['site_about']?>
  </p>

  <div class="text-center lg-4 p-4">
    <a href="#" class="h-font fw-bold"
      style="text-decoration:none; color: black; margin-right: 25px; font-size: 25px;">Home</a>
    <a href="#" class="h-font fw-bold"
      style="text-decoration:none;color: black; margin-right: 25px; font-size: 25px;">Rooms</a>
    <a href="#" class="h-font fw-bold"
      style="text-decoration:none;color: black; margin-right: 25px; font-size: 25px;">Facilities</a>
    <a href="#" class="h-font fw-bold"
      style="text-decoration:none;color: black; margin-right: 25px; font-size: 25px;">Contact</a>
    <a href="#" class="h-font fw-bold" style="text-decoration:none;color: black; font-size: 25px;">About</a>
  </div>
</div>
<h6 class="text-center bg-dark text-white p-4 m-0">Project</h6>
<script>
  let register_form = document.getElementById('register-form');
  register_form.addEventListener('submit', (e) => {
    e.preventDefault();
    let data = new FormData();
    data.append('name', register_form.elements['name'].value);
    data.append('surname', register_form.elements['surname'].value);
    data.append('email', register_form.elements['email'].value);
    data.append('phonenum', register_form.elements['phonenum'].value);
    data.append('address', register_form.elements['address'].value);
    data.append('dob', register_form.elements['dob'].value);
    data.append('country', register_form.elements['country'].value);
    data.append('pass', register_form.elements['pass'].value);
    data.append('cpass', register_form.elements['cpass'].value);
    data.append('register', '');

    var myModal = document.getElementById('RegMod');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/login_register.php", true);
    xhr.onload = function () {

      if (this.responseText == 'pass_mismatch') {
        window.alert('Passsword Mismatch');
      } else if (this.responseText == 'email_already') {
        window.alert('Email is already exist');
      }
       else if (this.responseText == 'phone_already') {
        window.alert('Phone is already exist');
      }else {
        window.alert('success',"registration successful.")
        register_form.reset();
      }
  };
  xhr.send(data);
  })
  let login_form = document.getElementById('login-form');
  login_form.addEventListener('submit', (e) => {
    e.preventDefault();
    let data = new FormData(login_form);

    data.append('email_mob', login_form.elements['email_mob'].value);
    data.append('pass', login_form.elements['pass'].value);
    data.append('login', '');

    var myModal = document.getElementById('LogMod');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/login_register.php", true);
    xhr.onload = function () {
      if (this.responseText == 'inv_email_mob') {
            window.alert('Invalid Email or Phone Number');
      }
      else if (this.responseText== 'not_verified') {
         window.alert('Email is not not_verified ');
      }
      else if (this.responseText == 'inactive') {
          window.alert('Suspended account!');
       }
       else if (this.responseText == 'invalid_pass') {
          window.alert('Incorrrect Pasword!');
       }
       else{
        window.location=window.location.pathname;

       }
    }
      
  xhr.send(data);

  function checkLoginToBook(status,room_id){
    if(status){
      window.location.href='confirm_booking.php?id='+room_id;
    }else{
      window.alert('Please login to book!' );
    }
  }
  
  })
  setActive();
 
</script>