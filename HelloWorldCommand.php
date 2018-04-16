<?php
namespace Main\Command;

use Main\Command\Command;
use \Main\Misc\Registry;
use \Main\Misc\Request;
use \Main\Misc\Response;
require_once 'Command.php';
require_once 'Request.php';
require_once 'Response.php';


class HelloWorldCommand extends Command
{
	public function Execute(Request $request)
	{

		$response = Registry::Instance()->Response;							// Get Response object
		$response->SetViewName("HelloWorldView");								// Set view we want to display (DefaultView.php)
		$response->IndexSetOut('cmd', $request->IndexGetProperty('cmd'));	// Pass this view the command value for display
        $response->IndexSetOut("message", "Hello world, this is me");
		return $response;
	}
}
?>