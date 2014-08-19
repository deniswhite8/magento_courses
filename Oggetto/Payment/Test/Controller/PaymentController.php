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

    protected $_status;

    /**
     * Set up function
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $order = $this->getModelMock('sales/order', array('setState'));
        $this->_status = null;

        $order->expects($this->any())
            ->method('setState')
            ->will($this->returnCallback(function ($_status) {
                $this->_status = $_status;
            }));

        $this->replaceByMock('model', 'sales/order', $order);
    }

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
     * Test correct response action
     *
     * @return void
     */
    public function testCorrectResponse()
    {
        $this->_status = null;
        $this->getRequest()->setMethod('POST')
            ->setPost('order_id', 241)
            ->setPost('status', 1)
            ->setPost('total', '445,1300')
            ->setPost('hash', 'f957d23c7d97d1960cd98931b4c3c0ee');

        $this->dispatch('oggetto_payment/payment/response');
        $this->assertRequestRoute('oggetto_payment/payment/response');

        $this->assertEquals(Mage_Sales_Model_Order::STATE_PROCESSING, $this->_status);
    }

    /**
     * Test hash incorrect response action
     *
     * @return void
     */
    public function testHashIncorrectResponse()
    {
        $this->_status = null;
        $this->getRequest()->setMethod('POST')
            ->setPost('order_id', 241)
            ->setPost('status', 1)
            ->setPost('total', '445,1300')
            ->setPost('hash', 'wtf');

        Mage::unregister('_helper/oggetto_payment/data');

        $this->dispatch('oggetto_payment/payment/response');
        $this->assertRequestRoute('oggetto_payment/payment/response');

        $this->assertEquals(null, $this->_status);
    }

    /**
     * Test status incorrect response action
     *
     * @return void
     */
    public function testStatusIncorrectResponse()
    {
        $this->_status = null;
        $this->getRequest()->setMethod('POST')
            ->setPost('order_id', 241)
            ->setPost('status', 0)
            ->setPost('total', '445,1300')
            ->setPost('hash', 'cf119b9a851b53a3ea5199f846c6d278');

        Mage::unregister('_helper/oggetto_payment/data');

        $this->dispatch('oggetto_payment/payment/response');
        $this->assertRequestRoute('oggetto_payment/payment/response');

        $this->assertEquals(Mage_Sales_Model_Order::STATE_CANCELED, $this->_status);
    }
}
