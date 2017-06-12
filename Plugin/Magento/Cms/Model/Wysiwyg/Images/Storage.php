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
 
/**
 * Class Storage
 */ 
class Storage {


    protected $_settings;
	protected $_type;

	public function __construct(
        \Experius\WysiwygDownloads\Helper\Settings $helperSettings
    ){
    	$this->_settings = $helperSettings;
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
}
