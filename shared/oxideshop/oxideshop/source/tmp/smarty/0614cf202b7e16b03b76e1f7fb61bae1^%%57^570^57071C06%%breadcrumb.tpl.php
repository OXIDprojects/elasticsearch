<?php /* Smarty version 2.6.31, created on 2018-11-10 09:53:10
         compiled from widget/breadcrumb.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxmultilang', 'widget/breadcrumb.tpl', 8, false),array('modifier', 'escape', 'widget/breadcrumb.tpl', 12, false),)), $this); ?>

    <?php echo '<div class="row"><div class="col-xs-12"><ol id="breadcrumb" class="breadcrumb"><li class="text-muted">'; ?><?php echo smarty_function_oxmultilang(array('ident' => 'YOU_ARE_HERE'), $this);?><?php echo ':</li>'; ?><?php $_from = $this->_tpl_vars['oView']->getBreadCrumb(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['breadcrumb'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['breadcrumb']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['sCrum']):
        $this->_foreach['breadcrumb']['iteration']++;
?><?php echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"'; ?><?php if (($this->_foreach['breadcrumb']['iteration'] == $this->_foreach['breadcrumb']['total'])): ?><?php echo ' class="active"'; ?><?php endif; ?><?php echo '><a href="'; ?><?php if ($this->_tpl_vars['sCrum']['link']): ?><?php echo ''; ?><?php echo $this->_tpl_vars['sCrum']['link']; ?><?php echo ''; ?><?php else: ?><?php echo '#'; ?><?php endif; ?><?php echo '" title="'; ?><?php echo ((is_array($_tmp=$this->_tpl_vars['sCrum']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?><?php echo '" itemprop="url"><span itemprop="title">'; ?><?php echo $this->_tpl_vars['sCrum']['title']; ?><?php echo '</span></a></li>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</ol></div></div>'; ?>

