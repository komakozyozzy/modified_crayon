
<?php
include_once "functions.php";
include_once "dbconn.php";
include_once "spcc_config.php";
include_once "../include/php/HTMLHelper.php";


// this array can be built in the logic of the inspection tables.
$deficiency_array = array(''=>'');


class spcc_docx_template{
    private $hdrs = array('tankNum' => 'Tank Number', 'use' => 'Use of tank',
              'num_bbl' => 'Nominal Capacity (bbl)', 'numGal' => 'Nominal Capacity (gallons)',
              'flow' => 'Direction of Flow', 'diameter' => 'Nominal Diameter (ft.)', 
              'height' => 'Nominal Height (ft.)', 'type' => 'Type',
              'material' => 'Material', 'top' => 'Top', 'foundation' => 'Foundation',
              'transportation' => 'Transportation');
    public $css = '<style>
                            .SPCC_Table {
                                margin: 0 auto;
                                width:100%;
                                border: 1px solid black;
                                border-collapse: collapse;
                             }
                            .SPCC_Table table{
                                width:100%;
                                border-collapse: collapse;
                                
                            }
                            .SPCC_Table th{
                                background-color:#C3C3C3;
                                border:1px solid #000000;
                                
                            }
                            .SPCC_Table td{
                                background-color:#F3F3F3;
                                border:1px solid #000000;
                                text-align:left;
                                font-size:12px;
                                font-family:Helvetica;
                                font-weight:bold;
                                color:#000000;
                            }
                           
                 </style>';

    // this array can be built in the logic of the inspection tables.
    public $deficiency_array = array(''=>'');
    /*
    * Each table in the FIR will go in this function, since they are all sort of
    * jumbled in the same constant table in the PDF example I have. This way, 
    * they will page break if they need to. ALl of this is done with the idea of 
    * keeping the format and design as close to the original as possible.
    */ 
    
   // Vessel/Area data may need to be added as parameters 
   public function fir($inspectionData){
        // FIELD INSPECTION REPORT TABLE
        global $fac_location;
        global $fac_security;
        global $facility_equipment_conditions;
        $info = $inspectionData[0]['props'];
        
        $html = $this->css.'<table class="SPCC_Table">
                                                <thead>
                                                    <tr>
                                                       <th style="text-align:center" colspan="2">
                                                          FACILITY LOCATION
                                                       </th>
                                                    </tr>
                                                </thead>
                                              <tbody>';
        foreach($fac_location as $field => $text){
            // logic in here to handle questions and build deficiency array
            $html .= '<tr>
                          <td width="80%">'.$text.'</td>
                          <td width="20%">'.$info[$field].'</td>
                      </tr></tbody><thead>';
        }
        // FACILITY SECURITY & SIGNAGE TABLE
        $html .='<tr>
                    <th style="text-align:center" colspan="2">
                       FACILITY SECURITY & SIGNAGE
                    </th>
                 </tr></thead><tbody>';
        // use a function with a switch statement to evaluate cases that may need coditional logic
        foreach($fac_security as $field => $text){
            // logic in here to handle questions and build deficiency array
            $html .= '<tr>
                        <td width="80%">'.$text.'</td>
                        <td width="20%">'.$info[$field].'</td>
                      </tr>';
        }
        // FACILITY EQUIPMENT & CONDITIONS TABLE
         $html .='<tr>
                    <th style="text-align:center" colspan="2">
                       FACILITY EQUIPMENT & CONDITIONS
                    </th>
                 </tr></thead><tbody>';
        foreach($facility_equipment_conditions as $field => $text){
            // logic in here to handle questions and build deficiency array
            $html .= '<tr>
                        <td width="80%">'.$text.'</td>
                        <td width="20%">'.$info[$field].'</td>
                      </tr>';
        }
        // BERM CONDITIONS AND DIMENSIONS TABLE
         $html .='<tr>
                    <th style="text-align:center" colspan="2">
                       BERM CONDITIONS AND DIMENSIONS:
                    </th>
                 </tr></thead><tbody>';
         // for each area...
//        foreach($facility_equipment_conditions as $field => $text){
//            $html .= '<tr>
//                        <td width="80%">'.$text.'</td>
//                        <td width="20%">'.$info[$field].'</td>
//                      </tr>';
//        }
         // SUMMARY OF DETAILS THAT NEED IMMEDIATE ATTENTION TABLE / DEFICIENCIES
         $html .='<tr>
                    <th style="text-align:center; color:#fff; background-color:red" colspan="2">
                       SUMMARY OF DETAILS THAT NEED IMMEDIATE ATTENTION:
                    </th>
                 </tr></thead><tbody>';
         // for each entry in the deficiency array...
//        foreach($facility_equipment_conditions as $field => $text){
//            $html .= '<tr>
//                        <td width="80%">'.$text.'</td>
//                        <td width="20%">'.$info[$field].'</td>
//                      </tr>';
//        }
        $html .= '</tbody></table>';
        return $html;
    }
    /*
     *  PREPARED FOR
     *  Parameters: company data
     */
    public function prepared_for($data) {
        $comp_addr = $data['Company_Address'].' '.$data['Company_City'].', '.
                    $data['Company_State'].' '.$data['Company_Zipcode'];
        $comp_phone = ''.$data['Company_Area_Code'].''.$data['Company_Prefix'].
                    ''.$data['Company_Sufix'];
        $facType = 'Onshore '.$data['Facility_Type'].' Facility';
        $h = new HTMLHelper();
        $style = array('style' => 'text-align:center');
        $class = array('class' => 'SPCC_Table');
        $html =  $h->tag('div', $this->css . 
                    $h->tag('table',
                      $h->tag('thead', 
                        $h->tag('tr', 
                          $h->tag('th', 'Prepared For',$style))) .
                      $h->tag('tbody', 
                        $h->tag('tr',$h->tag('td', $data['Company_Name'])).
                        $h->tag('tr',$h->tag('td', $comp_addr)).
                        $h->tag('tr',$h->tag('td', $comp_phone)) .
                        $h->tag('tr',$h->tag('td', $h->tag('b',$data['Facility_Name']))) .
                        $h->tag('tr',$h->tag('td', $data['Facility_Name'])) .
                        $h->tag('tr',$h->tag('td', $facType))
                      ), $class), $style);
        return $html;
    }
    
    /*
     *  BERM TABLE CALCULATIONS
     *  Parameters: Area/Vessel Information
     */
    public function berm_calc_table(){
        return;
    }
    
    /*
     * VESSEL TABLES(S)
     * Parameters: Area/Vessel Information
     */
    public function vessel_table($data, $aData){
        $h = new HTMLHelper();
        $html = '';
        foreach($this->_vessel_table($data) as $area => $table){
            $area = explode('-', $area);
            $aNum = 0;
            foreach($aData as $a){
                if($a['id'] == $area[0]){
                    $aNum = $a['props']['areaNum'];
                }
            }
            $txt =  'Table 3-1.'.($area[1]-1).': Potential discharge volume - Area '.$aNum;
            $html .= $h->tag('b', $txt);
            $html .= $this->css;
            $html .= $h->tag('table', implode('', $table), array('class' => 'SPCC_Table'));
        }
        return $html;
    }

    private function _vessel_table($data){
        $h = new HTMLHelper();
        $htmlRows = array();
        $cnt = 0;
        $x = 0;
        $th = array('width' => '100px;');
        $td = array('width' => '100px;');
        $rows = $this->sortVesselData($data);
        foreach ($rows as $head => $row) {
            foreach ($row as $areaNumber => $area) {
                $htmlRow = $h->tag('th', $head);
                $i = 0;
                foreach ($area as $vessel) {
                    $i++;
                    $htmlRow .= $h->tag((($i == 0)?'th':'td'), $vessel, $td);
                    if (($i % 5) == 0 && count($area) > $i) {
                        if (empty($htmlRows[$areaNumber.'-'.$cnt])) {
                            $htmlRows[$areaNumber.'-'.$cnt] = array($h->tag('tr', $htmlRow));
                        } else {
                            $htmlRows[$areaNumber.'-'.$cnt][] = $h->tag('tr', $htmlRow);
                        }
                        $cnt ++;
                        $htmlRow = $h->tag('th', $head);
                    }                   
                }
                if (empty($htmlRows[$areaNumber.'-'.$cnt])) {
                    $htmlRows[$areaNumber.'-'.$cnt] = array($h->tag('tr', $htmlRow));
                } else {
                    $htmlRows[$areaNumber.'-'.$cnt][] =  $h->tag('tr', $htmlRow);
                }
                $cnt ++;
                $x = 1;
            }
            $cnt = 0;
        }
        return $htmlRows;
    }
    
    
    
    private function sortVesselData($data){
        $row = array();

        foreach($this->hdrs as $p => $h){ 
            $row[$h] = array();
            foreach($data as $vessel){
                $prop = (isset($vessel['props'][$p]))?$vessel['props'][$p]:'';
                if(array_key_exists($vessel['parent'], $row[$h])){
                    $row[$h][$vessel['parent']][] = $prop;
                } else {
                    $row[$h][$vessel['parent']] = array($prop);
                }
            }
        }
        return $row;
    }
    public function facility_image($image_path){
        return '<img src="/modified_crayon/spcc/'.$image_path.'"/>';
    }
}
?>