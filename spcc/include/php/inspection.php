<?php
include_once "database.php";
include_once "config.php";

class Inspection {
    private $_xml;
    private $_docRoot;
    private $_db;
    private $log;
    private $error;
    public $equip_types = array();
    /**
     * There are dynamic instance variables for each object in the database if
     * the object doesnt exsist in the inspection it will be a blank array
     * $this->Area or $this->Chemical_Tank
     * Note: underscores are used for spaces
     **/

    public function __construct($facility_id){
        $this->_db = new Database();
        $config = new Config();
        $this->log = new KLogger($config->getLogSetting("log_path"),
                                 $config->getLogSetting("severity"));

        //Get inspection xml
        $this->_docRoot = $config->getDataPath();
        $data_path = $this->_db->query("SELECT data_path FROM t_inspection WHERE facility_id = '$facility_id'");
        $this->_xml = simplexml_load_file($this->_docRoot.$data_path[0]['data_path']);
        //


        //Get equipment types
        foreach($this->_db->query("SELECT name FROM t_equipment WHERE type = 'inspector'") as $equip){
            $this->equip_types[] = $equip['name'];
        }
        foreach($this->equip_types as $equip){
            $equip = str_replace(" ", "_", $equip);
            $this->{$equip} = $this->getEquipment($equip);
        }
        //


        //Get sheriff data
        $props = $this->Facility[0]['props'];
        $sheriff = array();
        if(isset($props['facility_county']) && isset($props['facility_state'])){
            $data = $this->_db->query("SELECT name, phone
                                       FROM t_sheriff
                                       WHERE state = '".$props['facility_state']."'
                                           AND county = '".$props['facility_county']."'");
            if(count($data) > 0){
                $sheriff = array('name' => $data[0]['name'], 'phone' => $data[0]['phone']);
            } else {
                $this->error[] = "No results from the database for County : ".$props['facility_county']."  State : ".$props['facility_state'];
            }
        } else {
            $this->error[] = "Missing County or State";
        }
        $this->{"sheriff"} = $sheriff;
    }

    /**
     *
     *  excepts an equipment name and an xml object if one is searching for a
     *  nested set of equipment
     *
     *  Returns an formated array of data
     **/
    private function _getEquipType($type, $xml=null){
        $array = array();
        if(!$xml) $xml = $this->_xml;
        if($type == "Facility"){
            return array(array('parent' => null,
                               'id' => 0,
                               'props' => $this->_getProperties($type, $xml)));
        } else {
            foreach($xml->equipment as $x){
                foreach($this->_getEquipType($type, $x) as $tmp){
                    $array[] = $tmp;
                }
                //$this->debug($array);
            }
            $xpath = $xml->xpath("equipment[@type='$type']");
            foreach($xpath as $path){
                $array[] = array('parent' => ''.$xml['id'].'',
                                 'id' => ''.$path['id'].'',
                                 'props' => $this->_getProperties($type, $path));
            }
            //$this->debug($array);
        }
        $this->log->logInfo("Returned from Insepction::getEquip : ", $array);
        return $array;
    }

    /**
     *
     *  excepts an equipment id, type, and a simple xml object
     *
     *  Returns an formated array of data
     **/
    private function _getEquipId($id, $type, $xml=null){
        if(!$xml) $xml = $this->_xml;
        $ary = array();
        if (''.$xml['id'].'' == $id) {
            $this->log->logInfo("Returned from Insepction::getEquip : ", $xml);
            return array('id' => $id,
                         'props' => $this->_getProperties($type, $xml));
        } else {
            foreach($xml as $x){
                $rtn = $this->_getEquipId($id, $type, $x);
                if($rtn) return $rtn;
            }
        }
    }

    /**
     *
     * excepts an equipment name and if its not the facilicy a simplexml object
     *
     * returns an array of property name as the key and the answered question as
     * the value
    **/
    private function _getProperties($name, $xml){
        $rtn = array();
        $nm_array = $this->_db->query("SELECT attr.name FROM t_attribute as attr
                                      INNER JOIN t_equipment as equip
                                      ON attr.equipment_id = equip.id
                                      WHERE equip.name = '$name'");
        foreach($nm_array as $array){
            $pName = $array['name'];
            $answer = $xml->xpath("property[@name='$pName']");
            if(count($answer) > 0){
                $rtn[$pName] = ''.$answer[0].'';
            } else {
                $rtn[$pName] = null;
            }
        }
        $this->log->logInfo("Returned from Insepction::getProperties : ", $rtn);
        return $rtn;
    }

    /**
     *
     * This method is a simple interface to work with the above listed method.  Please use this method.
     *
     * excepts either an id or a type for a piece of equipment
     * returns an array of properites by id
     *
     * returns :
     * array(array(parent => 0, id => 1, props => array(first => first_value, second => sec_value)),
     *       array(parent => 0, id => 2, props => array(first => first_value, second => sec_value)),)
     **/
    public function getEquipment($type, $id=null){
        if($id){
            if($type == "Facility"){
                return array(array('parent' => null,
                                   'id' => ''.$this->_xml['id'].'',
                                   'props' => $this->_getProperties("Facility", $this->_xml)));
            } else {
                return $this->_getEquipId($id, $type);
            }
        } else {
            if($type == "Facility"){
                return array(array('parent' => null,
                                   'id' => ''.$this->_xml['id'].'',
                                   'props' => $this->_getProperties("Facility", $this->_xml)));
            } else {
                return $this->_getEquipType($type);
            }
        }
    }

    //used to easily display arrays
    public function debug($array){
        print "<pre>";
        print_r($array);
        print "</pre>";

    }


}

?>
