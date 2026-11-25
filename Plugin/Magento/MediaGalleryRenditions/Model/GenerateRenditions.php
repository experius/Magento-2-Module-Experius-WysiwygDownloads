<?php
/**
 * Copyright © Happy Horizon Utrecht Development & Technology B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\WysiwygDownloads\Plugin\Magento\MediaGalleryRenditions\Model;

use Experius\WysiwygDownloads\Model\MediaFileType;
use Magento\MediaGalleryRenditionsApi\Api\GenerateRenditionsInterface;

/**
 * Keep PDF and other documents out of rendition generation.
 *
 * GenerateRenditions only accepts jpg, jpeg, gif and png, and sizes them with
 * getimagesizefromstring(). A document in that list fails the whole batch.
 */
class GenerateRenditions
{
    public function __construct(
        private readonly MediaFileType $mediaFileType
    ) {
    }

    /**
     * @param GenerateRenditionsInterface $subject
     * @param string[] $paths
     * @return array{0: string[]}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeExecute(
        GenerateRenditionsInterface $subject,
        array $paths
    ): array {
        $renditionPaths = [];

        foreach ($paths as $path) {
            if (!is_string($path) || $this->mediaFileType->shouldSkipRendition($path)) {
                continue;
            }

            $renditionPaths[] = $path;
        }

        return [$renditionPaths];
    }
}
