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

/**
 * Admin edit form
 *
 * @category   Oggetto
 * @package    Oggetto_Question
 * @subpackage Adminhtml
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Question_Block_Adminhtml_Question_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Constructor
     *
     * @return Oggetto_Question_Block_Adminhtml_Question_Grid
     */
    public function __construct()
    {
        parent::__construct();

        $this->setDefaultSort('id');
        $this->setId('oggetto_question_question_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Get collection class name
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'question/question_collection';
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id', array(
                'header' => $this->__('ID'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'question_id'
            )
        );

        $this->addColumn(
            'name', array(
                'header' => $this->__('Name'),
                'index' => 'name'
            )
        );

        $this->addColumn(
            'email', array(
                'header' => $this->__('Email'),
                'index' => 'email'
            )
        );

        $this->addColumn(
            'text', array(
                'header' => $this->__('Text'),
                'index' => 'text'
            )
        );

        $this->addColumn(
            'created_at', array(
                'header' => $this->__('Created at'),
                'index' => 'timestamp',
                'type' => 'datetime'
            )
        );

        $this->addColumn(
            'status_id', array(
                'header' => $this->__('Status'),
                'index' => 'status_id',
                'type'  => 'options',
                'options' => Mage::getModel('question/question')->getStatusArray()
            )
        );

        $this->addColumn(
            'answer', array(
                'header' => $this->__('Answer'),
                'index' => 'answer'
            )
        );

        return parent::_prepareColumns();
    }

    /**
     * Prepare mass actions
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('question_id');
        $this->getMassactionBlock()->setFormFieldName('question_id');
        $this->getMassactionBlock()->addItem(
            'delete', array(
                'label'=> Mage::helper('tax')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
                'confirm' => $this->__('Are you sure?')
            )
        );

        $this->getMassactionBlock()->addItem(
            'status', array(
                'label'=> $this->__('Change status'),
                'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => $this->__('Status'),
                        'values' =>
                            Mage::getModel('question/question')->getStatusArray()
                    )
                )
            )
        );

        return $this;
    }

    /**
     * Get row URL
     *
     * @parm $row Table row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}