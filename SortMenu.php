<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 10/04/2018
 * Time: 22:04
 */

namespace Main\Menu;

require_once 'Menu.php';

class SortMenu extends Menu
{
    protected $_url;
    // Constructor
    public function __construct() {
        parent::__construct();
        $this->_url = $_SERVER['REQUEST_URI'];
        $this->_menu = array('Dragon A-Z' => $this->_url.'&sort=ascdragons',
            'Dragon Z-A' => $this->_url.'&sort=descdragons');

        if (empty($_GET['typename'])) {
            $this->_menu['Type A-Z'] = $this->_url.'&sort=asctype';
            $this->_menu['Type Z-A'] = $this->_url.'&sort=desctype';
            }

        if (empty($_GET['elementname'])) {
            $this->_menu['Element A-Z'] = $this->_url.'&sort=ascelement';
            $this->_menu['Element Z-A'] = $this->_url.'&sort=descelement';
        }
    }

    public function BuildMenu()
    {
        echo '<div class="d-flex text-center align-items-center">';
        echo '<div class="dropdown">';
        echo '<button class="btn btn-default dropdown-toggle" type="button" id="sort" data-toggle="dropdown">Sort by
             <span class="caret"></span></button>';
        echo '<ul class="dropdown-menu" role="menu" aria-labelledby="sort">';
        foreach ($this->_menu as $title => $url) {
            echo '<li role="presentation"><a class="dropdown-item" role="menuitem" href="'.$url.'">'.$title.'</a></li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '</div>';
    }
}