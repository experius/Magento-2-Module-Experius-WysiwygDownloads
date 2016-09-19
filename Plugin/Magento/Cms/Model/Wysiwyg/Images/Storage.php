<?php 


namespace Experius\WysiwygDownloads\Plugin\Magento\Cms\Model\Wysiwyg\Images;
 
 
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
		if($this->_type == 'file'){
			return array_merge($result,$this->_settings->getExtraFiletypes());
		}
		return $result;
	}
}
