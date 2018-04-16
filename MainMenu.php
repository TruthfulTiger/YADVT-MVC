<?php

/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 10/04/2018
 * Time: 00:42
 */

namespace Main\Menu;

class MainMenu extends Menu
{
    // Attributes

    // Constructor
    public function __construct() {
        $this->_menu = array('Home' => './',
            'Egg list' => 'index.php?cmd=Dragons',
            'Elements' => '#',
            'Types' => '#',
            'Testing limited dragons' => 'index.php?cmd=Users');
        parent::__construct();
    }

    // Properties

    // Methods

    public function BuildMenu() {
        echo "<ul class='navbar-nav mr-auto'>";
        foreach ($this->_menu as $title => $url) {
            $activeClass = ($this->_title == $title ? 'active' : '');
            $activeSpan = ($this->_title == $title ? '<span class="sr-only">(current)</span>' : '');
            switch ($title) {
                case 'Elements':
                    echo "<li class='nav-item $activeClass dropdown yamm-fw'>";
                    echo "<a class='nav-link dropdown-toggle' href='$url' id='elements' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>$title $activeSpan</a>";
                    $this->elementMenu();
                    break;
                case 'Types':
                    echo "<li class='nav-item $activeClass dropdown'>";
                    echo "<a class='nav-link dropdown-toggle' href='$url' id='types' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>$title $activeSpan</a>";
                    $this->typeMenu();
                    break;
                default:
                    echo "<li class='nav-item $activeClass'>";
                    echo "<a class='nav-link' href='$url'>$title $activeSpan</a>";
                    break;
            }
            echo "</li>";
        }
        echo "</ul>";
    }

    function elementMenu() {
        $element = $this->_db->getRows('element');
        echo '<div class="dropdown-menu yamm-content" aria-labelledby="elements">';
        echo '<div class="row">';
        if ($element) {
            foreach ($element as $e) {
                echo "<div class='col-sm-4'>";
                echo "<a class='dropdown-item' href='index.php?cmd=Dragons&elementname=".$e['ElementName']."&elementid=".$e['ElementID']."'>".$e['ElementName']."</a>";
                echo "</div>";
            }
        } else {
            echo 'No results';
        }
        echo '</div></div></li>';
    }

    function typeMenu() {
        $type = $this->_db->getRows('dragontype');
        echo '<div class="dropdown-menu" aria-labelledby="types">';
        if ($type) {
            foreach ($type as $t) {
                echo "<a class='dropdown-item' href='index.php?cmd=Dragons&typename=".$t['TypeName']."&typeid=".$t['TypeID']."'>".$t['TypeName']."</a>";
            }
        } else {
            echo 'No results';
        }
        echo '</div></li>';
    }

}