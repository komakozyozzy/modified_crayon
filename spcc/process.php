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

$template->header(array('css'=>"include/css/process.css"));


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
          <!-- Equipment Box -->
          <fieldset>
            <legend>Select Model/ Equipment</legend>
            <table>
              <tr>
                <td><label for="name" >Select Company :  </label></td>
                <td>
                  <select  onchange="getProcessFacilities(this)"><?php print $function->getCompanies(); ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td><label for="name" >Select Facility :  </label></td>
                <td>
                  <select id="fac_select" onchange="getInspections(this)">
                  </select>
                </td>
              </tr>
              <tr>
                <td><label for="name" >Select Inspection :  </label></td>
                <td>
                  <select id="ins_select" parent="0" onchange="getXMLObj(this)">
                  </select>
                </td>
              </tr>
            </table>
          </fieldset>


          <!-- Equipment Box -->
          <div id="equip_box">
            <fieldset style="min-height:50px">
              <legend>Equipment Parent</legend>
            </fieldset>
            <fieldset>
              <legend>Equipment Selection Box</legend>
            </fieldset>
          </div>


          <!-- Equipment Box -->
          <div id="quest_box">
            <!-- This is the Equipment from -->
            <fieldset>
              <legend>Select Model/ Equipment</legend>
              <table id="question_table">
              </table>
            </fieldset>
          </div>

<?php
$template->footer();

?>
