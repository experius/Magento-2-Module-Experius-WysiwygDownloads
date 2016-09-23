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
 
namespace Experius\WysiwygDownloads\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\DataObject;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Filetypes
 */
class Filetypes extends AbstractFieldArray
{

    /**
     * Prepare to render
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'extension',
            [
                'label'     => __('Allowed Filetype'),
            ]
        );
		$this->_addAfter = false;
    }

}
