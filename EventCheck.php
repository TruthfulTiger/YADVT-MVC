<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 14/04/2018
 * Time: 03:41
 */

namespace Main;

class EventCheck
{
    private $_now;
    private $_event;
    private $_month;
    private $_season;
    private $_event_names;

    public function __construct() {
        $this->_event = new Events();
        $this->_now = $_SESSION['time'];
        $this->_month = date("n", strtotime($this->_now));
    }

    public function checkSeason() {
        $this->_season = $this->_event->get_season(date("Y-m-d", strtotime($this->_now)));

        switch ($this->_season) {
            case 'Spring':
                return $ltd = 1;
            case 'Summer':
                return $ltd = 2;
            case 'Autumn':
                return $ltd = 3;
            case 'Winter':
                return $ltd = 4;
            default:
                return null;
        }
    }

    public function checkMonth() {

        switch ($this->_month)  {
            case 1:
                return $ltd = 5; // Jan
            case 2:
                return $ltd = 6; // Feb
            case 3:
                return $ltd = 7; // Mar
            case 4:
                return $ltd = 8; // Apr
            case 5:
                return $ltd = 9; // May
            case 6:
                return $ltd = 10; // Jun
            case 7:
                return $ltd = 11; // Jul
            case 8:
                return $ltd = 12; // Aug
            case 9:
                return $ltd = 13; // Sep
            case 10:
                return $ltd = 14; // Oct
            case 11:
                return $ltd = 15; // Nov
            case 12:
                return $ltd = 16; // Dec
            default:
                return null;
        }
    }

    public function checkEvent($event)
    {
        $this->_event_names = $this->_event->getEvent(date("Y-m-d", strtotime($this->_now)));

        switch ($event) {
            case "main":
                switch ($this->_event_names) {
                    case "Gathering of Roses":
                        return $ltd = 21;
                    case "Egg Hunt":
                        return $ltd = 22;
                    case "Tails From The Campfire":
                        return $ltd = 23;
                    case "Jolly Jubilee":
                        return $ltd = 24;
                    case "Om of Noms":
                        return $ltd = 26;
                    case "Roar of the Rift":
                        return $ltd = 27;
                    default:
                        return null;
                }
            case 'special':
                switch ($this->_event_names) {
                    case "LeapYear":
                        return $ltd = 25;
                    default:
                        return null;
                }
        }
    }

    function checkQuarter () {
        $this->_event_names = $this->_event->getQuarter(date("Y-m-d", strtotime($this->_now)));

        switch ($this->_event_names) {
            case "Summer":
                return $ltd = 17;
            case "Autumn":
                return $ltd = 18;
            case "Winter":
                return $ltd = 19;
            case "Spring":
                return $ltd = 20;
            default:
                return null;
        }
    }
}

