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
 * Admin news controller
 *
 * @category   Oggetto
 * @package    Oggetto_News
 * @subpackage controllers
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_News_Adminhtml_News_CategoryController extends Mage_Adminhtml_Controller_Action
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
        $model = Mage::getModel('oggetto_news/category');

        if ($id) {
            $model->load($id);

            if (!$model->getNewsId()) {
                Mage::getSingleton('adminhtml/session')->
                    addError(Mage::helper('oggetto_news/data')->__('This news no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $data = Mage::getSingleton('adminhtml/session')->getNewsData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('oggetto_news', $model);

        $this->_initAction()
            ->_addBreadcrumb($id ? Mage::helper('oggetto_news/data')->__('Edit News') : Mage::helper('oggetto_news/data')->__('New News'),
                $id ? Mage::helper('oggetto_news/data')->__('Edit News') : Mage::helper('oggetto_news/data')->__('New News'))
            ->renderLayout();
    }

    /**
     * Delete action
     *
     * @return void
     */
    public function deleteAction() {
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('oggetto_news/category');

        if ($id) {
            $model->setNewsId($id)->delete();
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
            $model = Mage::getModel('oggetto_news/category');
            $model->setData($postData);

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->
                    addSuccess(Mage::helper('oggetto_news/data')->__('The news has been saved.'));
                $this->_redirect('*/*/');

                return;
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->
                    addError(
                        Mage::helper('oggetto_news/data')->__('An error occurred while saving this news.')
                    );
            }

            Mage::getSingleton('adminhtml/session')->getNewsData($postData);
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
            ->_setActiveMenu('catalog/oggetto_news_category')
            ->_title(Mage::helper('oggetto_news/data')->__('Catalog'))->_title(Mage::helper('oggetto_news/data')->__('News'))
            ->_addBreadcrumb(Mage::helper('oggetto_news/data')->__('Catalog'), Mage::helper('oggetto_news/data')->__('Catalog'))
            ->_addBreadcrumb(Mage::helper('oggetto_news/data')->__('News'), Mage::helper('oggetto_news/data')->__('News'));

        return $this;
    }

    /**
     * Mass delete action
     *
     * @return void
     */
    public function massDeleteAction()
    {
        $ids = $this->getRequest()->getParam('news_id');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->
                addError(Mage::helper('oggetto_news/data')->__('Please select news(s).'));
        } else {
            try {
                $model = Mage::getModel('oggetto_news/category');
                foreach ($ids as $id) {
                    $model->setNewsId($id)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('oggetto_news/data')->__(
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
        $ids = $this->getRequest()->getParam('category_id');
        $statusId = $this->getRequest()->getParam('status');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->
                addError(Mage::helper('oggetto_news/data')->__('Please select news(s).'));
        } else {
            try {
                $model = Mage::getModel('oggetto_news/category');
                foreach ($ids as $id) {
                    $model->load($id)->setStatus($statusId)->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('oggetto_news/data')->__(
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
            isAllowed('catalog/oggetto_news_category');
    }
}