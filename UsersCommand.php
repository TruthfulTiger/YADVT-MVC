<?php
namespace Main\Command;

use Main\Command\Command;
use \Main\Misc\Registry;
use \Main\Misc\Request;
use \Main\Misc\Response;
use \Main\EventCheck;
use Main\db;
use \Main\Events;

require_once 'Command.php';
require_once 'Request.php';
require_once 'Response.php';
require_once 'db.php';
require_once 'EventCheck.php';
require_once 'Events.php';


class UsersCommand extends Command
{
    public function Execute(Request $request)
	{
        $db = new db();
        $eventGet = new Events();
        $response = Registry::Instance()->Response;
        $time = $_SESSION['time'];
        $start = date("Y-m-d", strtotime('2018-11-27'));
        $end = date("Y-m-d", strtotime('2019-01-18'));

        if ($eventGet->isDateInRange($start, $end, $time)) {
            $event = $db->getLtdDragons(28);
        } else {
            $event = new EventCheck();
            $ltd = $event->checkSeason();
            $season = $db->getLtdDragons($ltd);
            $ltd = $event->checkMonth();
            $month = $db->getLtdDragons($ltd);
            $ltd = $event->checkQuarter();
            $quarter = $db->getLtdDragons($ltd);
            $ltd = $event->checkEvent('main');
            $event = $db->getLtdDragons($ltd);
            $leap = $this->isLeap(date("Y", strtotime($time)));
            $response->IndexSetOut('season', $season);
            $response->IndexSetOut('month', $month);
            $response->IndexSetOut('qt', $quarter);
            $response->IndexSetOut('leap', $leap);
        }
        // Get Response object
		$response->SetViewName("UsersView");								// Set view we want to display
		$response->IndexSetOut('cmd', $request->IndexGetProperty('cmd'));	// Pass this view the command value for display
        $response->IndexSetOut('time', date("d-m-Y", strtotime($time)));
        $response->IndexSetOut('event', $event);


        return $response;
	}

    function isLeap($year)
    {

        if ((0 == $year % 4) and (0 != $year % 100) or (0 == $year % 400)) {
            return true;
        } else {
            return false;
        }
    }
}
?>