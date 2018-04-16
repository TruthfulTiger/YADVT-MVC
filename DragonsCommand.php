<?php
namespace Main\Command;

use Main\Command\Command;
use \Main\Misc\Registry;
use \Main\Misc\Request;
use \Main\Misc\Response;
use Main\db;

require_once 'Command.php';
require_once 'Request.php';
require_once 'Response.php';
require_once 'db.php';

class DragonsCommand extends Command {

    public function Execute(Request $request)
    {
        $db = new db();

        if (!empty($_GET['elementid'])) {
            $db->TestInput($_GET['elementid']);
            $title = $db->TestInput($_GET['elementname']);
            $title = $title.' dragons';
        } elseif (!empty($_GET['typeid'])) {
            $db->TestInput($_GET['typeid']);
            $title = $db->TestInput($_GET['typename']);
            $title = $title.' dragons';
        } else {
            $title = 'Egg list';
        }

        $dragons = $db->getDragons(999);
        $response = Registry::Instance()->Response;							// Get Response object
        $response->SetViewName("DragonsView");								// Set view we want to display
        $response->IndexSetOut('cmd', $request->IndexGetProperty('cmd'));	// Pass this view the command value for display
        $response->IndexSetOut('title', $title);
        $response->IndexSetOut('dragons', $dragons);

        return $response;
    }
}
