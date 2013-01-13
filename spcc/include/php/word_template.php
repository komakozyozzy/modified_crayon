<?php
include_once "klogger.php";
include_once "config.php";

class SPCCTemplate{
    private $log;

    public function __construct(){
        $config = new Config();
        $this->log = new KLogger($config->getLogSetting("log_path"),
                                 $config->getLogSetting("severity"));

    }

    public function createTable($section, $data, $style=null){
        if(is_array($data)){
            $table = $section->addTable();
            foreach($data as $row){
                $table->addRow();
                foreach($row as $cellText){
                    $cell = $table->addCell(2000);
                    $cell->addText($cellText);
                }
            }
        } else {
            $this->log->logWarn("Table could not be made, no data was recieved ", $data);
        }
    }

}


?>