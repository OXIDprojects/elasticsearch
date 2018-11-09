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
    /*
     *
     */
    public function elasticclient()
    {
         $client = Elasticsearch\ClientBuilder::create()->build();
         return $client;
    }
 
    /*
     *
     */
    protected function GetModuleConfVar($var)
    {
        $allowedConf = [];

        if (in_array($var, $allowedConf)) {
            \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar($var, null, 'module:fabasicmodule');
        } else {
            return null;
        }
     }
 
    /*
     *
     */
    public function createarticleindex()
    {
         $client = self::elasticclient();
         $params = [
             'index' => self::GetModuleConfVar('oxcom_elasticsearch_article_index');
             'body'  => [
                 'settings' => [
                     'number_of_shards'   => self::GetModuleConfVar('oxcom_elasticsearch_article_shards');
                     'number_of_replicas' => self::GetModuleConfVar('oxcom_elasticsearch_article_replicas');
                 ]
             ]
         ];
         $response = $client->indices()->create($params);
         return $response;
    } 
 
    /*
     *
     */
    public function IndexArticle2Elasticsearch($oxid)
    {
         $client = self::elasticclient();
     
         $oxarticle = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);    
         $oxarticle->load($oxid);    
     
         $params = [
             'index' => self::GetModuleConfVar('oxcom_elasticsearch_article_index');
             'type'  => self::GetModuleConfVar('oxcom_elasticsearch_article_type');
             'id'    => $oxid
             'body'  => [
                 (array) $oxarticle
             ]
         ];
         $response = $client->index($params);
         return $response;
    } 
 
    /*
     *
     */
    public function SearchArticleFromElasticsearch($params)
    {
         // Performance
         if (!is_array($params)) {
             return null;
         }
     
         $client = self::elasticclient(); 
     
         $params = [
             'index' => self::GetModuleConfVar('oxcom_elasticsearch_article_index');
             'type'  => self::GetModuleConfVar('oxcom_elasticsearch_article_type');
             'body'  => [
                 'match' => [
                     $params;
                 ]
             ]
         ];
     
         $response = $client->search($params);
         return $response;
    }    
}
