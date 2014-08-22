<?php
/**
 * Oggetto Payment extension for Magento
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
 * the Oggetto Payment module to newer versions in the future.
 * If you wish to customize the Oggetto Sales module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Oggetto
 * @package   Oggetto_Payment
 * @copyright Copyright (C) 2014, Oggetto Web (http://oggettoweb.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Payment controller
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage controllers
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Payment_PaymentController extends Mage_Core_Controller_Front_Action
{
    /**
     * The redirect action is triggered when someone places an order
     *
     * @return void
     */
    public function redirectAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Cancel action
     *
     * @return void
     */
    public function cancelAction()
    {
        $errorMessage = $this->getRequest()->getParam('message');
        Mage::getSingleton('core/session')->addError($errorMessage);
        $this->_redirect('checkout/onepage/failure', array('_secure' => true));
    }

    /**
     * The response action is triggered when your gateway sends back a response after processing the customer's payment
     *
     * @return void
     */
    public function responseAction()
    {
        try {
            $requestHandler = Mage::getModel('oggetto_payment/requestHandler');
            $requestHandler->init($this->getRequest()->getPost());

            if ($requestHandler->validate()) {
                $requestHandler->process();
                $this->getResponse()->setHttpResponseCode(200);
            } else {
                $this->getResponse()->setHttpResponseCode(400);
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $this->getResponse()->setHttpResponseCode(500);
        }
    }
}