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
class Oggetto_News_Block_Adminhtml_News_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Constructor
     *
     * @return Oggetto_News_Block_Adminhtml_News_Edit_Form
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('oggetto_news_news_form');
        $this->setTitle(Mage::helper('oggetto_news/data')->__('News Information'));
    }

    /**
     * Prepare form
     *
     * @return string
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('oggetto_news');

        $form = new Varien_Data_Form(
            array(
                'id'        => 'edit_form',
                'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method'    => 'post'
             )
        );

        $fieldset = $form->addFieldset(
            'base_fieldset', array
            (
                'legend'    => Mage::helper('checkout')->__('News Information'),
                'class'     => 'fieldset-wide',
            )
        );

        if ($model->getNewsId()) {
            $fieldset->addField(
                'news_id', 'hidden', array(
                    'name' => 'news_id',
                )
            );
        }

        $fieldset->addField(
            'title', 'text', array(
                'name'      => 'title',
                'label'     => Mage::helper('oggetto_news/data')->__('Title'),
                'title'     => Mage::helper('oggetto_news/data')->__('Title'),
                'required'  => true,
            )
        );

        $fieldset->addField(
            'text', 'text', array(
                'name'      => 'text',
                'label'     => Mage::helper('oggetto_news/data')->__('Text'),
                'title'     => Mage::helper('oggetto_news/data')->__('Text'),
                'required'  => true,
            )
        );


        $fieldset->addField(
            'status', 'select', array(
                'name'      => 'status',
                'label'     => Mage::helper('oggetto_news/data')->__('Status'),
                'title'     => Mage::helper('oggetto_news/data')->__('Status'),
                'required'  => true,
                'values' => Mage::getModel('oggetto_news/news')->getStatusArray()
            )
        );

        $fieldset->addField(
            'category_id', 'text', array(
                'name'      => 'category_id',
                'label'     => Mage::helper('oggetto_news/data')->__('Category Id'),
                'title'     => Mage::helper('oggetto_news/data')->__('Category Id'),
                'required'  => true,
            )
        );


        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}