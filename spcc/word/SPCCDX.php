<?php
function development($docx, $dev, $var, $replace, $type='html') {
    if (!$dev) {
        $docx->addTemplateVariable($var, $replace, $type);
    } else {
        echo $replace . '<br>';
    }
}
include_once "../include/php/inspection.php";
include_once "../include/php/config.php";
include_once "../include/php/klogger.php";
include_once "../include/php/spcc_docx_template.php";
require_once("../../phpdocx/classes/CreateDocx.inc");
include_once "../include/php/functions.php";
include_once "../include/php/dbconn.php";
global $dbconn;
$facID = 11;
$insp = new Inspection($facID);
//$insp->debug();
//$insp->debug($insp->Vessel);
//die();

//$blah = $insp->getEquipment('Vessel', $insp->Vessel[0]['id']);
//$data = new XMLData(11);

$inspectionData = $insp->Facility;


/*
 * Set Development variables for dev environment, or disable for production environment
 */
$development = true; // This will display HTML in a browser, vs. needing to open a word doc for every change
$spcc = new spcc_docx_template();
//$insp->debug($insp->Vessel);
$insp->debug($spcc->vessel_table($insp->Vessel));
die();

if (!$development){
    $docx = new CreateDocx();
    $docx->addTemplate('templates/SPCC.docx');
} else {
    $docx = null;
}
/*
 * Create the instances of the SPCC doc.
 * _____________________________________________________________________________
 */

//Facility Location
development($docx, $development, 'FIR', $spcc->fir($inspectionData));
//Facility Image 
development($docx, $development, 'IMAGE1', $insp->images[0], 'image');
//Company Name
development($docx, $development, 'COMPANY', $insp->Company_Name, "text");
//Facility Name
development($docx, $development, 'LEASE', $insp->Facility_Name, "text");
//Latitude
development($docx, $development, 'LAT', $insp->Facility[0]['props']['latitude'], "text");
//Longitude
development($docx, $development, 'LON', $insp->Facility[0]['props']['longitude'], "text");
//Prepared For
development($docx, $development, 'PREPARED_FOR', $spcc->prepared_for(array()), "html");
//Vessel Table
development($docx, $development, 'PREPARED_FOR', $spcc->prepared_for(array()), "html");
/* Creaton of the actual Word Doc
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->createDocxAndDownload('trash/SPCC Site Specific'); 
}else{
    echo'<br> This web page is for development. Set $development to false to generate a word doc. Next is Summary of Details That Need Immediate Attention...'; 
    
}
?>