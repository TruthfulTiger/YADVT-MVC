<?php
session_start();
/*
 * For a proper RESTful webservice, all URL's should be routed to this
 * page.
 * http://www.mywebsite.com/Command/argument1/argument2 should be routed
 * to this page, then Command, argument1 and argument2 can be recovered
 * and fed to the front controller.
 * This would require adding URL Routing to Apache, which we shall avoid.
 * 
 * In our case, we aren't building a proper RESTful web server, and we
 * assume a 'cmd' attribute is provided with the HTTP Request
 * http://www.mywebsite.com?cmd=Command
 */
use \Main\Misc\Registry;
use \Main\Control\Controller;
use \Main\Misc\Request;
use Main\db;
use \Main\EventCheck;
use \Main\Events;

require_once 'Registry.php';
require_once 'Request.php';
require_once 'Controller.php';
require_once 'db.php';
require_once 'EventCheck.php';
require_once 'Events.php';

date_default_timezone_set('America/Denver'); // Set to timezone matching DV game servers

$time = date("Y-m-d");
$_SESSION['time'] = $time;

$isleap = isLeap(date("Y", strtotime($time)));

$db = new db();

$eventGet = new Events();
$event = new EventCheck();

$db->setAllLtdDragons(0);

$start = date("Y-m-d", strtotime('2018-11-27'));
$end = date("Y-m-d", strtotime('2019-01-18'));
 if ($eventGet->isDateInRange($start, $end, $time)) {
     $db->setAllLtdDragons(1);
} else {
    if ($isleap) {
        $leap = $event->checkEvent('special');
        $db->setLtdDragons($leap);
    }
    $season = $event->checkSeason();
    $db->setLtdDragons($season);
     $month = $event->checkMonth();
     $db->setLtdDragons($month);
     $quarter = $event->checkQuarter();
     $db->setLtdDragons($quarter);
    $event = $event->checkEvent('main');
    $db->setLtdDragons($event);
}

function isLeap($year) {

    if( (0 == $year % 4) and (0 != $year % 100) or (0 == $year % 400) )
    {
        return true;
    }
    else
    {
        return false;
    }
}

// Get instance of front controller (using Singleton pattern)
$controller = Controller::Instance();

// Get the Request object and feed it to the front controller
$request = Registry::Instance()->Request;
$controller->HandleRequest($request);
?>