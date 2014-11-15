<?php
include_once "database.php";
include_once "config.php";
include_once "calculations.php";


class Inspection {
    private $_xml;
    private $_docRoot;
    private $_db;
    private $log;
    private $error;
    public $equip_types = array();
    public $barrels = array('Oklahoma' => '10 barrels',
                            'Texas' => '5 barrels',
                            'Wyoming' => '10 barrels',
                            'Arkansas' => '1 barrel of crude oil or 5 barrels of produced water');
    /**
     * There are dynamic instance variables for each object in the database if
     * the object doesnt exsist in the inspection it will be a blank array
     * $this->Area or $this->Chemical_Tank
     * Note: underscores are used for spaces
     **/

    public function __construct($inspection_id){
        $this->_db = new Database();
        $config = new ConfigINI();
        $calc = new Calculation();
        $this->log = new KLogger($config->getLogSetting("log_path"),
                                 $config->getLogSetting("severity"));

        //Get inspection xml
        $this->_docRoot = $config->getDataFolder();
        $data_path = $this->_db->query("SELECT data_path, facility_id FROM t_inspection WHERE id = '$inspection_id'");
        $this->_xml = simplexml_load_file($this->_docRoot.$data_path[0]['data_path']);
        $this->{'facility_id'} = $data_path[0]['facility_id'];
        //

        //
        $facNameSql = "SELECT name, company_id FROM t_facility WHERE id = '".$this->facility_id."'";
        $facility_data = $this->_db->query($facNameSql);
        $this->{'Facility_Name'} = $facility_data[0]['name'];

        //Get Company Data
        $this->_getCompanyData($facility_data[0]['company_id']);
        //

        //Get images
        $imgSql = "SELECT data_path FROM t_image WHERE facility_id = '".$this->facility_id."'";
        $this->{'images'} = array_map(
            function($_){
                return '../'.$_['data_path'];
            }, $this->_db->query($imgSql)
        );
        //

        //Get equipment types
        foreach($this->_db->query("SELECT name FROM t_equipment WHERE type = 'inspector'") as $equip){
            $this->equip_types[] = $equip['name'];
        }
        foreach($this->equip_types as $equip){
            $this->{str_replace(" ", "_", $equip)} = $this->getEquipment($equip);
        }
        //
        $cnt = 1;
        foreach($this->Area as &$a_ref){
            $a_ref['props']['areaNum'] = $cnt++;
        }
        $cnt = 0;
        foreach($this->Vessel as &$vessel){
            $vessel['props']['num_bbl'] = $calc->nominal_capacity($vessel['props']['diameter'],
                                                                  $vessel['props']['height']);
            $vessel['props']['numGal'] = ($calc->nominal_capacity($vessel['props']['diameter'],
                                                                 $vessel['props']['height'])) /32;
            $vessel['props']['flow'] = $this->Facility[0]['props']['direction_flow'];
            $vessel['props']['tankNum'] = $cnt++;
        }

        //Just to reduce the length of the idioms
        $props = $this->Facility[0]['props'];


        //Get sheriff data
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
            $this->error[] = "Missing County or State for Sheriff";
        }
        $this->{"sheriff"} = $sheriff;

        //Get fire department data
        $fire_dept = array(
            'name'=>'',
            'addr_one'=>'',
            'addr_city'=>'',
            'addr_state'=>'',
            'addr_zip'=>'',
            'phone'=>''
        );
        if($props['fire_zip'] != ''){
            $data = $this->_db->query("SELECT name, addr_one, addr_city, addr_state, addr_zip, phone
                                           FROM t_fire_dept
                                       WHERE addr_zip = '".$props['fire_zip']."' ");
            if(count($data) > 0){
                $fire_dept = array(
                    'name'=> $data[0]['name'],
                    'addr_one'=> $data[0]['addr_one'],
                    'addr_city'=> $data[0]['addr_city'],
                    'addr_state'=> $data[0]['addr_state'],
                    'addr_zip'=> $data[0]['addr_zip'],
                    'phone'=> $data[0]['phone']
                );
            }
        }
        $this->{"fire_dept"} = $fire_dept;

        //Get data from regulatory_agency table, this data is state specific
        if(isset($props['facility_state'])){
            $data = $this->_db->query("SELECT type, name, phone
                                       FROM t_regulatory_agency
                                       WHERE state = '".$props['facility_state']."' ");
            if(count($data) > 0){
                foreach($data as $dat){
                    $this->{$dat['type']}  = array('name' => $data[0]['name'], 'phone' => $data[0]['phone']);
                }
            } else {
                $this->error[] = "No results from the database for State : ".$props['facility_state'];
            }
        } else {
            $this->error[] = "Missing State for Department of Eviromental Quality";
        }

        $this->{"min_barrels"} = (array_key_exists($props['facility_state'], $this->barrels))?$this->barrels[$props['facility_state']]:'';
        //Print any warnings
        if(count($this->error) > 0) $this->debug($this->error);

        $calc = array();
        //Calculate Area Attributes
        foreach($this->Area as $area){
            $calc[$area['id']] = new Calculation();
            $calc[$area['id']]->rain_fall = $props['rainfall'];
            $a_props = $area['props'];
            $calc[$area['id']]->add_area_volume($a_props['shape'],
                                                $a_props['length'],
                                                $a_props['width']);
            $calc[$area['id']]->add_area_volume($a_props['shape_one'],
                                                $a_props['length_one'],
                                                $a_props['width_one']);
            $calc[$area['id']]->add_area_volume($a_props['shape_two'],
                                                $a_props['length_two'],
                                                $a_props['width_two']);
            $calc[$area['id']]->add_area_volume($a_props['shape_three'],
                                                $a_props['length_three'],
                                                $a_props['width_three']);
            $calc[$area['id']]->add_area_volume($a_props['shape_four'],
                                                $a_props['length_four'],
                                                $a_props['width_four']);
        }

        //Caculate Vessel Attributes
        foreach ($this->Vessel as $vessel) {
            $v_props = $vessel['props'];
            $calc[$vessel['parent']]->set_production_value($v_props['type'],
                                                           $props['oil_production'],
                                                           $props['water_production']);
            $calc[$vessel['parent']]->calculate_vessel_area($v_props['diameter'],
                                                            $v_props['height']);
        }
        //Caculate Catch Basin Attribute
        foreach ($this->Catch_Basin as $cb) {
            $cb_props = $cb['props'];
            $calc[$cb['parent']]->add_catch_basin_volume($cb_props['length'],
                                                         $cb_props['width'],
                                                         $cb_props['depth']);
        }

        //Caculate Catch Basin Attribute
        foreach ($this->Object_Taking_Up_Space as $object) {
            $o_props = $object['props'];
            $calc[$object['parent']]->add_object_volume($o_props['length'],
                                                        $o_props['width']);
        }
        $this->{'calc'} = $calc;


        foreach($this->calc as $c){
            $c->berm_calc();
        }

    }


    /**
     *
     *  excepts an equipment name and an xml object if one is searching for a
     *  nested set of equipment
     *
     *  Returns an formated array of data
     **/
    private function _getCompanyData($company_id){
        $sql = "select name as Company_Name,
                    p_addr.address_1 as Company_Address,
                    p_city.city as Company_City,
                    p_state.state as Company_State,
                    p_zip.zipcode as Company_Zipcode,
                    m_addr.address_1 as Company_Mail_Address,
                    m_city.city as Company_Mail_City,
                    m_state.state as Company_Mail_State,
                    m_zip.zipcode as Company_Mail_Zipcode,
                    phone.area_code as Company_Area_Code,
                    phone.prefix as Company_Prefix,
                    phone.sufix as Company_Sufix,
                    p_zip.zipcode as Company_Zipcode
                from t_company as comp
                left join t_address as m_addr
                    on m_address_id = m_addr.id
                left join t_city as m_city
                    on m_addr.city_id = m_city.id
                left join t_state as m_state
                    on m_addr.state_id = m_state.id
                left join t_zipcode as m_zip
                    on m_addr.zipcode_id = m_zip.id
                left join t_address as p_addr
                    on p_address_id = p_addr.id
                left join t_city as p_city
                    on p_addr.city_id = p_city.id
                left join t_state as p_state
                    on p_addr.state_id = p_state.id
                left join t_zipcode as p_zip
                    on p_addr.zipcode_id = p_zip.id
                left join t_phone as phone
                    on comp.phone_id = phone.id
                where comp.id = '$company_id'";
        $data = $this->_db->query($sql);
        foreach($data[0] as $k=>$d){
            $this->{$k} = $d;
        }
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
                //$this->debug($path);
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
        //todo the equip needs to be an in statement matching the piece of equipment
        //whether its processor or inspector
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
