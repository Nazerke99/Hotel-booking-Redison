<?php
require ('inc/essen.php');
require ('inc/db_config.php');
adminLogin();
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <?php require ('inc/links.php'); ?>
    <style>
        #dashboard-menu {
            position: fixed;
            height: 100%;
        }

        #main-content {
            margin-top: 60px;
        }
        
    </style>
</head>

<body class="bg-white">
    <?php require ('inc/header.php'); ?>
    <div class="container-fluid" id="#main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Settings</h3>

                <!--GEN SET-->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Settings</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#gen-s">
                                <i class="bi bi-sliders2"></i>Edit
                            </button>

                        </div>
                        <h6 class="card-subtitle mb-2 mb-1 fw-bold">Site Title</h6>
                        <p class="card-text" id="site_title"></p>
                        <h6 class="card-subtitle mb-2 mb-1 fw-bold">About </h6>
                        <p class="card-text" id="site_about"></p>
                    </div>
                </div>

                <!--GEN SET MODAL-->
                <div class="modal fade" id="gen-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="general_s_form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">General Settings</h5>

                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold ">Site-Title</label>
                                        <input type="text" name="site_title" id="site_title_inp"
                                            class="form-control shadow-none">
                                    </div>
                                    <div class="mb-3 ">
                                        <label class="form-label fw-bold">About Us</label>
                                        <textarea name="site_about" id="site_about_inp" class="form-control shadow-none"
                                            rows="6"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button"
                                        onclick="site_title.value=general_data.site_title,site_about.value=general_data.site_about"
                                        class="btn text-secondary sadow-none" data-bs-dismiss="modal">Close</button>
                                    <button type="submit"
                                        class="btn custom-bg text-white shadow-none">Submit</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

                <!--Shutdown section-->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown section</h5>
                            <div class="form-check form-switch">
                                <form>
                                    <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox"
                                        id="shutdown-toggle">

                                </form>

                            </div>



                        </div>

                        <p class="card-text">
                            No customers will be allowed to book hotel room, when shutdown mode os on.
                        </p>
                    </div>
                </div>



            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let general_data;
        let general_s_form=document.getElementById('general_s_form');
        let site_title_inp = document.getElementById('site_title_inp');
        let site_about_inp = document.getElementById('site_about_inp');
        function get_general() {
            let site_title = document.getElementById('site_title');
            let site_about = document.getElementById('site_about');
            let shutdown_toggle = document.getElementById('shutdown-toggle');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings_crud.php", true)
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                general_data = JSON.parse(this.responseText);
                site_title.innerText = general_data.site_title;
                site_about.innerText = general_data.site_about;

                site_title_inp.value = general_data.site_title;
                site_about_inp.value = general_data.site_about;

                if (general_data.shutdown == 0) {
                    shutdown_toggle.checked = false;
                    shutdown_toggle.value = 0;

                }
                else {
                    shutdown_toggle.checked = true;
                    shutdown_toggle.value = 1;
                }
            }

            xhr.send('action=get_general');

        }
        general_s_form.addEventListener('submit',function(e){
            e.preventDefault();
            upd_general(site_title_inp.value,site_about_inp.value);

        })

        function upd_general(site_title_val, site_about_val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                var myModal = document.getElementById('gen-s')
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide(); // Returns a Bootstrap scrollspy instance

                if (this.responseText == 1) {
                    alert('Success! Changes saved', 'success');
                    get_general();
                }
                else {
                    alert('Error! Changes not saved', 'danger');
                }
            }
            xhr.send('upd_general&site_title=' + site_title_val + '&site_about=' + site_about_val + '&upd_general');
        }
        function upd_shutdown(val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (this.responseText == 1 && general_data.shutdown ==0)
                {
                        alert('Shutdown mode is on', 'success');
                } else {
                        alert('Shutdown mode is off', 'success');
                }
                get_general();
               
            }
            xhr.send('upd_shutdown=' + val);



        }
        window.onload = function () {
            get_general();
        }
        

    </script>
</body>

</html>