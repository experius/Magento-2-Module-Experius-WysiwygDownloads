<?php
namespace Experius\WysiwygDownloads\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\MediaStorage\Model\File\Validator\NotProtectedExtension;

class ProtectedExtensions implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var WriterInterface
     */
    private $configWriter;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        ScopeConfigInterface $scopeConfig,
        WriterInterface $configWriter,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->scopeConfig = $scopeConfig;
        $this->configWriter = $configWriter;
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $protectedExtensions = $this->getCurrentValue();
        $protectedExtensions = array_diff($protectedExtensions, ['svg', 'svgz']);
        $protectedExtensions = implode(',', $protectedExtensions);
        $this->configWriter->save(
            NotProtectedExtension::XML_PATH_PROTECTED_FILE_EXTENSIONS,
            $protectedExtensions,
            'default',
            'default'
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * @inheritdoc
     */
    public static function getDependencies()
    {
        return [];
    }

    public function revert()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $protectedExtensions = $this->getCurrentValue();
        $protectedExtensions = array_merge($protectedExtensions, ['svg', 'svgz']);
        $this->configWriter->save(
            NotProtectedExtension::XML_PATH_PROTECTED_FILE_EXTENSIONS,
            implode(',', $protectedExtensions),
            'default',
            'default'
        );
        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getCurrentValue() 
    {
        $configValue = $this->scopeConfig->getValue(
            NotProtectedExtension::XML_PATH_PROTECTED_FILE_EXTENSIONS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if(is_string($configValue)) {
            return explode(',', $configValue);
        }
        return $configValue ?? [];
    }

    /**
     * @inheritdoc
     */
    public function getAliases()
    {
        return [];
    }
}