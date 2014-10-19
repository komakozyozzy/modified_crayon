<?php
// Author: Nicholas Smith
session_start();


include_once 'include/php/functions.php';
include_once 'include/php/template.php';
include_once 'include/php/database.php';

$template = new Template();
$function = new Functions();
$db = new Database();

if(empty($_SESSION['logged'])){
    $template->header();
    $template->login();
    $template->footer();
    die();
}

$template->header();

if(isset($_POST['type'])){
  if($_POST['type'] == 'createCompany'){
    $db = new Database();

    $name = $_POST['name'];
    $phone_area = $_POST['phone_area'];
    $phone_pre = $_POST['phone_pre'];
    $phone_post = $_POST['phone_post'];
    $phone_ext = $_POST['phone_ext'];
    $address_data = array('physical' => array('address_one' => $_POST['p_address_one'],
                                              'address_two' => $_POST['p_address_two'],
                                              'city' => $_POST['p_city'],
                                              'state' => $_POST['p_state'],
                                              'zipcode_prefix' => $_POST['p_zipcode_prefix'],
                                              'zipcode_sufix' => $_POST['p_zipcode_sufix']),
                          'mailing' => array('address_one' => $_POST['m_address_one'],
                                             'address_two' => $_POST['m_address_two'],
                                             'city' => $_POST['m_city'],
                                             'state' => $_POST['m_state'],
                                             'zipcode_prefix' => $_POST['m_zipcode_prefix'],
                                             'zipcode_sufix' => $_POST['m_zipcode_sufix']));

    $phone_id = $db->findOrInsert('t_phone', array('area_code' => $phone_area,
                                                   'prefix' => $phone_pre,
                                                   'sufix' => $phone_post,
                                                   'ext' => $phone_ext,));
    $adr_arry = array();
    foreach ($address_data as $typ => $adr) {
      $qst = $db->query("select id from t_state where " .
                        ((strlen($adr['state']) == 2) ? 'abbr' : 'state') . ' = "' . $adr['state'] . '"');
      $state_id = $qst[0]['id'];

      $city_id = $db->findOrInsert('t_city', array('state_id' => $state_id,
                                                   'city' => $adr['city']));

      $zipcode_id = $db->findOrInsert('t_zipcode', array('zipcode' => $adr['zipcode_prefix'],
                                                         'sufix'=>$adr['zipcode_sufix']));

      $adr_arry[$typ] = $db->insert('t_address', array('address_1'=>$adr['address_one'],
                                                       'address_2'=>$adr['address_two'],
                                                       'city_id'=>$city_id,
                                                       'state_id'=>$state_id,
                                                       'zipcode_id'=>$zipcode_id,));

    }
    if (empty($_POST['company_id'])) {
      $db->insert('t_company', array('name' => $name,
                                     'phone_id' => $phone_id,
                                     'p_address_id' => $adr_arry['physical'],
                                     'm_address_id' => $adr_arry['mailing']));
    } else {
          $db->update('t_company', array('name' => $name,
                                         'phone_id' => $phone_id,
                                         'p_address_id' => $adr_arry['physical'],
                                         'm_address_id' => $adr_arry['mailing']),
                      array('id' => $_POST['company_id']));
    }
  }
}

?>
    <fieldset >
      <legend>Modify a Company</legend>
      <table>
        <tr>
          <td><label for="name" >Company Name :  </label></td>
		  <td><select onchange="changeCompanies(this)"> <?php print $function->getCompanies(); ?> </select></td>
        </tr>
      </table>
    </fieldset>
    </br>
    <form id="company" method="post" accept-charset="UTF-8">
      <input type="hidden" name="type" id="type" value="createCompany">
      <fieldset >
      <legend>Create a Company</legend>
      <table>
        <tr>
          <td><label for="name" >Company Name :  </label></td>
          <td><input type="text" name="name" id="name"  maxlength="50" /></td>
        </tr>
        <tr>
          <td><label for="address_one" >Phone Number :  </label></td>
          <td>
            <input type="text" name="phone_area" id="phone_area"  style="width:40px" />
            <input type="text" name="phone_pre" id="phone_pre"  style="width:50px" />
            <input type="text" name="phone_post" id="phone_post"  style="width:40px" />
            <input type="text" name="phone_ext" id="phone_ext"  style="width:40px" />
          </td>
        </tr>
      </table>

        <fieldset >
          <legend>Physical Address</legend>
          <table>
            <tr>
              <td><label for="p_address_one" >Address One :  </label></td>
              <td><input type="text" name="p_address_one" id="p_address_one"  maxlength="50" /></td>
            </tr>
            <tr>
              <td><label for="p_address_two" >Address Two :  </label></td>
              <td><input type="text" name="p_address_two" id="p_address_two" /></td>
            <tr>
              <td><label for="p_city" >City :  </label></td>
              <td><input type="text" name="p_city" id="p_city" /></td>
            </tr>
            <tr>
              <td><label for="p_state" >State :  </label></td>
              <td><input type="text" name="p_state" id="p_state" /></td>
            </tr>
            <tr>
              <td><label for="p_zipcode" >Zipcode :  </label></td>
              <td>
                <input type="text" name="p_zipcode_prefix" id="p_zipcode_prefix" style="width:60px"/>
                <input type="text" name="p_zipcode_sufix" id="p_zipcode_sufix" style="width:40px"/>
              </td>
            </tr>
          </table>
        </fieldset>
        <fieldset >
          <legend>Mailing Address</legend>
          <table>
            <tr>
              <td><label for="m_address_one" >Address One :  </label></td>
              <td><input type="text" name="m_address_one" id="m_address_one"  maxlength="50" /></td>
            </tr>
            <tr>
              <td><label for="m_address_two" >Address Two :  </label></td>
              <td><input type="text" name="m_address_two" id="m_address_two" /></td>
            <tr>
              <td><label for="m_city" >City :  </label></td>
              <td><input type="text" name="m_city" id="m_city" /></td>
            </tr>
            <tr>
              <td><label for="m_state" >State :  </label></td>
              <td><input type="text" name="m_state" id="m_state" /></td>
            </tr>
            <tr>
              <td><label for="m_zipcode" >Zipcode :  </label></td>
              <td>
                <input type="text" name="m_zipcode_prefix" id="m_zipcode_prefix" style="width:60px"/>
                <input type="text" name="m_zipcode_sufix" id="m_zipcode_sufix" style="width:40px"/>
              </td>
            </tr>
          </table>
        </fieldset>
        <input type="submit" name="Submit" value="Submit" />
        <input type="button" value="Delete" onclick="deleteRecord(\'company\')">
      </fieldset>
    </form>

<?php
      $template->footer();
?>
