<?php
session_start();

include_once 'include/php/template.php';

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