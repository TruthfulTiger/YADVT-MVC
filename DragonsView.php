<?php 
namespace Main\View;

use \Main\Misc\Registry;
use \Main\Misc\Response;
use \Main\Menu\SortMenu;


require_once 'Registry.php';
require_once 'Response.php';
require_once 'SortMenu.php';

$response = Registry::Instance()->Response;
$pagetitle = $dragons = $response->IndexGetOut('title');
$dragons = $response->IndexGetOut('dragons');
$sort = new SortMenu();

include_once "template.php";	?>
<h1 class="blog-header"><?=$pagetitle?></h1>
<div class="container">
    <div class="row">
        <p><?$sort->BuildMenu(); ?></p>
    </div>
    <div class="row">
        <? if ($dragons) {
            foreach ($dragons as $r) {
                $available = ($r['isAvailable'] == 1 ? true : false);?>
                <div class="col-md-4">
                    <div class="card">
                        <img class="eggImage" src="images/Dragons/<?php if ($r['EggImage'] !=null ) {echo $r['EggImage']; } else {echo $r['AdultImage'];} ?>" alt="<?=$r['DragonName']; ?>">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?= $r['DragonName']; ?></h5>
                            <p class="card-text">
                                <? if (!empty($r['elements'])) {
                                $elements = explode( ',', $r['elements']); ?>
                            <div class="text-center">
                                <? foreach ($elements as $element) { ?>
                                    <img class="iconSmall" src="images/Icons/<?= $element; ?>" alt="<?= $element; ?>"><? } ?>
                            </div>
                            <? } ?></p>
                            <p class="lead">
                            <a href="index.php?cmd=DragonDetail&dragonname=<?= $r['DragonName']; ?>&id=<?= $r['DragonID']; ?>" class="btn btn-secondary">View details &raquo;</a>
                            <? if ($available) {
                                echo '<span class="float-right badge badge-success">Available</span>';
                            } else {
                                echo '<span class="float-right badge badge-danger">Expired</span>';
                            } ?></p>
                        </div>
                    </div>
                </div>
         <?   }
        } else {
            echo "No results found.";
        } ?>
    </div>
</div>
