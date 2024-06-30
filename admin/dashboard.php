<?php
require ('inc/essen.php');
adminLogin();
session_regenerate_id(true);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <?php require ('inc/links.php'); ?>
    <style>
        #dashboard-menu {
            position: fixed;
            height: 100%;
        }
        #main-content{
            margin-top: 60px;
        }
        .feature-description {
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="bg-white">
    <?php require('inc/header.php');?>


    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="feature-description">
                    <h3>Admin Panel Features</h3>
                    <p>In the admin panel, you can:</p>
                    <ul>
                        <li>Change the website title and description.</li>
                        <li>Enable or disable shutdown mode to prevent user bookings.</li>
                        <li>Add or delete facilities and features available for rooms.</li>
                        <li>View, read, or delete user messages.</li>
                        <li>Manage general settings and configurations.</li>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
