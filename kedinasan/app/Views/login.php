<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bintang Timur Prestasi</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image: url("./images/bg/bg-body.jpg");
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}

.container {
    display: flex;
    width: 100%;
    /* height: 100%; */
    /* max-width: 1200px; */
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.image-column {
    flex: 3;
    overflow: hidden;
}

.image-column img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-column {
    flex: 2;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

h2 {
    margin-bottom: 20px;
    text-align: center;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }

    .image-column {
        flex: 1;
    }

    .form-column {
        flex: 1;
        padding: 20px;
    }
}

    </style>

<body>

<div class="container">
        <div class="image-column">
            <img class="image" src="<?php base_url() ?>images/bg/btp5.png" alt="Login">
        </div>
        <div class="form-column">
            <form action="<?= base_url() ?>/login/checklogin" method="post">
                <h2> <a href="<?= base_url() ?>"><b>Selamat Datang</a></h2>
                <label for="username">Username</label>
                <input type="text" id="username" class="form-control" name="username" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" name="password" required>
                
                <button type="submit">Login</button>
                <button type="button" onclick="location.href='login/register'">Register</button>
            </form>
        </div>
    </div>
    <!-- <div class="login-box">
        <div class="login-logo">
            <a href="<?= base_url() ?>"><b>Selamat Datang</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Siswa Bintang Timur Prestasi</p>
            <form action="<?= base_url() ?>/login/checklogin" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="username" name="username">
                    <span class="glyphicon glyphicon-user  form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        <a href="login/register"><button style="margin-top:10px;" type="button" class="btn btn-secondary btn-block">Register</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div> -->
    <script src="<?= base_url() ?>/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/plugins/iCheck/icheck.min.js"></script>
    <script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
    </script>
</body>
</html>

