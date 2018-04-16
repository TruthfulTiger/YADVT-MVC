<?php 
namespace Main\View;

use \Main\Misc\Registry;
use \Main\Menu\MainMenu;

require_once 'Registry.php';
require_once 'Menu.php';
require_once 'MainMenu.php';

$pagetitle = 'Home';

$response = Registry::Instance()->Response;

$dragons = $response->IndexGetOut('dragons');
if(!empty($dragons)){


include_once "template.php";
?>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h1 class="display-3">Yet Another Dragonvale Tracker?</h1>
        <p>I know, there are plenty of dragon databases and egg trackers out there already - so why should you use this
            one?</p>
        <p>Well, there are one or two nifty features that I have yet to see anywhere else...</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
    </div>
</div>
<div class="container">
    <h2>Newly added</h2>
    <p>These dragons have recently been added to the collection:</p>
    <!-- Example row of columns -->
    <div class="row">
        <?php foreach ($dragons as $dragon){ ?>
        <div class="col-md-4">
            <h4><?= $dragon['DragonName']; ?></h4>
            <img class="eggImage" src="images/Dragons/<?= $dragon['AdultImage']; ?>"
                 alt="<?= $dragon['DragonName']; ?>">
            <p><a href="index.php?cmd=DragonDetail&dragonname=<?= $dragon['DragonName']; ?>&id=<?= $dragon['DragonID']; ?>"
                  class="btn btn-secondary" role="button">View details &raquo;</a></p>
        </div>
        <?php }
        } ?>
    </div>

    <hr>

</div> <!-- /container -->