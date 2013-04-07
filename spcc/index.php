<?php
session_start();

include_once 'include/php/template.php';
include_once "include/php/database.php";
include_once "include/php/klogger.php";
include_once "include/php/config.php";
include_once "include/php/inspection.php";
$insp = new Inspection(11);
$config = new Config();
$log = new KLogger($config->getLogSetting("log_path"),
                   $config->getLogSetting("severity"));
$db = new Database();
die();

$template = new Template();

if($_SESSION['logged'] == '' || empty($_SESSION['logged'])){
    $template->header();
    $template->login();
} else {

    switch ($_GET['key']) {
        case '0':
            if($_SESSION['usertype'] == 'admin'){
                $template->header();
                $template->createUser();
                $template->footer();
            }
            break;
        case '1':
            $template->createCompany();
            break;
        case '2':
            $template->createFacility();
            break;
        case '3':
            $template->header();
            $template->createImage();
            $template->footer();
            break;
        case '4':
            $template->createModel();
        break;
        case '5':
           $template->createProcess();
        break;
        case '6':
           $template->createSPCC();
        break;
        default:
         $template->header();
         $template->footer();

    }
}



?>
<script>

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel();
  });

$($('li')[gup( 'key' )]).addClass('current_page_item');
</script>