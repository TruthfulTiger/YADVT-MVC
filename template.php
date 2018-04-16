<?php
if(!empty($_SESSION['statusMsg'])){
    echo '<p>'.$_SESSION['statusMsg'].'</p>';
    unset($_SESSION['statusMsg']);
}

use \Main\View\View;
use \Main\Misc\Registry;
use \Main\Menu\MainMenu;
use Main\db;

require_once 'View.php';
require_once 'Registry.php';
require_once 'Menu.php';
require_once 'MainMenu.php';
require_once 'db.php';

$response = Registry::Instance()->Response;

$file = ($response->IndexGetOut('cmd')!= null ? (string)$response->IndexGetOut('cmd').'View.php' : 'DefaultView.php');
$year = (date("Y") > '2018' ? '2018 - '.date("Y") : '2018');

$db = new db();
$view = new View($file);
$menu = new MainMenu();
$menu->setTitle($pagetitle);

?>
<!doctype html>
<html lang="en-gb">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>YADVT | <?=$pagetitle?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.0/pulse/bootstrap.min.css">
    <!-- Ionic icons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/custom.min.css" rel="stylesheet">
</head>

<body>

<header>
    <!-- Fixed navbar -->
    <nav class="yamm navbar navbar-expand-md navbar-dark bg-primary fixed-top">
        <div class="container d-flex flex-column flex-md-row justify-content-between">
            <a class="navbar-brand" href="#">YADVT</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <? $menu->BuildMenu(); ?>
                <form class="form-inline mt-2 mt-md-0" method="post" action="index.php?cmd=Search">
                    <input class="form-control mr-sm-2" type="text" name="searchname" placeholder="Find a dragon" aria-label="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" name = "search" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
</header>
<!-- Begin page content -->
<main role="main" class="container">
        <? $view->Render();?>
</main>

<footer class="footer">
    <div class="container text-center">
        <span class="text-muted">YADVT &copy; Sam Phoenix <?=$year;?>. The name Dragonvale and associated images, descriptions etc. remain the property of <a href="https://support.backflipstudios.com/hc/en-us/categories/202865587-DragonVale">Backflip Studios.</a> </span>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
<script src="js/bootstrap-4-navbar.min.js"></script>
<script src="js/passwordconfirm.min.js"></script>
<script src="js/back_to_top.min.js"></script>
<script>
    $(document).on('click', '.yamm .dropdown-menu', function(e) {
        e.stopPropagation()
    })
</script>
<button onclick="topFunction()" id="toTop" title="Go to top" class="btn btn-primary"><i class="ion-arrow-up-c"></i></button>
</body>
</html>
<? $view->Exit(); ?>