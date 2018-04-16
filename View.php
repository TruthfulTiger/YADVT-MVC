<?php
namespace Main\View;

class View
{
	private $_filepath;		// Path to the PHP file to be displayed
	
	public function __construct($filepath)
	{
		$this->_filepath = $filepath;
	}

    /**
     * @return mixed
     */
    public function getFilepath()
    {
        return $this->_filepath;
    }


	
	// Display the view
	public function Render()
	{
		include($this->_filepath);			// Load the HTML page
		//exit();								// Exit page processing now
	}

	public function Exit() {
        exit();
    }
		
}

?>