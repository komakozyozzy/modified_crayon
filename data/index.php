<?php
include('include/database.php');
//FieldInspDB
//shDke6Gf#

$db = new Database();
/**
  $im = file_get_contents('include/icon/minus.gif');
  header('content-type: image/gif');
  echo $im;
**/
//This is to clean the variables agianst sql injection
foreach ($_POST as $var) {
    $type = ereg_replace("[^A-Za-z0-9]", "", $var);
}
//print_r($_POST);
if (!empty($_POST['type'])) {
    switch ($_POST['type']) {
        case "login":
            if (login($_POST['user'], $_POST['pass'])) {
                print "true";
            }

            break;
        case "checkCompanies":
            if (login($_POST['user'], $_POST['pass'])) {
                $result = $db->query("select value from t_config where type = '$type'");
                print $result[0]['value'];
            }
            break;

        case "checkConnection":
            print "true";
            break;

        case "getCompanies":
            if (login($_POST['user'], $_POST['pass'])) {
                $result = $db->query("select blobb from t_config where type = 'getCompanies'");
                if (!empty($result[0]['blobb'])) {
                    print $result[0]['blobb'];
                }
            }
            break;
        case "getModel":
            if (login($_POST['user'], $_POST['pass'])) {
                $result = $db->query("select blobb from t_config where type = 'getModel'");
                if (!empty($result[0]['blobb'])) {
                    print $result[0]['blobb'];
                }
            }
            break;

       case "getIcon":
         //if (login($_POST['user'], $_POST['pass'])) {
           $im = file_get_contents('include/icon/'.$_POST['name']);
           header('content-type: image/gif');
           echo $im;
           //echo $_POST['name'];
           //}
         break;

        case "uploadFile":
          //print_r($_FILES);
          $base_dir = "include/data/";
          if(!is_dir($base_dir.$_POST['company_id'])){
            if(!mkdir($base_dir.$_POST['company_id'], 0777)){
              print "Could not make directory company";
              // break;
            }
          }
          if(!is_dir($base_dir.$_POST['company_id']."/".$_POST['facility_id'])){
            if(!mkdir($base_dir.$_POST['company_id']."/".$_POST['facility_id'], 0777)){
              print "Could not make directory facility";
              //break;
            }
          }
          $full_path = $base_dir.$_POST['company_id']."/".$_POST['facility_id']."/".$_FILES['bin']['name'];

          if(move_uploaded_file($_FILES['bin']['tmp_name'], $full_path)) {
            $db = new Database();
            $id = $db->findOrInsert('t_inspection', array('facility_id' => $_POST['facility_id'],
                                               'data_path' => $full_path));
            if($id > 0){
              $message = "success";
            }
          } else{
            $message = "There was an error uploading the file, please try again!";
          }
          print $message;

          break;
    }
}

function login($user, $pass) {
    $db = new Database();
    $result = $db->query("select password from t_user where name = '$user'");
    if ($pass === $result[0]['password']) {
        return true;
    }
}

/**
print;
if ($_POST['type'] == "getCompanies") {
    header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
    header("Cache-Control: public"); // needed for i.e.
    header("Content-Type: xml");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length:" . filesize($attachment_location));
    header("Content-Disposition: attachment; filename=test.xml");
    readfile("test.xml");
} else if($_POST['type'] == "checkConnection"){
    print "true";
} else if($_POST['type'] == "checkCompanies"){
    print "a46fd9035eebe4d422dfef5681d5d148";
}
 * **/

?>
