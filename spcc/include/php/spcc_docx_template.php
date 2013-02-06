<!DOCTYPE html>
<link type="text/css" rel="stylesheet" media="all" href="../css/table.css" />
</html>
<?php

class spp_docx_template{
    /*
     *  Having trouble getting the imported CSS file to show up in the docx, so I am creating all styles here.
     *  NOTE: The first <td> in the body needs to have style="display:none;". If not, then the first row will be 
     *  bold and have it's own 'header' template added to it. The purpose of this is to be able to have sub headers 
     *  in tables. An example is the Potential Discharge Volume tables.
     *  ALSO: Use td, not th, for the effect of creating a header. The first td in each section will automatically
     *  be bold and stand out. th has an altogether different effect. This can be modified later, but for now it 
     *  suites my purpose.
     */
    public $htmlclass = '<style>td { border: 1px solid black; align:right; padding-left:8px;}</style><style>th {border: 1px solid black; align:center}</style>';
    public $css = '<style>
                            .SPCC_Table {
                                
                                margin: 0 auto;padding:0px;
                                width:100%;
                                box-shadow: 10px 10px 5px #888888;
                                border:1px solid #000000;
                                -moz-border-radius-bottomleft:9px;
                                -webkit-border-bottom-left-radius:9px;
                                border-bottom-left-radius:9px;
                                -moz-border-radius-bottomright:9px;
                                -webkit-border-bottom-right-radius:9px;
                                border-bottom-right-radius:9px;
                                -moz-border-radius-topright:9px;
                                -webkit-border-top-right-radius:9px;
                                border-top-right-radius:9px;
                                -moz-border-radius-topleft:9px;
                                -webkit-border-top-left-radius:9px;
                                border-top-left-radius:9px;
                            }
                            .SPCC_Table table{
                                width:100%;
                                height:100%;
                                margin: 0 auto;padding:0px;
                            }
                            .SPCC_Table tr:last-child td:last-child {
                                -moz-border-radius-bottomright:9px;
                                -webkit-border-bottom-right-radius:9px;
                                border-bottom-right-radius:9px;
                            }
                            .SPCC_Table table tr:first-child td:first-child {
                                -moz-border-radius-topleft:9px;
                                -webkit-border-top-left-radius:9px;
                                border-top-left-radius:9px;
                            }
                            .SPCC_Table table tr:first-child td:last-child {
                                -moz-border-radius-topright:9px;
                                -webkit-border-top-right-radius:9px;
                                border-top-right-radius:9px;
                            }
                            .SPCC_Table tr:last-child td:first-child{
                                -moz-border-radius-bottomleft:9px;
                                -webkit-border-bottom-left-radius:9px;
                                border-bottom-left-radius:9px;
                            }
                            .SPCC_Table tr:hover td{
                                background-color:#82c0ff;
                                background:-o-linear-gradient(bottom, #82c0ff 5%, #56aaff 100%);	
                                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #82c0ff), color-stop(1, #56aaff) );
                                background:-moz-linear-gradient( center top, #82c0ff 5%, #56aaff 100% );
                                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#82c0ff", endColorstr="#56aaff");	
                                background: -o-linear-gradient(top,#82c0ff,56aaff);
                            }
                            .SPCC_Table tr:first-child td{
                                background:-o-linear-gradient(bottom, #0069d3 5%, #007fff 100%);	
                                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0069d3), color-stop(1, #007fff) );
                                background:-moz-linear-gradient( center top, #0069d3 5%, #007fff 100% );
                                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#0069d3", endColorstr="#007fff");	
                                background: -o-linear-gradient(top,#0069d3,007fff);
                                background-color:#0069d3;
                                border:0px solid #000000;
                                text-align:center;
                                border-width:0px 0px 1px 1px;
                                font-size:18px;
                                font-family:Comic Sans MS;
                                font-weight:bold;
                                color:#ffffff;
                            }
                            .CSSTableGenerator tr:first-child:hover td{
                                background:-o-linear-gradient(bottom, #0069d3 5%, #007fff 100%);	
                                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0069d3), color-stop(1, #007fff) );
                                background:-moz-linear-gradient( center top, #0069d3 5%, #007fff 100% );
                                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#0069d3", endColorstr="#007fff");	
                                background: -o-linear-gradient(top,#0069d3,007fff);
                                background-color:#0069d3;
                            }
                            .SPCC_Table tr:first-child td:first-child{
                                border-width:0px 0px 1px 0px;
                            }
                            .SPCC_Table tr:first-child td:last-child{
                                border-width:0px 0px 1px 1px;
                            }
                            .SPCC_Table td{
                                background:-o-linear-gradient(bottom, #56aaff 5%, #82c0ff 100%);	
                                background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #56aaff), color-stop(1, #82c0ff) ); 
                                background:-moz-linear-gradient( center top, #56aaff 5%, #82c0ff 100% );
                                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#56aaff", endColorstr="#82c0ff");	
                                background: -o-linear-gradient(top,#56aaff,82c0ff);
                                background-color:#56aaff;
                                border:1px solid #000000;
                                border-width:0px 1px 1px 0px;
                                text-align:left;
                                padding:7px;
                                font-size:12px;
                                font-family:Comic Sans MS;
                                font-weight:bold;
                                color:#000000;
                            }
                            .SPCC_Table tr:last-child td{
                                border-width:0px 1px 0px 0px;
                            }
                            .SPCC_Table tr td:last-child{
                                border-width:0px 0px 1px 0px;
                            }
                            .SPCC_Table tr:last-child td:last-child{
                                border-width:0px 0px 0px 0px;
                            }
                 </style>';
    public $startdiv = '<div class="SPCC_Table" style="width:800px;">';
    public $enddiv = '</div>';       
    public $degreeSymbol = '&deg;';
    
    function enableHTML(){
        return '<html><body>';
    }
    
    function disableHTML(){
        return '</body></html>';
    }

    
    function operator_information(){
        // OPERATOR SPECIFIC INFORMATION TABLE
              
        $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr>
                            <td colspan="2">
                                OPERATOR SPECIFIC INFORMATION
                            </td>
                                               
                        <tr>
                    </thead>
                    <tbody>
                    <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr>
                            <td width="80%">
                                Owner/Operator (Name Registered with State)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                State (Location of Owner/Operator\'s Office):
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Operator Number:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Operator Mailing Address:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Operator Physical Address:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Operator Day Phone:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Business FAX:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Authorized Representative:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Title:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Auth. Rep. Home Address:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Auth. Rep. 24-Hour/Cell Phone:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Auth. Rep. Email:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Field Operations Manager (FOM)
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                FOM Home Address:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                FOM 24 Hour/Cell Phone:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Response Coordinator
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                RC Home Address:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                RC 24 Hour/Cell Phone:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Does Owner/Operator employ a full time RC?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Whose work experience will be referred to in plan? [Title]
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Number Years Experience in Oil Production: [# ONLY]
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Where are SPCC plans and reports kept?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Are there greater than 16 Facilities for this Owner/Operator that Scientific is providing SPCC\'s for?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                    </tbody>
                  </table>'.$this->enddiv;
        return $html;
        
    }
    
    function facility_data(){
        
         $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr >
                            <td colspan="2">
                                PART II - FACILITY DATA	
                            </td>
                                               
                        <tr>
                    </thead>
                    <tbody>
                    <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr>
                            <td width="80%">
                                Facility Name: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Type of Facility: Onshore Drilling, Oil Production, Salt Water Disposal, Gas Production, Oil & Gas Production, Workover
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Legal Description:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                               Lease Permit Number/RRC#:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                State:  (Facility)
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                               County & State:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Center of Facility GPS Latitude:
                            </td>
                            <td>
                                N'.$this->degreeSymbol.' Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Center of Facility GPS Longitude:
                            </td>
                            <td>
                                W'.$this->degreeSymbol.' Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                How Many Containment Areas are present on this lease?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Is this a 24 Hour Monitored Facility:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Is there an Emergency "Auto Shut-off" in Area 1?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Loop Emergency Shut off for areas...
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                State Regulatory Agency:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Rules and Regulations:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                District Number:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                District Address:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                RC Home Address:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                District Phone:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Local Emergency Planning Committee (LEPC) Address:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                LEPC Phone:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Where are emergency spill materials stored?
                            </td>
                            <td>
                                on the pumper\'s truck
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Who is responsible for checking spill supplies?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Frequency of Field Operations Inspections:
                            </td>
                            <td>
                                Daily
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Frequency Water Areas Inspected:
                            </td>
                            <td>
                                Annually
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Has facility experienced reportable oil spill 12 months prior to January 10, 1974. If Yes, include Reports to EPA.
                            </td>
                            <td>
                                no
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Who provides pumper services?
                            </td>
                            <td>
                                Pumper
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Frequency of Field Operations Inspections:
                            </td>
                            <td>
                                Pumper\'s / WRM\'s Home Address:  
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Frequency of Field Operations Inspections:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Pumper\'s / WRM\'s Cell Phone:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Are any tanks field constructed and subject to Brittle Fracture Evaluation?
                            </td>
                            <td>
                                are no
                            </td>
                        </tr>
                    </tbody>
                  </table>'.$this->enddiv;
        return $html;
        
    }
    
    function BLM(){
        $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr>
                            <td colspan="2">
                                BLM
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr>
                            <td width="80%">
                                BLM District:  (Wyoming fills in auto.  Colorado must be filled in manually)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                BLM Field Office:  (Wyoming fills in auto.  Colorado must be filled in manually)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                BLM Field Office Address:   (Wyoming fills in auto.  Colorado must be filled in manually)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                BLM Field Office Phone:   (Wyoming fills in auto.  Colorado must be filled in manually)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                Additional State Agencies (KS & AR Only):  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Office:
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                Additional District Address:
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                Additional District Phone Number:
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Office (AR):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Office (AR):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Office (KS):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Office (KS):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Address (AR):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Address (AR):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Address (KS):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Address (KS):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Phone (AR):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Phone (AR):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                District Phone (KS):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               District Phone (KS):
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                EPA Region Number
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                EPA Region Address
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                EPA Region Phone
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                EPA Local Address
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                EPA Local Phone
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        
                 </tbody>
                  </table>'.$this->enddiv;
        return $html;
        
    }
    
    function epa_map(){
        return $this->css.$this->startdiv.'<img src="../include/image/epa.gif">'.$this->enddiv;
    }
    
    function emergency_spill_materials(){
         $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr>
                            <td colspan="2">
                                Emergency Spill Materials
                            </td>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Quantity
                            </td>
                            <td>
                                Materials
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Salvage Drums & Buckets
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Foaming Agents & Fire Suppressants
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Hand Tools
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Absorbent Materials
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Pumps & Hoses
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Inflatable Seals
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Ropes 
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Wedges & Plugs
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                PVS Piping & Fittings - Assorted Sizes
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Sand Bags
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Decontamination Equipment
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Communications Equipment
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Portable Breathing Apparatus
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Salvage Drums & Buckets
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Peat Moss
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Vacuum Trucks, Tanker Trucks, Bob Tail
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Portable Containment Booms
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Boots, Waders, Gloves, Coveralls, Masks
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Roll Off Boxes, Frac Tanks, Storage Tanks
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Boats, Skiffs, Barges & Rafts
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Portable Light Sets
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Electric Generators
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Plastic Sheeting
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Weirs
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Booms
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                
                            </td>
                            <td width="50%">
                                Other
                            </td>
                        </tr>
                     </tbody>
                  </table>'.$this->enddiv;
        return $html;
        
    }
    
    function tank_info(){
        /*
         *  I am assuming this will depend on the number of tanks/areas that are present
         *  This function will need to be modified for dynamic table creation.
         */
        $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr>
                            <td colspan="6">
                                Potential Discharge Volume
                            </td>
                        </tr>
                        
                    </thead>
                    <tbody>
                    <tr>
                            <td width="40%">
                                Tank Number - Dike Area 1
                            </td>
                            <td width="12%">
                                
                            </td>
                             <td width="12%">
                                
                            </td>
                             <td width="12%">
                               
                            </td
                             <td width="12%">
                                
                            </td>
                             <td width="12%">
                               
                            </td>
                            <td width="12%">
                               
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Use of Tank
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                        <tr>
                            <td>
                                Geometric Shape of Tank
                            </td>
                            <td>
                                CYLINDER
                            </td>
                            <td>
                                CYLINDER
                            </td>
                            <td>
                                CYLINDER
                            </td>
                            <td>
                                CYLINDER
                            </td>
                            <td>
                                CYLINDER
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Nominal Capacity (bbl)
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                0
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Nominal Capacity (gallons)
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                0
                            </td>
                            <td>
                                0
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Nominal Diameter (ft.)
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Nominal Hieght(ft.)
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Year Manufactured
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Type 
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Material 
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Top 
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Foundation 
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Transportation
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Note if Raised Horizontal
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         <tr>
                            <td>
                                Type of Failure
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            <td>
                                
                            </td>
                            
                        </tr>
                         
                         <tr>
                            <td colspan="5" align="right">
                                Area 1 Total Gallons:
                            </td>
                            <td>
                                0
                            </td>
                            
                        </tr>
                    </tbody>
                  </table>'.$this->enddiv;
        return $html;
        
    }
    
    function field_agent_inspection(){
        $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr>
                            <td colspan="2">
                                Field Agent Inspection
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr>
                            <td width="80%">
                                Lease Name of Facility:
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                Are there any satellite leases feeding into the main tank battery?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                How Many? (this question will have logic)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               What is main access road to lease? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Composition of lease road: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Condition of lease road: (logic)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Are there any storm drains within 100 yards of this facility? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Is there signage at the entrance? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Condition of the signage: (logic)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Is there a gate at the entrance of the Main Facility? Is it open or locked? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                Is it open or locked? (logic)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Gate Entrance GPS Latitude of Main Facility: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Gate Entrance GPS Longitude of Main Facility:
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               DIRECTIONS TO MAIN TANK BATTERY 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              Elevation:  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Digital picture of tank battery:  
                            </td>
                            <td width="20%">
                                INSERT PICTURE ON COVER PAGE 
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Is there signage at the tank battery?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Condition of signeage: (logic) 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Is there signage at the wellhead?   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Condition of signeage: (logic)  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               For Marinas, Farms, Residential areas…Are there "No Smoking" signs near all fuel storage tanks and dispensers?
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              Condition of signeage: (logic)   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              For Marinas, Farms, Residential areas…Are there fueling instruction signs easily readable at the fuel dispensers?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Condition of signeage: (logic)   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              For Marinas, Farms, Residential areas…Are there fire extinguishers near the fuel dispensers?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Condition of signeage: (logic)  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Is there H2S Gas Present?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                             Is there a sign?  (logic) 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              What is the measurement?  (ppms)  (logic)
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              What were the wind conditions at the time of the H2S measurement?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              Does wellhead have sludge in surrounding area or signs of seepage or leaks?   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Lease road is what direction from the tank battery?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               How is oil production transferred to Buyers? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              How frequently does the oil get hauled off?  (if trucked)  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              Current average daily gas production in mcf:  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              How is the gas transferred?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Current average daily water production in barrels: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                                Water Production:
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               SW, FW or PW? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Gallons of Salt Water: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               How is water transferred? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               How frequently does the water get hauled off?  (if trucked); [if injected--N/A] 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Location & distance from containment area of water injection wellhead/freshwater runoff:  (p. 13) 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              What is the rainfall for this county according to Tech. Paper 40? (if it does not auto populate, type over the formula in B103)  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Are there Catch Basins Present on this lease? 
                            </td>
                            <td width="20%">
                                Logic dictates the next section.
                            </td>
                        </tr>
                        </body>
                        <thead>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2">
                               Catch Basins 
                            </td>
                           
                        </tr>
                        <tr>
                            <td width="80%">
                               Area # ...
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Length
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Width
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Height
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Area # ...
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Length
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Width
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Height
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                      </body>
                        <thead>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2">
                               Other Objects Taking Up Space - Logic if they exist...
                            </td>
                           
                        </tr>
                        <tr>
                            <td width="80%">
                               Area # ...
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Length
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Width
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Discription
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Area # ...
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Length
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Width
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Discription
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               What is the Geometric Shape of Area ...
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               What is the Geometric Shape of Area ...
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Area Berm Stuff Goes Here...
                            </td>
                            <td width="20%">
                                Don\'t Exactly know what to do here yet...
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Area 1 Berm is constructed of:
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Area 2 Berm is constructed of:
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Are any firewalls present in Area 1?  See Diagram
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Are any firewalls present in Area 2?  See Diagram
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               For Marinas, Farms, Residential areas…is there security fencing around all storage tanks and are all portable tanks locked up when not in use?
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Is containment area 1 fenced?   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               Is containment area 2 fenced?   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                               For Marinas, Farms, Residential areas: is there adequate lighting to detect spills at night and to deter vandalism?   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="80%">
                              Adjacent Land Usage is:  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                              INSERT FACILITY DIAGRAM (PG 22) & MAP (PG 23) - outside of table
                            </td>
                            
                        </tr>
                        <tr>
                            <td width="80%">
                              Are there any water areas within 100 yards of this facility (Other than the navigable water listed on the map)?  If yes, where and how far away? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Fire Department Zip Code:  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Fire Department Name: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Fire Department Address & Phone Number: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              List nearest Navigable Water and distance for:
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              List any buildings within 100 yards of containment area:  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              What is direction of flow if discharge should occur?
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Terrain is:   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are there any deviations for containment from SPCC Rules? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are there any equalization lines between oil and water tanks?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are loadlines extending beyond containment?  LOGIC FOR NEXT QUESTION
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              If yes, are loadlines equipped with drip buckets that have lids?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is there containment area beneath loadlines extending beyond containment area?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              What materials are flowlines composed of?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is production treated through a SEP, HT, FWKO or GB? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are tanks level? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are ladders in safe condition? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are the any buried tanks? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              List Equipment to be inspected at facility: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Do vessels show signs of corrosion?   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              List Tanks 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Do vessels need painting?
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              List Tanks  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is there a dike drain in Area 1?   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is there a dike drain in Area 2?   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is there a sump pump in Area 1? LOGIC FOR NEXT QUESTION  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is there any standing water with a sheen? 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is there a sump pump in Area 1? LOGIC FOR NEXT QUESTION   
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is there any standing water with a sheen?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are salt water tanks covered with nets?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are smoke stacks covered with a screen?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are there trash bins inside of containment area or trash/debris on the ground inside containment?    
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are there electric poles inside of containment area?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is there any foliage (grass, weeds, trees, etc.) inside containment area?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Is there sludge or signs of salt water spills inside or outside of containment?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Are there any breaches in the berm that are need of repair?  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td colspan="2">
                              Additional Field Inspection Report Notes  
                            </td>
                            
                        </tr>
                         <tr>
                            <td width="80%">
                              Other: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Other: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                             Other:  
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td width="80%">
                              Other: 
                            </td>
                            <td width="20%">
                                Data Goes Here
                            </td>
                        </tr>
                        
                     
                    </tbody>
                  </table>'.$this->enddiv;
        return $html;
    }
    
    function additional_contacts(){
         $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr>
                            <td colspan="3">
                                Additional Contacts
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td width="33%">
                                Emergency Contractors
                            </td>
                            <td width="33%">
                                Company
                            </td>
                            <td width="33%">
                                Phone
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Environmental Services
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Backhoe/Dozer/heavy Equipment
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Vacuum Truck/Tankers/Frac Tanks
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Roustabout Crews
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                            <td width="33%">
                                Police Department
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Local Ambulance
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Local Hospital
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Sherrifs Department
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                State Highway Patrol
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                U.S. Army Coprs of Engineers
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Water Resources Board
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Department of Wildlife Conservation
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                        </tr>
                        <tr>
                            <td width="33%">
                                Department of Environmental Quality
                            </td>
                            <td width="33%">
                                Data Goes Here
                            </td>
                            <td width="33%">
                                ShaZAM!
                            </td>
                        </tr>
                 
                 </tbody>
                  </table>'.$this->enddiv;
        return $html;
        
         
    }
    
           function areas_of_responsibility(){
            $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr>
                            <td colspan="4">
                                Scientific EE Areas of Responsibility
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr>
                            <td width="25%">
                                Date of Inspection
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Agent
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                                Date of Processing
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Processor
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                                Date of Proofing
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Proofer
                      s      </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
            </tbody>
                  </table>'.$this->enddiv;
        return $html;
        }
        
        function containers_under_55(){
                        $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr>
                            <td colspan="4">
                               SECTION VII- Containers under 55 (1.75\' x 3\') gallons threshold
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr>
                            <td width="25%">
                               Dike # 1 ... Tank ID no... This will be handled with logic
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                                Type - Logic will dictate dynamic data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                                Construction
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                What the Hell goes here?
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                               Content
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                         <tr>
                            <td width="25%">
                               Diameter
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                         <tr>
                            <td width="25%">
                               Height
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                         <tr>
                            <td width="25%">
                               Nominal Capacity (bbl)
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr> 
                         <tr>
                            <td width="25%">
                               Capacity Gallons
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                               Dike # 2 ... Tank ID no
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                                Type - Logic will dictate dynamic data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                                Construction
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                        <tr>
                            <td width="25%">
                               Content
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                         <tr>
                            <td width="25%">
                               Diameter
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                         <tr>
                            <td width="25%">
                               Height
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
                         <tr>
                            <td width="25%">
                               Nominal Capacity (bbl)
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr> 
                         <tr>
                            <td width="25%">
                               Capacity Gallons
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                            <td width="25%">
                                Data
                            </td>
                        </tr>
            </tbody>
                  </table>'.$this->enddiv;
        return $html;
        }
        
        function field_inspection_report(){
             $html = $this->css.$this->startdiv.'<table>
                    <thead>
                        <tr>
                            <td colspan="2">
                                Field Inspection Report
                            </td>
                                               
                        <tr>
                    </thead>
                    <tbody>
                    <tr><td style="display:none;"></td><td style="display:none;"></td><tr>
                        <tr>
                            <td>
                                County & State
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Type of Facility
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Legal Description
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Lease Permit Number
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Center of Facility GPS Latttude
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Center of Facility GPS Longitude
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is There a Gate?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                (logic) Is it open or locked?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is there a sign at the entrance?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                (logic) What is the condition of the sign?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                What is the lease road constructed of?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                (logic) What is the condition of the lease road?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is there a sign at the tank battery?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                (logic) What is the condition of the sign?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is there a sign at the wellhead?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                 (logic) What is the condition of the sign?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is H2S gas present? 
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                (logic) Is there a sign?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                What is the H2S measurement and wind condition during this measurement?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
//                                Foreach area... this question?... Is Containment Area 1 fenced?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                (logic) What is the condition of the fence?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is this a 24-hour monitored facility?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                foreach area.. Is there an Emergency "Auto Shut-Off" In Area 1?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Does Wellhead have sludge in surrounding area or signs of seepage or leaks?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                What is the direction of flow if a discharge should occur?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                The terrain is:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Nearest water areas:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are loadlines equipped with bullplugs?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are loadlines extending beyond containment? 
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                If Yes (logic), are loadlines equipped with drip buckets that have lids? 
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is there another form of containment beneath loadlines extending beyond the containment area?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are tanks level?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are ladders in safe condition?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are there any buried tanks or partially buried tanks?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Do vessels show signs of corrosion?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                (logic) Which Tanks?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Do vessels need painting?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Which Vessels? (logic)
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is there a dike drain in area 1? foreach area... 
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is it open or closed? say something about how they should be closed when not in use..
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are all open top water tanks covered with nets? N/A for closed top tanks.
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are there screens covering all smoke stacks of heater treaters?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are there trash bins inside of containment or trash/debris on the ground inside of containment?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are there electric boxes or poles inside of containment?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is there foliage (grass, weeds, trees, etc.) inside containment?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Are there leaks or seepage at any connections?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Is there any sludge or signs of salt water spills inside or outside of containment?
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                foreach area.. this never ends... Current dimensions of berm in area 1 (L\' x W\' x H"):
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Area 1 Berm is constructed of:
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                         <tr>
                            <td>
                                Proposed dimensions of berm in Area 1 (L\' x W\' x H"):
                            </td>
                            <td>
                                Data Goes Here
                            </td>
                        </tr>
                        
                        </tbody>
                  </table>'.$this->enddiv;
        return $html;
            
        }
}

?>
