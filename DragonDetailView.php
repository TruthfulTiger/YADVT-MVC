<?php 
namespace Main\View;

use \Main\Misc\Registry;
use \Main\Misc\Response;
use Main\Model\Dragon;


require_once 'Registry.php';
require_once 'Response.php';

$response = Registry::Instance()->Response;
$title = $dragon = $response->IndexGetOut('title');
$dragon = $response->IndexGetOut('dragon');

$pagetitle = $title;

include_once "template.php";
if (!empty($dragon['EggImage'])) { ?>
    <img class="details float-right" src="images/Dragons/<?= $dragon['EggImage'];?>" alt="<?= $dragon['DragonName'].' egg'; ?>">
<? }
if ($dragon['TypeID'] == 4 or $dragon['TypeID'] == 5) {
    $breedtime = 'N/A';
    $breedtimeup = 'N/A';
} elseif ($dragon['TypeID'] == 6) {
    $breedtime = 'Instant';
    $breedtimeup = 'Instant';
} else {
    $breedtime = $dragon['BreedTimeReg'];
    $breedtimeup = $dragon['BreedTimeUpgrade'];
}
?>

<h1 class="blog-header"><?=$pagetitle?></h1>
<p class="lead"><?= $dragon['Description']; ?></p>
<div class="container">
    <?php if ($dragon['TypeID'] == 4 or $dragon['TypeID'] == 5) {
        $maxlevel = 'N/A'; ?>
        <div class="d-flex text-center align-items-center">
            <img class="adult" src="images/Dragons/<?= $dragon['AdultImage'];?>" alt="<?= $dragon['DragonName'].' adult'; ?>">
        </div>
    <?php    } else if ($dragon['ElderImage'] != null) {
    $maxlevel = 'N/A'; ?>
    <div class="row">
        <div class="col-md-3">
            <img class="details" src="images/Dragons/<?= $dragon['BabyImage'];?>" alt="<?= $dragon['DragonName'].' baby'; ?>">
        </div>
        <div class="col-md-3">
            <img class="details" src="images/Dragons/<?= $dragon['TeenImage'];?>" alt="<?= $dragon['DragonName'].' juvenile'; ?>">
        </div>
        <div class="col-md-3">
            <img class="details" src="images/Dragons/<?= $dragon['AdultImage'];?>" alt="<?= $dragon['DragonName'].' adult'; ?>">
        </div>
        <div class="col-md-3">
            <img class="details" src="images/Dragons/<?= $dragon['ElderImage'];?>" alt="<?= $dragon['DragonName'].' elder'; ?>">
        </div>
    </div>

        <?php
    } else {
        $maxlevel = $dragon['MaxLevel'];
        ?>
        <div class="row">
            <div class="col-md-4">
                <img class="details" src="images/Dragons/<?= $dragon['BabyImage'];?>" alt="<?= $dragon['DragonName'].' baby'; ?>">
            </div>
            <div class="col-md-4">
                <img class="details" src="images/Dragons/<?= $dragon['TeenImage'];?>" alt="<?= $dragon['DragonName'].' juvenile'; ?>">
            </div>
            <div class="col-md-4">
                <img class="details" src="images/Dragons/<?= $dragon['AdultImage'];?>" alt="<?= $dragon['DragonName'].' adult'; ?>">
            </div>
        </div>
    <?php     }        ?>
    <table class="table table-sm table-responsive-md">
        <thead>
        <caption class="sr-only">More information on <?= $dragon['DragonName']; ?></caption>
        </thead>
        <tbody>
        <tr>
            <th scope="row">Available at park level</th>
            <td><?= $dragon['UnlockLevel'];?></td>
        </tr>
        <tr>
            <th scope="row">Max dragon level</th>
            <td><?= $maxlevel;?></td>
        </tr>
        <tr>
            <th scope="row">Type</th>
            <td><?php if ($dragon['TypeIcon'] !=null) {?> <img class="iconSmall" src="images/Icons/<?= $dragon['TypeIcon'];?>" alt="<?= $dragon['TypeName']; ?>"> <?php } else {echo $dragon['TypeName'];} ?></td>
        </tr>
        <tr>
            <th scope="row">Regular breeding time</th>
            <td><?= $breedtime; ?></td>
        </tr>
        <tr>
            <th scope="row">Upgraded breeding time</th>
            <td><?= $breedtimeup; ?></td>
        </tr>
        <tr>
            <th scope="row">Incubation time</th>
            <td><?= $breedtime; ?></td>
        </tr>
        <?php if(!empty($dragon['elements'])) { ?>
            <tr>
                <th scope="row">Elements</th>
                <td>
                    <?     $elements = explode( ',', $dragon['elements']); ?>
                        <? foreach ($elements as $element) { ?>
                            <img class="iconSmall" src="images/Icons/<?= $element; ?>" alt="<?= $element; ?>"><? } ?>
                </td>
            </tr>
        <?php }?>
        <?php if($dragon['Notes'] !=null ) { ?>
            <tr>
                <th scope="row">Notes</th>
                <td><?= $dragon['Notes'];?></td>
            </tr>
        <?php }
        ?>

        </tbody>
    </table>
</div>