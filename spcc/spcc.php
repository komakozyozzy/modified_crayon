<?php
session_start();

include_once 'include/php/functions.php';
include_once 'include/php/template.php';
include_once 'include/php/database.php';

$template = new Template();
//$_SESSION['logged'] = '';
//$_SESSION['usertype'] = '';
if(empty($_SESSION['logged'])):
  $template->header();
  $template->login();
  $template->footer();
  die();
endif;
$template->spccCSS();

function getFacilities($searchParams, $dbconn){
    $db = new Database();
    $companyID = $searchParams['company'];
    $sql = "SELECT t_company.name, t_facility.name as fname, t_facility.id, t_company.id as cid FROM t_facility
                CROSS JOIN t_company ON t_company.id = t_facility.company_id WHERE company_id = '".$companyID."'";
    $facilities = $db->query($sql);
    return $facilities;
}
?>

<link type="text/css" rel="stylesheet" media="all" href="include/css/tango/default.css" />
<link type="text/css" rel="stylesheet" media="all" href="include/css/tablesorter/style.css" />
<?php
 $fun = new Functions();
?>
            <form method="post" accept-charset="UTF-8">
            <input type="hidden" name="type" id="type" value="CreateSPCC">
              <fieldset >
              <legend>Choose Facility</legend>
              <table>
                <tr>
                  <td><label for="name" >Company Name :  </label></td>
                  <td><select name = "company" ><?php echo $fun->getCompanies() ?></select></td>
                  <td></td>
                </tr>
                <tr>
                  <td><label for="name" >Facility Name :  </label></td>
                  <td><select name = "facility" ></select></td>
                  <td></td>
                </tr>
             </table>
              <input type="submit" name="CreateSPCC" value="Submit" />

            </fieldset>
            </form>
    <?php

        if ($_REQUEST['CreateSPCC']):
         // echo '<pre>'; print_r($_REQUEST);
          $searchParams = array('company' => $_REQUEST['company']);
          //echo '<pre>'; print_r($searchParams);
          $facilities = getFacilities($searchParams, $dbconn);
          //echo '<pre>'; print_r($facilities);?>

          <table class='tablesorter docx'>
                                    <thead>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>Facility Name</th>
                                            <th>Reference ID</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach($facilities as $eachFAC => $thisFAC): ?>
                                        <?php $ref = $thisFAC['id'];?>
                                        <tr title='docx' alt='<?php echo $ref ?>'>
                                            <!-- Need a check to see if anything is actually here -->
                                            <td><?php echo $thisFAC['name']; ?></td>
                                            <td><?php echo $thisFAC['fname']; ?></td>
                                            <td alt='docx'><?php echo $ref; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody><?php
        endif;
?>
<script src="include/js/jquery.1.7.2.js"></script>
<script src="include/js/jquery.tablesorter.js"></script>
<script src="include/js/jquery.tablesorter.pager.js"></script>
<script src="include/js/jquery.tablesorter.widgets.js"></script>
<script src="include/js/jquery-ui-1.8.17.custom.min.js"></script>
<script src="include/js/spcc.js"></script>