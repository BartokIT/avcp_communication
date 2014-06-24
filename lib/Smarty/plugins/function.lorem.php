<?php 
/* 
 * Smarty plugin 
 * ------------------------------------------------------------- 
 * File:     function.lorem.php 
 * Type:     function 
 * Name:     lorem 
 * Author:   Monte Ohrt 
 * Date:     Jan 16th, 2010 
 * Purpose:  outputs lorem ipsum text 
 * ------------------------------------------------------------- 
 */ 
function smarty_function_lorem($params, &$smarty) 
{ 
    $length = isset($params['length']) ? (int)$params['length'] : 446; 
    $p_tags = isset($params['p_tags']) ? (bool)$params['p_tags'] : true; 

    $repeat = $length <= 446 ? 1 : ceil(($length/446)); 

    $lorem_text = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n"; 

    $lorem_text =  substr(str_repeat($lorem_text,$repeat),0,$length); 

    if($p_tags) { 
      $lorem_text =  preg_replace(array('!^!','!\n!','!$!'),array('<p>',"</p>\n<p>","</p>\n"),$lorem_text); 
    } 

    return $lorem_text; 

} 
?> 