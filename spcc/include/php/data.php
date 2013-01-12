<?php

session_start();
include_once 'database.php';
include_once "config.php";

$data = $_POST;
//print_r($data);

$config = new Config();
$docRoot = $config->getDataPath();


if($data['type'] == 'login'){
    $db = new Database();

    $name = $_POST['username'];
    $pass = md5($_POST['password']);
    $query = $db->query("select count(*) as auth, type from t_user where name = '$name' and password = '$pass'");
    if($query[0]['auth'] == 1){
      $_SESSION['usertype'] = $query[0]['type'];
        $_SESSION["logged"] = $_POST["username"];
    }
        header("location:../../index.php");

}

if($data['type'] == 'createUser'){
    $db = new Database();
    if(isset($_POST['user_id'])){
        $db->update('t_user', array('name' => $_POST['username'],
                                    'type' => $_POST['usertype'],
                                    'password' => md5($_POST['password_one'])),
                    array('id' => $_POST['user_id']));
    } else {
        $db->insert('t_user', array('name' => $_POST['username'],
                                    'type' => $_POST['usertype'],
                                    'password' => md5($_POST['password_one'])));
    }
    header("location:../../index.php?key=0");

}
if($data['type'] == 'createCompany'){
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
        header("location:../../index.php?key=1");
    }
   if($data['type'] == 'getCompany'){
       $db = new Database();
       $id = $_POST['company_id'];

       $comp = $db->query("SELECT * FROM t_company
                           WHERE t_company.id = '".$id."'");

       $addr_one = $db->query("SELECT * from t_address
                               LEFT JOIN t_city on city_id = t_city.id
                               LEFT JOIN t_state on t_address.state_id = t_state.id
                               LEFT JOIN t_zipcode on zipcode_id = t_zipcode.id
                               WHERE t_address.id = '".$comp[0]['p_address_id']."'");

       $addr_two = $db->query("SELECT * from t_address
                               LEFT JOIN t_city on city_id = t_city.id
                               LEFT JOIN t_state on t_address.state_id = t_state.id
                               LEFT JOIN t_zipcode on zipcode_id = t_zipcode.id
                               WHERE t_address.id = '".$comp[0]['m_address_id']."'");

       $phone = $db->query("SELECT * from t_phone
                            WHERE id = '".$comp[0]['phone_id']."'");


       print json_encode(array('company'=>$comp[0],
                               'address_one' => $addr_one[0],
                               'address_two' => $addr_two[0],
                               'phone' => $phone[0]));

   }
   if($data['type'] == 'getUser'){
       $db = new Database();
       $comp = $db->query("SELECT * FROM t_user WHERE id = '".$_POST['user_id']."'");
       print json_encode(array('user'=>$comp[0]));

   }
   if($data['type'] == 'deleteUser'){
       $db = new Database();
       $comp = $db->query("DELETE FROM t_user WHERE id = '".$_POST['id']."'");
       print json_encode(array('result' => 'true'));

   }
   if($data['type'] == 'deleteAttribute'){
       $db = new Database();
       $comp = $db->query("DELETE FROM t_attribute WHERE id = '".$_POST['id']."'");
       print json_encode(array('result' => 'true'));

   }
   if($data['type'] == 'deleteEquipment'){
       $db = new Database();
       $comp = $db->query("DELETE FROM t_equipment WHERE id = '".$_POST['id']."'");
       print json_encode(array('result' => 'true'));

   }
   if($data['type'] == 'deleteCompany'){
       $db = new Database();
       $comp = $db->query("DELETE FROM t_company WHERE id = '".$_POST['id']."'");
       print json_encode(array('result' => 'true'));

   }
   if($data['type'] == 'deleteFacility'){
       $db = new Database();
       $comp = $db->query("DELETE FROM t_facility WHERE id = '".$_POST['id']."'");
       print json_encode(array('result' => 'true'));

   }
   if($data['type'] == 'createFacility'){
       $db = new Database();
       $ctr = 0;
       print_r($_POST);
       while(isset($_POST['name'.$ctr])){
         if(isset($_POST[$ctr])){
           //print $_POST['name'.$ctr]."ONE";
          $db->update('t_facility', array('name' => $_POST['name'.$ctr],
                                          'company_id' => $_POST['company_id']),
                      array('id' => $_POST[$ctr]));

         } else {
           //print $_POST['name'.$ctr]."TWO";
          $db->insert('t_facility', array('name' => $_POST['name'.$ctr],
                                         'company_id' => $_POST['company_id']));
         }
          $ctr += 1;

       }
       header("location:../../index.php?key=2");

   }
   if($data['type'] == 'getFacilities'){
       $db = new Database();

       $query = $db->query("SELECT id, name FROM t_facility WHERE company_id = '".$_POST['company_id']."'");
       $result = array();
       foreach($query as $q){
         $result[] = array('id' => $q['id'], 'name' => $q['name']);
       }
       print json_encode($result);
   }

   if($data['type'] == 'getImages'){
       $db = new Database();

       $query = $db->query("SELECT * FROM t_image WHERE facility_id = '".$_POST['id']."'");
       $result = array();
       foreach($query as $q){
         $result[] = array('id' => $q['id'], 'data_path' => $q['data_path']);
       }
       print json_encode($result);
   }


  if($data['type'] == 'uploadImage'){
       $db = new Database();
       $ctr = 0;
       //print_r($_FILES);
       //print_r($_POST);
       if($_POST['facility_id'] > 0 && $_POST['company_id'] > 0){

           $base_dir = "../data/";
           if(!is_dir($base_dir.$_POST['company_id'])){
             if(!mkdir($base_dir.$_POST['company_id'], 0777)){
               print "Could not make directory company\n";
               print $base_dir.$_POST['company_id'];
               // break;
             }
           }
           if(!is_dir($base_dir.$_POST['company_id']."/".$_POST['facility_id'])){
             if(!mkdir($base_dir.$_POST['company_id']."/".$_POST['facility_id'], 0777)){
               print "Could not make directory facility\n";
               print $base_dir.$_POST['company_id']."/".$_POST['facility_id'];
               //break;
             }
           }
           $move_path = $base_dir.$_POST['company_id']."/".$_POST['facility_id']."/";
           $url = "include/data/".$_POST['company_id']."/".$_POST['facility_id']."/";
           $cnt = 0;
           foreach($_FILES as $file){
             $file_name = time()."-".$cnt.".jpg";
             if(move_uploaded_file($file['tmp_name'], $move_path.$file_name)) {
               $id = $db->findOrInsert('t_image', array('facility_id' => $_POST['facility_id'],
                                                        'data_path' => $url.$file_name));
               if($id > 0){
                 $message = "The success";
               }
             } else{
               $message = "There was an error uploading the file, please try again!";
             }
             $cnt += 1;
             print $message;
         }
       }
       header("location:../../index.php?key=3");
  }
  if($data['type'] == 'getAttributes'):
       $db = new Database();
       $result = $db->query("SELECT id, name, type FROM t_attribute WHERE equipment_id = '".$data['id']."'");
       print json_encode($result);
  endif;
  if($data['type'] == 'getAttribute'):
       $db = new Database();
       $result = $db->query("SELECT * FROM t_attribute WHERE id = '".$data['id']."'");
       print json_encode($result[0]);
  endif;
  if($data['type'] == 'getOptions'):
       $db = new Database();
       $result = $db->query("SELECT id, text FROM t_option WHERE attribute_id = '".$data['id']."'");
       print json_encode($result);
  endif;
  if($data['type'] == 'deleteOption'):
       $db = new Database();
       $result = $db->query("delete FROM t_option WHERE id = '".$data['id']."'");
       print json_encode($result);
  endif;
  if($data['type'] == 'getEquipment'):
       $db = new Database();
       $result = $db->query("select id, name, parent  FROM t_equipment WHERE type = '".$data['model_type']."'");
       print json_encode($result);
  endif;
  if($data['type'] == 'getInspections'):
       $db = new Database();
       $result = $db->query("select data_path, timestamp  FROM t_inspection WHERE facility_id = '".$data['id']."'");
       print json_encode($result);
  endif;
  if($data['type'] == 'getXMLObj'){
       $db = new Database();
       $xml = simplexml_load_file($docRoot.$data['data_path']);
       $tmp = array();
       $rData = array();
       if($data['parent_id'] == 0){
           foreach($xml->equipment as $equip){
               $tmp[] = array('type' => ''.$equip['type'].'', 'id' => ''.$equip['id'].'');
           }
           $rData = array('child' => $tmp, 'parent' => array('id' => 0, 'type' => 'facility'), 'data_path' => $data['data_path']);
       } else {
         $xml = _getEquipId($xml, $data['parent_id']);
         foreach($xml->equipment as $equip){
           $tmp[] = array('type' => ''.$equip['type'].'', 'id' => ''.$equip['id'].'');
         }
         $rData = array('child' => $tmp, 'parent' => array('id' => ''.$xml['id'].'', 'type' => ''.$xml['type'].''), 'data_path' => $data['data_path']);

       }
       $results = $db->query("select *, attr.name as attr_name, attr.id as attr_id
                            from t_attribute as attr
                            inner join t_equipment as equip
                            on equip.id = attr.equipment_id
                            where equip.name = '".$rData['parent']['type']."'");
       $tmp = array();
       foreach($results as $result){
         $answer = null;
         $options = null;
         foreach($xml->property as $prop){
           if(''.$prop['name'].'' == $result['attr_name']){
             $answer = ''.$prop.'';
             $name = ''.$prop['name'].'';
           }
         }
         if($result['type'] != "text"){
           $res = $db->query("select * from t_option where attribute_id = ".$result['attr_id']."");
           $options = array();
           foreach($res as $r){
             $options[] = array('text' => $r['text']);
           }
         }
         $tmp[] = array('name' => $result['attr_name'], 'text' => $result['text'], 'answer' => $answer, 'options' => $options);
       }
       $rData['question'] = $tmp;
       print json_encode($rData);
  }
  if($data['type'] == 'updateXML' && $data['value'] != ''){
    $xml = simplexml_load_file($docRoot.$data['data_path']);
    $equip = array();
    if($data['id'] == 0){
      $equip[0] = $xml;
    } else {
      $equip = $xml->xpath("equipment[@id='".$data['id']."']");
    }
    $prop = $equip[0]->xpath("property[@name='".$data['name']."']");
    if(count($prop) == 0){
       $child = $equip[0]->addChild('property', $data['value']);
       $child->addAttribute('name', $data['name']);
    } else {
      $prop[0]->{0} = $data['value'];
    }
    $xml->saveXML($docRoot.$data['data_path']);
    print json_encode(array('result' => 'true'));
  }
function _getEquipId($xml, $id){
  $e = null;
  foreach($xml->equipment as $equip){
    if(''.$equip['id'].'' == $id){
      return $equip;
    } else {
      $e = _getEquipId($equip, $id);
      if ($e){
        return $e;
      }
    }
  }
  return null;
}

function createXML(){
  $db = new Database();

  $xml = '<?xml version="1.0"?><companies>';
  $c_qry = $db->query("SELECT id, name FROM t_company");
  foreach($c_qry as $cmp){
    $xml .= '<company id="'.$cmp['id'].'" name="'.$cmp['name'].'">';
    //Facility query
    $f_qry = $db->query("SELECT id, name FROM t_facility WHERE company_id = '".$cmp['id']."'");
    foreach($f_qry as $fac){
      $xml .= '<facility id="'.$fac['id'].'" name="'.$fac['name'].'"></facility>';
    }
    $xml .= "</company>";
  }
  $xml .= '</companies>';

  $db->update('t_config', array('value' => md5($xml)),
              array('type' => 'checkCompanies'));
  $db->update('t_config', array('blobb' => $xml),
              array('type' => 'getCompanies'));

  $qry = $db->query("SELECT blobb FROM t_config where type = 'getCompanies'");

}

createXML();
?>
