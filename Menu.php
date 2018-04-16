<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 10/04/2018
 * Time: 00:42
 */

namespace Main\Menu;

use Main\db;
require_once 'db.php';


class Menu
{
    // Attributes
    protected $_menu;
    protected $_title;
    protected $_url;
    protected $_db;

    // Constructor
    public function __construct() {
        $this->_db = new db();
    }

    // Properties

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->_title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->_title = $title;
    }


    // Methods
    public function BuildMenu() {

    }

}