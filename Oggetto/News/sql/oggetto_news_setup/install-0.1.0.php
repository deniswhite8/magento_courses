<?php
/**
 * Oggetto Web extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Oggetto Sales module to newer versions in the future.
 * If you wish to customize the Oggetto Sales module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Oggetto
 * @package   Oggetto_News
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
$installer->startSetup();

try {
    $table = $installer
        ->getConnection()
        ->newTable($installer->getTable('oggetto_news/news'))
        ->addColumn(
            'news_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
                'identity' => true,
            ), 'News ID'
        )
        ->addColumn(
            'title', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => false,
                'length'   => 255,
            ), 'Title'
        )
        ->addColumn(
            'url_key', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => true,
                'length'   => 255,
            ), 'Url key'
        )
        ->addColumn(
            'text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'nullable' => true,
            ), 'News text'
        )
        ->addColumn(
            'timestamp', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
                'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
            ), 'Timestamp'
        )
        ->addColumn(
            'status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
            ), 'Status'
        )
        ->addColumn(
            'category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
            ), 'Category Id'
        )
        ->setComment('News');
    $installer->getConnection()->createTable($table);




    $table = $installer
        ->getConnection()
        ->newTable($installer->getTable('oggetto_news/news_category'))
        ->addColumn(
            'category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
                'identity' => true,
            ), 'Category Id'
        )
        ->addColumn(
            'title', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => false,
                'length'   => 255,
            ), 'Title'
        )
        ->addColumn(
            'url_key', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => true,
                'length'   => 255,
            ), 'Url key'
        )
        ->addColumn(
            'parent_category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
            ), 'Parent category Id'
        )
        ->setComment('News category');
    $installer->getConnection()->createTable($table);
} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();