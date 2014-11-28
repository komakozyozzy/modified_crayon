<?php

/**
 * @todo  Need the army of engineer data
 * @todo  Need the LEPC and EPA reg data
 * @todo  Need to work on the last part of the berm calc with Mekay
 */

function development($docx, $dev, $var, $replace, $type='html') {
	if (!$dev) {

	$docx->replaceVariableByHTML(
		$var,
		'block',
		$replace,
		array('isFile' => false, 'parseDivsAsPs' => true, 'downloadImages' => false));
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

$facID = 11;
$insp = new Inspection($facID);
//$insp->debug();
//$insp->debug($insp->Vessel);
//die();

//$blah = $insp->getEquipment('Vessel', $insp->Vessel[0]['id']);
//$data = new XMLData(11);
//
$inspectionData = $insp->Facility;

/*
 * Set Development variables for dev environment, or disable for production environment
 */
$development = false; // This will display HTML in a browser, vs. needing to open a word doc for every change
$spcc = new spcc_docx_template($insp);


if (!$development){
    $docx = new CreateDocxFromTemplate('templates/SPCC.docx');
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
//development($docx, $development, 'IMAGE1', $insp->images[0], 'image');

$fp = $insp->Facility[0]['props'];
$p_address = $insp->Company_Address.' '.$insp->Company_City.', '.$insp->Company_State.' '.$insp->Company_Zipcode;
$m_address= $insp->Company_Mail_Address.' '.$insp->Company_Mail_City.', '.$insp->Company_Mail_State.' '.$insp->Company_Mail_Zipcode;
$a_num = array('one (1)','two (2)','three (3)', 'four (4)','five (5)',
		'six (6)','seven (7)','eight (8)', 'nine (9)', 'ten (10)');
$og = ($fp['oil_production'] * 32);
$sg = ($fp['water_production'] * 32);

$variables = array('COMPANY' => $insp->Company_Name, 
				   'LEASE' => $insp->Facility_Name,
				   'LAT' => $fp['latitude'], 
				   'LON' => $fp['longitude'],
				   'FAC_TYPE' => 'Onshore '.$fp['facility_type'].' Facility',
				   'COUNTY' => $fp['facility_county'],
				   'STATE' => $fp['facility_state'],
				   'OWNER_ADDRESS' => $p_address,
				   'MAILING_ADDRESS' => $m_address,
				   'PHYSICAL_ADDRESS' => $p_address,
				   'PRES_PHONE' => $fp['AR-phone'],
				   'FOM_PHONE' => $fp['FOM_phone'],
				   'RC_PHONE' => $fp['RC_phone'],
				   'PUMPER_PHONE' => $fp['pumper_phone'],
				   'PRES_ADDR' => $fp['AR_home_address'],
				   'FOM_ADDR' => $fp['FOM_home_address'],
				   'RC_ADDR' => $fp['RC_address'],
				   'PUMPER_ADDR' => $fp['pumper_address'],
				   'PRESIDENT' => $fp['AR_name'],
				   'FOM' => $fp['RC_name'],
				   'RC' => $fp['FOM_name'],
				   'PUMPER' => $fp['pumper_name'],
				   'LEASE_ROAD' => $fp['main_road'],
				   'LEASE_RD_CONST' => $fp['road_comp'],
				   'FLOWLINE_CONST'=> $fp['flowlines_comp'],
				   'AREA_NUM' => $a_num[((count($insp->Area)<11)? 
											count($insp->Area):"NUMBER TO HIGH")],
				   'OB' => $fp['oil_production'],
				   'SB' => $fp['water_production'],
				   'OG' => sprintf("%d", ($fp['oil_production']*32)),
				   'SG' => sprintf("%d", ($fp['water_production']*32)),
				   'TG' => sprintf("%d", (($fp['oil_production'] + $fp['water_production'])*32)),
				   'HT' => $fp['is_heater'],
				   'OIL_PROD_ANS' => $fp['oil_transfer'],
				   'GAS_PROD_ANS' => $fp['gas_transfer'],
				   'SW_PROD_ANS' => $fp['water_transfered'],
				   'SW_PROD_ANS' => $fp['nav_water'],
				   'PROD_EQUIP' => $fp['prod_equip'],
				   'ENGINEER_NOTES' => $fp['engineer_notes'],
				   'BHDHE_COMPANY' => $fp['dozer_name'],
				   'BDHE_PHONE' => $fp['dozer_phone'],
				   'VTTFT_COMPANY' => $fp['vac_name'],
				   'VTTFT_PHONE' => $fp['vac_phone'],
				   'RC_CREW' => $fp['roust_name'],
				   'RC_CREW_PHONE' => $fp['roust_phone'],
				   'SHERIFF' => $insp->sheriff['name'],
				   'SHERIFF_PHONE' => $insp->sheriff['phone'],
				   'DEPT_EQ' => $insp->deq['name'],
				   'DEPT_EQ_PHONE' => $insp->deq['phone'],
				   'DWC' => $insp->dept_wild_life['name'],
				   'DWC_PHONE' => $insp->dept_wild_life['phone'],
				   'FIRE_MARSHAL' => $insp->fire_marshal['name'],
				   'FIRE_MARSHAL_PHONE' => $insp->fire_marshal['phone'],
				   'HYPO' => $insp->state_police['name'],
				   'HYPO_PHONE' => $insp->state_police['phone'],
				   'ARMY' => 'Dont Have',
				   'ARMY_PHONE' => 'Dont Have',
				   'WRB' => $insp->water_resouce['name'],
				   'WRB_PHONE' => $insp->water_resouce['phone'],
				   'GATE_LOCK' => $fp['entrance_locked'],
				   'FIRE_DEPT' => $insp->fire_dept['name'],
				   'FIRE_ADDR_1' => $insp->fire_dept['addr_one'], 
				   'FIRE_ADDR_2' => $insp->fire_dept['addr_city'].", ".
						   $insp->fire_dept['addr_state']." ".
						   $insp->fire_dept['addr_zip'],
				   'FIRE_PHONE' => $insp->fire_dept['phone']
);
//
foreach($variables as $index => $value){
	//$insp->debug($index);
	//$insp->debug($value);
	$docx->replaceVariableByText(
		array($index => $value),
		array('parseLineBreaks'=>true));
}
//die();
//Prepared For
$company = array(
	'Company_Name' => $insp->Company_Name, 
	'Company_Address' => $insp->Company_Address, 
	'Company_City' => $insp->Company_City, 
	'Company_State' => $insp->Company_State,
	'Company_Zipcode' => $insp->Company_Zipcode, 
	'Company_Area_Code' => $insp->Company_Area_Code, 
	'Company_Prefix' => $insp->Company_Prefix, 
	'Company_Sufix' => $insp->Company_Sufix, 
	'Facility_Name' => $insp->Facility_Name, 
	'Facility_Type' => $fp['facility_type'], 
	'Legal_Desc' => $fp['legal_desc']
);
//Prepared For Table
development(
	$docx, 
	$development, 
	'PREPARED_FOR', 
	$spcc->prepared_for($company), 
	"html"
);
//Vessel Table
development(
	$docx, 
	$development, 
	'VESSEL_TABLE', 
	$spcc->vessel_table(
		$insp->Vessel, 
		$insp->Area
	), 
	"html"
);
//Area Statement
development(
	$docx, 
	$development, 
	'AREA_STATEMENT', 
	$spcc->area_statement(
		$insp->calc, 
		$insp->Area
	), 
	"html"
);
//Chemical Table
development($docx, 
			$development, 
			'CHEMICAL_TANK_TABLE', 
			$spcc->chemical_table(
				$insp->Chemical_Tank
			), 
			"html"
);
//Berm Calc Table
development(
		$docx, 
		$development, 
		'BERM_TABLE', 
		$spcc->berm_calc_table(
				$insp->Area, 
				$insp->Vessel,
				$insp->Catch_Basin,
				$insp->Object_Taking_Up_Space,
				$insp->calc
		), 
		"html"
);
//Vessel Inspection Table
development(
		$docx, 
		$development, 
		'TANK_INSPECTION_TABLE', 
		$spcc->vessel_inspection_table(
				$insp->Area, 
				$insp->Vessel,
				$insp->Catch_Basin,
				$insp->Object_Taking_Up_Space,
				$insp->calc
		), 
		"html"
);
/* Creaton of the actual Word Doc
 * _____________________________________________________________________________
 */
if (!$development){ 
    $docx->createDocxAndDownload('trash/SPCCSiteSpecific'); 
}else{
    echo'<br> This web page is for development. Set $development to false to generate a word doc. Next is Summary of Details That Need Immediate Attention...'; 
    
}
?>
