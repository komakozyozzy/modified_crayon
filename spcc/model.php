<?php
// Author: Nicholas Smith
session_start();


include_once 'include/php/functions.php';
include_once 'include/php/template.php';
include_once 'include/php/database.php';

$template = new Template();
$function = new Functions();
$db = new Database();
//$_SESSION['logged'] = '';
//$_SESSION['usertype'] = '';
if(empty($_SESSION['logged'])):
  $template->header();
  $template->login();
  $template->footer();
  die();
endif;

$template->header();

if(!empty($_REQUEST['type'])):
  if ($_REQUEST['type'] == 'CreateEquipment'):
    if ($_REQUEST['equip_id'] == 0):
      $db->findOrInsert('t_equipment', array('name' => $_REQUEST['equip_name'],
                                             'type' => $_REQUEST['model_type'],
                                             'parent' => $_REQUEST['parent_equip_id']));
    else:
      $db->update('t_equipment', array('name' => $_REQUEST['equip_name'],
                                       'type' => $_REQUEST['model_type'],
                                       'parent' => $_REQUEST['parent_equip_id']),
                  array('id' => $_REQUEST['equip_id']));
    endif;
  elseif($_REQUEST['type'] == 'CreateAttribute'):
    if ($_REQUEST['attr_id'] == 0):
      $db->findOrInsert('t_attribute', array('text' => $_REQUEST['attr_text'],
                                             'name' => $_REQUEST['attr_name'],
                                             'type' => $_REQUEST['attr_type'],
                                             'equipment_id' => $_REQUEST['equip_id']));
    else:
      $db->update('t_attribute', array('text' =>$_REQUEST['attr_text'],
                                       'name' => $_REQUEST['attr_name'],
                                       'type' => $_REQUEST['attr_type']),
                  array('id' => $_REQUEST['attr_id']));

    endif;
  elseif($_REQUEST['type'] == 'CreateOption'):
    foreach($_REQUEST['opt_text'] as $text):
      $db->findOrInsert('t_option', array('text' => $text,
                                         'attribute_id' => $_REQUEST['attr_id']));
    endforeach;
  endif;
endif;
?>
            <!-- This is the Equipment from -->
            <fieldset>
              <legend>Select Model/ Equipment</legend>
              <table>
                <tr>
                  <td><label for="name" >Select Model :  </label></td>
                  <td>
                    <select id="model_type" onchange="getEquipment(this)">
                        <option value=""></option>
                        <option value="processor">Processor</option>
                        <option value="inspector">Inspector</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="name" >Select Equipment :  </label></td>
                  <td><select id="equip_id" onchange="getAttributes(this)"></select></td>
                </tr>
              </table>
            </fieldset>

            <!-- This is the Equipment from -->
            <form method="post" accept-charset="UTF-8">
              <input type="hidden" name="type" value="CreateEquipment">
              <input type="hidden" name="equip_id" value="">
              <fieldset >
              <legend>Create/Edit Equipement</legend>
              <table>
                <tr>
                  <td><label for="name" >Select Parent Equipment :  </label></td>
                  <td><select id="parent_equip_id" name="parent_equip_id"></select></td>
                </tr>
                <tr>
                  <td><label for="name" >Select Model :  </label></td>
                  <td><select name="model_type" >
                        <option value=""></option>
                        <option value="processor">Processor</option>
                        <option value="inspector">Inspector</option>
                      </select>
                    </td>
                </tr>
                <tr>
                  <td><label for="name" >Edit/Add Equipment Name :  </label></td>
                  <td><input id="equip_name" name="equip_name" value=""/></td>
                </tr>
             </table>
              <input type="submit" name="CreateEquipment" value="Submit" />
              <input type="button" onclick="deleteEquipment()" value="Delete" />
            </fieldset>
            </form>

            <!-- Thi is the Attribute Form -->
            <form method="post" accept-charset="UTF-8">
              <input type="hidden" name="type" id="type" value="CreateAttribute">
              <input type="hidden" name="equip_id" value="" >
              <fieldset >
              <legend>Create/Edit Questions</legend>
              <table>
                <tr>
                  <td><label for="name" >Select Questions :  </label></td>
                  <td><select id="attr_id" name="attr_id" type="edit" onchange="getAttributeData(this)"></select></td>
                </tr>
                <tr>
                  <td><label for="name" >Edit/Add Quesiton Name (Unique name for the question):  </label></td>
                  <td><input id="attr_name" name="attr_name" value=""/></td>
                </tr>
                <tr>
                  <td><label for="name" >Edit/Add Question :  </label></td>
                  <td><input id="attr_text" name="attr_text" value=""/></td>
                </tr>
                <tr>
                  <td><label for="name" >Edit/Add Question Type :  </label></td>
                  <td>
                      <select id="attr_type" name="attr_type" />
                          <option value=""></option>
                          <option value="text">Text Box</option>
                          <option value="select">Select Box</option>
                         <!-- <option value="check">Check Box</option> -->
                          <option value="radio">Radio Button</option>
                      </select>
                  </td>
                </tr>
             </table>
              <input type="submit" name="CreateAttribute" value="Submit" />
              <input type="button" onclick="deleteAttribute()" value="Delete" />
            </fieldset>
            </form>

            <!-- This is the Option Form -->
            <form method="post" accept-charset="UTF-8">
            <input type="hidden" name="type" id="type" value="CreateOption">
              <fieldset >
              <legend>Create/Edit Options</legend>
              <table>
                <tr>
                  <td><label for="name" >Select Attribute :  </label></td>
                  <td><select name="attr_id" type="option" onchange="getOptions(this)"></select></td>
                </tr>
              </table>
              <table id="optionTable">
                <tr>
                  <td><label for="name" >Edit/Add Option Text :  </label></td>
                  <td><input id="opt_text" name="opt_text[]" value=""/></td>
                  <td></td>
                </tr>
             </table>
              <input type="submit" name="CreateOption" value="Submit" />
              <input type="button" onclick="addOption()" value="Add" />
            </fieldset>
            </form>

<?php

function _createXML($id){
  $db = new Database();
  $xml = '';

  $e_qry = $db->query("SELECT id, name, parent FROM t_equipment where id = '".$id."'");

  foreach($e_qry as $equip){
    //print "works";
    $xml = '<equipment type="'.$equip['name'].'" >'."\n";
    $a_qry = $db->query("SELECT id, name, text, type FROM t_attribute where equipment_id = '".$equip['id']."'");
    foreach($a_qry as $attr){
      $xml .= '<question type="'.$attr['type'].'" name="'.$attr['name'].'">'."\n";
      $xml .= '<text>'.$attr['text'].'</text>'."\n";
      $o_qry = $db->query("SELECT text FROM t_option where attribute_id = '".$attr['id']."'");
      foreach($o_qry as $option){
        $xml .= '<option>'.$option['text'].'</option>'."\n";
      }
      $xml .= '</question>'."\n";
    }
    $s_qry = $db->query("SELECT id FROM t_equipment where parent = '".$equip['id']."'");
    foreach($s_qry as $sub_equip){
      $xml .= _createXML($sub_equip['id']);
    }
    $xml .= "</equipment>"."\n";
  }
 return  $xml;
}

function createXML($type){
  $db = new Database();
  $data = array();
  $xml = '<?xml version="1.0"?>';
  //Get the head of the
  $head_query = $db->query("SELECT id, name FROM t_equipment where type = '".$type."' AND parent IS NULL");

  if (count($head_query) != 1){
    die("There seems to be more than one, if this problem persists contact the system admin.");
  } else {
    $head = $head_query[0];
  }
  $xml = "";
  $xml .= _createXML($head['id']);

  $db->update('t_config', array('blobb' => $xml),
              array('type' => 'getModel'));

}
/**
//ini_set("memory_limit","56M");
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="text.xml"');
echo createXML('inspector');
**/
createXML('inspector');
$template->footer();

?>
