<?php 
namespace Main\View;

use \Main\Misc\Registry;
use \Main\Misc\Response;


require_once 'Registry.php';
require_once 'Response.php';


$response = Registry::Instance()->Response;

$pagetitle = 'Testing limited dragons';

$month = $response->IndexGetOut('month');
$season = $response->IndexGetOut('season');
$events = $response->IndexGetOut('event');
$time = $response->IndexGetOut('time');
$leap = $response->IndexGetOut('leap');
$qt = $response->IndexGetOut('qt');

include_once "template.php";	?>
<h1 class="blog-header"><?=$pagetitle?></h1>
<div class="container">
    <div class="row">
        <?=$time;?>
        <?=$leap;?>
        <ul>
            <? if ($month) {
                foreach ($month as $m) {
                    echo '<li>'.$m['DragonName'].'</li>';
                }
            } ?>
        </ul>
        <ul>
            <? if ($season) {
                foreach ($season as $d) {
                    echo '<li>'.$d['DragonName'].'</li>';
                }
            } ?>
        </ul>
        <ul>
            <? if ($events) {
                foreach ($events as $e) {
                    echo '<li>'.$e['DragonName'].'</li>';
                }
            }?>
        </ul>
        <ul>
            <? if ($qt) {
                foreach ($qt as $d) {
                    echo '<li>'.$d['DragonName'].'</li>';
                }
            }?>
        </ul>
    </div>
</div>
