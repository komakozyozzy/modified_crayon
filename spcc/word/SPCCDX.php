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


$docx = new CreateDocx();
$spcc = new spp_docx_template();
$docx->addTemplate('templates/SPCC.docx');
$test = $spcc->test();
$docx->addTemplateVariable('TEST',$test, 'html');


$docx->createDocx('templates/SPCC_2'); 

// http://localhost/git/modified_crayon/spcc/word/SPCCDX.php



// Create a new PHPWord Object
//$PHPWord = new PHPWord();
//$section = $PHPWord->createSection();

//$styleTable = array('borderColor'=>'000000',
//			  'borderSize'=>6,
//			  'cellMargin'=>50);
//$styleFirstRow = array('bgColor'=>'66BBaa');
//$PHPWord->addTableStyle('myTable', $styleTable, $styleFirstRow);
//
//$table = $section->addTable('myTable');
//
//$table->addRow(500);
//$table->addCell(3000)->addText('Cell 1');
//$table->addCell(3000)->addText('Cell 2');
//$table->addCell(2000)->addText('Cell 3');
//$table->addRow(500);
//
//$table->addCell(4000)->addText('Cell 5');
//$table->addCell(4000)->addText('Cell 6');
//


// At least write the document to webspace:

/**
// After creating a section, you can append elements:
$section->addText('Hello world!');

// You can directly style your text by giving the addText function an array:
$section->addText('Hello world! I am formatted.', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));

// If you often need the same style again you can create a user defined style to the word document
// and give the addText function the name of the style:
$PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
$section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');

$section = $PHPWord->createSection();
// You can also putthe appended element to local object an call functions like this:
$myTextElement = $section->addText('Hello World!');
//$myTextElement->setBold();
//$myTextElement->setName('Verdana');
//$myTextElement->setSize(22);
**/



//
//$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
//$objWriter->save('templates/SPCC.docx');

?>
