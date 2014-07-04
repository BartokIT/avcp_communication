<?php
/**
 * Smarty plugin to format text blocks
 *
 * @package Smarty
 * @subpackage PluginsBlock
 */

/**
 * Smarty {textformat}{/textformat} block plugin
 *
 * Type:     block function<br>
 * Name:     textformat<br>
 * Purpose:  format text a certain way with preset styles
 *           or custom wrap/indent settings<br>
 * Params:
 * <pre>
 * - style         - string (email)
 * - indent        - integer (0)
 * - wrap          - integer (80)
 * - wrap_char     - string ("\n")
 * - indent_char   - string (" ")
 * - wrap_boundary - boolean (true)
 * </pre>
 *
 * @link http://www.smarty.net/manual/en/language.function.textformat.php {textformat}
 *       (Smarty online manual)
 * @param array                    $params   parameters
 * @param string                   $content  contents of the block
 * @param Smarty_Internal_Template $template template object
 * @param boolean                  &$repeat  repeat flag
 * @return string content re-formatted
 * @author Monte Ohrt <monte at ohrt dot com>
 */
function smarty_block_form($params, $content, $template, &$repeat)
{
    if (is_null($content)) {
        return;
    }
	$state = $template->tpl_vars['state']->value;
	$user = $template->tpl_vars['user']->value;
	$configuration = $template->tpl_vars['configuration']->value;
	$method = "post";
	$hiddens = array();
	//$area =$state->getArea();
	$action = $configuration->default_action;
	if (isset($params["method"]))
	{
		if ( (strcmp(strtolower($params["method"]),"post") == 0) ||
			(strcmp(strtolower($params["method"]),"get") == 0) )
		{
			$method =strtolower($params["method"]);
		}
	}
	
	if (isset($params["area"]))
	{
		$area=$params["area"];		
		$hiddens[] ='<input type="hidden" name="area" value="' .$area . '" />';
	}

	if (isset($params["action"]))
	{
		$action = $params["action"];
	}
	if (isset($params["parameters"]))
	{
		$params = $params["parameters"];
		if (is_array($params))
		{
			foreach ($params as $name=>$value)
			{
				$hiddens[] = '<input type="hidden" name="' . $name . '" value="' . $value . '" />';
			}
		}
		else
			$hiddens[]  ='<input type="hidden" name="parameter" value="' . $params["parameters"] . '" />';
	}
	
	$hiddens[] ='<input type="hidden" name="action" value="' .$action . '" />';
	
	$_output='<form method="'.$method.'" action="'.INDEX.'">';
	$_output .= "\n" . implode($hiddens,"\n") . "\n";
	$_output .= $content;
	$_output .= "</form>";
    return $_output;
}
