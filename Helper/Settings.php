<?php

namespace Experius\WysiwygDownloads\Helper;

use Magento\Framework\App\Helper\Context;

class Settings extends \Magento\Framework\App\Helper\AbstractHelper
{

	const CONFIG_PATH_FILETYPES = 'wysiwyg/filetypes';
    
    public $configPathModule = 'cms';
    
    protected $_storeManager;
    
    /**
     * Currently selected store ID if applicable
     *
     * @var int
     */
    protected $_storeId;
    
    
    public function __construct(
        Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }
    
    /**
     * Set a specified store ID value
     *
     * @param int $store
     * @return $this
     */
    public function getStoreId()
    {
        if (!$this->_storeId){
            $this->_storeId = $this->_storeManager->getStore()->getId();
        }
        return $this->_storeId;
    }
    
    /**
     * Set a specified store ID value
     *
     * @param int $store
     * @return $this
     */
    public function setStoreId($store)
    {
        $this->_storeId = $store;
        return $this;
    }
    
    public function getConfigValue($path)
    {
        if (substr_count($path, '/') < 2){
            $path = $this->configPathModule . '/' . $path;
        }
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
    }
    
	public function getExtraFiletypes()
	{
    	$filetypes = array();
        $settings = unserialize($this->getConfigValue(self::CONFIG_PATH_FILETYPES));
		foreach($settings as $setting){
			$filetypes[] =  $setting['extension'];
		}
		$defaultFiletypes = array('doc','docm','docx','csv','xml','xls','xlsx','pdf','zip','tar');
		return array_merge($filetypes,$defaultFiletypes);
	}
   
}