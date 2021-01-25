<?php 
/**
 * This module makes it possible to upload different filetypes inside the WYSIWYG-editor. Extra filetypes are Word (doc, docm, docx), Excel (csv, xml, xls, xlsx), PDF (pdf), Compressed Folder (zip, tar)
 * Copyright (C) 2016  
 * 
 * This file included in Experius/WysiwygDownloads is licensed under OSL 3.0
 * 
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Experius\WysiwygDownloads\Plugin\Magento\Cms\Model\Wysiwyg\Images;
 
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * Class Storage
 */ 
class Storage {


    protected $_settings;
	protected $_type;
    /**
     * @var \Magento\Framework\Module\Dir\Reader
     */
    private $moduleReader;
    /**
     * @var \Magento\Framework\Filesystem
     */
    private $filesystem;

    /**
     * Storage constructor.
     *
     * @param \Experius\WysiwygDownloads\Helper\Settings $helperSettings
     * @param \Magento\Framework\Module\Dir\Reader $moduleReader
     * @param \Magento\Framework\Filesystem $filesystem
     */
    public function __construct(
        \Experius\WysiwygDownloads\Helper\Settings $helperSettings,
        \Magento\Framework\Module\Dir\Reader $moduleReader,
        \Magento\Framework\Filesystem $filesystem
    ){
    	$this->_settings = $helperSettings;
        $this->moduleReader = $moduleReader;
        $this->filesystem = $filesystem;
    }

	public function beforeGetAllowedExtensions(
		\Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
		$type
	){
		$this->_type = $type;
	}
	
	
	public function afterGetAllowedExtensions(
		\Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
		$result
	){
        return array_merge($result,$this->_settings->getExtraFiletypes());
	}

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
}
