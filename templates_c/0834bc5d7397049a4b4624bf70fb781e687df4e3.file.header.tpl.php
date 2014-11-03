<?php /* Smarty version Smarty-3.1.18, created on 2014-10-01 10:01:36
         compiled from "presentation\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:402553fc7798a62de5-06906215%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0834bc5d7397049a4b4624bf70fb781e687df4e3' => 
    array (
      0 => 'presentation\\header.tpl',
      1 => 1412150494,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '402553fc7798a62de5-06906215',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_53fc7798b03060_06041920',
  'variables' => 
  array (
    'user' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_53fc7798b03060_06041920')) {function content_53fc7798b03060_06041920($_smarty_tpl) {?><?php if (!is_callable('smarty_block_authorized')) include 'E:\\Users\\claudio.papa\\Documents\\Development\\PHP\\avcp_communication\\lib\\Smarty\\frameworkplugins\\block.authorized.php';
if (!is_callable('smarty_function_urlarea')) include 'E:\\Users\\claudio.papa\\Documents\\Development\\PHP\\avcp_communication\\lib\\Smarty\\frameworkplugins\\function.urlarea.php';
if (!is_callable('smarty_block_ifarea')) include 'E:\\Users\\claudio.papa\\Documents\\Development\\PHP\\avcp_communication\\lib\\Smarty\\frameworkplugins\\block.ifarea.php';
?>	<!--[if lt IE 7]>
		<p class="chromeframe">State usando un browser <strong>datato</strong>.
		Per cortesia <a href="http://browsehappy.com/">aggiornate il vostro browser</a> oppure utilizzate Mozilla Firefox per rendere la vostra migliore la vostra esperienza di navigazione.</p>
	<![endif]-->
    <div id="container"><!-- [container] -->
        <div id="inside"> <!-- [inside] -->
	        <div id="header"><!-- [header] -->
				<div id="mini-top-bar">
					<div class="content-width">
						<div class="user_detail">
						<?php $_smarty_tpl->smarty->_tag_stack[] = array('authorized', array('roles'=>"notlogged")); $_block_repeat=true; echo smarty_block_authorized(array('roles'=>"notlogged"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

							<a class="smaller" title="Accedi all'area riservata" href="<?php echo smarty_function_urlarea(array('area'=>"login"),$_smarty_tpl);?>
">Accesso area riservata</a>
						<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_authorized(array('roles'=>"notlogged"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

						<?php $_smarty_tpl->smarty->_tag_stack[] = array('authorized', array('roles'=>"logged")); $_block_repeat=true; echo smarty_block_authorized(array('roles'=>"logged"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

						<div class="submenu">
							<?php echo htmlentities($_smarty_tpl->tpl_vars['user']->value->getDisplayName());?>

							<ul>
								<?php $_smarty_tpl->smarty->_tag_stack[] = array('ifarea', array('site-view'=>"reserved")); $_block_repeat=true; echo smarty_block_ifarea(array('site-view'=>"reserved"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

									<li><a class="smaller logout" href="<?php echo smarty_function_urlarea(array('area'=>"avcpman",'nonce'=>"true",'action'=>"logout"),$_smarty_tpl);?>
">Logout</a></li>
								<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_ifarea(array('site-view'=>"reserved"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

								<?php $_smarty_tpl->smarty->_tag_stack[] = array('ifarea', array('site-view'=>"general")); $_block_repeat=true; echo smarty_block_ifarea(array('site-view'=>"general"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

									<li><a class="smaller logout" href="<?php echo smarty_function_urlarea(array('area'=>"login",'nonce'=>"true",'action'=>"logout"),$_smarty_tpl);?>
">Logout</a></li>
								<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_ifarea(array('site-view'=>"general"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

							</ul>
						</div>
						<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_authorized(array('roles'=>"logged"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

						</div>
					</div>
				</div>
               <div class="content">
					<div class="content-width">
						<div id="h_logo">
							&nbsp;
							<img src="resources/css/images/Terracina-Logo.png" height=45 alt="Logo del Comnue di Terracina" />
						</div>
	                    <div id="h_stemma">
							<img src="resources/css/images/Terracina-Stemma-Desaturato.png" height=75 alt="Logo del Comnue di Terracina" />
						</div>
						
					</div>					
                </div>			
            </div><!-- [/header] -->
			<div id="menu_h" class="clear"><!-- [menu_h] -->
 				<?php echo $_smarty_tpl->getSubTemplate ("menu_h.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			</div> <!-- [menu_h] -->

<?php }} ?>
