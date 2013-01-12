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

if(isset($_SESSION["logged"])):
  if ($_REQUEST['type'] == 'addFacility'):
    if ($_REQUEST['company_id'] > 0):
      foreach($_REQUEST['facility'] as $key => $value):
        if($_REQUEST['facility_id'][$key] == 0):
          $db->findOrInsert('t_facility', array('name' => $value,
                                                'company_id' => $_REQUEST['company_id']));
        else:
          $db->update('t_facility', array('name' =>$value,
                                          'company_id' => $_REQUEST['company_id']),
                      array('id' => $_REQUEST['facility_id'][$key]));
        endif;
      endforeach;
    endif;
  endif;

?>

            <!-- This is to add facilities -->
            <form method="post" accept-charset="UTF-8">
            <input type="hidden" name="type" id="type" value="addFacility">
              <fieldset >
              <legend>Create/Edit Equipement</legend>
              <table>
                <tr>
                  <td><label for="name" >Select Equipment:  </label></td>
                  <td><select id="company_id" name="company_id" onchange="getFacilities(this)" ><?php echo $function->getCompanies(); ?></select></td>
                </tr>
             </table>
              <table id="facTable">
                <tr>
                  <td><label for="name" >Add/Edit Facility:  </label></td>
                  <td><input name="facility[]" value="" /></td>
                  <td><input type="hidden" name="facility_id[]" value="0" /></td>
               </tr>
             </table>

              <input type="submit" name="addFacility" value="Submit" />
              <input type="button" onclick="addFacility()" value="Add" />
            </fieldset>
            </form>

<?php
endif;
$template->footer();
?>
