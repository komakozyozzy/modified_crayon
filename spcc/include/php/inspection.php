<?php
include_once "database.php";
include_once "config.php";

class Inspection {
    private $_xml;
    private $_docRoot;
    private $_db;
    private $log;

    public function __construct($facility_id){
        $this->_db = new Database();
        $config = new Config();
        $this->log = new KLogger($config->getLogSetting("log_path"),
                                 $config->getLogSetting("severity"));
        print $config->getLogSetting("severity");
        $this->_docRoot = $config->getDataPath();
        $data_path = $this->_db->query("SELECT data_path FROM t_inspection WHERE facility_id = '$facility_id'");
        $this->_xml = simplexml_load_file($this->_docRoot.$data_path[0]['data_path']);

    }

    /**
     *  Returns an simplexml object to be passed back for recursiveness.
     **/
    public function getEquip($type, $xml=null){
        if(!$xml) $xml = $this->_xml;
        if($type == "Facility"){
            $this->log->logInfo("Returned from Insepction::getEquipID : ", $rtn);
            return $xml;
        } else {
            $this->log->logInfo("Returned from Insepction::getEquipID : ", $rtn);
            return $xml->xpath("equipment[@type='$type']");
        }
    }

    public function getProperties($name, $xml){
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
    }

    public function debug($array){
        print "<pre>";
        print_r($array);
        print "</pre>";

    }


}

?>
