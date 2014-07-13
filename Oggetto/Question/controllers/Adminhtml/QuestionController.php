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
class Oggetto_Question_Adminhtml_QuestionController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Index action
     *
     * @return void
     */
    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }

    /**
     * New action
     *
     * @return void
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit action
     *
     * @return void
     */
    public function editAction()
    {
        $this->_initAction();

        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('question/question');

        if ($id) {
            $model->load($id);

            if (!$model->getQuestionId()) {
                Mage::getSingleton('adminhtml/session')->
                    addError($this->__('This question no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getQuestionData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('oggetto_question', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Question') : $this->__('New Question'),
                $id ? $this->__('Edit Question') : $this->__('New Question'))
            ->_addContent(
                $this->getLayout()
                    ->createBlock('oggetto_question/adminhtml_question_edit')
                    ->setData('action', $this->getUrl('*/*/save'))
            )
            ->renderLayout();
    }

    /**
     * Delete action
     *
     * @return void
     */
    public function deleteAction() {
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('question/question');

        if ($id) {
            $model->load($id)->delete();
        }

        $this->_redirect('*/*/');
    }

    /**
     * Save action
     *
     * @return void
     */
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getModel('question/question');
            $model->setData($postData);

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->
                    addSuccess($this->__('The question has been saved.'));
                $this->_redirect('*/*/');

                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->
                    addError(
                        $this->__('An error occurred while saving this question.')
                    );
            }

            Mage::getSingleton('adminhtml/session')->setBazData($postData);
            $this->_redirectReferer();
        }
    }

    /**
     * Init action
     *
     * @return void
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customer/oggetto_question_question')
            ->_title($this->__('Customers'))->_title($this->__('Question'))
            ->_addBreadcrumb($this->__('Customers'), $this->__('Customers'))
            ->_addBreadcrumb($this->__('Question'), $this->__('Question'));

        return $this;
    }

    /**
     * Mass delete action
     *
     * @return void
     */
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('question_id');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->
                addError($this->__('Please select question(s).'));
        } else {
            try {
                $model = Mage::getModel('question/question');
                foreach ($ids as $id) {
                    $model->load($id)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->__(
                        'Total of %d record(s) were deleted.', count($ids)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Mass change status action
     *
     * @return void
     */
    public function massStatusAction()
    {
        $ids = $this->getRequest()->getParam('question_id');
        $statusId = $this->getRequest()->getParam('status');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->
                addError($this->__('Please select question(s).'));
        } else {
            try {
                $model = Mage::getModel('question/question');
                foreach ($ids as $id) {
                    $model->load($id)->setStatusId($statusId)->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    $this->__(
                        'Total of %d record(s) were changed.', count($ids)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Is allowed
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->
            isAllowed('customer/oggetto_question_question');
    }
}