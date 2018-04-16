<?php
namespace Main\Misc;

use \Main\Misc\Registry;
require_once 'Registry.php';

// Anything the view needs to use should be placed in this
// object.
//
class Response
{		
	private $_output = array();
	
	public function __construct()
	{
		// Do nothing
	}
	
	// Data you want to use in View.
	// Provide unique key.
	public function IndexGetOut($key)
	{
		if(isset($this->_output[$key]))
		{
			return $this->_output[$key];
		}
		return;	// Return undefined
	}
	
	// Set the data you want to View to use.
	public function IndexSetOut($key, $value)
	{
		$this->_output[$key] = $value;
	}
	
	// ApplicationController needs to know which View you want to
	// display, read here and set it below.
	public function GetViewName()
	{
		if(isset($this->_output['view']))		// Use the key 'view' for this value
		{
			return $this->_output['view'];
		}
		
		return false;		// Return false
	}
	
	public function SetViewName($viewName)
	{
		// Store the name of the view to be displayed
		// Here we check a string was provided for the name
		if(is_string($viewName))
		{
			$this->_output['view'] = $viewName;
		}
	}		
}
?>