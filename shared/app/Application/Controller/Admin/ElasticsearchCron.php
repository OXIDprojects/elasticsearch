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
        $oViewConf = oxNew(\OxidEsales\Eshop\Core\ViewConfig::class);
        $this->_aViewData["sModuleUrl"] = $oViewConf->getModuleUrl('oxcom/elasticsearch');
        return $this->_sThisTemplate;
    }
    /*
     *
     */
    public function elasticclient()
    {
        $oViewConf = oxNew(\OxidEsales\Eshop\Core\ViewConfig::class);
        $sPath = $oViewConf->getModuleUrl('oxcom/elasticsearch');
     
        $sLogValue = self::GetModuleConfVar('oxcom_elasticsearch_article_loglevel');
     
        $retry = self::GetModuleConfVar('');
        $logger = ClientBuilder::defaultLogger($sPath.'Logs/', Logger::$sLogValue);

        $host1 = array();
        $host1['host'] = self::GetModuleConfVar('oxcom_elasticsearch_server_host');
        $host1['port'] = self::GetModuleConfVar('oxcom_elasticsearch_server_port');
        $host1['scheme'] = self::GetModuleConfVar('oxcom_elasticsearch_server_scheme');
     
        $sUser = self::GetModuleConfVar('');
        if (!empty($sUser)) {
            $host1['user'] = self::GetModuleConfVar('oxcom_elasticsearch_server_user');    
        }
     
        $sPass = self::GetModuleConfVar('');
        if (!empty($sPass)) {
            $host1['pass'] = self::GetModuleConfVar('oxcom_elasticsearch_server_pass'); 
        }
     
        $hosts = [
            [
                $host1
            ]
        ];
     
        $client = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->setLogger($logger)->setRetries($retry)->build();
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
    public function CreateArticleIndex()
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
    public function DeleteArticleIndex()
    {
         $client = self::elasticclient();
         $params = [
             'index' => self::GetModuleConfVar('oxcom_elasticsearch_article_index');
         ];
         $response = $client->indices()->delete($params);
         return $response;
    }  
 
    /*
     *
     */
    public function RecreateArticleIndex()
    {
        // Delete Index
        $info = self::DeleteArticleIndex()
        
        if ($info->acknowleged <> 1) {
            return 'Index could not be deleted!';
        }  
     
        // Create Index
        $info = self::CreateArticleIndex()
        
        if ($info->acknowleged <> 1) {
            return 'Index could not be created!';
        }          
     
        // Reset all Articles for new Import
        $info = self::MarkAllArticle4NewImport()
        
        if ($info->acknowleged <> 1) {
            return 'Articles were not reseted!';
        }  else {
            return '1';
        }
    }   
 
    /*
     *
     */
    public function MarkAllArticle4NewImport()
    {
        $sQ = "UPDATE oxarticles SET oxcomelasticstat = '0'; UPDATE oxarticles SET oxcomelasticstat = '1' WHERE oxactive = '1'";
        $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
        $oDb->execute($sQ);
     
        return '1';
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
 
     /*
     *
     */
    public function CronAddArticle2Index($Limit)
    {
         if (!is_numeric($Limit)) { 
             return 'Bullshit'; 
         }
        
         $sQ = "Select oxid from oxarticles WHERE oxactive = '1' AND oxcomelasticstat= '1' LIMIT ".$Limit;
         $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(); 
     
         $resultSet = $oDb::getDb()->select($sQ);

         if ($resultSet != false && $resultSet->count() > 0) {
             while (!$resultSet->EOF) {
                 $row = $resultSet->getFields();
                 $final = self::IndexArticle2Elasticsearch($row['oxid']);
                 if ($final == '1') {
                    $sFinalQ = "UPDATE oxarticles SET oxcomelasticstat= '0' WHERE oxid=".$oDb->quote($row['oxid']);
                    $oDb::getDb()->execute($sQ);
                 }
                 $resultSet->fetchRow();
             }
          }
    
          $sQ2 = "Select oxid from oxarticles WHERE oxactive = '1' AND oxcomelasticstat= '1' LIMIT 1";
          $resultSet2 = $oDb::getDb()->select($sQ2);
          if ($resultSet != false && $resultSet->count() > 0) {
              return '0';
          } else {
              return '1';
          }
    } 
}
