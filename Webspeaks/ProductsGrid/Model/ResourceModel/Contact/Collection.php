<?php
namespace Webspeaks\ProductsGrid\Model\ResourceModel\Contact;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'contact_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Webspeaks\ProductsGrid\Model\Contact', 'Webspeaks\ProductsGrid\Model\ResourceModel\Contact');
    }
}
