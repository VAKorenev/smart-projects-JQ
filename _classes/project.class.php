
<?php

include("./_classes/sql.php");

class Projects {

    protected $db_host = 'localhost';
    protected $db_name;
    protected $db_username;
    protected $db_passw;
    protected $mysqlid;
    protected $id = 0;
    protected $project_data = array();
    protected $sql;

    function __construct($id, $db_host, $db_name, $db_username, $db_passw) {

        $this->id = $id;
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_username = $db_username;
        $this->db_passw = $db_passw;

        $this->init();

        $this->sql = new SQL;
    }

    function init() {

        $this->mysqlid = new mysqli($this->db_host, $this->db_username, $this->db_passw, $this->db_name) or die("Ошибка соединения: " . mysql_error());
    }

    function getAllProjects() {

        $result = $this->mysqlid->query($this->sql->prepare('all_projects', 0));
        while ($row = $result->fetch_object()) {
            $user_arr[] = $row;
        }
        $result->close();

        return $user_arr;
    }

    function getProject($id) {
        $result = $this->mysqlid->query($this->sql->prepare('project', $id));
        return $result->fetch_object();
    }

    function getProjectWorks($id) {

        $result = $this->mysqlid->query($this->sql->prepare('get_project_works', $id));

        while ($row = $result->fetch_object()) {
            $user_arr[] = $row;
        }
        $result->close();

        return isset($user_arr) ? $user_arr : array();
    }

    function insertNewComments($param) {
//        echo $this->sql->parse('addNewComments', $param);
        if (!$this->mysqlid->query($this->sql->parse('addNewComments', $param))) {
            echo "Ошибка: (" . $this->mysqlid->errno . ") " . $this->mysqlid->error;
        }
    }

    function getProjectMsg($id) {

        $result = $this->mysqlid->query($this->sql->prepare('getComments', $id));

        while ($row = $result->fetch_object()) {
            $user_arr[] = $row;
        }
        $result->close();

        return isset($user_arr) ? $user_arr : array();
    }

    function getPrice() {

        $result = $this->mysqlid->query($this->sql->prepare('get_price', 0));

        while ($row = $result->fetch_object()) {
            $user_arr[] = $row;
        }
        $result->close();

        return isset($user_arr) ? $user_arr : array();
    }

    function insertWorksPosition($param) {
//        echo $this->sql->parse('insertWorkPosition', $param);
        if (!$this->mysqlid->query($this->sql->parse('insertWorkPosition', $param))) {
            echo "Ошибка: (" . $this->mysqlid->errno . ") " . $this->mysqlid->error;
        }
    }

    function insertEquipmentPosition($param) {

        if (!$this->mysqlid->query($this->sql->parse('insertEquipmentPosition', $param))) {
            echo "Ошибка: (" . $this->mysqlid->errno . ") " . $this->mysqlid->error;
        }
    }

    function updatePosition($param) {
        if (!$this->mysqlid->query($this->sql->parse('updatePosition', $param))) {
            echo "Ошибка: (" . $this->mysqlid->errno . ") " . $this->mysqlid->error;
        }
    }

    function updateEquipmentPosition($param) {
        if (!$this->mysqlid->query($this->sql->parse('updateEquipmentPosition', $param))) {
            echo "Ошибка: (" . $this->mysqlid->errno . ") " . $this->mysqlid->error;
        }
    }

    function updateOrganizationName($param) {
        if (!$this->mysqlid->query($this->sql->parse('updateOrganizationName', $param))) {
            echo "Ошибка: (" . $this->mysqlid->errno . ") " . $this->mysqlid->error;
        }
    }

    function updateProjectName($param) {
        if (!$this->mysqlid->query($this->sql->parse('updateProjectName', $param))) {
            echo "Ошибка: (" . $this->mysqlid->errno . ") " . $this->mysqlid->error;
        }
    }

    function getProjectEquipment($param) {

        $result = $this->mysqlid->query($this->sql->parse('getProjectEquipment', $param));

        while ($row = $result->fetch_object()) {
            $rows_arr[] = $row;
        }
        $result->close();

//        $filledArray[$val] = is_array($value) ? $value[$key] : $value;

        return isset($rows_arr) ? $rows_arr : array();
    }

    function getEquipmetn() {

        $result = $this->mysqlid->query($this->sql->prepare('getEquipment', 0));
        while ($row = $result->fetch_object()) {
            $user_arr[] = $row;
        }
        $result->close();

        return isset($user_arr) ? $user_arr : array();
    }

    function deleteEquipment($param) {
        if (!$this->mysqlid->query($this->sql->parse('deleteEquipment', $param))) {
            echo "Ошибка: (" . $this->mysqlid->errno . ") " . $this->mysqlid->error;
        }
    }

    function deleteWork($param) {
        if (!$this->mysqlid->query($this->sql->parse('deleteWork', $param))) {
            echo "Ошибка: (" . $this->mysqlid->errno . ") " . $this->mysqlid->error;
        }
    }

}

?>
