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


// If no other command found then execute this
// command by default.
class DefaultCommand extends Command
{
	public function Execute(Request $request)
	{
		//echo "Default command executed";
        $db = new db();
        $dragons = $db->getRows('dragon',array('limit' => 6, 'order_by' => 'dragonID DESC'));
		$response = Registry::Instance()->Response;							// Get Response object
		$response->SetViewName("DefaultView");								// Set view we want to display (DefaultView.php)
		$response->IndexSetOut('cmd', $request->IndexGetProperty('cmd'));	// Pass this view the command value for display
        $response->IndexSetOut('dragons', $dragons);
		return $response;
	}
}
?>