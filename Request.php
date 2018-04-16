<?php
namespace Main\Misc;

use \Main\Misc\Registry;
use \Main\Misc\Response;
require_once 'Registry.php';
require_once 'Response.php';

// Build a wrapper class for the PHP $_REQUEST
// which is an associative array that by default contains 
// the contents of $_GET, $_POST and $_COOKIE.
// We use _REQUEST instead of _GET or _POST when we want
// the script to handle either of them the same.
// This also allows us to build our own "Request" to generate
// a new command with it's own data e.g. we receive
// HTTP Request and decide to process it differently, so we create
// a fake HTTP Request with our own data.
// In HTTP the name value pairs look like this
// http://www.mikes.com?cmd=SelectAll&someval=10&sometext=Hello
// In PHP these are placed in an associative array $_REQUEST.
//
class Request
{
	private $_properties;
	
	public function __construct()
	{
		$this->Init();
	}
	
	private function Init()
	{
		// Check servers Request Method environment variable
		// to see which request method was used to access the page
		// i.e. 'GET', 'HEAD', 'POST', 'PUT' but don't assume it will be one of
		// these legal values, always check
		if(  isset($_SERVER['REQUEST_METHOD'])
		&& ($_SERVER['REQUEST_METHOD'] == "POST"
		|| $_SERVER['REQUEST_METHOD'] == "GET")  )
		{
			$this->_properties = $_REQUEST;		// Use array from HTTP Request
		}
		else
		{
			$this->_properties = array();		// Create our own array
		}
	}
	
	// Read value from array using key.
	public function IndexGetProperty($key)
	{
		if(isset($this->_properties[$key]))
		{
			return $this->_properties[$key];
		}
		return;	// Return undefined
	}
	
	public function IndexSetProperty($key, $value)
	{
		$this->_properties[$key] = $value;
	}
	
	public function Copy(Response $response)
	{
		// Copy the request data into the response.
		// You may want to do this to preserve the form
		// field values posted from a page e.g. if an
		// error is found in a form then you may want to
		// redisplay the content the user has already completed.
		foreach($this->_properties as $key => $value)
		{
			$response->IndexSetOut($key, $value);			
		}
	}
	
}
?>