<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 13/04/2018
 * Time: 23:05
 */

namespace Main;

use \Main\db;

require_once 'db.php';

class Events
{
    // Attributes
    private $_db;
    private $_event_names;
    // Constructor
    public function __construct() {
        $this->_db = new db();
        }

    // Properties


    // Methods

// $date - A date in any English textual format. If blank
// defaults to the current date
// $hemisphere - "northern", "southern" or "australia"
// Ref: http://biostall.com/get-the-current-season-using-php/
    function get_season($date="", $hemisphere="northern") {

        // Set $date to today if no date specified
        if ($date=="") { $date = date("Y-m-d"); }

        // Specify the season names
        $season_names = array('Winter', 'Spring', 'Summer', 'Autumn');

        // Get year of date specified
        $date_year = date("Y", strtotime($date));

        // Declare season date ranges
        switch (strtolower($hemisphere)) {
            case "northern": {
                if (
                    strtotime($date)<strtotime($date_year.'-03-21') ||
                    strtotime($date)>=strtotime($date_year.'-12-21')
                ) {
                    return $season_names[0]; // Must be in Winter
                }elseif (strtotime($date)>=strtotime($date_year.'-09-23')) {
                    return $season_names[3]; // Must be in Fall
                }elseif (strtotime($date)>=strtotime($date_year.'-06-21')) {
                    return $season_names[2]; // Must be in Summer
                }elseif (strtotime($date)>=strtotime($date_year.'-03-21')) {
                    return $season_names[1]; // Must be in Spring
                }
                break;
            }
            case "southern": {
                if (
                    strtotime($date)<strtotime($date_year.'-03-21') ||
                    strtotime($date)>=strtotime($date_year.'-12-21')
                ) {
                    return $season_names[2]; // Must be in Summer
                }elseif (strtotime($date)>=strtotime($date_year.'-09-23')) {
                    return $season_names[1]; // Must be in Spring
                }elseif (strtotime($date)>=strtotime($date_year.'-06-21')) {
                    return $season_names[0]; // Must be in Winter
                }elseif (strtotime($date)>=strtotime($date_year.'-03-21')) {
                    return $season_names[3]; // Must be in Fall
                }
                break;
            }
            case "australia": {
                if (
                    strtotime($date)<strtotime($date_year.'-03-01') ||
                    strtotime($date)>=strtotime($date_year.'-12-01')
                ) {
                    return $season_names[2]; // Must be in Summer
                }elseif (strtotime($date)>=strtotime($date_year.'-09-01')) {
                    return $season_names[1]; // Must be in Spring
                }elseif (strtotime($date)>=strtotime($date_year.'-06-01')) {
                    return $season_names[0]; // Must be in Winter
                }elseif (strtotime($date)>=strtotime($date_year.'-03-01')) {
                    return $season_names[3]; // Must be in Fall
                }
                break;
            }
            default: { echo "Invalid hemisphere set"; }
        }

    }

    function isDateInRange($startDate, $endDate, $userDate)
    {
        $startT = strtotime($startDate);
        $endT = strtotime($endDate);
        $userT = strtotime($userDate);
        return (($userT >= $startT) && ($userT <= $endT));
        }

    function getEvent($date = "")
    {
        $events = array();
        $this->_event_names = $this->_db->getRows('limitededition');

        if ($date == "") {
            $date = date("Y-m-d");
        }

        $date_year = date("Y", strtotime($date));

        foreach ($this->_event_names as $event) {
            $eventName = $event['EditionName'];
            if (!empty($event['startDate'])) {
                array_push($events, $eventName);
            }
        }

        switch (true) {
            case $this->isDateInRange($date_year.'-01-31', $date_year.'-02-20', $date):
                return $events[0];
            case $this->isDateInRange($date_year.'-03-01', $date_year.'-04-03', $date):
                return $events[1];
            case $this->isDateInRange($date_year.'-10-11', $date_year.'-11-01', $date):
                return $events[2];
            case $this->isDateInRange($date_year.'-12-13', $date_year.'-01-15', $date):
                return $events[3];
            case $this->isDateInRange($date_year.'-02-27', $date_year.'-03-05', $date):
                return $events[4];
            case $this->isDateInRange($date_year.'-11-08', $date_year.'-11-27', $date):
                return $events[5];
            case $this->isDateInRange($date_year.'-07-05', $date_year.'-08-29', $date):
                return $events[6];
            default:
                return null;
        }
    }

    function getQuarter($date = "")
    {
        if ($date == "") {
            $date = date("Y-m-d");
        }

        $date_year = date("Y", strtotime($date));

        // Specify the season names
        $quarter_names = array('Winter', 'Spring', 'Summer', 'Autumn');

        switch (true) {
            case $this->isDateInRange($date_year.'-05-01', $date_year.'-08-01', $date):
                return $quarter_names[2];
            case $this->isDateInRange($date_year.'-08-01', $date_year.'-11-01', $date):
                return $quarter_names[3];
            case $this->isDateInRange($date_year.'-11-01', $date_year.'-03-01', $date):
                return $quarter_names[0];
            case $this->isDateInRange($date_year.'-03-01', $date_year.'-05-01', $date):
                return $quarter_names[1];
            default:
                return null;
        }
    }
}