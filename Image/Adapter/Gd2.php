<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Experius\WysiwygDownloads\Image\Adapter;

class Gd2 extends \Magento\Framework\Image\Adapter\Gd2
{

    protected $settings;

    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Psr\Log\LoggerInterface $logger,
        \Experius\WysiwygDownloads\Helper\Settings $helperSettings,
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
        if (!key_exists('extension', $pathInfo) || !in_array($pathInfo['extension'], $this->settings->getExtraFiletypes())) {
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
        if (!key_exists('extension', $pathInfo) || !in_array($pathInfo['extension'], $this->settings->getExtraFiletypes())) {
            parent::save($destination, $newName);
        }
    }

}
