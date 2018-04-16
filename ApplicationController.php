<?php
namespace Main\Control;

use \Main\Misc\Request;
use \Main\Misc\Response;
use \Main\View\View;
require_once 'Request.php';
require_once 'Response.php';
require_once 'View.php';

class ApplicationController
{
	static private $_viewMap;
	
	// Load the mapping between the view names and the view files.
	// A more sophisticated version could use an XML file to
	// load the mapping and create a multi-dimensional array to
	// allow other data (e.g. status OK/error) to be used from
	// the Response object to change the view returned.
	static public function LoadViewMap()
	{
		//self::$_viewMap['HelloWorldView'] = new View(".\HelloWorldView.php");
		self::$_viewMap = array(
				'DefaultView' => new View(".\DefaultView.php"),
				'SearchView' => new View(".\SearchView.php"),
				'DragonsView' => new View(".\DragonsView.php"),
				'DragonDetailView' => new View(".\DragonDetailView.php"),
				'UsersView' => new View(".\UsersView.php")
		);
	}

	// Check the Response object to work out the view to display.
	// Currently very simple, could extract other data from the
	// response object to pick view from array.
	static public function GetView(Response $response)
	{
		return self::$_viewMap[$response->GetViewName()];
	}
	
}
?>