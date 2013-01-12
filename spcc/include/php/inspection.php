<?php
include_once "database.php";
include_once "config.php";

class Inspection {
    private $_xml;
    private $_docRoot;

    public function __construct($facility_id){
        $db = new Database();
        $config = new Config();
        $this->_docRoot = $config->getDataPath();
        $data_path = $db->query("SELECT data_path FROM t_inspection WHERE facility_id = '$facility_id'");
        $this->_xml = simplexml_load_file($this->_docRoot.$data_path[0]['data_path']);
        die();
    }

    public function getEquip($type){
        if($type == "facility"){
            return $xml;
        } else {
            return $xml->xpath("equipment[@type='$type']");
        }
    }


}
/**
if($data['type'] == 'updateXML' && $data['value'] != ''){
  $xml = simplexml_load_file($docRoot.$data['data_path']);
  $equip = array();
  if($data['id'] == 0){
    $equip[0] = $xml;
  } else {
    $equip = $xml->xpath("equipment[@id='".$data['id']."']");
  }
  $prop = $equip[0]->xpath("property[@name='".$data['name']."']");
  if(count($prop) == 0){
    $child = $equip[0]->addChild('property', $data['value']);
    $child->addAttribute('name', $data['name']);
  } else {
    $prop[0]->{0} = $data['value'];
  }
  $xml->saveXML($docRoot.$data['data_path']);
  print json_encode(array('result' => 'true'));
}
**/
?>
