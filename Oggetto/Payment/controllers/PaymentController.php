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
        $block = $this->getLayout()->createBlock('Mage_Core_Block_Template', 'gateway',
            array('template' => 'oggetto_payment/redirect.phtml'));
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    /**
     * The response action is triggered when your gateway sends back a response after processing the customer's payment
     *
     * @return void
     */
    public function responseAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->_redirect('');
            return;
        }
        /** @var Oggetto_Payment_Helper_Data $helper */
        $helper = Mage::helper('oggetto_payment/data');

        $request = $this->getRequest();
        $orderId = $request->getPost('order_id');
        $order = Mage::getModel('sales/order')->load($orderId);

        if ($order->getEntityId() && $helper->validateOrder($order, $request->getPost('hash'))){
            $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'Gateway has authorized the payment.');

            $order->sendNewOrderEmail();
            $order->setEmailSent(true);

            $order->save();

            Mage::getSingleton('checkout/session')->unsQuoteId();

            $this->_redirectUrl($helper->getSuccessUrl());
        } else {
            $this->cancel();
            $this->_redirectUrl($helper->getFailureUrl());
        }
    }

    /**
     * The cancel action is triggered when an order is to be cancelled
     *
     * @return void
     */
    protected  function cancel()
    {
        $order = Mage::helper('oggetto_payment/data')->getOrder();

        if ($order->getEntityId()) {
            $order->cancel()->
                setState(Mage_Sales_Model_Order::STATE_CANCELED, true, 'Gateway has declined the payment.')->save();
        }
    }
}