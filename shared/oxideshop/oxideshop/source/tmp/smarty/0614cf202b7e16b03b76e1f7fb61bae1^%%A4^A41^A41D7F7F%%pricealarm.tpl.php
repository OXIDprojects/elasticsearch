<?php /* Smarty version 2.6.31, created on 2018-11-10 09:53:09
         compiled from form/pricealarm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'oxscript', 'form/pricealarm.tpl', 1, false),array('function', 'oxmultilang', 'form/pricealarm.tpl', 5, false),array('block', 'oxhasrights', 'form/pricealarm.tpl', 19, false),)), $this); ?>
<?php echo smarty_function_oxscript(array('include' => "js/libs/jqBootstrapValidation.min.js",'priority' => 10), $this);?>

<?php echo smarty_function_oxscript(array('add' => "$('input,select,textarea').not('[type=submit]').jqBootstrapValidation();"), $this);?>


<?php $this->assign('currency', $this->_tpl_vars['oView']->getActCurrency()); ?>
<p class="alert alert-info"><?php echo smarty_function_oxmultilang(array('ident' => 'MESSAGE_PRICE_ALARM_PRICE_CHANGE'), $this);?>
</p>
<form class="js-oxValidate form-horizontal" name="pricealarm" action="<?php echo $this->_tpl_vars['oViewConf']->getSelfActionLink(); ?>
" method="post" novalidate="novalidate">
    <div>
        <?php echo $this->_tpl_vars['oViewConf']->getHiddenSid(); ?>

        <?php echo $this->_tpl_vars['oViewConf']->getNavFormParams(); ?>

        <input type="hidden" name="cl" value="<?php echo $this->_tpl_vars['oViewConf']->getTopActiveClassName(); ?>
">
        <?php if ($this->_tpl_vars['oDetailsProduct']): ?>
            <input type="hidden" name="anid" value="<?php echo $this->_tpl_vars['oDetailsProduct']->oxarticles__oxid->value; ?>
">
        <?php endif; ?>
        <input type="hidden" name="fnc" value="addme">
    </div>
    <div class="form-group">
        <label class="req control-label col-lg-3"><?php echo smarty_function_oxmultilang(array('ident' => 'YOUR_PRICE'), $this);?>
 (<?php echo $this->_tpl_vars['currency']->sign; ?>
):</label>
        <div class="col-lg-9">
            <input class="form-control" type="text" name="pa[price]" value="<?php $this->_tag_stack[] = array('oxhasrights', array('ident' => 'SHOWARTICLEPRICE')); $_block_repeat=true;smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php if ($this->_tpl_vars['product']): ?><?php echo $this->_tpl_vars['product']->getFPrice(); ?>
<?php endif; ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_oxhasrights($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>" maxlength="32" required="required">
            <div class="help-block"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="req control-label col-lg-3"><?php echo smarty_function_oxmultilang(array('ident' => 'EMAIL'), $this);?>
:</label>
        <div class="col-lg-9">
            <input class="form-control" type="email" name="pa[email]" value="<?php if ($this->_tpl_vars['oxcmp_user']): ?><?php echo $this->_tpl_vars['oxcmp_user']->oxuser__oxusername->value; ?>
<?php endif; ?>" maxlength="128" required="required">
            <div class="help-block"></div>
        </div>
    </div>

    

    <div class="form-group">
        <div class="col-lg-9 col-lg-offset-3">
            <button class="submitButton btn btn-primary" type="submit"><?php echo smarty_function_oxmultilang(array('ident' => 'SEND'), $this);?>
</button>
        </div>
    </div>
</form>