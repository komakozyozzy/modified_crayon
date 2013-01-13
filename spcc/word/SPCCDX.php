<?php
include_once "PHPWord.php";
include_once "../include/php/inspection.php";
include_once "../include/php/word_template.php";
/**

$data = new XMLData(11);
print "<pre>";
print_r($data->getEquip("Area"));
print "</pre>";
**/

// Create a new PHPWord Object
$PHPWord = new PHPWord();
$spccTemplate = new SPCCTemplate();


$section = $PHPWord->createSection();

$spccTemplate->createTable($section, array(array('cell one', 'cell_two', 'cell three', 'cell four'),
                                           array('cell five', 'cell six', 'cell seven')));



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




$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('templates/helloWorldtwo.docx');

?>
