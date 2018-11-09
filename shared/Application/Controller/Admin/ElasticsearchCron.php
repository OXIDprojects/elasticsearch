<?php
namespace OxidCommunity\Elasticsearch\Application\Controller\Admin;
/**
 * Order class wrapper 
 */
 
class ElasticsearchCron extends \OxidEsales\Eshop\Application\Controller\Admin\AdminController
{
    protected $_sThisTemplate = "oxcom_elastic_status_cron_list.tpl";
    /*
     *
     */
    public function render()
    {
        parent::render();
        return $this->_sThisTemplate;
    }
 
}
