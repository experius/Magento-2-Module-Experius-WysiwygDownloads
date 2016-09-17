<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Experius\WysiwygDownloads\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\DataObject;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class CountryCreditCard
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
