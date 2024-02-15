<?php
if (!logged_in()) {
    redirect('login');
}
$username = $_SESSION['username'];
$userimage = $_SESSION['image'];
$userrole = $_SESSION['role'];
$pagetitle = "Admin panel";
$section = $url[1] ?? 'dashboard';
$action = $url[2] ?? 'view';
$id = $url[3] ?? '0';

$filename = "../app/pages/admin/" . $section . ".php";

if (!file_exists($filename)) {
    $filename = "../app/pages/admin/404.php";
}

if ($userrole === 'admin') {
    if ($section == 'users') {
        require_once  "../app/pages/admin/users-controller.php";
    }
    if ($section == 'categories') {
        require_once  "../app/pages/admin/categories-controller.php";
    }
    if ($section == 'posts') {
        require_once  "../app/pages/admin/posts-controller.php";
    }
} else {
    if ($section == 'posts') {
        require_once  "../app/pages/admin/posts-controller.php";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pagetitle; ?></title>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- font-family: 'Montserrat', sans-serif;
    font-family: 'Roboto', sans-serif;
    font-family: 'Barlow', sans-serif;
    font-family: 'Barlow Condensed', sans-serif;-->

    <!-- fontawesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo ROOT ?>/assets/css/bootstrap.min.css">

    <!-- mycss -->
    <link rel="stylesheet" href="<?php echo ROOT ?>/assets/css/style.css">
</head>
<div class="mastercontainer">
    <div class="header">
        <div class="header-container">

            <div class="logo">
                <a href=""><img src="<?php echo ROOT ?>/images/logo.png" alt="logo">
                    <span>Khulla Samachar</span>
                </a>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-6">
                <div class="header-icons">
                    <i class="fa-solid fa-clock"></i>
                    <div id="clock"></div>
                    <i class="fa-solid fa-calendar"></i>
                    <div id="calendar"></div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-6">
                <ul class="links">
                    <li><a href="#"><i class="fa-brands fa-instagram fa-lg"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                </ul>

            </div>

        </div>
    </div>
</div>

<!--Navigation starts from here,
        These contains:
        The navigation bar-->

<div class="navigation-bar">
    <div class="mastercontainer">
        <div class="row">
            <div class="col-md-5 nav-items">
                <ul class="secondary-nav">
                    <li><a href="<?php echo ROOT ?>/home" class="active hov-eff-txt">Back to Front Page</a></li>

                </ul>
            </div>
            <div class="col-md-3 my-auto">
                <h5 class="txt-col-white">Welcome, <?php echo $_SESSION['username']; ?></h5>
            </div>
            <div class="col-md-4">

                <div class="dropdown">
                    <div class="profile">
                        <!-- <img src="<?php echo ROOT ?>/images/blank-profile.jpg" alt="" > -->
                        <img src="<?= $userimage ?>" id="profile-img" alt="User Profile">
                    </div>

                    <ul class="dropdown-menu" id="dropdown-menu">

                        <li><a href="<?= ROOT ?>/logout">Log Out</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="dashboard">
    <div class="dashboard-container">
        <div class="mastercontainer sec-break-padtb">
            <div class="row">
                <div class="col-lg-3">
                    <ul class="dash-li">
                        <li><a href="<?= ROOT ?>/admin"><i class="fa-solid fa-table-columns"></i>Dashboard</a></li>
                        <?php if ($_SESSION['role'] === 'admin') : ?>
                            <li><a href="<?= ROOT ?>/admin/users"><i class="fa-solid fa-pen fa"></i>User</a></li>
                            <li><a href="<?= ROOT ?>/admin/categories"><i class="fa-solid fa-puzzle-piece"></i>Categories</a></li>
                        <?php endif; ?>
                        <li><a href="<?= ROOT ?>/admin/posts"><i class="fa-regular fa-newspaper"></i>Post</a></li>
                    </ul>
                </div>
                <div class="col-lg-9">

                    <?php
                    require_once $filename;

                    ?>

                </div>
            </div>
        </div>
    </div>


</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="<?php echo ROOT ?>/assets/js/script.js"></script>