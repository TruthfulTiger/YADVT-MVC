<?php
namespace Main\Command;

use Main\Command\Command;
use \Main\Misc\Registry;
use \Main\Misc\Request;
use \Main\Misc\Response;
use Main\db;
use \Main\Model\Dragon;

require_once 'Command.php';
require_once 'Request.php';
require_once 'Response.php';
require_once 'Dragon.php';
require_once 'db.php';

class DragonDetailCommand extends Command {

    public function Execute(Request $request)
    {
        $db = new db();

        if (!empty($_GET['id'])) {
            $id = $db->TestInput($_GET['id']);
            $title = $db->TestInput($_GET['dragonname']);
            $dragon = $db->getDragon($id);
        } else {
            $dragon = '';
            $title = 'All dragons';
        }

        $response = Registry::Instance()->Response;							// Get Response object
        $response->SetViewName("DragonDetailView");								// Set view we want to display
        $response->IndexSetOut('cmd', $request->IndexGetProperty('cmd'));	// Pass this view the command value for display
        $response->IndexSetOut('title', $title);
        $response->IndexSetOut('dragon', $dragon);

        return $response;
    }
}
