<?php
$session = \Config\Services::session();
?>
<nav class="navbar navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a style="padding-top: 5px;" href="<?= base_url() ?>" class="navbar-brand">
                <p style="margin-bottom:0px;">Simulasi CAT Psikologi<p style="font-size:14px;padding:0px;">Bintang Timur
                        Prestasi</p>
                </p>
            </a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <?php 
        $request = \Config\Services::request();
            if ($request->uri->getSegment(1) !== "tryout") {
                echo "<div class='collapse navbar-collapse pull-left' id='navbar-collapse'>
                        <ul class='nav navbar-nav'>
                            <li class='nav-item'>
                                <a href='".base_url()."/home' class='nav-link'>Home</a>
                            </li>
                            <li class='nav-item'>
                                <a href='".base_url()."/materi' class='nav-link'>Materi</a>
                            </li>
                            <li class='nav-item'>
                                <a href='".base_url()."/pembahasan' class='nav-link'>Pembahasan</a>
                            </li>
                            <li class='nav-item'>
                                <a href='".base_url()."/sikapkerja' class='nav-link'>Sikap Kerja</a>
                            </li>
                            <li class='nav-item'>
                                <a href='".base_url()."/latihan' class='nav-link'>Latihan Soal</a>
                            </li>
                        </ul>
                    </div>";
            } else if ($request->uri->getSegment(2) !== "hasiltryout") {
                echo "<div class='collapse navbar-collapse pull-left' id='navbar-collapse'>
                        <ul class='nav navbar-nav'>
                            <li class='nav-item'>
                                <a href='".base_url()."' class='nav-link'>Materi</a>
                            </li>
                        </ul>
                    </div>";
            }
        ?>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $session->person_nm ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                            <p>
                                <?= $session->person_nm ?> - <?= $session->satuan ?>
                                <small><?= $session->birth_dttm ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= base_url() ?>/profile" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= base_url() ?>/login/logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>