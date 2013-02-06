<!DOCTYPE html>
<link type="text/css" rel="stylesheet" media="all" href="../css/table.css" />
</html>
<?php
//include_once "PHPWord.php";
include_once "../include/php/inspection.php";
include_once "../include/php/spcc_docx_template.php";
require_once("../../phpdocx/classes/CreateDocx.inc");
//$data = new XMLData(11);
print "<pre>";
//print_r($data->getEquip("Area"));
print "</pre>";
//echo 'test';
//die();
/*
 * Set Development variables for dev environment, or disable for production environment
 */
$development = true; // This will display HTML in a browser, vs. needing to open a word doc for every change
$spcc = new spp_docx_template();

if (!$development){
    $docx = new CreateDocx();
    $docx->addTemplate('templates/TEST.docx');
}
/*
 * Create the instances of the SPCC doc
 * _____________________________________________________________________________
 */
$facility_data = $spcc->facility_data();
$operator_information = $spcc->operator_information();
$blm = $spcc->BLM();
$epa_map = $spcc->epa_map();
$emergency_spills = $spcc->emergency_spill_materials();
$tank_info = $spcc->tank_info();
$fia = $spcc->field_agent_inspection();
$additional_contacts = $spcc->additional_contacts();
$areas_of_responsibility = $spcc->areas_of_responsibility();
$containers_under_55 = $spcc->containers_under_55();
$field_inspection_report = $spcc->field_inspection_report();

/*
 * Operator Information
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$operator_information, 'html');
}else{
    echo $operator_information . '<br>';
    
}

/*
 * Facility Data
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('FACDATA',$facility_data, 'html');
    $docx->createDocx('templates/SPCC_3'); 
}else{
    echo $facility_data . '<br>';
    
}

/*
 * BLM Information
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$blm, 'html');
}else{
    echo $blm . '<br>';
    
}

/*
 * EPA Map
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$epa_map, 'html');
}else{
    echo $epa_map . '<br>';
    
}

/*
 * Emergency Spills Information
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$emergency_spills, 'html');
}else{
    echo $emergency_spills . '<br>';
    
}

/*
 * Tank Information
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$tank_info, 'html');
}else{
    echo $tank_info . '<br>';
    
}

/*
 * Field Agen Inspection Information
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$fia, 'html');
}else{
    echo $fia . '<br>';
    
}

/*
 * Additional Contacts Information
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$additional_contacts, 'html');
}else{
    echo $additional_contacts . '<br>';
    
}

/*
 * Areas of Responsibility Information
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$areas_of_responsibility, 'html');
}else{
    echo $areas_of_responsibility . '<br>';
    
}

/*
 * Containers Under 55 Information
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$containers_under_55, 'html');
}else{
    echo $containers_under_55 . '<br>';
    
}

/*
 * Field Inspection Report Information
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->addTemplateVariable('OPINFO',$field_inspection_report, 'html');
}else{
    echo $field_inspection_report . '<br>';
    
}

/*
 * Creaton of the actual Word Doc
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->createDocx('templates/SPCC_3'); 
}else{
    echo'<br> This web page is for development. Set $development to false to generate a word doc. Next is Summary of Details That Need Immediate Attention...'; 
    
}
// Here is what to put in your browser to generate the doc, or run the test environment 
// http://localhost/git/modified_crayon/spcc/word/SPCCDX.php    





?>
