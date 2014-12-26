<?php
include_once 'database.php';

class Functions {
    private $db;
    function __construct() {
        $this->db = new Database();
    }

    function getCompanies(){
        $str = '<option value="0"></option>';
        $query = $this->db->query("SELECT id, name FROM t_company order by name");
        foreach($query as $q){
            $str .= '<option value="'.$q['id'].'">'.$q['name'].'</option>';
        }
        return $str;
    }

    function getUsers(){
        $str = '<option value="0"></option>';
        $query = $this->db->query("SELECT id, name FROM t_user order by name");
        foreach($query as $q){
            $str .= '<option value="'.$q['id'].'">'.$q['name'].'</option>';
        }
        return $str;
    }

    function getEquipment(){
        $str = '<option type="none" value="0"></option>';
        $query = $this->db->query("SELECT id, name, type FROM t_equipment");
        foreach($query as $q){
            $str .= '<option type="'.$q['type'].'" value="'.$q['id'].'">'.$q['name'].'</option>';
        }
        return $str;
    }

    function getAttribute(){
        $str = '<option value="0"></option>';
        $query = $this->db->query("SELECT id, name FROM t_attribute WHERE type <> 'text'");
        foreach($query as $q){
            $str .= '<option value="'.$q['id'].'">'.$q['name'].'</option>';
        }
        return $str;
    }

}
?>
