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

/**
 * Admin edit form
 *
 * @category   Oggetto
 * @package    Oggetto_News
 * @subpackage Adminhtml
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_News_Block_Adminhtml_News_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Constructor
     *
     * @return Oggetto_News_Block_Adminhtml_News_Grid
     */
    public function __construct()
    {
        parent::__construct();

        $this->setDefaultSort('id');
        $this->setId('oggetto_news_news_grid');
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
        return 'oggetto_news/news_collection';
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
            'news_id', array(
                'header' => Mage::helper('oggetto_news/data')->__('ID'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'news_id'
            )
        );

        $this->addColumn(
            'title', array(
                'header' => Mage::helper('oggetto_news/data')->__('Title'),
                'index' => 'title'
            )
        );

        $this->addColumn(
            'text', array(
                'header' => Mage::helper('oggetto_news/data')->__('Text'),
                'index' => 'text'
            )
        );

        $this->addColumn(
            'created_at', array(
                'header' => Mage::helper('oggetto_news/data')->__('Created at'),
                'index' => 'timestamp',
                'type' => 'datetime'
            )
        );

        $this->addColumn(
            'category_id', array(
                'header' => Mage::helper('oggetto_news/data')->__('Category Id'),
                'index' => 'category_id'
            )
        );

        $this->addColumn(
            'status', array(
                'header' => Mage::helper('oggetto_news/data')->__('Status'),
                'index' => 'status',
                'type'  => 'options',
                'options' => Mage::getModel('oggetto_news/news')->getStatusArray()
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
        $this->setMassactionIdField('news_id');
        $this->getMassactionBlock()->setFormFieldName('news_id');
        $this->getMassactionBlock()->addItem(
            'delete', array(
                'label'=> Mage::helper('oggetto_news/data')->__('Delete'),
                'url'  => $this->getUrl('*/*/massDelete', array('' => '')),
                'confirm' => Mage::helper('oggetto_news/data')->__('Are you sure?')
            )
        );

        $this->getMassactionBlock()->addItem(
            'status', array(
                'label'=> Mage::helper('oggetto_news/data')->__('Change status'),
                'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'visibility' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('oggetto_news/data')->__('Status'),
                        'values' =>
                            Mage::getModel('oggetto_news/news')->getStatusArray()
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