<?php

namespace Dev\ProductComments\Model\Attribute\Backend;

class Comments extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * Validate
     * @param \Magento\Catalog\Model\Product $object
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool
     */
    public function validate($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
    #            if ($value == 'no') {
     #       throw new \Magento\Framework\Exception\LocalizedException(
     #           __('comments are not allowed for this product')
    #        );
  #      }
        return true;
    }
}