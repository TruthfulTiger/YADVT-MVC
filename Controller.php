<?php
namespace Main\Control;

use \Main\Misc\Request;
use Main\Misc\Response;
use \Main\Command\CommandResolver;
use \Main\Control\ApplicationController;
use \Main\View\View;
require_once 'CommandResolver.php';
require_once 'Request.php';
require_once 'Response.php';
require_once 'ApplicationController.php';
require_once 'View.php';

// Often referred to as the Front Controller.
// Fairly simple in our case, this class finds the command it wants
// to execute, executes it and then renders the view.
// We could make this a lot more complicated by implementing
// a Chain of Responisibility design pattern for example.
//
class Controller
{
    static private $_instance;		// Singleton pattern, only one object instance of this class required

    private $_commandResolver;		// Convert Request to the associated Command object

    private function __construct()	// Private to prevent object being instantiated outside class
    {
        // Do nothing
    }

    static public function Instance()		// Static so we use classname itself to create object i.e. Controller::Instance()
    {
        // Check if the object has been created
        // Only one object of this class is required
        // so we only create if it hasn't already
        // been created.
        if(!isset(self::$_instance))
        {
            self::$_instance = new self();	// Make new instance of the Controler class
            self::$_instance->_commandResolver = new CommandResolver();

            ApplicationController::LoadViewMap();
        }
        return self::$_instance;
    }

    // Manage the recovery of the command we need to execute,
    // execute it and then render the view.
    public function HandleRequest(Request $request)
    {
        $command = $this->_commandResolver->GetCommand($request);	// Create command object for Request
        $response = $command->Execute($request);					// Execute the command to get response
        $view = ApplicationController::GetView($response);					// Send response to the appropriate view for display
        $view->Render();											// Display the view
    }

}

?>