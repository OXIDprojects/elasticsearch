[{include file="bestitamazonpay4oxid_paybutton.tpl"}]
[{$smarty.block.parent}]
[{if $oViewConf->getActiveClassName() === 'user'}]
    [{include file="bestitamazonpay4oxid_paybutton.tpl"}]
[{/if}]