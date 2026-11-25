<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\WysiwygDownloads\Plugin\Magento\MediaGalleryUi\Ui\Component\Listing\Columns;

use Experius\WysiwygDownloads\Helper\Settings;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

class Url
{

    /**
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Settings $helperSettings
     * @param Reader $moduleReader
     */
    public function __construct(
        public Filesystem $filesystem,
        public StoreManagerInterface $storeManager,
        public Settings $helperSettings,
        private readonly Reader $moduleReader
    ) {}

    /**
     * @param \Magento\MediaGalleryUi\Ui\Component\Listing\Columns\Url $subject
     * @param $result
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterPrepareDataSource(
        \Magento\MediaGalleryUi\Ui\Component\Listing\Columns\Url $subject,
                                                                 $result
    ) {
        if (!$this->helperSettings->getConfigValue('system/media_gallery/enabled')) {
            return $result;
        }

        foreach ($result['data']['items'] as &$item) {
            if ($this->isPdfContentType($item['content_type'] ?? null)) {
                $this->ensurePdfIcon();
                $item['thumbnail_url'] =
                    $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
                    . 'pdf-icon.png';
            }
        }

        return $result;
    }

    /**
     * Media Gallery stores the mime type. Older rows may only contain "PDF".
     */
    private function isPdfContentType(mixed $contentType): bool
    {
        if (!is_string($contentType) || $contentType === '') {
            return false;
        }

        $normalized = strtolower($contentType);

        return $normalized === 'application/pdf'
            || $normalized === 'image/pdf'
            || $normalized === 'pdf';
    }

    /**
     * Publish the module icon into pub/media, where the gallery thumbnail URL points.
     */
    private function ensurePdfIcon(): void
    {
        $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $mediaPath = $mediaDirectory->getAbsolutePath('pdf-icon.png');
        if (is_file($mediaPath)) {
            return;
        }

        $source = $this->moduleReader->getModuleDir(Dir::MODULE_VIEW_DIR, 'Experius_WysiwygDownloads')
            . '/adminhtml/web/images/pdf-icon.png';
        if (!is_file($source)) {
            return;
        }

        copy($source, $mediaPath);
    }
}
