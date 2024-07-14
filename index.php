<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();
session_start();

// Include configuration file
if (file_exists("config/config.php")) {
    include("config/config.php");
} else {
    die("Error: config/config.php file not found.");
}

$msg = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($con, $_POST['userName']);
    $password = encrypt($_POST['password']);
    $sql = "SELECT * FROM tbl_user WHERE email = '$username' AND password = '$password'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $_SESSION['username'] = $username;
        header("location: welcome.php");
    } else {
        $msg = "<div class='alert alert-danger'>Invalid Login Credentials.</div>";
    }
}

function encrypt($encrypt)
{
    $encrypted = sha1(md5(base64_encode($encrypt)));
    return $encrypted;
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
    <title>ClearVote - Login</title>
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
                                        <h1 class="h4 text-gray-900 mb-4"><img src="img/logo.png" width="300"><br>Login</h1>
                                    </div>
                                    <?php if ($msg != '') echo $msg; ?>
                                    <form method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address" name="userName" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" name="login">Login</button>
                                        <br><a href="register.php">Register here</a>
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
