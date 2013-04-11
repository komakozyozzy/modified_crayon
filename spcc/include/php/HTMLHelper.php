<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HTMLHelper
 *
 * @author Intern Account
 */
class HTMLHelper {
    public function tag($type, $inner, $attr=null){
        $attributes = '';
        if ($attr){
            foreach($attr as $k => $v){
                $attributes .= $k.'="'.$v.'" '; 
            }
        }
        return "<$type $attributes>$inner</$type>";
    }
}

?>
