<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\WysiwygDownloads\Plugin\Magento\MediaGalleryUi\Ui\Component\Listing\Columns;

use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;
use Experius\Core\Helper\Settings;

class Url
{

    /**
     * @param Filesystem $filesystem
     * @param StoreManagerInterface $storeManager
     * @param Settings $helperSettings
     */
    public function __construct(
        public Filesystem $filesystem,
        public StoreManagerInterface $storeManager,
        public Settings $helperSettings
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
            if ($item['content_type'] == "PDF") {
                $item['thumbnail_url'] =
                    $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)
                    . 'pdf-icon.png';
            }
        }

        return $result;
    }
}
