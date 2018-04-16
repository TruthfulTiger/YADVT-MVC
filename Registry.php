<?php
namespace Main\Misc;

use \Main\Props;

require_once 'Props.php';

require_once 'Request.php';
require_once 'Response.php';

// Create a Registry class to store things required across the
// entire application and all the tiers (layers) of the application.
// Effectively, this is equivalent to putting all our global
// variables in one class, although we should try to prevent
// this becoming a dumpling ground for globals.
class Registry extends Props
{
	private static $_instance;		// Singleton pattern, only one object instance of this class required
	
	private $_request;				// Stores Request object (enforced by type hint)
	private $_response;				// Stores Response object (enforect by type hint)
	
	private $_factories = array();	// Store our factories (enforced by type hint)
	
	private function __construct()	// Private to prevent object being instantiated outside class
	{								// i.e. can't do "new" outside this class
		// Do nothing
	}
	
	static public function Instance()		// Static so we use classname itself to create object i.e. Registry::Instance()
	{
		// Check if the object has been created
		// Only one object of this class is required
		// so we only create if it hasn't already 
		// been created.
		if(!isset(self::$_instance))
		{
			self::$_instance = new self();	// Make new instance of the Registry class
			
			// Store the Request and Response objects in the Registry
			// because we only every want one of each
			self::$_instance->_request = new Request();
			self::$_instance->_response = new Response();			
		}
		return self::$_instance;
	}

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @param mixed $request
     * @return Registry
     */
    public function setRequest(Request $request) // Provide type hint so only Request object can be used to set it
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @param mixed $response
     * @return Registry
     */
    public function setResponse(Response $response) // Provide type hint so only Response object can be used to set it
    {
        $this->_response = $response;
        return $this;
    }


	// Read a key/value pair
	public function IndexGetFactory($key)
	{
		if(isset($this->_factories[$key]))
		{
			return $this->_factories[$key];
		}
		return null;	// Return undefined
	}
	
	// Write to a key/value pair
	public function IndexSetFactory($key, $value)
	{
		$this->_factories[$key] = $value;
	}
}
?>