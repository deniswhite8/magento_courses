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
 * Payment model test
 *
 * @category   Oggetto
 * @package    Oggetto_Payment
 * @subpackage Controller
 * @author     Denis Belov <dbelov@oggettoweb.com>
 */
class Oggetto_Payment_Test_Controller_PaymentController extends EcomDev_PHPUnit_Test_Case_Controller
{
    /**
     * Test redirect action
     *
     * @return void
     */
    public function testRedirectAction()
    {
        $this->dispatch('oggetto_payment/payment/redirect');
        $this->assertRequestRoute('oggetto_payment/payment/redirect');
        $this->assertEquals('oggetto_payment/redirect.phtml',
            $this->getLayout()->getBlock('content')->getChild('gateway')->getTemplate());
    }

    /**
     * Test response action
     *
     * @return void
     */
    public function testResponseAction()
    {
        $order = $this->getModelMock('sales/order', array('setState'));
        $status = null;

        $order->expects($this->any())
            ->method('setState')
            ->will($this->returnCallback(function ($_status) use (&$status) {
                $status = $_status;
            }));

        $this->replaceByMock('model', 'sales/order', $order);

        // correct
        $this->getRequest()->setMethod('POST')
            ->setPost('order_id', 241)
            ->setPost('status', 1)
            ->setPost('total', '445,1300')
            ->setPost('hash', 'f957d23c7d97d1960cd98931b4c3c0ee');

        $this->dispatch('oggetto_payment/payment/response');
        $this->assertRequestRoute('oggetto_payment/payment/response');

        $this->assertEquals(Mage_Sales_Model_Order::STATE_PROCESSING, $status);

        // hash error
        $status = null;
        $this->getRequest()->setMethod('POST')
            ->setPost('order_id', 241)
            ->setPost('status', 1)
            ->setPost('total', '445,1300')
            ->setPost('hash', 'wtf');

        Mage::unregister('_helper/oggetto_payment/data');

        $this->dispatch('oggetto_payment/payment/response');
        $this->assertRequestRoute('oggetto_payment/payment/response');

        $this->assertEquals(0, $status);

        // status error
        $status = null;
        $this->getRequest()->setMethod('POST')
            ->setPost('order_id', 241)
            ->setPost('status', 0)
            ->setPost('total', '445,1300')
            ->setPost('hash', 'cf119b9a851b53a3ea5199f846c6d278');

        Mage::unregister('_helper/oggetto_payment/data');

        $this->dispatch('oggetto_payment/payment/response');
        $this->assertRequestRoute('oggetto_payment/payment/response');

        $this->assertEquals(Mage_Sales_Model_Order::STATE_CANCELED, $status);
    }
}