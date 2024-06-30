<?php
 require('admin/inc/essen.php');
 session_start();
 session_destroy();
 redirect('index.php');
?>