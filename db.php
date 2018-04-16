<?php
/*
 * DB Class
 * This class is used for database related (connect, insert, update, and delete) operations
 * with PHP Data Objects (PDO)
 * @author    CodexWorld.com
 * @url       http://www.codexworld.com
 * @license   http://www.codexworld.com/license
 */

namespace Main;
use \PDO;
use Main\Events;

require_once 'Events.php';

class db
{
    private $dbHost     = "localhost:3307";
    private $dbUsername = "dragons";
    private $dbPassword = "0HulBWOBZcVTdTG5";
    private $dbName     = "tharbedragons";
    private $_sort;
    private $_sortitem;
    private $_paging;
    private $db;

    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            try{
                $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $conn;
            }catch(PDOException $e){
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
    }

    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function getRows($table,$conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$table;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by'];
        }

        if(array_key_exists("join",$conditions)){
            $sql .= ' JOIN ';
            $i = 0;
            foreach($conditions['join'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit'];
        }

        $query = $this->db->prepare($sql);
        $query->execute();

        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $query->rowCount();
                    break;
                case 'single':
                    $data = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $data = '';
            }
        }else{
            if($query->rowCount() > 0){
                $data = $query->fetchAll();
            }
        }
        return !empty($data)?$data:false;
    }

    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    public function insert($table,$data){
        if(!empty($data) && is_array($data)){
            $columns = '';
            $values  = '';
            $i = 0;
            if(!array_key_exists('created',$data)){
                $data['created'] = date("Y-m-d H:i:s");
            }
            if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }

            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
            $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            $query = $this->db->prepare($sql);
            foreach($data as $key=>$val){
                $query->bindValue(':'.$key, $val);
            }
            $insert = $query->execute();
            return $insert?$this->db->lastInsertId():false;
        }else{
            return false;
        }
    }

    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($table,$data,$conditions){
        if(!empty($data) && is_array($data)){
            $colvalSet = '';
            $whereSql = '';
            $i = 0;
            if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $colvalSet .= $pre.$key."='".$val."'";
                $i++;
            }
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
            $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
            $query = $this->db->prepare($sql);
            $update = $query->execute();
            return $update?$query->rowCount():false;
        }else{
            return false;
        }
    }

    /*
     * Delete data from the database
     * @param string name of the table
     * @param array where condition on deleting data
     */
    public function delete($table,$conditions){
        $whereSql = '';
        if(!empty($conditions)&& is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
        $sql = "DELETE FROM ".$table.$whereSql;
        $delete = $this->db->exec($sql);
        return $delete?$delete:false;
    }

    // Sanitises user input before processing data
    public function TestInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Sanitises user email before processing data
    public function TestEmail($data) {
        $data = trim($data);
        $data = filter_var($data, FILTER_SANITIZE_EMAIL);
        $data = filter_var($data,FILTER_VALIDATE_EMAIL);
        return $data;
    }

    public function getDragons($limit) {

        $starting_limit = 0;

        if (!empty($_GET['elementid'])) {
            $id = $this->TestInput($_GET['elementid']);
            $where = 'e.ElementID';
            $type = null;
        } elseif (!empty($_GET['typeid'])) {
            $id = $this->TestInput($_GET['typeid']);
            $where = 't.TypeID';
            $type = $id;
        } else {
            $where = '';
            $id = null;
            $type = null;
        }

        $this->_sortitem = $this->sortDragons();

        if (!empty($where)) {
            $count = "SELECT COUNT(*) AS TotalDragons FROM dragon AS d
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                JOIN dragonelement AS de ON de.DragonID = d.DragonID
                JOIN element AS e ON de.ElementID = e.ElementID
                WHERE $where = :filter
                GROUP BY de.DragonID";

            if (!empty($type) && $type == 4 || $type == 5) {
                $sql = "SELECT * FROM dragon AS d 
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                WHERE $where = :filter";
            } else {
                switch ($where) {
                    case "t.TypeID":
                        $sql = "SELECT e.ElementName, e.ElementID, e.ElementFlag, e.ElementNotes, GROUP_CONCAT(e.ElementIcon) as elements, d.*, de.*, t.* FROM dragon AS d 
                    JOIN dragontype AS t ON d.TypeID = t.TypeID
                    JOIN dragonelement AS de ON de.DragonID = d.DragonID
                    JOIN element AS e ON de.ElementID = e.ElementID
                    WHERE $where = :filter
                    GROUP BY de.DragonID
                    ORDER BY $this->_sortitem";
                        break;
                    case "e.ElementID":
                        $sql = "SELECT * FROM dragon AS d 
                    JOIN dragontype AS t ON d.TypeID = t.TypeID
                    JOIN dragonelement AS de ON de.DragonID = d.DragonID
                    JOIN element AS e ON de.ElementID = e.ElementID
                    WHERE $where = :filter
                    GROUP BY de.DragonID
                    ORDER BY $this->_sortitem";
                        break;
                    default:
                        $sql = "SELECT e.ElementName, e.ElementID, e.ElementFlag, e.ElementNotes, GROUP_CONCAT(e.ElementIcon) as elements, d.*, de.*, t.* FROM dragon AS d 
                    JOIN dragontype AS t ON d.TypeID = t.TypeID
                    JOIN dragonelement AS de ON de.DragonID = d.DragonID
                    JOIN element AS e ON de.ElementID = e.ElementID
                    GROUP BY de.DragonID
                    ORDER BY $this->_sortitem LIMIT $starting_limit, $limit";
                        break;
                }
            }
        } else {
            $count = "SELECT COUNT(*) AS TotalDragons FROM dragon AS d
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                JOIN dragonelement AS de ON de.DragonID = d.DragonID
                JOIN element AS e ON de.ElementID = e.ElementID
                GROUP BY de.DragonID";

            $sql = "SELECT e.ElementName, e.ElementID, e.ElementNotes, e.ElementFlag, GROUP_CONCAT(e.ElementIcon) as elements, d.*, de.*, t.* FROM dragon AS d 
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                JOIN dragonelement AS de ON de.DragonID = d.DragonID
                JOIN element AS e ON de.ElementID = e.ElementID
                GROUP BY d.DragonID
                ORDER BY $this->_sortitem LIMIT $starting_limit, $limit";
        }

        $this->_paging = $count;

        $query = $this->db -> prepare($sql);
        if (!empty($where)) {
            $query->bindParam(':filter', $id);
        }

        $query -> execute();

        if($query->rowCount() > 0){
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return !empty($data)?$data:false;
    }

    public function getDragon($id) {
        if ($id >= 11 and $id <= 14) {
            $sql = "SELECT * FROM dragon AS d 
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                WHERE d.DragonID= :dragon limit 1";
        }  else {
            $sql = "SELECT e.ElementName, e.ElementID, e.ElementNotes, GROUP_CONCAT(e.ElementIcon) as elements, d.*, de.*, t.* FROM dragon AS d
                JOIN dragontype AS t ON d.TypeID = t.TypeID
                JOIN dragonelement AS de ON de.DragonID = d.DragonID
                JOIN element AS e ON de.ElementID = e.ElementID
                WHERE d.DragonID= :dragon
                GROUP BY de.DragonID limit 1";
        }

        $query = $this->db-> prepare($sql);
        $query->bindParam(':dragon', $id);

        $query -> execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);

        return !empty($data)?$data:false;
    }

    public function getLtdDragons($ltd) {
        $sql = "SELECT * FROM ltddragon AS ld
                JOIN dragon AS d ON ld.DragonID = d.DragonID
                WHERE ld.LtdID= :ltd";

        $query = $this->db -> prepare($sql);
        $query->bindParam(':ltd', $ltd);

        $query -> execute();

        if($query->rowCount() > 0){
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return !empty($data)?$data:false;
    }

    public function setLtdDragons($ltd) {
    $sql = "UPDATE ltddragon AS ld
                join dragon AS d on ld.DragonID = d.DragonID
                SET d.isAvailable = 1
                where ld.LtdID= :ltd";

    $query = $this->db->prepare($sql);
    $query->bindParam(':ltd', $ltd);

    $update = $query->execute();

    return $update?$query->rowCount():false;
}

    public function setAllLtdDragons($flag) {
        $sql = "UPDATE ltddragon AS ld
                join dragon AS d on ld.DragonID = d.DragonID
                SET d.isAvailable = $flag";

        $query = $this->db->prepare($sql);

        $update = $query->execute();

        return $update?$query->rowCount():false;
    }

    public function sortDragons(){
        if (!empty($_GET['sort'])) {
            $this->_sort = $this->TestInput($_GET['sort']); // Sorting menu
            switch ($this->_sort) {
                case 'ascdragons':
                    $this->_sortitem = 'd.DragonName';
                    break;
                case 'descdragons':
                    $this->_sortitem = 'd.DragonName DESC';
                    break;
                case 'asctype':
                    $this->_sortitem = 't.TypeName';
                    break;
                case 'desctype':
                    $this->_sortitem = 't.TypeName DESC';
                    break;
                case 'ascelement':
                    $this->_sortitem = 'e.ElementName';
                    break;
                case 'descelement':
                    $this->_sortitem = 'e.ElementName DESC';
                    break;
                default:
                    $this->_sortitem = "de.DragonID";
                    break;
            }
        } else {
            $this->_sortitem = "de.DragonID";
        }
        return $this->_sortitem;
    }

    public function searchDragons($searchname)
    {
        $sql = 'SELECT * FROM dragon AS d WHERE DragonName LIKE :dragon';

        $query = $this->db->prepare($sql);
        $search = '%'.$searchname.'%'; // Because bound parameters don't accept wildcards
        $query->bindParam(':dragon', $search);
        $query->execute();

        $data = $query -> fetchAll(PDO::FETCH_ASSOC);

        return !empty($data) ? $data : false;
    }
}

?>