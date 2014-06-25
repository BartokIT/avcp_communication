<?php /* Smarty version Smarty-3.1.18, created on 2014-06-24 16:28:35
         compiled from "presentation\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2123053a98b13678456-64601457%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd64857fb5c613ff12fc26b6b2b0448a2b0be3065' => 
    array (
      0 => 'presentation\\index.tpl',
      1 => 1403616438,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2123053a98b13678456-64601457',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_53a98b13728111_50044122',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53a98b13728111_50044122')) {function content_53a98b13728111_50044122($_smarty_tpl) {?><?php if (!is_callable('smarty_function_urlarea')) include 'E:\\Users\\claudio.papa\\Documents\\Development\\PHP\\avcp_communication\\lib\\Smarty\\plugins\\function.urlarea.php';
if (!is_callable('smarty_block_authorized')) include 'E:\\Users\\claudio.papa\\Documents\\Development\\PHP\\avcp_communication\\lib\\Smarty\\plugins\\block.authorized.php';
if (!is_callable('smarty_function_lorem')) include 'E:\\Users\\claudio.papa\\Documents\\Development\\PHP\\avcp_communication\\lib\\Smarty\\plugins\\function.lorem.php';
?><html>
    <head>
    <title>Comunicazioni AVCP</title> 
    </head>
    <body>
        <?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <?php echo $_smarty_tpl->getSubTemplate ("menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <h1>Smarty Template</h1>
        <p>
           <?php echo $_smarty_tpl->tpl_vars['user']->value->getDisplayName();?>
 <br/>
           <?php echo smarty_function_urlarea(array('action'=>"delete"),$_smarty_tpl);?>

           
        </p>
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('authorized', array('roles'=>"reader")); $_block_repeat=true; echo smarty_block_authorized(array('roles'=>"reader"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

            <p>
                <?php echo smarty_function_lorem(array(),$_smarty_tpl);?>

            </p>
        <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_authorized(array('roles'=>"reader"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

        <?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    </body>
</html><?php }} ?>
