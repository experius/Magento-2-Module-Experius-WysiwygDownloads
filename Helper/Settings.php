<?php
/**
 * This module makes it possible to upload different filetypes inside the WYSIWYG-editor. Extra filetypes are Word (doc, docm, docx), Excel (csv, xml, xls, xlsx), PDF (pdf), Compressed Folder (zip, tar)
 * Copyright (C) 2016
 *
 * This file included in Experius/WysiwygDownloads is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Experius\WysiwygDownloads\Helper;

use Magento\Framework\App\Helper\Context;

/**
 * Class Settings
 */
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
      $settings = json_decode($this->getConfigValue(self::CONFIG_PATH_FILETYPES));
      if ($settings) {
          foreach($settings as $setting){
              $filetypes[] =  $setting->extension;
          }
      }
      $defaultFiletypes = array('doc','docm','docx','csv','xml','xls','xlsx','pdf','zip','tar');
      return array_merge($filetypes,$defaultFiletypes);
	}

}
