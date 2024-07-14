<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();
session_start();

include("config/config.php");

function encrypt($encrypt)
{
    $encrypted = sha1(md5(base64_encode($encrypt)));
    return $encrypted;
}

if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $password = encrypt($_POST['password']);
    $plain_pass = mysqli_real_escape_string($con, $_POST['password']);

    $sql = "INSERT INTO tbl_user (name, email, phone, password, plain_pass) VALUES ('$name', '$email', '$phone', '$password', '$plain_pass')";

    // Log the query for debugging
    error_log("SQL Query: " . $sql);

    if (mysqli_query($con, $sql)) {
        echo "<div class='alert alert-success'>Registration successful. You can now <a href='index.php'>login</a>.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
        // Log the error for debugging
        error_log("SQL Error: " . mysqli_error($con));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ClearVote - Register</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-10 col-md-7">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><img src="img/logo.png" width="300"><br>Register</h1>
                                    </div>
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="exampleInputName" aria-describedby="nameHelp" placeholder="Enter Name..." name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="exampleInputPhone" placeholder="Phone" name="phone" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" name="register">Register</button>
                                        <br><a href="index.php">Back to Login</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
