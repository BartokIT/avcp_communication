<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {counter} function plugin
 *
 * Type:     function<br>
 * Name:     counter<br>
 * Purpose:  print out a counter value
 *
 * @author Shadow Silver<monte at ohrt dot com>
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_urlarea($params, $template)
{
    $link ="?";
	$counter=0;
	$state = $template->tpl_vars['state']->value;
	if (isset($params['area']))
	{
		$link .= "area=" . urlencode($params['area']);
		$counter++;
	}
	else
	{
		$link .= "area=" . urlencode($state->toString());
		$counter++;
	}
	
	if (isset($params['action']))
	{
		if ($counter > 0 ) { $link .="&";};
		$link .= "action=" . urlencode($params['action']);
		$counter++;
	}
	
    return $link;

}
