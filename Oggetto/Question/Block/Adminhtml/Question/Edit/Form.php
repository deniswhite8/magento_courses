<?php
/**
 * Oggetto question extension for Magento
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
 * @package   Oggetto_Question
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
class Oggetto_Question_Block_Adminhtml_Question_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Constructor
     *
     * @return Oggetto_Question_Block_Adminhtml_Question_Edit_Form
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('oggetto_question_question_form');
        $this->setTitle($this->__('Question Information'));
    }

    /**
     * Prepare form
     *
     * @return string
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('oggetto_question');

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
                'legend'    => Mage::helper('checkout')->__('Question Information'),
                'class'     => 'fieldset-wide',
            )
        );

        if ($model->getQuestionId()) {
            $fieldset->addField(
                'question_id', 'hidden', array(
                    'name' => 'question_id',
                )
            );
        }

        $fieldset->addField(
            'name', 'text', array(
                'name'      => 'name',
                'label'     => $this->__('Name'),
                'title'     => $this->__('Name'),
                'required'  => true,
            )
        );

        $fieldset->addField(
            'email', 'text', array(
                'name'      => 'email',
                'label'     => $this->__('Email'),
                'title'     => $this->__('Email'),
                'required'  => false,
            )
        );

        $fieldset->addField(
            'text', 'text', array(
                'name'      => 'text',
                'label'     => $this->__('Text'),
                'title'     => $this->__('Text'),
                'required'  => true,
            )
        );


        $fieldset->addField(
            'status', 'select', array(
                'name'      => 'status',
                'label'     => $this->__('Status'),
                'title'     => $this->__('Status'),
                'required'  => true,
                'values' => Mage::getModel('question/question')->getStatusArray()
            )
        );

        $fieldset->addField(
            'answer', 'textarea', array(
                'name'      => 'answer',
                'label'     => $this->__('Answer'),
                'title'     => $this->__('Answer'),
                'required'  => false,
            )
        );

        $fieldset->addField(
            'sent_email', 'select', array(
                'name'      => 'sent_email',
                'label'     => $this->__('Sent email'),
                'title'     => $this->__('Sent email'),
                'required'  => true,
                'values' => Mage::getModel('question/question')->getYesnoArray()
            )
        );


        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}