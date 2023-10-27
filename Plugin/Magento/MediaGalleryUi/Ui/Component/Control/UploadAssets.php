<?php
/**
 * Copyright © Happy Horizon Utrecht Development & Technology B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\WysiwygDownloads\Plugin\Magento\MediaGalleryUi\Ui\Component\Control;

class UploadAssets
{
    /**
     * @param \Magento\MediaGalleryUi\Ui\Component\Control\UploadAssets $subject
     * @param $result
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetButtonData(
        \Magento\MediaGalleryUi\Ui\Component\Control\UploadAssets $subject,
        $buttonData
    ): array {
        // Override label to more correctly represent the functionality
        if (isset($buttonData['label']) && $buttonData['label'] == __('Upload Image')) {
            $buttonData['label'] = __('Upload Image / File');
        }
        return $buttonData;
    }
}
