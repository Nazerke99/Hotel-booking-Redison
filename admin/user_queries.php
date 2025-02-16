<?php
require ('inc/essen.php');
require ('inc/db_config.php');
adminLogin();

if(isset($_GET['seen'])){
    $frm_data=filteration($_GET);
    if($frm_data['seen']=='all'){
        $q="UPDATE user_queries SET seen=?";
        $values=[1];
        if(update($q,$values,'i')){
            alert('success','Marked all as read');
        }else{
            alert('error','Opearation failed');

        }

    }else{
        $q="UPDATE user_queries SET seen=? WHERE sr_no=?";
        $values=[1,$frm_data['seen']];
        if(update($q,$values,'ii')){
            alert('success','Marked as read');
        }else{
            alert('error','Opearation failed');

        }

    }
}
if(isset($_GET['del'])){
    $frm_data=filteration($_GET);
    if($frm_data['del']=='all'){
        $q="DELETE FROM user_queries";
        if(mysqli_query($con,$q)){
            alert('success','All Data deleted');
        }else{
            alert('error','Opearation failed');

        }

    }else{
        $q="DELETE FROM user_queries WHERE sr_no=?";
        $values=[$frm_data['del']];
        if(delete($q,$values,'i')){
            alert('success','Data deleted');
        }else{
            alert('error','Opearation failed');

        }

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel-User Queries</title>
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

<body class="bg-light">
    <?php require ('inc/header.php'); ?>
    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">USER QUERIES
                </h3>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                            <i class="bi bi-check"></i> Mark all read</a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                            <i class="bi bi-trash3"></i>Delete all</a>
                        </div>
                        <div class="table-responsive-md" style="height:450px;  overflow-y: auto;">
                            <table class="table table-hover border">
                                <thead class="stikcy-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col" width="30%">Message</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = "SELECT*FROM user_queries ORDER BY sr_no DESC";
                                    $data = mysqli_query($con, $q);
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        $seen = '';
                                        if ($row['seen'] != 1) {
                                            $seen = "<a href='?seen={$row['sr_no']}' class='btn-sm rounded-pill btn-primary text-decoration-none'> Mark as read</a>";
                                        }
                                        $delete = "<a href='?del={$row['sr_no']}' class='btn-sm rounded-pill btn-danger text-decoration-none'>Delete</a>";
                                        echo <<<query
                                            <tr>
                                                <td>$i</td>
                                                <td>{$row['name']}</td>
                                                <td>{$row['email']}</td>
                                                <td>{$row['message']}</td>
                                                <td>{$row['date']}</td>
                                                <td>$seen $delete</td>
                                            </tr>
                                        query;
                                        $i++;
                                    }
                                    
                                    ?>
                                </tbody>
                            </table>
                        </div>





                    </div>

                </div>





                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>