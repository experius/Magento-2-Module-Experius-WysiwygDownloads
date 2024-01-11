<?php
/**
 * Copyright © Happy Horizon Utrecht Development & Technology B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\WysiwygDownloads\Plugin\Magento\Cms\Model\Wysiwyg\Images;

use Experius\WysiwygDownloads\Helper\Settings;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Module\Dir\Reader;

class Storage
{
    /**
     * @var Settings
     */
    protected $_settings;

    /**
     * @var string
     */
    protected $_type;
    /**
     * @var Reader
     */
    private $moduleReader;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param Settings $helperSettings
     * @param Reader $moduleReader
     * @param Filesystem $filesystem
     */
    public function __construct(
        Settings $helperSettings,
        Reader $moduleReader,
        Filesystem $filesystem
    ) {
        $this->_settings = $helperSettings;
        $this->moduleReader = $moduleReader;
        $this->filesystem = $filesystem;
    }

    /**
     * @param \Magento\Cms\Model\Wysiwyg\Images\Storage $subject
     * @param $type
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeGetAllowedExtensions(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
        $type
    ) {
        $this->_type = $type;
    }

    /**
     * @param \Magento\Cms\Model\Wysiwyg\Images\Storage $subject
     * @param $result
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetAllowedExtensions(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
        $result
    ) {
        return array_merge($result, $this->_settings->getExtraFiletypes());
    }

    /**
     * @param \Magento\Cms\Model\Wysiwyg\Images\Storage $subject
     * @param $source
     * @param $keepRatio
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeResizeFile(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
        $source,
        $keepRatio = true
    ) {
        $sourceInfo = explode('.', $source);
        $fileExtension = end($sourceInfo);
        if (strtolower($fileExtension) == 'pdf') {
            $mediaPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath() . 'pdf-icon.png';
            if (!file_exists($mediaPath)) {
                copy(
                    $this->moduleReader->getModuleDir(
                        \Magento\Framework\Module\Dir::MODULE_VIEW_DIR,
                        'Experius_WysiwygDownloads'
                    ) . '/adminhtml/web/images/pdf-icon.png',
                    $mediaPath
                );
            }
            $source = $mediaPath;
        }
        return [$source, $keepRatio];
    }

    /**
     * @param \Magento\Cms\Model\Wysiwyg\Images\Storage $subject
     * @param \Closure $proceed
     * @param $source
     * @param $keepRatio
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundResizeFile(
        \Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
        \Closure $proceed,
                                                  $source,
                                                  $keepRatio = true
    ) {
        if (pathinfo($source, PATHINFO_EXTENSION) == 'pdf') {
            return $source;
        }

        return $proceed($source, $keepRatio);
    }
}
