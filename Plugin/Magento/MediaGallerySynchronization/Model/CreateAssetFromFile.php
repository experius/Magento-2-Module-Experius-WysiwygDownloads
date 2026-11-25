<?php
/**
 * Copyright © Happy Horizon Utrecht Development & Technology B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\WysiwygDownloads\Plugin\Magento\MediaGallerySynchronization\Model;

use Experius\WysiwygDownloads\Model\MediaFileType;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\MediaGalleryApi\Api\Data\AssetInterface;
use Magento\MediaGalleryApi\Api\Data\AssetInterfaceFactory;
use Magento\MediaGallerySynchronization\Model\GetContentHash;
use Magento\MediaGallerySynchronizationApi\Model\CreateAssetFromFileInterface;

/**
 * Register PDF and other non-image files as media assets.
 *
 * Magento\MediaGallerySynchronization\Model\CreateAssetFromFile calls
 * getimagesizefromstring() for local storage. On PHP 8.3 that warning becomes
 * an exception for anything that is not a raster image, so the upload fails
 * while the file is being registered.
 */
class CreateAssetFromFile
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly AssetInterfaceFactory $assetFactory,
        private readonly GetContentHash $getContentHash,
        private readonly MediaFileType $mediaFileType
    ) {
    }

    /**
     * @param CreateAssetFromFileInterface $subject
     * @param \Closure $proceed
     * @param string $path
     * @return AssetInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(
        CreateAssetFromFileInterface $subject,
        \Closure $proceed,
        string $path
    ): AssetInterface {
        if ($this->mediaFileType->isRasterImage($path)) {
            return $proceed($path);
        }

        return $this->createNonImageAsset($path);
    }

    /**
     * Build the asset with width and height 0 and the detected mime type.
     */
    private function createNonImageAsset(string $path): AssetInterface
    {
        $directory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $absolutePath = $directory->getAbsolutePath($path);
        $content = $directory->readFile($path);
        $stat = $directory->stat($path);

        return $this->assetFactory->create(
            [
                'id' => null,
                'path' => $path,
                'title' => pathinfo($path, PATHINFO_FILENAME),
                'width' => 0,
                'height' => 0,
                'hash' => $this->getContentHash->execute($content),
                'size' => (int) ($stat['size'] ?? 0),
                'contentType' => $this->mediaFileType->detectMimeType($absolutePath, $content),
                'source' => 'Local',
            ]
        );
    }
}
