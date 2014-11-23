<?php
session_start();

include_once 'include/php/functions.php';
include_once 'include/php/template.php';
include_once 'include/php/database.php';

$template = new Template();
$function = new Functions();

if(empty($_SESSION['logged'])):
  $template->header();
  $template->login();
  $template->footer();
  die();
endif;

$template->header(array('css'=>"include/css/process.css"));

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
				  <select id="ins_select" parent="0" onchange="getSPCC(this)">
                  </select>
                </td>
              </tr>
            </table>
          </fieldset>


<?php
$template->footer();

?>

