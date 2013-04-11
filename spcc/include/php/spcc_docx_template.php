
<?php
include_once "functions.php";
include_once "dbconn.php";
include_once "spcc_config.php";
include_once "../include/php/HTMLHelper.php";


    // this array can be built in the logic of the inspection tables.
    $deficiency_array = array(''=>'');

class spcc_docx_template{

    /*
     *  Having trouble getting the imported CSS file to show up in the docx, so I am creating all styles here.
     */

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
        $h = new HTMLHelper();
        $style = array('style' => 'text-align:center');
        $class = array('class' => 'SPCC_Table');
        $html =  $h->tag('div',
                    $h->tag('table',
                      $h->tag('thead', 
                        $h->tag('tr', 
                          $h->tag('th', 'Prepared For',$style))) .
                      $h->tag('tbody', 
                        $h->tag('tr',$h->tag('td', 'this is an name')).
                        $h->tag('tr',$h->tag('td', 'this is an address')).
                        $h->tag('tr',$h->tag('td', 'this is an phone'))
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
    public function vessel_table($data){
        $h = new HTMLHelper();
        
        foreach($this->getVesselRow($data) as $head => $row){
            $h->tag(, $inner)
                    
            $h->tag('table', $table);
        }
        
 
    }
    private function getVesselRow($data){
        $row = array();
        $hdrs = array('Tank Number', 'Use of tank','Nominal Capacity (bbl)',
                    'Nominal Capacity (gallons)','Direction of Flow',
                    'Nominal Diameter (ft.)', 'Nominal Height (ft.)','Type',
                    'Material','Top','Foundation','Transportation');

        foreach($hdrs as $h){ 
            $row[$h] = array();
            foreach($data as $vessel){
                if(array_key_exists($vessel['parent'], $row[$h])){
                    $row[$h][$vessel['parent']][] = $vessel['props']['use'];
                } else {
                    $row[$h][$vessel['parent']] = array($vessel['props']['use']);
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