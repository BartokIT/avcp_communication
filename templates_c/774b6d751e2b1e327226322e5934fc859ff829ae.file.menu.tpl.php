<?php /* Smarty version Smarty-3.1.18, created on 2014-11-11 13:24:08
         compiled from "presentation\menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2134353fc7798c52f65-45172749%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '774b6d751e2b1e327226322e5934fc859ff829ae' => 
    array (
      0 => 'presentation\\menu.tpl',
      1 => 1415708011,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2134353fc7798c52f65-45172749',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_53fc7798cacce9_69202649',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53fc7798cacce9_69202649')) {function content_53fc7798cacce9_69202649($_smarty_tpl) {?><?php if (!is_callable('smarty_block_authorized')) include 'E:\\Users\\claudio.papa\\Documents\\Development\\PHP\\avcp_communication\\lib\\Smarty\\frameworkplugins\\block.authorized.php';
if (!is_callable('smarty_function_urlarea')) include 'E:\\Users\\claudio.papa\\Documents\\Development\\PHP\\avcp_communication\\lib\\Smarty\\frameworkplugins\\function.urlarea.php';
?><ul id="menu_v">
    <?php $_smarty_tpl->smarty->_tag_stack[] = array('authorized', array('roles'=>"administrator,publisher")); $_block_repeat=true; echo smarty_block_authorized(array('roles'=>"administrator,publisher"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    <li>
        <a href="<?php echo smarty_function_urlarea(array('area'=>"avcpman/pubblicazioni"),$_smarty_tpl);?>
">Pubblicazioni</a>
    </li>
    <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_authorized(array('roles'=>"administrator,publisher"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    <li>
        <a href="<?php echo smarty_function_urlarea(array('area'=>"avcpman/gare"),$_smarty_tpl);?>
">Gare</a>
    </li>
    <li>
        <a href="<?php echo smarty_function_urlarea(array('area'=>"avcpman/ditte"),$_smarty_tpl);?>
">Ditte</a>
    </li>
    <?php $_smarty_tpl->smarty->_tag_stack[] = array('authorized', array('roles'=>"administrator")); $_block_repeat=true; echo smarty_block_authorized(array('roles'=>"administrator"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    <li>
        <a href="<?php echo smarty_function_urlarea(array('area'=>"avcpman/impostazioni"),$_smarty_tpl);?>
">Impostazioni</a>
    </li>
    <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_authorized(array('roles'=>"administrator"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

</ul><?php }} ?>
