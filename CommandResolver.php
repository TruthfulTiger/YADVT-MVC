<?php
namespace Main\Command;

use Main\Misc\Registry;

use \ReflectionClass;
use \Main\Misc\Request;
use \Main\Misc\Response;
use \Main\Command\DefaultCommand;
require_once 'Command.php';
require_once 'Request.php';
require_once 'Response.php';
require_once 'DefaultCommand.php';

// This class uses the "cmd" name/value pair provided in the Request
// and looks up the command class that matches the value provided.
// So the request may contain cmd=HelloWorld and this class will look
// in the file HelloWorldCommand.php for a class HelloWorldCommand which
// must inherit from the Command class.
class CommandResolver
{
	static private $_baseCommandClass;
	static private $_defaultCommand;
	
	public function __construct()
	{
		// We only want these objects once, and we only need
		// to create them the first time we use the CommandResolver
		if(isset(self::$_baseCommandClass) == false)
		{
			// Get the class information so that we can confirm
			// that the class we create dynamically later, is
			// a child of the Command parent class and therefore
			// a valid class.
			self::$_baseCommandClass = new ReflectionClass("\Main\Command\Command");
			
			// We need a default command to return when we get a bad
			// request, this command could display an error.
			self::$_defaultCommand = new DefaultCommand();
		}	
	}
	
	// Given the Request, usually from HTTP Request,
	// read the name/value pair 'cmd'.
	// http://www.mikes.com?cmd=SelectAll
	// Find the file matching the command value and load
	// the class... note we append "Command" to this
	// value i.e. HelloWorld becomes HelloWorldCommand.
	public function GetCommand(Request $request)
	{
		$cmd = $request->IndexGetProperty('cmd');	// Get 'cmd' value from HTTP Request
		
		$sep = DIRECTORY_SEPARATOR;				// Built in PHP Constant = \
		
		// If name/value pair doesn't exist in Request
		// use the default command.
		if(isset($cmd) == false) 
		{
			return clone self::$_defaultCommand;	// Return copy of default command
		}	
		
		// Replace any dots or seperator characters with empty string
		// i.e. remove them. So students\insert.10 becomes studentsinsert10
		$cmd = str_replace(array('.',$sep), "", $cmd);
		
		// Set the file path for the commmand. Assumes the PHP file has the
		// same name as the command
		$filepath = ".\\{$cmd}Command.php";
		
		// Class name including namespace
		$classname = "\\Main\\Command\\{$cmd}Command";
		
		if(file_exists($filepath))
		{
			@require_once $filepath;	// @ = Suppress error report
			
			// Having loaded the class file, check that the
			// class wasn't actually defined in this file
			if(class_exists($classname))
			{
				// Now use reflection to reverse-engineer classes, etc to get
				// information about them. In our case, we will also use reflection
				// to create an object from the class we just loaded.
				
				// Start by created ReflectionClass object that allows us to read
				// information about the class
				$reflectionClass = new ReflectionClass($classname);
				
				// One more security check, make sure this class inherits from the
				// Command class
				if($reflectionClass->isSubclassOf(self::$_baseCommandClass))
				{
					// Instantiate (create) and object using this class
					return $reflectionClass->newInstance();
				}
				else 
				{					
					$response = Registry::Instance()->Response; 
					$response->IndexSetOut('Error', "Command {$cmd}Command is not a command");
					return clone self::$_defaultCommand;	// Return copy of default command			
				}
			}
		}
		
		$response = Registry::Instance()->Response; 
		$response->IndexSetOut('Error', "Command {$cmd}Command not found");
		return clone self::$_defaultCommand;	// Return copy of default command			
	}
}


?>