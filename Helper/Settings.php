<?php
/**
 * Copyright © Happy Horizon Utrecht Development & Technology B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\WysiwygDownloads\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Settings extends AbstractHelper
{
    const CONFIG_PATH_FILETYPES = 'wysiwyg/filetypes';

    /**
     * @var string
     */
    public $configPathModule = 'cms';

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Currently selected store ID if applicable
     *
     * @var int
     */
    protected $_storeId = null;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Get store ID
     *
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreId()
    {
        if (!$this->_storeId) {
            $this->_storeId = $this->_storeManager->getStore()->getId();
        }
        return $this->_storeId;
    }

    /**
     * Set a specified store ID value
     *
     * @param int $store
     * @return void
     */
    public function setStoreId($store)
    {
        $this->_storeId = $store;
    }

    /**
     * Get config value
     *
     * @param $path
     * @return mixed
     */
    public function getConfigValue($path)
    {
        if (substr_count($path, '/') < 2) {
            $path = $this->configPathModule . '/' . $path;
        }
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
    }


    /**
     * This is used for the Gd2
     *
     * @return array
     */
    public function getImageFiletypes()
    {
        return [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'webp',
            'bmp',
            'xpm',
            'xbm',
            'wbmp'
        ];
    }

    /**
     * Get extra file types (allowed)
     *
     * @return array|string[]
     */
    public function getExtraFiletypes()
    {
        $filetypes = [];
        if ($this->getConfigValue(self::CONFIG_PATH_FILETYPES) != null) {
            $settings = json_decode($this->getConfigValue(self::CONFIG_PATH_FILETYPES));
            if ($settings) {
                foreach ($settings as $setting) {
                    $filetypes[] = $setting->extension;
                }
            }
        }

        $defaultFiletypes = [
            'jpg',
            'jpeg',
            'png',
            'gif',
            'webp',
            'svg',
            'pdf',
            'doc',
            'docx',
            'docm',
            'odt',
            'csv',
            'txt',
            'xml',
            'xls',
            'xlsx',
            'ods',
            'zip',
            'tar',
            'mp3',
            'mp4',
            'ogg',
            'webm',
            'bmp'
        ];

        return array_merge($filetypes, $defaultFiletypes);
    }
}
