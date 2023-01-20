<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="User Profile">
                    <div class="card-body">
                        <h5 class="card-title"> <?php echo $_SESSION["name"]; ?></h5>
                        <a href="#" class="btn btn-primary">Change Password</a>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <h1>Welcome to your Dashboard</h1>
                <p>You can add additional content here.</p>
            </div>
        </div>
    </div>
</body>
</html>


<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: login.php");
    exit();
}
?>
