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
class SearchCommand extends Command
{
	public function Execute(Request $request)
	{
        $message = null;
		//echo "Default command executed";
        $db = new db();
        if (isset($_POST['search'])) {
            $search = $_POST['searchname'];
            $db->TestInput($search);
            $dragons = $db->searchDragons($search);
            if (empty($dragons)) {
                $message = 'No results found';
            }
        } else {
            $search = null;
            $dragons = null;
            $message = null;
        }

		$response = Registry::Instance()->Response;							// Get Response object
		$response->SetViewName("SearchView");								// Set view we want to display (DefaultView.php)
		$response->IndexSetOut('cmd', $request->IndexGetProperty('cmd'));	// Pass this view the command value for display
        $response->IndexSetOut('dragons', $dragons);
        $response->IndexSetOut('message', $message);
		return $response;
	}
}
?>