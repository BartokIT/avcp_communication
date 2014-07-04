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
function smarty_block_ifarea($params, $content, $template, &$repeat)
{
    if (is_null($content)) {
        return;
    }
	
	$state = $template->tpl_vars['state']->value;
	$_output="";
	
	if (isset($params["value"]))
	{
		if ($state->getArea() == $params["value"])
			$_output .= $content;
	}
    return $_output;
}
