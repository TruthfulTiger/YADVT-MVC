<?php
namespace Main\Command;

use \Main\Misc\Request;
use \Main\Misc\Response;

require_once 'Request.php';
require_once 'Response.php';

// Basic Command Design Pattern

// Note: By making all the commands inherit from this class
// we can perform a check later when we are trying to make
// sure we have recovered a legal command class.
abstract class Command
{
	public final function __construct()	// Can't override this constructor, no child command constructor will ever take parameters
	{
	}
	
	// Let child class determine how the command is executed.
	public abstract function Execute(Request $request);
}
?>