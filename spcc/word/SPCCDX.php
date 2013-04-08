<?php

include_once "../include/php/inspection.php";
include_once "../include/php/klogger.php";
include_once "../include/php/spcc_docx_template.php";
require_once("../../phpdocx/classes/CreateDocx.inc");
include_once "../include/php/functions.php";
include_once "../include/php/dbconn.php";

global $dbconn;
$facID = 11;
$insp = new Inspection($facID);
$blah = $insp->getEquipment('Vessel', $insp->Vessel[0]['id']);
$insp->Vessel;
//$data = new XMLData(11);

$inspectionData =$insp->Facility;
//echo "<pre>";
//print_r($inspectionData);
//die();


/*
 * Set Development variables for dev environment, or disable for production environment
 */
$development = false; // This will display HTML in a browser, vs. needing to open a word doc for every change
$spcc = new spcc_docx_template();


if (!$development){
    $docx = new CreateDocx();
    $docx->addTemplate('templates/SPCC.docx');
}
/*
 * Create the instances of the SPCC doc.
 * _____________________________________________________________________________
 */

$facility_location = $spcc->fir($inspectionData);

/*
 * Facility Location
 * _____________________________________________________________________________
 */
if (!$development){
    $docx->addTemplateVariable('FIR',$facility_location, 'html');
}else{
    echo $facility_location . '<br>';
}
/* Creaton of the actual Word Doc
 * _____________________________________________________________________________
 */
if (!$development){
    $docx->createDocxAndDownload('trash/SPCC Site Specific');
}else{
    echo'<br> This web page is for development. Set $development to false to generate a word doc. Next is Summary of Details That Need Immediate Attention...';

}
?>