<?php
include_once "functions.php";
include_once "config.php";

class Template {

    function __construct() {
        $config = new Config();
        $this->url = $config->getTmpSetting("url");
        $this->index_url = $config->getTmpSetting("index");
        $this->base_url = $config->getTmpSetting("base");

    }

    function login() {
        echo '
            <form id="login" action="'.$this->url.'" method="post" accept-charset="UTF-8">
            <input type="hidden" name="type" id="type" value="login">
              <fieldset >
              <legend>Login</legend>
              <table>
                <tr>
                  <td><label for="name" >Username :  </label></td>
                  <td><input type="text" name="username" id="username"  maxlength="50" /></td>
                </tr>
                <tr>
                  <td><label for="password" >Password :  </label></td>
                  <td><input type="password" name="password" id="password_one"/></td>
                </tr>
              </table>
              <input type="submit" name="Submit" value="Submit" />
            </fieldset>
            </form>
        ';
    }
    function createProcess() {
      header("Location: ".$this->base_url."process.php");
        exit;
    }

    function createModel() {
      header("Location: ".$this->base_url."model.php");
        exit;
    }

    function createSPCC() {
        header("Location: ".$this->base_url."spcc.php");
        exit;
    }

    function createImage() {
        $fun = new Functions();
        echo '
            <form id="login" action="'.$this->url.'" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" id="type" value="uploadImage">
              <fieldset>
              <legend>Upload Image</legend>
              <table>
                <tr>
                  <td><label for="company" >Company :  </label></td>
                  <td><select id="company_id" name="company_id" onchange="getFacImage(this)">'.$fun->getCompanies().'</select></td>
                </tr>
                <tr>
                  <td><label for="password" >Facility :  </label></td>
                  <td><select id="facility_id" name="facility_id" onchange="getImages(this)"></select></td>
                </tr>
                <tr>
                  <td><label for="password" >Image :  </label></td>
                  <td id="image"><input type="file" id="image0" name="file0"></td>
                </tr>

              </table>
              <input type="submit" name="Submit" value="Submit" />
              <input type="button" value="Add" onclick="addImage()"/>
            </fieldset>
            <fieldset>
              <legend>View Image</legend>
              <div id="carousel"><ul id="mycarousel" class="jcarousel-skin-tango"></ul></div>

            </fieldset>

            </form>
        ';
    }


    function createFacility() {
        header("Location: ".$this->base_url."facility.php");
        exit;
    }


    function createCompany() {
        header("Location: ".$this->base_url."company.php");
        exit;
    }

    function createUser() {
        $fun = new Functions();
        echo '
              <fieldset >
              <legend>Modify a Username</legend>
              <table>
                <tr>
                  <td><label for="name" >Username :  </label></td>
                  <td><select onchange="changeUsers(this)">'.$fun->getUsers().'</select></td>
                </tr>
              </table>
            </fieldset>

            <form id="user" action="include/php/data.php" method="post" accept-charset="UTF-8">
            <input type="hidden" name="type" id="type" value="createUser">
              <fieldset >
              <legend>User</legend>
              <table>
                <tr>
                  <td><label for="name" >User Name :  </label></td>
                  <td><input type="text" name="username" id="username"  /></td>
                </tr>
                <tr>
                  <td><label for="name" >User Type :  </label></td>
                  <td>
                      <select  name="usertype" id="usertype">
                           <option value=""></option>
                           <option value="admin">Admin</option>
                           <option value="manager">Manager</option>
                           <option value="member">Member</option>
                     </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="password" >Password :  </label></td>
                  <td><input type="password" name="password_one" id="password_one" onblur="encode(this)"/></td>
                <tr>
                  <td><label for="password" >Confirm Password :  </label></td>
                  <td><input type="password" name="password_two" id="password_two" onblur="encode(this)"/></td>
                </tr>
              </table>
              <input type="submit" name="Submit" value="Submit" />
              <input type="button" value="Delete" onclick="deleteRecord(\'user\')">
            </fieldset>
            </form>

        ';
    }

    //current_page_item
    function header($include=null) {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
        echo '<html xmlns="http://www.w3.org/1999/xhtml">';
        echo '<head>';
        echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
        echo '<title>Scientific SPCC</title>';
        echo '<link href="http://fonts.googleapis.com/css?family=Oswald:400,300" rel="stylesheet" type="text/css" />';
        echo '<link href="http://fonts.googleapis.com/css?family=Abel|Satisfy" rel="stylesheet" type="text/css" />';
        echo '<link href="include/css/default.css" rel="stylesheet" type="text/css" media="all" />';
        echo '<link rel="stylesheet" type="text/css" href="include/css/tango/skin.css" />';
        echo '<!--[if IE 6]>';
        echo '<link href="default_ie6.css" rel="stylesheet" type="text/css" />';
        echo '<![endif]-->';

        if(isset($include['css'])){
          echo '<link href="'.$include['css'].'" rel="stylesheet" type="text/css" media="all" />';
        }
        echo '<script src="include/js/jquery-1.7.2.js"></script>';
        //echo '<script src="include/js/scientific.js"></script>';
        echo '<script src="include/js/Scientific.js"></script>';
        echo '<script type="text/javascript" src="include/js/jquery.jcarousel.min.js"></script>';
        echo '</head>';
        echo '    <body>';
        echo '        <div id="wrapper">';
        echo '            <div id="header-wrapper">';
        echo '                <div id="header">';
        echo '                    <div id="logo">';
        echo '                        <h1><a href="#">Scientific</a></h1>';
        echo '                    </div>';
        echo '                    <div id="menu">';
        echo '                        <ul>';
        echo '                            <li><a href="'.$this->index_url.'?key=0" accesskey="0" title="">Users</a></li>';
        echo '                            <li><a href="'.$this->index_url.'?key=1" accesskey="1" title="">Companies</a></li>';
        echo '                            <li><a href="'.$this->index_url.'?key=2" accesskey="2" title="">Facilities</a></li>';
        echo '                            <li><a href="'.$this->index_url.'?key=3" accesskey="3" title="">Images</a></li>';
        echo '                            <li><a href="'.$this->index_url.'?key=4" accesskey="4" title="">Inspection Model</a></li>';
        echo '                            <li><a href="'.$this->index_url.'?key=5" accesskey="5" title="">Process Plan</a></li>';
        echo '                            <li><a href="'.$this->index_url.'?key=6" accesskey="6" title="">SPCC</a></li>';
        echo '                       </ul>';
        echo '                   </div>';
        echo '               </div>';
        echo '           </div>';
        echo '       <!-- <div id="banner"><img src="images/header-img.jpg" width="1120" height="500" alt="" /></div> -->';
        echo '           <div id="page-wrapper">';
        echo '               <div id="page">';
        echo '                   <div id="wide-content">';
        echo '                       <div>';
    }

    function spccCSS() {
      echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
      echo '<html xmlns="http://www.w3.org/1999/xhtml">';
      echo '<head>';
      echo '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
      echo '<title>Scientific SPCC</title>';
      echo '<link href="http://fonts.googleapis.com/css?family=Oswald:400,300" rel="stylesheet" type="text/css" />';
      echo '<link href="http://fonts.googleapis.com/css?family=Abel|Satisfy" rel="stylesheet" type="text/css" />';
      echo '<link href="include/css/default.css" rel="stylesheet" type="text/css" media="all" />';
      echo '<link rel="stylesheet" type="text/css" href="include/css/tango/skin.css" />';
      echo '<!--[if IE 6]>';
      echo '<link href="default_ie6.css" rel="stylesheet" type="text/css" />';
      echo '<![endif]-->';
      echo '<script src="include/js/jquery-1.7.2.js"></script>';
      echo '<script src="include/js/scientific.js"></script>';
      echo '<script type="text/javascript" src="include/js/jquery.jcarousel.min.js"></script>';
      echo '</head>';
      echo '    <body>';
      echo '        <div id="wrapper">';
      echo '            <div id="header-wrapper">';
      echo '                <div id="header">';
      echo '                    <div id="logo">';
      echo '                        <h1><a href="#">Scientific</a></h1>';
      echo '                    </div>';
      echo '                    <div id="menu">';
      echo '                        <ul>';
      echo '                            <li><a href="'.$this->index_url.'?key=0" accesskey="0" title="">Users</a></li>';
      echo '                            <li><a href="'.$this->index_url.'?key=1" accesskey="1" title="">Companies</a></li>';
      echo '                            <li><a href="'.$this->index_url.'?key=2" accesskey="2" title="">Facilities</a></li>';
      echo '                            <li><a href="'.$this->index_url.'?key=3" accesskey="3" title="">Images</a></li>';
      echo '                            <li><a href="'.$this->index_url.'?key=4" accesskey="4" title="">Inspection Model</a></li>';
      echo '                            <li><a href="'.$this->index_url.'?key=5" accesskey="5" title="">Process Plan</a></li>';
      echo '                            <li><a href="'.$this->index_url.'?key=6" accesskey="6" title="">SPCC</a></li>';
      echo '                       </ul>';
      echo '                   </div>';
      echo '               </div>';
      echo '           </div>';
      echo '       <!-- <div id="banner"><img src="images/header-img.jpg" width="1120" height="500" alt="" /></div> -->';
      echo '           <div id="page-wrapper">';
      echo '               <div id="page">';
      echo '                   <div id="wide-content">';
      echo '                       <div>';
    }


    function footer() {
        echo '                            </div>';
        echo '                        </div>';
        echo '                    </div>';
        echo '                </div>';
        echo '            <div id="footer">';
        echo '            <p></p>';
        echo '            </div>';
        echo '        </div>';
        echo '    </body>';
        echo '</html>';
    }

}

?>
