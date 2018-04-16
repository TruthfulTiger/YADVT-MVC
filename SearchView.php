<?php 
namespace Main\View;

use \Main\Misc\Registry;
use \Main\Menu\MainMenu;

require_once 'Registry.php';
require_once 'Menu.php';
require_once 'MainMenu.php';

$pagetitle = 'Search results';

$response = Registry::Instance()->Response;
$message = $response->IndexGetOut('message');
$dragons = $response->IndexGetOut('dragons');


include_once "template.php";
?>
<h1 class="blog-header"><?=$pagetitle?></h1>
<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <?php
        if(!empty($dragons)){
        foreach ($dragons as $dragon){ ?>
        <div class="col-md-4">
            <h4><?= $dragon['DragonName']; ?></h4>
            <img class="eggImage" src="images/Dragons/<?= $dragon['AdultImage']; ?>"
                 alt="<?= $dragon['DragonName']; ?>">
            <p><a href="index.php?cmd=DragonDetail&dragonname=<?= $dragon['DragonName']; ?>&id=<?= $dragon['DragonID']; ?>"
                  class="btn btn-secondary" role="button">View details &raquo;</a></p>
        </div>
        <?php }
        } else {
    echo $message;
        }?>
    </div>
</div>

<!-- /container -->