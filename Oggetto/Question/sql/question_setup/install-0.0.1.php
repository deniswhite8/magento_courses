<?php

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()->newTable($installer->getTable('question/question'))
    ->addColumn('question_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
        ), 'Question ID')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable' => false,
        'length'   => 255,
        ), 'User name')
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable' => true,
        'length'   => 255,
        ), 'User email')
    ->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
        ), 'Question text')
    ->addColumn('timestamp', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
        ), 'Timestamp')
    ->setComment('User feedback question');
$installer->getConnection()->createTable($table);

$installer->endSetup();