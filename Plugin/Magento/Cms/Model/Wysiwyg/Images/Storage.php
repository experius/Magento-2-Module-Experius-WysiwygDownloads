<?php 


namespace Experius\WysiwygDownloads\Plugin\Magento\Cms\Model\Wysiwyg\Images;
 
 
class Storage {


    protected $_settings;

	public function __construct(
        \Experius\WysiwygDownloads\Helper\Settings $helperSettings
    ){
    	$this->_settings = $helperSettings;
    }

	
	public function afterGetAllowedExtensions(
		\Magento\Cms\Model\Wysiwyg\Images\Storage $subject,
		$result
	){
		return array_merge($result,$this->_settings->getExtraFiletypes());
	}
}
