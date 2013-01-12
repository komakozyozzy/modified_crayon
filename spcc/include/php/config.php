<?php

class Config
{
    private $ini_array;
    private $type;
    private $DOCROOT;

    function __construct() {
        //Remeber that the localhost version is in the root not the git folder.
        $this->DOCROOT = $_SERVER['DOCUMENT_ROOT'];
        $this->ini_array = parse_ini_file($this->DOCROOT."/config.ini", true);
        $this->type = $this->ini_array['enviroment']['type'];
    }

    public function getDBSetting($name){
        if ($this->type == "localhost"){
            $data = $this->ini_array['data_base_localhost'];
        } else {
            $data = $this->ini_array['data_base_live'];
        }
        return (isset($data[$name]))? $data[$name] : "";
    }

    public function getLogSetting($name){
        $env = $this->ini_array['enviroment'];
        $data = $this->ini_array['logger'];
        if($name == "log_path"){
            return $this->DOCROOT.$env[$this->type."_path"].$data[$name];
        } else {
            return $data[$name];
        }
    }

    public function getDataPath(){
        $env = $this->ini_array['enviroment'];
        $data = $this->ini_array['data_path'];
        return $this->DOCROOT.$env[$this->type."_path"].$data;
    }

    public function getTmpSetting($name){
        $env = $this->ini_array['enviroment'];
        $data = $this->ini_array['template'];
        return $this->DOCROOT.$env[$this->type."_path"].$data[$name];
    }
}
?>