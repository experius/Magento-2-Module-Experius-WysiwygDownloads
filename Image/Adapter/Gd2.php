<?php
/**
 * Copyright © Happy Horizon Utrecht Development & Technology B.V. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Experius\WysiwygDownloads\Image\Adapter;

use Experius\WysiwygDownloads\Helper\Settings;
use Magento\Framework\Filesystem;
use Psr\Log\LoggerInterface;

class Gd2 extends \Magento\Framework\Image\Adapter\Gd2
{
    /**
     * @var Settings
     */
    protected $settings;
    protected $imageFileTypes = [
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

    /**
     * @param Filesystem $filesystem
     * @param LoggerInterface $logger
     * @param Settings $helperSettings
     * @param array $data
     */
    public function __construct(
        Filesystem $filesystem,
        LoggerInterface $logger,
        Settings $helperSettings,
        array $data = []
    ) {
        $this->settings = $helperSettings;

        parent::__construct($filesystem, $logger, $data);
    }

    /**
     * Open image for processing
     *
     * @param string $filename
     * @return void
     * @throws \OverflowException
     */
    public function open($filename)
    {
        $pathInfo = pathinfo($filename);
        if (!key_exists('extension', $pathInfo)
            || !in_array($pathInfo['extension'], $this->settings->getExtraFiletypes())
            || in_array($pathInfo['extension'], $this->imageFileTypes)
        ) {
            parent::open($filename);
        }
    }

    /**
     * Save image to specific path.
     * If some folders of path does not exist they will be created
     *
     * @param null|string $destination
     * @param null|string $newName
     * @return void
     * @throws \Exception  If destination path is not writable
     */
    public function save($destination = null, $newName = null)
    {
        $fileName = $this->_prepareDestination($destination, $newName);
        $pathInfo = pathinfo($fileName);
        if (!key_exists('extension', $pathInfo)
            || !in_array($pathInfo['extension'], $this->settings->getExtraFiletypes())
            || in_array($pathInfo['extension'], $this->imageFileTypes)
        ) {
            parent::save($destination, $newName);
        }
    }
}
