<?php
/**
 * Oggetto Web sales extension for Magento
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
 * @package   Oggetto_Sales
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
$installer->startSetup();

try {
    $table = $installer
        ->getConnection()
        ->newTable($installer->getTable('question/question'))
        ->addColumn(
            'question_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
                'identity' => true,
                ), 'Question ID'
        )
        ->addColumn(
            'name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => false,
                'length'   => 255,
                ), 'User name'
        )
        ->addColumn(
            'email', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' => true,
                'length'   => 255,
                ), 'User email'
        )
        ->addColumn(
            'text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'nullable' => true,
                ), 'Question text'
        )
        ->addColumn(
            'timestamp', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
                'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
                ), 'Timestamp'
        )
        ->addColumn(
            'answer', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                'nullable' => true,
            ), 'Answer text'
        )
        ->addColumn(
            'status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'unsigned' => true,
                'nullable' => false,
            ), 'Status ID (1 - Answered, 2 - Not answered)'
        )
        ->setComment('User feedback question');
    $installer->getConnection()->createTable($table);
} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();