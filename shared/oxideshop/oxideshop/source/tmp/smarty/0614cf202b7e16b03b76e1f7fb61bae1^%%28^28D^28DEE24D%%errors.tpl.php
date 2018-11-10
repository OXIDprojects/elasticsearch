<?php /* Smarty version 2.6.31, created on 2018-11-10 09:52:27
         compiled from message/errors.tpl */ ?>
<?php if (count ( $this->_tpl_vars['Errors']['default'] ) > 0): ?>
    <?php $_from = $this->_tpl_vars['Errors']['default']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['oEr']):
?>
        <p class="alert alert-danger"><?php echo $this->_tpl_vars['oEr']->getOxMessage(); ?>
</p>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
<?php if (count ( $this->_tpl_vars['Errors']['popup'] ) > 0): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "message/errors_modal.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>