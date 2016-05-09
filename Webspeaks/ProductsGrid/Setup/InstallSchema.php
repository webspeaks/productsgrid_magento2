<?php
namespace Webspeaks\ProductsGrid\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (!$installer->tableExists('webspeaks_contact')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('webspeaks_contact'))
                ->addColumn(
                    'contact_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true]
                )
                ->addColumn('contact_name', Table::TYPE_TEXT, 255, ['nullable' => false])
                ->addColumn('age', Table::TYPE_INTEGER, 10, ['nullable' => false])
                ->addColumn('address', Table::TYPE_TEXT, '2M', ['default' => ''], 'File path')
                ->addColumn('phone', Table::TYPE_TEXT, 10, ['default' => ''], 'File extension')
                ->addColumn('creation_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation Time')
                ->addColumn('update_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Update Time')
                ->setComment('Sample table');

            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('webspeaks_product_attachment_rel')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('webspeaks_product_attachment_rel'))
                ->addColumn('contact_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true])
                ->addColumn('product_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true], 'Magento Product Id')
                ->addForeignKey(
                    $installer->getFkName(
                        'webspeaks_contact',
                        'attachment_id',
                        'webspeaks_product_attachment_rel',
                        'attachment_id'
                    ),
                    'attachment_id',
                    $installer->getTable('webspeaks_contact'),
                    'attachment_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'webspeaks_product_attachment_rel',
                        'attachment_id',
                        'catalog_product_entity',
                        'entity_id'
                    ),
                    'product_id',
                    $installer->getTable('catalog_product_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('Webspeaks Product Attachment relation table');

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
